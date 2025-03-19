<?php

class GameManager {
    private $conn;

    // Constructor with database connection as parameter
    public function __construct($db) {
        if ($db instanceof PDO) {
            $this->conn = $db;
        } elseif (method_exists($db, 'getConnection')) {
            $this->conn = $db->getConnection();
        } else {
            throw new TypeError('Expected PDO or a class with getConnection() method.');
        }
        include_once 'Game.php';
    }
   

    public function addGame($data, $image) {

        //waarom gebruiken we htmlspecialchars?
        // het doel van htmlspecialchars is om te verkomen dat er HTML of JavaScript injections worden gedaan
        $title = htmlspecialchars($data["title"]);
        $genre = htmlspecialchars($data["genre"]);
        $platform = $data["platform"];
        $release_year = $data["release_year"];
        $rating = $data["rating"];
        $description = htmlspecialchars($data["description"]);
        $developer = htmlspecialchars($data["developer"]);

        $titleRegex = '/^[A-Za-z]+(\s(or|and|[A-Za-z]+))*\s?[!?.,]*$/';
        $genreRegex = '/[A-z]*\s{0,1}[A-z]{0,50}\s{0,1}[A-z]{0,50}$/';
        $regexPlatform = '/([A-z]*[0-9]{0,10}\,\s){0,10}[A-z]*[0-9]{0,10}$/';
        $regexRating = "/[0-5]{1}(\,{0,1}[0-9]{0,1})$/";
        $regexDescription = "/.*/";

        if (!preg_match($titleRegex, $title)) {
            echo "Please enter a correct title";
        } else if (!preg_match($genreRegex, $genre)) {
            echo "Please enter a correct genre";
        } else {
       
            try {
                $sql = "INSERT INTO game (title, genre, platform, release_year, rating, description, developer, image)
                        VALUES (:title, :genre, :platform, :release_year, :rating, :description, :developer, :image)";
                //waarom gebruiken we bindParam?
                //de redenen waarom we bindParam gebruiken is om de variabele te binden aan de placeholders (het helpt tegen SQL injections en het maakt het netter)
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':genre', $genre);
                $stmt->bindParam(':platform', $platform);
                $stmt->bindParam(':release_year', $release_year);
                $stmt->bindParam(':rating', $rating);
                $stmt->bindParam(':developer', $developer);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $image);

                $stmt->execute();
                echo "Data inserted successfully<br><br>";
            } catch (PDOException $e) {
                echo "Insert data failed: " . $e->getMessage();
                echo "<br><br>";
            }
        }
    }

    public function getData() {

        try { 
            $stmt = $this->getConnection()->query("SELECT * FROM gameManager");
            $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //waarom gebruiken we fetch_assoc?
            //we gebruiken FETCH_ASSOC om alle data dat we van de database pakken automatisch in een array te zetten (associatieve array)
        } 
        
        catch (PDOException $e) {
            echo "Fout bij het ophalen van gegevens: " . $e->getMessage();
            $resultaten = [];
        }
        
        
        $gameManager = [];
        
        foreach ($resultaten as $rij) {
        
            $gameManager = new gameManager();
            $gameManager->setTitle($rij['title']);
            $gameManager->setGenre($rij['genre']);
            $gameManager->setPlatform($rij['platform']);
            $gameManager->setRelease_year($rij['release year']);
            $gameManager->setRating($rij['rating']);
            $gameManager->setsDescription($rij['description']);
            $gameManager->setDeveloper($rij['developer']);
            
        
            $gameManager[] = $gameManager;
        }

        return $gameManager;
    }



    // Method to handle file upload
    public function file_upload($file) {

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is actually uploaded and is an image
        if (empty($file["tmp_name"])) {
            echo "No file uploaded.";
            return null;
        }

        // Validate if the uploaded file is an image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size 
        if ($file["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Only allow certain file types (JPG, PNG, JPEG, WEBP GIF)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "WEBP") {
            echo "Sorry, only JPG, JPEG, WEBP, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If everything is okay, try to upload the file
        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";
            return null;
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
                return $target_file; // Return the file path
            } else {
                echo "Sorry, there was an error uploading your file.";
                return null;
            }
        }
    }

    function get_data_list_picture(){
        try{
            $stmt = $this->conn->prepare("SELECT id, image FROM game");
            $stmt->execute();

            //checks if there is something in the database
            if ($stmt->rowCount()> 0) {
                //gets the data out of the database and displays it in big pictures
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $gameId = $row['id'];
                    $game = new Game();
                    $game->setImage($row["image"]);
                    $afbeeldingPath = $game->getImage();
 
                    echo "<a href='detailPages.php?id=$gameId'>" . '<div class="pictureDiv">' . '<img class="imgBig" src="' . "uploads/" . $afbeeldingPath . '">' . "</div>";    
                }
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        //display errors
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function get_data_list_picture2(){
        try{
            $stmt = $this->conn->prepare("SELECT id, image FROM game");
            $stmt->execute();

            //checks if there is something in the database
            if ($stmt->rowCount()> 0) {
                //gets the data out of the database and displays it in big pictures
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $gameId = $row['id'];
                    $game = new Game();
                    $game->setImage($row["image"]);
                    $afbeeldingPath = $game->getImage();
 
                    echo "<a href='storedetail.php?id=$gameId'>" . '<div class="pictureDiv">' . '<img class="imgBig" src="' . "uploads/" . $afbeeldingPath . '">' . "</div>";    
                }
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        //display errors
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function getList(){
        try{
            $stmt = $this->conn->prepare("SELECT id, title, image FROM game");
            $stmt->execute();

            //checks if there is something in the database
            if ($stmt->rowCount()> 0) {
                //gets the data out of the database and displays it in big pictures
                echo "<ul>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $gameId = $row['id'];
                    $game = new Game();
                    $game->setTitle($row["title"]);
                    $game->setImage($row["image"]);
                    $titel = $game->getTitle();
                    $afbeeldingPath = $game->getImage();
 
                    echo '<li><a href="detailPages.php?id=' . $gameId . '"><img class="smallImage" src="uploads/' . $afbeeldingPath . '"><span class="titleClass">' . $titel . '</span></a></li>';

                }
                echo "</ul>";
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        //display errors
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    function get_data_by_id($id) {
        try {
            // SQL-query aanpassen om een specifieke game te selecteren
            $stmt = $this->conn->prepare("SELECT * FROM game WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind het ID aan de query
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC); // Haal één enkele rij op
                
                // Maak een nieuw game-object
                $game = new Game();
                $game->setTitle($row["title"]);
                $game->setImage($row["image"]);
                $game->setGenre($row["genre"]);
                $game->setPlatform($row["platform"]);
                $game->setRelease_year($row["release_year"]);
                $game->setRating($row["rating"]);
                $game->setDescription($row["description"]);
                $game->setDeveloper($row["developer"]);
    
                // Haal data op
                $titel = $game->getTitle();
                $afbeeldingPath = $game->getImage();
                $genre = $game->getGenre();
                $platform = $game->getPlatform();
                $Release_year = $game->getRelease_year();
                $rating = $game->getRating();
                $description = $game->getDescription();
                $developer = $game->getDeveloper();
    
                // Toon de gegevens van de game
                echo '<div>';
                echo '<img class="normalImage" src="uploads/' . htmlspecialchars($afbeeldingPath) . '">';
                echo '<h1>' . htmlspecialchars($titel) . '</h1>';
                echo '<p>Genre: ' . htmlspecialchars($genre) . '</p>';
                echo '<p>Platform: ' . htmlspecialchars($platform) . '</p>';
                echo '<p>Release Year: ' . htmlspecialchars($Release_year) . '</p>';
                echo '<p>Rating: ' . htmlspecialchars($rating) . '</p>';
                echo '<p>Description: ' . htmlspecialchars($description) . '</p>';
                echo '<p>Developer: ' . htmlspecialchars($developer) . '</p>';
                echo '</div>';
            } else {
                echo "Geen resultaten gevonden.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}    
?>