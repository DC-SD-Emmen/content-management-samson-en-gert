<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});


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
    <div class=wishlist id=storewishlist> <p onclick="window.location.href='store.php'">STORE</p> </div>
    <div class=wishlist id=librarywishlist> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
    <div class=wishlist id=add_gamewishlist> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
    <div class=wishlist id=wishlistwishlist> <p>WISHLIST</p> </div>
    <div class=wishlist id=uitloggenwishlist ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
</div>
</body>
</html>