<?php
class Requests{

    private $consultTable = 'consultant';
	private $userTable = 'user';
    private $requestTable = 'requests';
	private $conn;
	
    public function __construct(){
		$db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function getRequestList($key){
        $key = $this->conn->real_escape_string($key);

        if ($_SESSION['auth_user']['user_type'] == "Admin") {
            if ($key == "") {
                $sqlQuery = "
                    SELECT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.note, r.requestApproval, c.consultantName, u.Name, u.pfp
                    FROM " . $this->requestTable . " as r, " . $this->consultTable . " as c, " . $this->userTable . " as u
                    WHERE r.consultID = c.consultantID
                        AND r.userID = u.UserID
                    ORDER BY r.requestID DESC";
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            } else {
                $sqlQuery = "
                    SELECT DISTINCT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.note, r.requestApproval, c.consultantName, u.Name, u.pfp
                    FROM " . $this->requestTable . " as r, " . $this->consultTable . " as c, " . $this->userTable . " as u
                    WHERE (c.consultantName LIKE ? OR u.Name LIKE ? OR r.bookingDateTime LIKE ? OR r.requestApproval LIKE ? OR r.bookingDateTime LIKE ? OR r.userPhone LIKE ? OR r.note LIKE ?)
                        AND r.consultID = c.consultantID
                        AND r.userID = u.UserID
                    ORDER BY r.requestID DESC";
                $stmt = $this->conn->prepare($sqlQuery);
                $param = "%$key%";
                $stmt->bind_param("sssssss", $param, $param, $param, $param, $param, $param, $param);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }
        }   
        
        if ($_SESSION['auth_user']['user_type'] == "Consultant") {
            if ($key == "") {
                $sqlQuery = "
                    SELECT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.note, r.requestApproval, c.consultantName, u.Name, u.pfp
                    FROM " . $this->requestTable . " as r
                    INNER JOIN " . $this->consultTable . " as c ON r.consultID = c.consultantID
                    INNER JOIN " . $this->userTable . " as u ON r.userID = u.UserID
                    WHERE c.consultantEmail = ?
                    ORDER BY r.requestID DESC";
        
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bind_param("s", $_SESSION['auth_user']['user_email']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            } else {
                $sqlQuery = "
                    SELECT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.note, r.requestApproval, c.consultantName, u.Name, u.pfp
                    FROM " . $this->requestTable . " as r
                    INNER JOIN " . $this->consultTable . " as c ON r.consultID = c.consultantID
                    INNER JOIN " . $this->userTable . " as u ON r.userID = u.UserID
                    WHERE (u.Name LIKE ? OR r.bookingDateTime LIKE ? OR r.requestApproval LIKE ? OR r.bookingDateTime LIKE ? OR r.userPhone LIKE ? OR r.note LIKE ?)
                        AND c.consultantEmail = ?
                    ORDER BY r.requestID DESC";
        
                $stmt = $this->conn->prepare($sqlQuery);
                $param = "%$key%";
                $stmt->bind_param("sssssss", $param, $param, $param, $param, $param, $param, $_SESSION['auth_user']['user_email']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }
        }
        

        if ($_SESSION['auth_user']['user_type'] == "Member") {
            if ($key == "") {
                $sqlQuery = "
                    SELECT DISTINCT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.requestApproval, r.note, c.consultantName, c.consultantPhone, c.consultantPic
                    FROM " . $this->requestTable . " as r
                    INNER JOIN " . $this->consultTable . " as c ON r.consultID = c.consultantID
                    WHERE r.userID = ?
                    ORDER BY r.requestID DESC";
        
                $stmt = $this->conn->prepare($sqlQuery);
                $stmt->bind_param("s", $_SESSION['auth_user']['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            } else {
                $sqlQuery = "
                    SELECT DISTINCT r.requestID, r.consultID, r.userID, r.userPhone, r.bookingDateTime, r.requestApproval, r.note, c.consultantName, c.consultantPhone, c.consultantPic
                    FROM " . $this->requestTable . " as r
                    INNER JOIN " . $this->consultTable . " as c ON r.consultID = c.consultantID
                    WHERE (c.consultantName LIKE ? OR r.bookingDateTime LIKE ? OR r.requestApproval LIKE ? OR r.bookingDateTime LIKE ? OR c.consultantPhone LIKE ? OR r.note LIKE ?)
                        AND r.userID = ?
                    ORDER BY r.requestID DESC";
        
                $stmt = $this->conn->prepare($sqlQuery);
                $param = "%$key%";
                $stmt->bind_param("sssssss", $param, $param, $param, $param, $param, $param, $_SESSION['auth_user']['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }
        }
        
    }

    public function createRequest($userID, $consultantID, $userPhone, $bookingDateTime, $approval, $msg) {
        $request_query = "INSERT INTO requests (userID, consultID, userPhone, bookingDateTime, requestApproval, note) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($request_query);
        $stmt->bind_param("ssssss", $userID, $consultantID, $userPhone, $bookingDateTime->format('Y-m-d H:i:s'), $approval, $msg);
    
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
    

    public function editRequest($requestID, $userID, $consultantID, $userPhone, $bookingDateTime, $msg) {
        $edit_query = "UPDATE " . $this->requestTable . "
            SET userID = ?,
            consultID = ?,
            userPhone = ?,
            bookingDateTime = ?,
            note = ?
            WHERE requestID = ?";
    
        $stmt = $this->conn->prepare($edit_query);
        $stmt->bind_param("ssssss", $userID, $consultantID, $userPhone, $bookingDateTime->format('Y-m-d H:i:s'), $msg, $requestID);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }
    

    public function acceptRequest($requestID) {
        $accept_query = "UPDATE " . $this->requestTable . "
            SET requestApproval = 'ACCEPTED'
            WHERE requestID = ?";
    
        $stmt = $this->conn->prepare($accept_query);
        $stmt->bind_param("s", $requestID);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }
    

    public function rejectRequest($requestID) {
        $reject_query = "UPDATE " . $this->requestTable . "
            SET requestApproval = 'REJECTED'
            WHERE requestID = ?";
    
        $stmt = $this->conn->prepare($reject_query);
        $stmt->bind_param("s", $requestID);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }
    

    public function deleteRequest($requestID) {
        $sqlQuery = "DELETE FROM " . $this->requestTable . " 
            WHERE requestID = ?";
    
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $requestID);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }
    

    public function getMembersList() {
        $sqlQuery = "
            SELECT u.Name, u.UserID
            FROM " . $this->userTable . " as u
            WHERE u.accType = 'Member'
            ORDER BY u.Name ASC";
            
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
    }
    public function getUsersList($currentID) {
        $sqlQuery = "
            SELECT u.Name, u.UserID, u.Email
            FROM " . $this->userTable . " as u
            WHERE u.UserID != '$currentID'
            ORDER BY u.Name ASC";
            
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
    }
    

    public function getconsultantPFP($consultantID) {
        $getPFP_query = "SELECT consultantPic FROM consultant WHERE consultantID = ?";
        
        $stmt = $this->conn->prepare($getPFP_query);
        $stmt->bind_param("i", $consultantID);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pic = $row['consultantPic'];
            return $pic;
        } else {
            return NULL;
        }
    }
    

    public function getuserPFP($userID) {
    $getPFP_query = "SELECT pfp FROM user WHERE UserID = ?";
    
    $stmt = $this->conn->prepare($getPFP_query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pic = $row['pfp'];
        return $pic;
    } else {
        return NULL;
    }
}

    public function getWorkHours($consultantID){
        $getPFP_query = "SELECT consultantHours FROM consultant WHERE consultantID = ?";
    
        $stmt = $this->conn->prepare($getPFP_query);
        $stmt->bind_param("i", $consultantID);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hours = $row['consultantHours'];
            return $hours;
        } else {
            return NULL;
        } 
    }
}
?>