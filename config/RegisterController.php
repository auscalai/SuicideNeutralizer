<?php

class RegisterController 
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function registration($name, $email, $password, $regDate)
{
    $token= $this->token();
    $register_query = "INSERT INTO user (Name, Email, Password, registerDate, accType, token) VALUES (?, ?, ?, ?, 'Member', ?)";
    $stmt = $this->conn->prepare($register_query);
    $stmt->bind_param("sssss", $name, $email, $password, $regDate, $token);
    $result = $stmt->execute();
    return $result;
}

public function isEmailExist($email)
{
    $checkEmail = "SELECT Email FROM user WHERE Email = ? LIMIT 1";
    $stmt = $this->conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

public function isUsernameExist($name)
{
    $checkName = "SELECT Name FROM user WHERE Name = ? LIMIT 1";
    $stmt = $this->conn->prepare($checkName);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

public function isMinFourChar($input)
{
    return strlen($input) >= 4;
}

public function token($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}   
}

class LoginController   
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function login($email, $password)
{
    $login_query = "SELECT UserID, Name, Email, Password, pfp, registerDate, accType, token, imgURL FROM user WHERE Email = ? LIMIT 1";
    $stmt = $this->conn->prepare($login_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['Password'])) {
            $this->userAuthentication($data);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

    private function userAuthentication($data)
    {
        $_SESSION['authenticated'] = true;
        $_SESSION['auth_user'] = [
            'user_id' => $data['UserID'],
            'user_name' => $data['Name'],
            'user_email' => $data['Email'],
            'user_pfp' => $data['pfp'],
            'user_regDate' => $data['registerDate'],
            'user_type' => $data['accType'],
            'user_token' => $data['token'],
            'imgURL' => $data['imgURL']
        ];
    }

    public function logout()
{
    if ($_SESSION['authenticated']) {
        session_unset();
        session_destroy(); 
        return true;
    } else {
        return false;
    }
}

    public function editUserType($userID, $typeChange){
        $edit_query = "UPDATE user
            SET accType = ?
            WHERE UserID = ?";
    
        $stmt = $this->conn->prepare($edit_query);
        $stmt->bind_param("ss", $typeChange, $userID);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }

}
