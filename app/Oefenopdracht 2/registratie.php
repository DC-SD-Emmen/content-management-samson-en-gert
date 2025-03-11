<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Database();
$userManager = new UserManager($db->getConnection());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registratie'])) {
        $username = htmlspecialchars($_POST['username']);
        $emailaddress = htmlspecialchars($_POST['emailaddress']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        
        $result = $userManager->registerUser($username, $emailaddress, $password);

        if ($result) {
            echo "U bent geregistreerd.";
        } else {
            echo "Er is een fout opgetreden bij het registreren.";
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
    <title>registratie</title>
</head>
<body>
<div class="gridLibrary">
        <div class="gridItem" id="gridItem1">
            <div class=registreer id=storeRegistree> <p onclick="window.location.href='store.php'">STORE</p> </div>
            <div class=registreer id=libraryRegistree> <p>LIBRARY</p> </div>
            <div class=registreer id=add_gameRegistree> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div class=registreer id=RegistreerRegistree> <p>REGISTER</p></div>
            <div class=registreer id=InloggenRegistree> <p onclick="window.location.href='inloggen.php'">LOGIN</p></div>
        </div>
    
    <form action="" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" class="username1" name="username" required>

        <label for="emailaddress">E-Mail:</label>
        <input type="email" class="emailaddress1" name="emailaddress" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" class="password1" name="password" required>

        <input type="submit" name="registratie" value="registratie">

        <p>Heeft u al een account? <a href="inloggen.php">Log hier in</a></p>
    </form>
</body>
</html>