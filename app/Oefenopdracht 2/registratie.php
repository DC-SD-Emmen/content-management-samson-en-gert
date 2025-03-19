<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Database();
$userManager = new UserManager($db->getConnection());


// Controleert of het formulier is verzonden via een POST-verzoek
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleert of het formulier is ingediend door te kijken of de knop met de naam 'registratie' is ingedrukt.
    if (isset($_POST['registratie'])) {
        $username = htmlspecialchars($_POST['username']);
        $emailaddress = htmlspecialchars($_POST['emailaddress']);
        // Hash het wachtwoord voordat het wordt opgeslagen in de database
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        // Registreer de gebruiker
        $result = $userManager->registerUser($username, $emailaddress, $password);
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
        <title>registratie</title>
    </head>
    <body>
        <div class="gridLibrary">
                <div class="gridItem" id="gridItemInloggen">
                    <div class=registreer id=libraryRegistree> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
                    <div class=registreer id=add_gameRegistree> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                    <div class=registreer id=RegistreerRegistree> <p onclick="window.location.href='registratie.php'">REGISTER</p></div>
                    <div class=registreer id=InloggenRegistree> <p onclick="window.location.href='inloggen.php'">LOGIN</p></div>
                </div>
            
            <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" class="username1" name="username" required>

                <label for="emailaddress">E-Mail:</label>
                <input type="email" class="emailaddress1" name="emailaddress" required>

                <label for="password">Password:</label>
                <input type="password" class="password1" name="password" required>

                <input type="submit" name="registratie" value="Register">

                <p>Already have an account? <a href="inloggen.php">Click here</a></p>
            </form>
    </body>
</html>