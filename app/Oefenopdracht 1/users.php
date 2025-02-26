<?php

$host = "mysql";
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";

spl_autoload_register(function ($class) {
    include __DIR__ . '/' . $class . '.php';
});

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
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Document</title>
</head>
<body>
    <form>
        <h2>kom <?php echo $_SESSION['username']; ?></h2>
        <p>U bent ingelogd.</p>
        <p> <a href="users.php?action=logout">uitloggen</a></p>
    </form>
</body>
</html>