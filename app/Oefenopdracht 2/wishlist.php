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

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: inloggen.php");
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
<div class="gridLibrary">
<div class="gridItem" id="gridItem1">
    <div class=wishlist id=storeWishlist> <p onclick="window.location.href='store.php'">STORE</p> </div>
    <div class=wishlist id=libraryWishlist> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
    <div class=wishlist id=add_gameWishlist> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
    <div class=wishlist id=wishlistWishlist> <p>WISHLIST</p> </div>
    <div class=wishlist id=uitloggenWishlist ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
</div>
</body>
</html>
<?php
$userManager = new UserManager($conn);
$user = $userManager->getUser($_SESSION['username']);
$user_id = $user['id'];

if (isset($_GET['action']) && $_GET['action'] == 'add_to_wishlist' && isset($_GET['game_id'])) {
    $game_id = intval($_GET['game_id']);
    $userManager->connection_user_games($user_id, $game_id);
}

$wishlistQuery = "
SELECT game.title, game.image
FROM game
INNER JOIN user_games ON game.id = user_games.game_id
WHERE user_games.user_id = :user_id;
";
$stmt = $conn->prepare($wishlistQuery);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$wishlistGames = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>My Wishlist</h2>";
if (count($wishlistGames) > 0) {
    echo "<ul>";
    foreach ($wishlistGames as $game) {
        echo "<div class='WishlistItem'><div id='WishlistTitle'><li>" . htmlspecialchars($game['title']) . "</li></div></div>";
        echo "<div class='WishlistItem'><div id='WishlistImage'><li><img src='uploads/" . htmlspecialchars($game['image']) . "' alt='" . htmlspecialchars($game['title']) . "'></li></div></div>";
    }
    echo "</ul>";
} else {
    echo "<p>Your wishlist is empty.</p>";
}
?>