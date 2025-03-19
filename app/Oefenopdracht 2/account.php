<?php

session_start(); // Start de session 

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

// Maak een nieuwe databaseverbinding
$db = new Database();
$conn = $db->getConnection();
$userManager = new UserManager($conn);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: inloggen.php");
    exit;
}

// maakt de session kapot als je op logout klikt en stuurt je naar de inlogpagina
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: inloggen.php");
    exit;
}

// Verwijder het account
// Als het formulier is verzonden en de knop is ingedrukt dan wordt de functie deleteUser aangeroepen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteAccount'])) {
    // Haal de huidige gebruikersnaam op uit de sessie
    $currentUsername = $_SESSION['username'];
    // Haal het wachtwoord op van de gebruiker
    $password = htmlspecialchars($_POST['currentPassword']);

    // Probeer het account te verwijderen
    if ($userManager->deleteUser($currentUsername, $password)) {
        session_destroy(); // Vernietig de sessie
        header("Location: inloggen.php"); // Stuur de gebruiker naar de loginpagina
        exit;
    } else {
        echo "Incorrect password. Account not deleted.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="eindopdracht.css">
        <link rel="stylesheet" href="detailpages.css">
    </head>
    <body>
        
            <div class="gridItem" id="gridItem1">
                <div class=account id=libraryAccount> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
                <div class=account id=add_gameAccount> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <div class=account id=wishlistAccount> <p onclick="window.location.href='wishlist.php'">WISHLIST</p></div>
                <div class=account id=accountAccount> <p onclick="window.location.href='account.php'">ACCOUNT SETTINGS</p></div>
                <div class=account id=uitloggenAccount><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
            </div>
            <div class="usernameAccount">
                <?php echo htmlspecialchars($_SESSION['username']) . ", here is your Account Settings"; ?>
            </div>
            <?php
             

                    // verander de gebruikersnaam
                    // Als het formulier is verzonden en de knop is ingedrukt dan wordt de functie updateUsername aangeroepen
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUsername'])) {
                    $currentUsername = $_SESSION['username'];
                    $newUsername = htmlspecialchars($_POST['newUsername']);
                    $password = htmlspecialchars($_POST['currentPassword']);

                    // Probeer de gebruikersnaam bij te werken
                    if ($userManager->updateUsername($currentUsername, $newUsername, $password)) {
                        $_SESSION['username'] = $newUsername; // Update de sessie met de nieuwe gebruikersnaam
                        echo "Username successfully updated!";
                    } else {
                        echo "Something went wrong, username not updated.";
                    }
                }   
                    // verander het emailadres
                    // Als het formulier is verzonden en de knop is ingedrukt dan wordt de functie updateEmail aangeroepen
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateEmail'])) {
                        $currentUsername = $_SESSION['username'];
                        $newEmail = htmlspecialchars($_POST['newEmail']);
                        $password = htmlspecialchars($_POST['currentPassword']);
                    
                        // Probeer het e-mailadres bij te werken
                        if ($userManager->updateEmail($currentUsername, $newEmail, $password)) {
                            echo "E-mail successfully updated!";
                        } else {
                            echo "Incorrect password. E-mail not updated.";
                        }
                    }

                    // verander het wachtwoord
                    // Als het formulier is verzonden en de knop is ingedrukt dan wordt de functie updatePassword aangeroepen
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePassword'])) {
                        $currentUsername = $_SESSION['username'];
                        $newPassword = htmlspecialchars($_POST['newPassword']);
                        $password = htmlspecialchars($_POST['currentPassword']);
                    
                        // Probeer het wachtwoord bij te werken
                        if ($userManager->updatePassword($currentUsername, $password, $newPassword)) {
                            echo "Password successfully updated!";
                        } else {
                            echo "Incorrect password. Password not updated.";
                        }
                    }

            ?>

            <form action="" method="post">
                <h2>Delete Account</h2>
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="currentPassword" name="currentPassword" required>

                <input type="submit" name="deleteAccount" value="Delete Account">
            </form>


            <form action="" method="post">
                <h2>change username</h2>
                <label for="newUsername">New Username:</label>
                <input type="text" class="newUsername" name="newUsername" required>
                    
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="currentPassword" name="currentPassword" required>

                <input type="submit" name="updateUsername" value="Update Username">
            </form>

            <form action="" method="post">
                <h2>change E-Mail</h2>
                <label for="newEmail">New E-Mail:</label>
                <input type="text" class="newEmail" name="newEmail" required>
                    
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="currentPassword" name="currentPassword" required>

                <input type="submit" name="updateEmail" value="Update E-Mail">
            </form>

            <form action="" method="post">
                <h2>change password</h2>
                <label for="newPassword">New Password:</label>
                <input type="password" class="newPassword" name="newPassword" required>
                    
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="currentPassword" name="currentPassword" required>

                <input type="submit" name="updatePassword" value="Update Password">
            </form>
    </body>
</html>