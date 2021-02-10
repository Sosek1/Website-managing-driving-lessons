<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}

$czyinsert = true;

if(isset($_POST['addname'])){
    $_SESSION['adname'] = $_POST['addname'];
    $name = $_POST['addname'];
}else{
    $czyinsert=false;
}
if(isset($_POST['addsurname'])){
    $_SESSION['adsurname'] = $_POST['addsurname'];
    $surname = $_POST['addsurname'];
}else{
    $czyinsert=false;
}
if(isset($_POST['addnrtel'])){
    $_SESSION['adnrtel'] = $_POST['addnrtel'];
    $nrtel = $_POST['addnrtel'];
}else{
    $czyinsert=false;
}
if(isset($_POST['addkat'])){
    $_SESSION['adkat'] = $_POST['addkat'];
    $kat = $_POST['addkat'];
}
if(isset($_POST['addhours'])){
    $_SESSION['adhours'] = $_POST['addhours'];
    $dlugosc = $_POST['addhours'];
}
if(isset($_POST['addpojazd'])){
    $_SESSION['adpojazd'] = $_POST['addpojazd'];
    $pojazd = $_POST['addpojazd'];
}

if(isset($_POST['szukaj'])){
    $zap = $_POST['szukaj'];
    if(!$zap==""){
        echo $zap;
        echo '<meta http-equiv="Refresh" content="0; url=szukaj.php?szuk='.$zap.'">';
        exit();
    }
}

