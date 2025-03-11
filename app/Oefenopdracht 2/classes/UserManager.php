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

    public function registerUser($username, $email, $password) {

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            header("Location: registratie.php");
            echo "Username already exists. Please choose a different username.";
            exit();
        }

        try{
            $stmt = $this->conn->prepare("INSERT INTO users (username, emailaddress, password) VALUES (:username, :emailaddress, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':emailaddress', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            echo "Registration success!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
    
public function connection_user_games($user_id, $game_id) {

    $checkSql = "SELECT COUNT(*) FROM user_games WHERE user_id = :user_id AND game_id = :game_id";
                $checkStmt = $this->conn->prepare($checkSql);
                $checkStmt->bindParam(':user_id', $user_id);
                $checkStmt->bindParam(':game_id', $game_id);
                $checkStmt->execute();

                if ($checkStmt->fetchColumn() > 0) {
                    $message = date('Y-m-d H:i:s') . " - Connection between user and game already exists\n";

                    return false;
                }
    
    $checkStmt = $this->conn->prepare($checkSql);


    $sql= "INSERT INTO user_games (user_id, game_id) VALUES (:user_id, :game_id)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':game_id', $game_id);
    $stmt->execute();
    }

}

?>