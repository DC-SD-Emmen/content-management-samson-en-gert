<?php
session_start(); // Start de session 

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
    <title>Document</title>
    <link rel="stylesheet" href="eindopdracht.css">
</head>
<body>

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


            // foreach($gameManager as $gameManager ) {
            //          echo "<tr>";
            //          echo "<td>" . $gameManager-> getTitle() . "</td>";
            //          echo "<td>" . $gameManager-> getGenre() . "</td>";
            //          echo "<td>" . $gameManager-> getPlatform() . "</td>";
            //          echo "<td>" . $gameManager-> getRelease_year() . "</td>";
            //          echo "<td>" . $gameManager-> getRating() . "</td>";
            //          echo "<td>" . $gameManager-> getDescription() . "</td>";
            //          echo "<td>" . $gameManager-> getDeveloper() . "</td>";
            //          echo "</tr>";
            //      }
        
    ?>
    
     <div class="gridLibrary">
        <div class="gridItem" id="gridItem1">
            <div class=library id=storeLibrary> <p onclick="window.location.href='store.php'">STORE</p> </div>
            <div class=library id=libraryLibrary> <p>LIBRARY</p> </div>
            <div class=library id=add_gameLibrary> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div class=library id=wishlistLibrary> <p onclick="window.location.href='wishlist.php'">WISHLIST</p></div>
            <div class=library id=uitloggenLibrary ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
        </div>
        <div class="sideBar gridItem" id="gridItem2">
            <div class="sideBarItem">
                <?php
                $gameManager->getList();
                ?>
            </div>
        </div>
        <div class="imageShelf gridItem" id="gridItem3">

                <?php


                $gameManager->get_data_list_picture();
                ?>
                
            </div>
        </div> 
     </div>
    </body> 
</html>