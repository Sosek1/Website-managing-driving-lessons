<?php
session_start();
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
require_once "connect.php";
if(isset($_GET['szuk'])){
    $zap = $_GET['szuk'];
}
$zap = 'SELECT * FROM kursanci WHERE imie LIKE \'%'.$zap.'%\' OR surname LIKE \'%'.$zap.'%\'';

$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_errno!=0){}else{
    $rezu=$conn->query($zap);
    
    if(!$rezu){
    }else{
        $ile=$rezu->num_rows;
        if($ile>0){
            echo 'znalezioooooooooono';
        }

    }
    $conn -> close();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szukaj</title>
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <div class="logo"></div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.html">Panel jazd</a></li>
            <li><a href="panelRozliczania.html">Rozliczenie jazdy</a></li>
            <li><a href="#">Szukaj</a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <div class="searchFor">
        <input type="text" placeholder="Szukaj...">
    </div>
</body>