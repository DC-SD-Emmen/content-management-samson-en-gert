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
        
    ?>
    
     <div class="gridLibrary">
        <div class="gridItem" id="gridItem1">
            <div class=store id=storeStore> <p>STORE</p> </div>
            <div class=add_game id=libraryAdd_game> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div class=store id=add_gameStore> <p onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div class=store id=RegistreerStore> <p onclick="window.location.href='registratie.php'">REGISTREER</p></div>
            <div class=store id=InloggenStore> <p onclick="window.location.href='inloggen.php'">INLOGGEN</p></div>
        </div>
        <!-- <div class="sideBar gridItem" id="gridItem2">
            <div class="sideBarItem">
                <?php
                $gameManager->getList('storedetail.php');
                ?>
            </div> -->
        </div>
        <div class="imageShelf gridItem" id="gridItem3">

                <?php


                $gameManager->get_data_list_picture2();
                ?>
                
            </div>
        </div> 
     </div>
    </body> 
</html>