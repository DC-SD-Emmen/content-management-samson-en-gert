<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});




    
class UserManager {


    private $conn;

    public function __construct($conn) {
    $this -> conn = $conn;
        }
   
        //inloggen// 

    public function getUser ($username) {
        $stmt = $this -> conn -> prepare("SELECT * FROM users WHERE username = :username");
        // Bindt de waarde van de variabele $username aan de parameter :username in de SQL-query.
        // Dit zorgt ervoor dat de waarde veilig wordt ingevoerd in de database zonder risico op SQL-injecties.
        $stmt -> bindParam(':username', $username);
        $stmt -> execute();
        return $stmt -> fetch();
      
    }

    public function verify_password($username, $password) {

        // Sanitize input
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        // Start een SQL-statement om gebruikersgegevens op te halen op basis van de gebruikersnaam.
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
    }
        // registratie//

    public function registerUser($username, $email, $password) {

        // start een SQL-query voor om het aantal gebruikers te tellen met een specifieke gebruikersnaam.
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            header("Location: registratie.php");

            echo "Username already exists. Please choose a different username.";
            exit();
        }

        try {
            // start een SQL-query om een nieuwe gebruiker toe te voegen aan de database
            $stmt = $this->conn->prepare("INSERT INTO users (username, emailaddress, password) VALUES (:username, :emailaddress, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':emailaddress', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            echo "Registratie succesvol!";
        } catch (PDOException $e) {
            // Vang eventuele PDOExceptions op
            // Toon het foutbericht
            // Stop de uitvoering van het script
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

        // Wishlist//
    
    public function connection_user_games($user_id, $game_id) {

        // start een SQL-query voor om het aantal gebruikers te tellen met een specifieke gebruikersnaam.
        $checkSql = "SELECT COUNT(*) FROM user_games WHERE user_id = :user_id AND game_id = :game_id";
                    $checkStmt = $this->conn->prepare($checkSql);
                    $checkStmt->bindParam(':user_id', $user_id);
                    $checkStmt->bindParam(':game_id', $game_id);
                    $checkStmt->execute();
                    // Controleer of de connectie tussen de gebruiker en het spel al bestaat
                    if ($checkStmt->fetchColumn() > 0) {
                        $message = date('Y-m-d H:i:s') . " - Connection between user and game already exists\n";

                        return false;
                    }
    // start een SQL-query voor om het aantal gebruikers te tellen met een specifieke gebruikersnaam.
        $checkStmt = $this->conn->prepare($checkSql);

    // SQL-query om een game toe te voegen aan de wishlist van een gebruiker
        $sql= "INSERT INTO user_games (user_id, game_id) VALUES (:user_id, :game_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':game_id', $game_id);
        $stmt->execute();
    }
    // Verwijder een game uit de wishlist van een gebruiker
    public function removeFromWishlist($user_id, $game_id) {
        // SQL-query om een game te verwijderen uit de user_games-tabel
        $sql = "DELETE FROM user_games WHERE user_id = :user_id AND game_id = :game_id";
        // Bereid de SQL-statement voor
        $stmt = $this->conn->prepare($sql);
        // Bind de parameters user_id en game_id aan de query
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':game_id', $game_id);
        // Voer de query uit
        $stmt->execute();
    }

        // Account settings//

        // Gebruikersnaam wijzigen//

    public function updateUsername($currentUsername, $newUsername, $password) {
        // Haal de huidige gebruiker op
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        // Controleer of de nieuwe gebruikersnaam al bestaat
        $checkStmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :newUsername");
        $checkStmt->bindParam(':newUsername', $newUsername);
        $checkStmt->execute();
        if ($checkStmt->fetchColumn() > 0) {
            return false; // Nieuwe gebruikersnaam bestaat al
        }

        if (!isset($_POST['currentPassword']) || empty($_POST['currentPassword'])) {
            echo "Old password is required.";
            return false;
        }

        $oldPassword = htmlspecialchars($_POST['currentPassword'], ENT_QUOTES, 'UTF-8');
        $stmt->bindParam(':username', $currentUsername);
        $stmt->execute();
        $user = $stmt->fetch();
    
        // Controleer of het wachtwoord klopt
        if ($user && password_verify($password, $user['password'])) {
            // Update de gebruikersnaam
            $updateStmt = $this->conn->prepare("UPDATE users SET username = :newUsername WHERE username = :currentUsername");
            $updateStmt->bindParam(':newUsername', $newUsername);
            $updateStmt->bindParam(':currentUsername', $currentUsername);
            $updateStmt->execute();
            return true;
            } else {
                    return false; // Wachtwoord is onjuist
                }
            }
        
    
            // Email wijzigen//
            
    public function updateEmail($currentUsername, $newEmail, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $currentUsername);
        $stmt->execute();
        $user = $stmt->fetch();
            
    if ($user && password_verify($password, $user['password'])) {
        $updateStmt = $this->conn->prepare("UPDATE users SET emailaddress = :newEmail WHERE username = :currentUsername");
        $updateStmt->bindParam(':newEmail', $newEmail);
        $updateStmt->bindParam(':currentUsername', $currentUsername);
        $updateStmt->execute();
        return true;
        } else {
            return false; // Wachtwoord is onjuist
        }
    }

        // Wachtwoord wijzigen//

    public function updatePassword($username, $currentPassword, $newPassword) {
        // Haal de huidige gebruiker op
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
            
        // Controleer of het wachtwoord klopt
        if ($user && password_verify($currentPassword, $user['password'])) {
        // het nieuwe wachtwoord hashen
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        // Update het wachtwoord    
            $updateStmt = $this->conn->prepare("UPDATE users SET password = :newPassword WHERE username = :username");
            $updateStmt->bindParam(':newPassword', $hashedNewPassword);
            $updateStmt->bindParam(':username', $username);
            $updateStmt->execute();
            return true;
        } else {
            return false; // Wachtwoord is onjuist
        }
    }

        // Account verwijderen//

    public function deleteUser($username, $password) {
        // Haal de huidige gebruiker op
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
    
        // Controleer of het wachtwoord klopt
        if ($user && password_verify($password, $user['password'])) {
            // Verwijder de wishlist-items van de gebruiker
            $deleteWishlistStmt = $this->conn->prepare("DELETE FROM user_games WHERE user_id = :user_id");
            $deleteWishlistStmt->bindParam(':user_id', $user['id']);
            $deleteWishlistStmt->execute();
            // Verwijder de gebruiker
            $deleteStmt = $this->conn->prepare("DELETE FROM users WHERE username = :username");
            $deleteStmt->bindParam(':username', $username);
            $deleteStmt->execute();
            return true;
        } else {
            return false; // Wachtwoord is onjuist
        }
    }
}

?>