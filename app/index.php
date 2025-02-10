<?php

$host = "mysql";
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";
?>

<html>

<head>

<title>Registratie</title>
</head>
<body>
    <h2>Registratieformulier</h2>
    <form action="register.php" method="post">
        <label for="username">Gebruikersnaam:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Registreren">
    </form>

<body>

</body>

</html>
