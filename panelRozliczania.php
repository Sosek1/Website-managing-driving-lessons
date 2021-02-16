<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}

if(isset($_GET['id'])){
    $idj = $_GET['id'];
    $_SESSION['rid']=$idj;
}
$idu=$_SESSION['id'];
$imie;
$nazwisko;

$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
}else{
    $id=$_SESSION['id'];
    $zap = 'SELECT * FROM jazdy WHERE id="'.$idj.'" and id_instruktora='.$idu.'';
    $rezu=$conn->query($zap);
    if(!$rezu){
    }else{
        $ile = $rezu->num_rows;
        if($ile>0){
            $row = $rezu->fetch_assoc();
            $ido = $row['id_kursanta'];
            $data = $row['data_jazdy'];
            $zap = 'SELECT * FROM kursanci WHERE id="'.$ido.'"';
            $osoba=$conn->query($zap);
            if(!$osoba){
            }else{
                $ileo = $osoba->num_rows;
                if($ileo>0){
                    $osobarow=$osoba->fetch_assoc();
                    $imie = $osobarow['imie'];
                    $nazwisko = $osobarow['surname'];
                }
            }
        }
    }
}





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel rozliczania jazd</title>
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js"></script>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <nav>
        <div class="logo"></div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.php">Panel jazd</a></li>
            <li><a href="rozliczDzien.php">Rozliczenie jazdy</a></li>
            <li><a href="szukaj.php">Szukaj</a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <form method="post" class="containerR">
        
            <h1 class="headingR">Panel rozliczania jazd</h1>
            <input type="text" placeholder="Imię..." class="nameR" name="imie"<?php if(isset($imie)){ echo 'value="'.$imie.'" disabled';}?>>
            <input type="text" placeholder="Nazwisko..." class="surnameR" name="nazwisko"<?php if(isset($nazwisko)){ echo 'value="'.$nazwisko.'" disabled';}?>>
            <input type="text" placeholder="Dzień..." class="dayR" name="day"<?php if(isset($data)){ echo 'value="'.$data.'" disabled';}?>>
            <div class="fuel">
                <p class="text">Tankowanie</p>
                <select class="custom-select" name="tankowanie">
                    <option value="1" >Nie</option>
                    <option value="2">Tak</option>
                </select>
            </div>
            <div class="rideRealized">
                <p class="text">Jazda zrealizowana</p>
                <select class="custom-select" name="zrealizowano">
                    <option value="1">Tak</option>
                    <option value="2">Nie</option>
                </select>
            </div>
            <div class="kind">
                <p class="text">Rodzaj wydatku</p>
                <select class="custom-select" name="rodzaj">
                    <option value="1" select="selected">Brak</option>
                    <option value="2">Paliwo</option>
                    <option value="3">Myjnia</option>
                    <option value="4">Inne</option>
                </select>
            </div>
            <div class="traningForm">
                <p class="text">Formularz szkoleniowy</p>
                <select class="custom-select">
                </select>
            </div>
            <input type="text" placeholder="Wpłata..." class="payment" name="wplata" >
            <input type="text" placeholder="Wydatek..." class="expenses"name="wydatki" >
            <button type="submit" class="settleRide">
                <p>Rozlicz jazdę</p>
            </button type="submit">
    </form>
    <script src="burger.js"></script>
    <script src="colorChange2.js"></script>
</body>
<?php
$conn -> close();
?>
</html>