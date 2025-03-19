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
                <div class=detailpages id=libraryLibrary> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
                <div class=detailpages id=add_gameLibrary> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <div class=detailpages id=wishlistLibrary> <p onclick="window.location.href='wishlist.php'">WISHLIST</p></div>
                <div class=library id=wishlistLibrary> <p onclick="window.location.href='account.php'">ACCOUNT SETTINGS</p></div>
                <div class=detailpages id=uitloggenLibrary ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
                
            </div>

        <div class="sideBar gridItem">
            <div class="sideBarItem">
                <?php
                    $gameManager->getList();
                ?>
            </div>
        </div>
        
            <div class="detail-container">
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
                <a href="index.php" class="back-button">back to Library</a>
            </div>

        </div>  
    </body>
</html>


