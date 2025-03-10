<?php 
    session_start(); // Start de session 

    spl_autoload_register(function ($class) {
        include 'classes/' . $class . '.php';
    });
    
    $db = new Database();

    $gameManager = new GameManager($db);

    if(isset($_POST['submit'])) {

        $gameManager->file_upload($_FILES["fileToUpload"]);
        $gameManager->addGame($_POST, $_FILES["fileToUpload"]['name']);
        }
        
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
    
        <div class="gridItem">
            <div class=add_game id=storeAdd_game> <p onclick="window.location.href='store.php'">STORE</p> </div>
            <div class=add_game id=libraryAdd_game> <p onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div class=add_game id=add_gameAdd_game> <p>ADD GAME</p> </div>
            <div class=add_game id=uitloggenLibrary ><p> <a href="index.php?action=logout">LOGOUT</a></p></div>
        </div>
        <div class="gridAdd_game">
            <form method='POST' enctype="multipart/form-data">

                <label id="textTitle" for='title'>title:</label>
                <input type='text' name='title'> <br><br>

                <label id="textGenre" for='genre'>genre:</label>
                <input type='text' name='genre'> <br><br>

                <name='platform'><label for="platform">Choose a platform:</label>
                <select name="platform" id="platform">
                <option value="PC">PC</option>
                <option value="Xbox">Xbox</option>
                <option value="PlayStation">PlayStation</option>
                <option value="Nintendo">Nintendo</option>
                </select> <br><br>          

                <label id="textRelease_year" for='release_year'>release_year:</label>
                <input type='date' name='release_year'> <br><br>

                <label id="textRating" for='rating'>rating:</label>
                <input id="formRating" type="range" name="rating" placeholder="rating" min="1.0" max="10.0" step="0.1" required
                oninput="this.nextElementSibling.value = parseFloat(this.value).toFixed(1)">
                <output for="rating">5.0</output> <br><br> 

                <label id="textDeveloper" for='developer'>developer:</label>
                <input type='text' name='developer'> <br><br>

                <label id="textDescription" for='description'>description:</label>
                <input type='text' name='description'> <br><br>

                <input type="file" name="fileToUpload" id="fileToUpload"><br><br>

                <input type='submit' name='submit'>
            </form>


            <?php


                

                class add_game {
                
                private $personen; 

                public function __construct($db) {
            
                    $this->personen = $db->add_game(); 
                }
            

                public function displayGames() {
        
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $personen = $db->add_game();
                    if ($_SERVER["REQUEST_METHOD"] == "POST") 


                    foreach($personen as $persoon ) {
                    echo "<tr>";
                    echo "<td>" . $persoon-> getTitle() . "</td>";
                    echo "<td>" . $persoon-> getGenre() . "</td>";
                    echo "<td>" . $persoon-> getPlatform() . "</td>";
                    echo "<td>" . $persoon-> getRelease_year() . "</td>";
                    echo "<td>" . $persoon-> getRating() . "</td>";
                    echo "<td>" . $persoon-> getImage() . "</td>";
                    echo "<td>" . $persoon-> getDescription() . "</td>";
                    echo "<td>" . $persoon-> getDeveloper() . "</td>";
                    echo "</tr>";
                    }
                    }
                }
                }
            ?>
              
        </div>
    </body>
</html>