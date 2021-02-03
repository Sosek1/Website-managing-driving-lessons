<?php
session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
    <title>Kalendarz - dzień</title>
    <link rel="stylesheet" href="./css/main.css">
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

    <h1 class="name">Cześć, <?php echo $_SESSION['user_name'];?>   <a href="logout.php">[Wyloguj się]</a></h1>
    <a href="kalendarzTydzien.php"><button class="dayWeek">Tydzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <i class="fas fa-arrow-left"></i>
        </div>
        <p class="date3">20.10.2021</p>
        <div class="next">
            <i class="fas fa-arrow-right"></i>
        </div>
    </div>

    <div class="dayContainer">
        <div class="table">
            <div class="hour">7:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>

        </div>
        <div class="table">
            <div class="hour">8:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">9:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">10:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">11:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">12:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">13:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">14:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">15:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">16:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">17:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">18:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">19:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">20:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">21:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table">
            <div class="hour">22:00</div>
            <div class="data"></div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
    </div>

    <div class="settle">Rozlicz</div>

</body>
<script src="burger.js"></script>

</html>