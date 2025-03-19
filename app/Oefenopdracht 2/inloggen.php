<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
session_start();



$db = new Database(); 
$userManager = new UserManager($db->getConnection());

// Check if the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // als je op de knop inloggen drukt dan wordt de username, email en wachtwoord opgehaald
    if (isset($_POST['Inloggen'])) {
        $username = htmlspecialchars($_POST['username']);
        $emailaddress = htmlspecialchars($_POST['emailaddress']);
        $password = htmlspecialchars($_POST['password']);

        $user = $userManager->getUser($username);

        // Check if the user exists and the password is correct
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
            <div class="gridItem" id="gridItemInloggen">
                <div class=inloggen id=libraryInloggen> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
                <div class=inloggen id=add_gameInloggen> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <div class=inloggen id=RegistreerInloggen> <p onclick="window.location.href='registratie.php'">REGISTER</p></div>
                <div class=inloggen id=InloggenInloggen> <p onclick="window.location.href='inloggen.php'">LOGIN</p></div>
         </div>

        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" class="username2" name="username" required>

            <label for="emailaddress">E-Mail:</label>
            <input type="email" class="emailaddress2" name="emailaddress" required>

            <label for="password">Password:</label>
            <input type="password" class="password2" name="password" required>

            <input type="submit" name="Inloggen" value="Login">

            <p>Don't have an account? <a href="registratie.php">Click here</a></p>
        </form>
    </body>
</html>