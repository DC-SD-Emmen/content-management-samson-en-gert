<?php

$host = "mysql";
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";

spl_autoload_register(function ($class) {
    include __DIR__ . '/' . $class . '.php';
});

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
    <form action="process_login.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Inloggen</button>
        <p>Heeft u nog geen account? <a href="index.php">Registreer hier</a></p>
    </form>
</body>
</html>