<?php
class Topic {	
   
	private $topicTable = 'forum_topics';
	private $postTable = 'forum_posts';
	private $userTable = 'user';
	private $conn;
	
	public function __construct(){
		$db = new DatabaseConnection;
        $this->conn = $db->conn;
    }	
	
	public function insert(){				
		if($this->topicName && $this->message && $_SESSION["auth_user"]["user_id"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->topicTable."(`subject`, `user_id`)
				VALUES(?, ?)");
						
			$stmt->bind_param("si", $this->topicName, $_SESSION["auth_user"]["user_id"]);
			
			if($stmt->execute()){	
				$lastTopicId = $stmt->insert_id;
				
				$stmt2 = $this->conn->prepare("
				INSERT INTO ".$this->postTable."(`message`, `topic_id`, `user_id`)
				VALUES(?, ?, ?)");
				
				$stmt2->bind_param("sii", $this->message, $lastTopicId, $_SESSION["auth_user"]["user_id"]);
				$stmt2->execute();
				echo $lastTopicId;
			}		
		}
	}
	
	public function getTopicList($key)
{
    if ($key == "") {
        $sqlQuery = "SELECT subject, topic_id, user_id, created, created FROM " . $this->topicTable . " ORDER BY topic_id DESC";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    } else {
        $sqlQuery = "SELECT subject, topic_id, user_id, created, created FROM " . $this->topicTable . " WHERE subject LIKE ? ORDER BY topic_id DESC";
        $searchKey = "%" . $key . "%";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("s", $searchKey); 
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

	
public function getTopic()
{
    if ($this->topic_id) {
        $sqlQuery = "SELECT subject FROM " . $this->topicTable . " WHERE topic_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $this->topic_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        $topicDetails = $result->fetch_assoc();
        return $topicDetails;
    }
}

	
public function getPosts()
{
    if ($this->topic_id) {
        $sqlQuery = "SELECT t.topic_id, p.post_id, p.message, p.topic_id, p.user_id, p.created, u.name, u.accType, u.email
            FROM " . $this->topicTable . " as t
            LEFT JOIN " . $this->postTable . " as p ON t.topic_id = p.topic_id
            LEFT JOIN " . $this->userTable . " as u ON p.user_id = u.UserID
            WHERE p.topic_id = ?
            ORDER BY p.post_id ASC";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $this->topic_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
	
public function getTopicPostCount()
{
    if ($this->topic_id) {
        $sqlQuery = "SELECT count(*) as total_posts
            FROM " . $this->postTable . "
            WHERE topic_id = ?";
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $this->topic_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoryDetails = $result->fetch_assoc();
        return $categoryDetails['total_posts'];
    }
}


public function deleteTopic()
{
    $sqlQuery = "DELETE FROM " . $this->postTable . " WHERE topic_id = ?";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->bind_param("i", $this->topic_id); 
    $stmt->execute();
    $sqlQuery2 = "DELETE FROM " . $this->topicTable . " WHERE topic_id = ?";
    $stmt2 = $this->conn->prepare($sqlQuery2);
    $stmt2->bind_param("i", $this->topic_id);
    $stmt2->execute();
    header("Location: ../forum.php");
}

	
}
?>