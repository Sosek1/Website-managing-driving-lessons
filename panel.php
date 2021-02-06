<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
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
            <li><a href="#">Panel jazd</a></li>
            <li><a href="#">Rozliczenie jazdy</a></li>
            <li><a href="#">Szukaj</a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <div class="container">
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
            <form action="kalendarzDzien.php" method="post">
            <input type="text" class="searchInput" name="szukanie">
            <button  type="submit"> <i class="fas fa-search"> </i>
            </form>
        </div>
        <input type="text" class="name2 border " placeholder="Imię..." <?php if(isset($_SESSION['imieadd'])){ echo 'value="'.$_SESSION['imieadd'].'"';}?>>
        <input type="text" class="surname border " placeholder="Nazwisko..." <?php if(isset($_SESSION['nazwadd'])){ echo 'value="'.$_SESSION['nazwadd'].'"';}?>>
        <input type="text" class="phoneNumber border " placeholder="Numer telefonu..." <?php if(isset($_SESSION['nrteladd'])){ echo 'value="'.$_SESSION['nrteladd'].'"';}?>>
        <div class="chooseCategory" onclick="rollDown()">
            <p class="text">Kategoria</p>
            <i class="fas fa-angle-down arrow1"></i>
            
            <div class="options">
            <optgroup label="Swedish Cars">
    <option value="volvo">Volvo</option>
    <option value="saab">Saab</option>
  </optgroup>
            </div>
        </div>
        <div class="chooseHour" onclick="rollDown2()">
            <p class="text">Liczba godzin</p>
            <i class="fas fa-angle-down arrow2"></i>
            <div class="options2"></div>
        </div>
        <div class="chooseCar" onclick="rollDown3()">
            <p class="text"> Pojazd</p>
            <i class="fas fa-angle-down arrow3"></i>
            <div class="options3"></div>
        </div>
        <div class="city">miasto</div>
        <div class="place">plac</div>
        <div class="vehicle">miasto/plac</div>
        <textarea class="info" placeholder="Napisz coś..."></textarea>
        <div class="save">zapisz</div>

    </div>

    <script src="burger.js"></script>
    <script src="options.js"></script>
    <script src="colorChange.js"></script>

</body>

</html>