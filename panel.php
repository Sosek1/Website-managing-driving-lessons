<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    //header('Location: index.php');
    //exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel ustalania jazd</title>
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

    <form method="post" class="container">
        <h1 class="heading">Panel ustalania jazd</h1>
        <div class="datePlace">
            <div class="prev2">
                <i class="fas fa-angle-left"></i>
            </div>
            <p class="date">20.02.2021</p>
            <div class="next2">
                <i class="fas fa-angle-right"></i>
            </div>
        </div>
        <div class="search">
                <input type="text" class="searchInput" name="szukanie">
                <label><input type="submit"value=""style= "border-style:none;"><i class="fas fa-search"></i></label>
        </div>
            <input type="text" name="name" class="name2 border " placeholder="Imię...">
            <input type="text" name="surname" class="surname border " placeholder="Nazwisko...">
            <input type="text" name="nrtel" class="phoneNumber border " placeholder="Numer telefonu...">
            <div class="chooseCategory">
                <p class="text">Kategoria</p>
                <select class="custom-select">
                    <option value="1">AM</option>
                    <option value="2">A1</option>
                    <option value="3">A2</option>
                    <option value="4">A</option>
                </select>
            </div>
            <div class="chooseHour">
                <p class="text">Liczba godzin</p>
                <select class="custom-select">
                    <option value="1">AM</option>
                    <option value="2">A1</option>
                    <option value="3">A2</option>
                    <option value="4">A</option>
                </select>
            </div>
            <div class="chooseCar">
                <p class="text"> Pojazd</p>
                <select class="custom-select">
                    <option value="1">AM</option>
                    <option value="2">A1</option>
                    <option value="3">A2</option>
                    <option value="4">A</option>
                </select>
            </div>
            <div class="city">miasto</div>
            <div class="place">plac</div>
            <div class="vehicle">miasto/plac</div>
            <textarea class="info" placeholder="Napisz coś..."></textarea>
            <button type="submit" class="save">zapisz</button>
    </form>

    <script src="burger.js"></script>
    <!-- <script src="options.js"></script> -->
    <script src="colorChange.js"></script>

</body>

</html>