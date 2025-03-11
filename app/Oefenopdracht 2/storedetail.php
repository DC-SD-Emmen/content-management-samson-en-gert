<?php 
    spl_autoload_register(function ($class) {
        include 'classes/' . $class . '.php';
    });
    
    $db = new Database();

    $gameManager = new GameManager($db);

    if(isset($_POST['submit'])) {

        $gameManager->file_upload($_FILES["fileToUpload"]);
        $gameManager->addGame($_POST, $_FILES["fileToUpload"]['name']);
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
    
        <div class="gridLibrary">
            <div class="gridItem" id="gridItem1">
                <div class=storedetailpages id=storeStoreDetailpages> <p onclick="window.location.href='store.php'">STORE</p> </div>
                <div class=storedetailpages id=libraryStoreDetailpages> <p>LIBRARY</p> </div>
                <div class=storedetailpages id=add_gameStoreDetailpages> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <div class=storedetailpages id=RegistreerStoreDetailpages> <p onclick="window.location.href='registratie.php'">REGISTREER</p></div>
                <div class=storedetailpages id=InloggenStoreDetailpages> <p onclick="window.location.href='inloggen.php'">INLOGGEN</p></div>
            </div>

            <div class="storeDetailContainer">
                <?php
                // Haal gamegegevens op via ID
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $gameManager->get_data_by_id($id);
                } else {
                    echo "<p>Geen ID opgegeven.</p>";
                }
                ?>
                <a href="wishlist.php?action=add_to_wishlist&game_id=<?php echo $id; ?>" class="add_to_wishlist">Add to wishlist</a>
                <a href="store.php" class="back-button" >back to store</a>
            </div>

        </div>  
    </body>
</html>


