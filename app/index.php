<?php

$host = "mysql";
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";

spl_autoload_register(function ($class) {
    include __DIR__ . '/' . $class . '.php';
});


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $database = new Database();
    $conn = $database->getConnection();

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo "Registratie succesvol!";
    } else {
        echo "Er is een fout opgetreden bij de registratie.";
    }
}

?>

<html>

<head>

<title>Registratie</title>
</head>
<body>

    <h2>inloggen</h2>
    <form action="index.php" method="post">

        <label for="username">Gebruikersnaam:</label><br>

        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Wachtwoord:</label><br>

        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Registreren">
    </form>

<body>

</body>

</html>
