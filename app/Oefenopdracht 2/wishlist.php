<?php
    spl_autoload_register(function ($class) {
        include 'classes/' . $class . '.php';
    });

    session_start(); // Start de session 

    $db = new Database();
    $conn = $db->getConnection();

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

   // Maak een nieuwe UserManager aan en geef de databaseverbinding door
    $userManager = new UserManager($conn);
    $user = $userManager->getUser($_SESSION['username']);
    $user_id = $user['id'];

    // als je op de kop add_to_wishlist drukt dan wordt de game toegevoegd aan de wishlist
    if (isset($_GET['action']) && $_GET['action'] == 'add_to_wishlist' && isset($_GET['game_id'])) {
        // Haal de game_id op ( intval zorgt ervoor dat het waarde wordt omgezet naar een integer dus een geheel getal)
        $game_id = intval($_GET['game_id']);
        $userManager->connection_user_games($user_id, $game_id);
    }

    // als je op de kop remove_to_wishlist drukt dan wordt de game verwijderd van de wishlist
    if (isset($_GET['action']) && $_GET['action'] == 'remove_to_wishlist' && isset($_GET['game_id'])) {
        // Haal de game_id op ( intval zorgt ervoor dat het waarde wordt omgezet naar een integer dus een geheel getal)
        $game_id = intval($_GET['game_id']);
        $userManager->removeFromWishlist($user_id, $game_id);
        header("Location: wishlist.php"); // Vernieuw de pagina na het verwijderen
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="eindopdracht.css">
        <link rel="stylesheet" href="detailpages.css">
        <title>Wishlist</title>
    </head>
    <body>

        <div class="gridItem" id="gridItem1">
            <div class=wishlist id=libraryWishlist> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div class=wishlist id=add_gameWishlist> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div class=wishlist id=wishlistWishlist> <p onclick="window.location.href='wishlist.php'">WISHLIST</p> </div>
            <div class=wishlist id=wishlistLibrary> <p onclick="window.location.href='account.php'">ACCOUNT SETTINGS</p></div>
            <div class=wishlist id=uitloggenWishlist ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
        </div>
    </body>
</html>

<?php

   
    // Maak een nieuwe UserManager aan en geef de databaseverbinding door
    $userManager = new UserManager($conn);
    $user = $userManager->getUser($_SESSION['username']);
    $user_id = $user['id'];

    // Haal de games op die in de wishlist staan
    $wishlistQuery = "
    SELECT game.id, game.title, game.image, game.description, game.genre, game.platform, game.release_year, game.rating, game.developer
    FROM game
    INNER JOIN user_games ON game.id = user_games.game_id
    WHERE user_games.user_id = :user_id;
    ";

    // Bereid de query voor
    $stmt = $conn->prepare($wishlistQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    // Haal de resultaten op
    // Fetch de resultaten als een associatieve array
    $wishlistGames = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=wishlistUsername>" . htmlspecialchars($_SESSION['username']) . ", here is your wishlist:" . "</div>";

    echo "<div class='WishlistGrid'>";
    // tel de games in de wishlist
    if (count($wishlistGames) > 0) {
        echo "<ul>";
        // Loop door de games heen
        foreach ($wishlistGames as $game) {
            // Laat de game zien
            echo "<div class='WishlistItem'>";
            echo "<a href='detailPages.php?id=" . htmlspecialchars($game['id']) . "'>";
            echo "<div class='WishlistImage'><img src='uploads/" . htmlspecialchars($game['image']) . "' alt='" . htmlspecialchars($game['title']) . "'></div>";
            echo "</a>";
            echo "<div id='WishlistTeks'>";
            echo "<div id='WishlistTitle'>" . htmlspecialchars($game['title']) . "</div>";
            echo "<div id='Wishlistrating'>Rating: " . htmlspecialchars($game['rating']) . "</div>";
            echo "<div id='Wishlistrelease_year'>Release year: " . htmlspecialchars($game['release_year']) . "</div>";
            echo "<div id='WishlistDeveloper'>Developer: " . htmlspecialchars($game['developer']) . "</div>";
            echo "<div id='WishlistGenre'>Genre: " . htmlspecialchars($game['genre']) . "</div>";
            echo  "<a href='wishlist.php?action=remove_to_wishlist&game_id=" . htmlspecialchars($game['id']) . "' class='remove_to_wishlist'>remove from wishlist</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<p>Your wishlist is empty.</p>";
    }
?>