<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});




    
class UserManager {

    private $conn;

    public function __construct($conn) {
    $this -> conn = $conn;
    }
    //inloggen
// 
    public function getUser ($username) {
        $stmt = $this -> conn -> prepare("SELECT * FROM users WHERE username = :username");
        $stmt -> bindParam(':username', $username);
        $stmt -> execute();
        return $stmt -> fetch();
      
    }

    public function verify_password($username, $password) {
        
        // $conn = $database->getConnection();

        // Sanitize input
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
    }
    // registratie

    public function registerUser($username, $password, $emailaddress) {
        // Validate input
        if (empty($username) || empty($password) || empty($emailaddress)) {
            return false;
        }

        // $database = new Database();
        // $conn = $database->getConnection();

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (username, password, emailaddress) VALUES (:username, :password, :emailaddress)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':emailaddress', $emailaddress);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Sanitize input
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
        $emailaddress = htmlspecialchars($emailaddress, ENT_QUOTES, 'UTF-8');

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>