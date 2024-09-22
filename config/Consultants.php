<?php
class Consultant{
	private $consultTable = 'consultant';
	private $userTable = 'user';
	private $conn;
    public function __construct(){
		$db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function getConsultantList($key) {
		if ($key == "") {
			$sqlQuery = "
				SELECT consultantID, consultantName, consultantEmail, consultantPhone, consultantPic, consultantHours, consultantPlace, consultantAbout
				FROM " . $this->consultTable . "
				ORDER BY consultantName ASC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		} else {
			$keyParam = "%" . $key . "%";
			$sqlQuery = "
				SELECT consultantID, consultantName, consultantEmail, consultantPhone, consultantPic, consultantHours, consultantPlace, consultantAbout
				FROM " . $this->consultTable . "
				WHERE consultantName LIKE ? OR consultantHours LIKE ? OR consultantPlace LIKE ? OR consultantEmail LIKE ? OR consultantAbout LIKE ?
				ORDER BY consultantName ASC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("sssss", $keyParam, $keyParam, $keyParam, $keyParam, $keyParam);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result;
		}
	}
	
	public function deleteConsultant($consultantID) {
		$imgQuery = "SELECT consultantPic FROM " . $this->consultTable . " WHERE consultantID = ?;";
		$stmt = $this->conn->prepare($imgQuery);
		$stmt->bind_param("i", $consultantID);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$oldImage = $row['consultantPic'];
		} else {
			$oldImage = "";
		}
	
		if ($oldImage != NULL) {
			unlink("../" . $oldImage);
		}
	
		$sqlQuery = "DELETE FROM " . $this->consultTable . " WHERE consultantID = ?;";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bind_param("i", $consultantID);
		$stmt->execute();
		header("Location: ../consultant.php");
	}	
}

?>