if($czyinsert){
    $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
    $czyzwalidowano = true;
    $czyjestosoba = true;
    if($conn->connect_errno!=0){

    }else{
        if(!isset($_SESSION['adid'])){
            $zap = 'SELECT id, kat FROM kursanci WHERE imie =\''.$name.'\' AND surname = \''.$surname.'\'';
            $osoba=$conn->query($zap);

            if(!$osoba){}else{
                $ile=$osoba->num_rows;
                
                if($ile>0){
                    $osobarow = $osoba->fetch_assoc();
                    $id = $osobarow['id'];
                    $katosoby = $osobarow['kat'];
                }else{
                    //$czyjestosoba=false;
                }
            }
        }else{
            $id = $_SESSION['adid'];
        }

        if($czyjestosoba){

           // if($kat>$katosoby){
           //     $czyzwalidowano=false;
           //     $_SESSION['katerror']="Zła kategoria dla tego kursanta!";
           //     echo "Zła kategoria dla tego kursanta!";
           // }
            $zap = 'SELECT kat FROM pojazdy WHERE id =\''.$pojazd.'\'';
            $poj=$conn->query($zap);

            if(!$poj){}else{
                $ile=$poj->num_rows;
                
                if($ile>0){
                    $pojrow = $poj->fetch_assoc();
                    $katpoj = $poj['kat'];
                }
            }
            if($katpoj>$kat){
                $czyzwalidowano=false;
                $_SESSION['katerror']="Zła kategoria dla tego kursanta!";
                echo "Zła kategoria dla tego kursanta!";
            }
            $zap = 'SELECT jazdy FROM pojazdy WHERE id =\''.$pojazd.'\' AND';
            $poj=$conn->query($zap);
            if(!$poj){}else{
                $ile=$poj->num_rows;                
                if($ile>0){
                    $czyz1SSION['pojerror']="Pojazd jest zajęty o tej godzinie!";
                    echo "Pojazd jest zajęty o tej godzinie!";
                }
            }          

        }

        if($czyzwalidowano){
            $idinstruktora = $_SESSION['id'];
            if($conn->query("INSERT INTO jazdy VALUES(NULL, '$idinstruktora', 
                    '$id', '$pojazd', NULL, NULL, 1, NULL)")){
                         echo 'ok';
                        
            }else{
                echo $conn->errno;
            }
        }

    }
    $conn->close();


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
                <input type="text" class="searchInput" name="szukaj">
                <label><input type="submit"value=""style= "border-style:none;"><i class="fas fa-search"></i></label>
        </div>
            <input type="text" name="addname" class="name2 border " placeholder="Imię..."<?php if(isset($_SESSION['adname'])){echo 'value="'.$_SESSION['adname'].'"';}?>>
            <input type="text" name="addsurname" class="surname border " placeholder="Nazwisko..."<?php if(isset($_SESSION['adsurname'])){echo 'value="'.$_SESSION['adsurname'].'"';}?>>
            <input type="text" name="addnrtel" class="phoneNumber border " placeholder="Numer telefonu..."<?php if(isset($_SESSION['adnrtel'])){echo 'value="'.$_SESSION['adnrtel'].'"';}?>>
            <div class="chooseCategory">
                <p class="text">Kategoria</p>
                <select class="custom-select" name="addkat">
                    <option value="1"<?php if(isset($_SESSION['adkat'])){if($_SESSION['adkat']==1){echo 'selected="selected"';}}?>>AM</option>
                    <option value="2"<?php if(isset($_SESSION['adkat'])){if($_SESSION['adkat']==2){echo 'selected="selected"';}}?>>A1</option>
                    <option value="3"<?php if(isset($_SESSION['adkat'])){if($_SESSION['adkat']==3){echo 'selected="selected"';}}?>>A2</option>
                    <option value="4"<?php if(isset($_SESSION['adkat'])){if($_SESSION['adkat']==4){echo 'selected="selected"';}}?>>A</option>
                </select>
            </div>
            <div class="chooseHour">
                <p class="text">Liczba godzin</p>
                <select class="custom-select" name="addhours">
                    <option value="1"<?php if(isset($_SESSION['adhours'])){if($_SESSION['adhours']==1){echo 'selected="selected"';}}?>>1</option>
                    <option value="2"<?php if(isset($_SESSION['adhours'])){if($_SESSION['adhours']==2){echo 'selected="selected"';}}?>>2</option>
                    <option value="3"<?php if(isset($_SESSION['adhours'])){if($_SESSION['adhours']==3){echo 'selected="selected"';}}?>>3</option>
                </select>
            </div>
            <div class="chooseCar">
                <p class="text"> Pojazd</p>
                <select class="custom-select" name="addpojazd">
                    <?php
                    $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
                    if(isset($_SESSION['adid'])){

                        if($conn->connect_errno!=0){

                        }else{
                            $id = $_SESSION['adid'];
                            $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$id'");

                            if(!$osoba){}else{
                                $ile=$rezu->num_rows;
                                if($ile>0){
                                    $osobarow = $osoba->fetch_assoc();
                                    $katosoba = $osobarow['kat'];
                                }
                            }
                        }
                    }
                    if(!isset($katosoba)){
                        $katosoba=5;
                    }

                    $rezu=$conn->query("SELECT * FROM pojazdy WHERE kat<='$katosoba'");

                    if(!$rezu){}else{
                        $ile=$rezu->num_rows;
                        if($ile>0){
                            $i = 1;
                            while($i<=$ile){
                                $pojazdrow = $rezu->fetch_assoc();
                                $pojname = $pojazdrow['nazwa'];
                                $pojid = $pojazdrow['id'];
                                if(isset($_SESSION['adpojazd'])){
                                    if($_SESSION['adpojazd']==$i){
                                        echo '<option value="'.$id.'" selected="selected">'.$pojname.'</option>';
                                    }else{
                                        echo '<option value='.$id.'>'.$pojname.'</option>';
                                    }
                                }else{
                                    echo '<option value='.$id.'>'.$pojname.'</option>';
                                }

                                $i++;
                            }
                                
                        }
                        $conn -> close();       
                    }
                    ?>
                </select>
            </div>
            <button class="city" name="addcity">miasto</button>
            <button class="place" name="addplac">plac</button>
            <button class="cityPlace" name=addmspl>miasto/plac</button>
            <textarea class="info" placeholder="Napisz coś..." name="addinfo"></textarea>
            <button type="submit" class="save">zapisz</button>
    </form>

    <script src="burger.js"></script>
    <script src="colorChange.js"></script>

</body>

</html>