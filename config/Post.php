<?php
class Post {	
   
	private $postTable = 'forum_posts';
	private $userTable = 'user';
	private $conn;
	
	public function __construct(){
		$db = new DatabaseConnection;
        $this->conn = $db->conn;
    }	
	
	
	public function insert(){				
		if($this->message && $this->topic_id && $_SESSION["auth_user"]["user_id"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->postTable."(`message`, `topic_id`, `user_id`)
				VALUES(?, ?, ?)");
						
			$stmt->bind_param("sii", $this->message, $this->topic_id, $_SESSION["auth_user"]["user_id"]);
			
			if($stmt->execute()){	
				$lastPid = $stmt->insert_id;
				$sqlQuery = "
					SELECT post.post_id, post.message, post.user_id, DATE_FORMAT(post.created,'%d %M %Y %H:%i:%s') AS post_date, user.name, user.pfp, user.accType, user.email, post.topic_id
					FROM ".$this->postTable." post
					LEFT JOIN ".$this->userTable." user ON post.user_id = user.UserID
					WHERE post.post_id = '".$lastPid."'";
				$stmt2 = $this->conn->prepare($sqlQuery);				
				$stmt2->execute();
				$result = $stmt2->get_result();
				$record = $result->fetch_assoc();
				echo json_encode($record);
			}		
		}
	}

	public function getPFP($postID) {
		$sqlQuery = "SELECT pfp FROM " . $this->postTable . " post, " . $this->userTable . " user WHERE post.user_id = user.UserID AND post.post_id = ?";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bind_param("i", $postID);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if ($row['pfp'] == NULL) {
				return "img/pfp.jpeg";
			} else {
				return $row['pfp'];
			}
		} else {
			return false;
		}
	}
	
	public function deletePost() {
		$sqlQuery = "DELETE FROM " . $this->postTable . " WHERE post_id = ?";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bind_param("i", $this->post_id);
		$stmt->execute();
		header("Location: ../post.php?topic_id=" . $this->topic_id);
	}
	

}
?>