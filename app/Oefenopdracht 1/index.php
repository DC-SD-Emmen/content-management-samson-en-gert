

<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="index.css">
<title>registratie</title>
</head>
</body>

    <h2>registratie </h2>
    <form action="" method="post">

        <label for="username">Gebruikersnaam:</label>

        <input type="text" class="username1" name="username" required>

        <label for="password">Wachtwoord:</label>

        <input type="password" class="password1" name="password" required>

        <input type="submit" name="submit" value="registratie">

        <p>Heeft u al een account? <a href="inloggen.php">Log hier in</a></p>
    </form>

<body>

</body>

</html>

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
    // Validate input
    if (empty($username) || empty($password)) {
        echo "Gebruikersnaam en wachtwoord zijn verplicht.";
        exit;
    }

    $database = new Database();
    $conn = $database->getConnection();

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
    if ($stmt->execute()) {
        echo "U bent geregistreerd.";
    } else {
        echo "Er is een fout opgetreden bij het inloggen.";
    }
}
?>