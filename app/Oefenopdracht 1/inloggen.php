<?php

$host = "mysql";
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        include $file;
    }
});


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $errors = [];

    if (empty($errors)) {
        verify_password();
    } else {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
}

function verify_password() {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Validate input
    if (empty($username) || empty($password)) {
        echo "Gebruikersnaam en wachtwoord zijn verplicht.";
        exit;
    }
    $database = new Database();
    $conn = $database->getConnection();
    // Sanitize input
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        header("Location: users.php?id=" . $user['username'] . $user['id']);
        exit;
    } else {
        echo "Gebruikersnaam of wachtwoord is onjuist.";
    }
}
     
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Login</title>
</head>
<body>
    <h2>Inloggen</h2>
    <form action="" method="post">

        <label for="username">Gebruikersnaam:</label>

        <input type="text" class="username2" name="username" required>

        <label for="password">Wachtwoord:</label>

        <input type="password" class="password2" name="password" required>
        
        <input type="submit" name="submit" value="Inloggen">

        <p>Heeft u nog geen account? <a href="index.php">Registreer hier</a></p>
    </form>
</body>
</html>