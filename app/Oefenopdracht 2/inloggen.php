<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
session_start();



$db = new Database(); 
$userManager = new UserManager($db->getConnection());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Inloggen'])) {
        $username = htmlspecialchars($_POST['username']);
        $emailaddress = htmlspecialchars($_POST['emailaddress']);
        $password = htmlspecialchars($_POST['password']);

        $user = $userManager->getUser($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            echo "Gebruikersnaam, e-mailadres of wachtwoord is onjuist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Eindopdracht.css">
    <link rel="stylesheet" type="text/css" href="detailpages.css">
    <title>Login</title>
</head>
<body>
<div class="gridLibrary">
        <div class="gridItem" id="gridItem1">
            <div class=inloggen id=libraryInloggen> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div class=inloggen id=add_gameInloggen> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div class=inloggen id=RegistreerInloggen> <p onclick="window.location.href='registratie.php'">REGISTER</p></div>
            <div class=inloggen id=InloggenInloggen> <p>LOGIN</p></div>
        </div>

    <form action="" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" class="username2" name="username" required>

        <label for="emailaddress">E-Mail:</label>
        <input type="email" class="emailaddress2" name="emailaddress" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" class="password2" name="password" required>

        <input type="submit" name="Inloggen" value="Inloggen">

        <p>Heeft u nog geen account? <a href="registratie.php">Registreer hier</a></p>
    </form>
</body>
</html>