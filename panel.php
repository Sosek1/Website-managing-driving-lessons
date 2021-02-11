<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}

if(isset($_GET['d'])){
    $dzien=$_GET['d'];
}else{
    $dzien=strtotime("now");
}
if(isset($_GET['h'])){
    $godzina=$_GET['h'];
}else{
    $godzina=$_SESSION['h'];
}



$day = date('d', $dzien);
$msc = date('m', $dzien);
$ye = date('y', $dzien);
$czyinsert = true;
$podtel=false;
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
    $podtel=true;
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
if(isset($_POST['addinfo'])){
    $_SESSION['adinfo'] = $_POST['addinfo'];
    $info = $_POST['addinfo'];
}
if(isset($_POST['szukaj'])){
    $zap = $_POST['szukaj'];
    if(!$zap==""){
        echo $zap;
        echo '<meta http-equiv="Refresh" content="0; url=szukaj.php?szuk='.$zap.'">';
        exit();
    }
}
$id;
if($czyinsert){
    $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
    $conn->query("SET NAMES 'utf8'");
    $czyzwalidowano = true;
    if($conn->connect_errno!=0){

    }else{

        if(!isset($_SESSION['adid'])){

            $zap = 'SELECT id, kat FROM kursanci WHERE imie =\''.$name.'\' AND surname = \''.$surname.'\'';
            $osoba=$conn->query($zap);

            if(!$osoba){}else{
                $ile=$osoba->num_rows;
                echo 'ok';
                if($ile>0){
                    echo 'okk';
                    $osobarow = $osoba->fetch_assoc();
                    $idd = $osobarow['id'];
                    $katosoby = $osobarow['kat'];
                }else{
                    echo 'okkk';
                    if($podtel){
                        echo 'okkkkk';
                        $zap = 'INSERT INTO kursanci VALUES(NULL, \''.$name.'\', \''.$surname.'\', '.$nrtel.', \''.$kat.'\')';
                        echo $zap;
                        if($conn->query($zap)){
                            echo 'ok';
                                    
                        }else{
                            echo $conn->error;
                            echo $conn->errno;
                            
                        }
                        $katosoby=$kat;
                        $zap = 'SELECT id FROM kursanci WHERE imie =\''.$name.'\' AND surname = \''.$surname.'\'';
                        $osoba=$conn->query($zap);
                        if(!$osoba){}else{
                            $ile=$osoba->num_rows;
                            if($ile>0){
                                $osobarow=$osoba->fetch_assoc();
                                $idd = $osoba['id'];
                            }
                        }
                    }else{
                        $czyinsert=false;
                        $_SESSION['telerror']="Nie podano numeru telefonu!";
                    }
                }
            }
        }else{
            $idd = $_SESSION['adid'];
        }
        if($info==""){
            $info = "Brak";
        }

        if($kat>=$katosoby){
            $czyzwalidowano=false;
            $_SESSION['katerror']="Zła kategoria dla tego kursanta!";
            echo "Zła kategoria dla tego kursanta!44";
        }

        
        $zap = 'SELECT kat FROM pojazdy WHERE id =\''.$pojazd.'\'';
        $poj=$conn->query($zap);
        if(!$poj){}else{
            $ile=$poj->num_rows;
                
            if($ile>0){
                $pojrow = $poj->fetch_assoc();
                $katpoj = $pojrow['kat'];
            }
        }
        if($katpoj>$kat){
            $czyzwalidowano=false;
            $_SESSION['katerror']="Zła kategoria dla tego kursanta!";
            echo "Zła kategoria dla tego kursanta!2";
        }
        $dataa=date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
        $zap = 'SELECT * FROM jazdy WHERE id_pojazdu ='.$pojazd.' AND data_jazdy=\''.$dataa.'\'';
        $poj=$conn->query($zap);
        if(!$poj){}else{
            $ile=$poj->num_rows;                
            if($ile>0){
                $czyzwalidowano=false;
                $_SESSION['pojerror']="Pojazd jest zajęty o tej godzinie!";
                echo "Pojazd jest zajęty o tej godzinie!";
            }
        }
        if($dlugosc>1 && $godzina+1<22){
            $dataa=date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
            $zap = 'SELECT * FROM jazdy WHERE id_pojazdu ='.$pojazd.' AND data_jazdy=\''.$dataa.'\'';
            $poj=$conn->query($zap);
            if(!$poj){}else{
                $ile=$poj->num_rows;                
                if($ile>0){
                    $czyzwalidowano=false;
                    $_SESSION['pojerror']="Pojazd jest zajęty o tej godzinie!";
                    echo "Pojazd jest zajęty o tej godzinie!";
                }
            }
        }else if($godzina+1>=22){
            $_SESSION['pojerror']="Jazda nie może trwać po 22!";
        }
        if($dlugosc>2 && $godzina+2<22){
            $dataa=date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
            $zap = 'SELECT * FROM jazdy WHERE id_pojazdu ='.$pojazd.' AND data_jazdy=\''.$dataa.'\'';
            $poj=$conn->query($zap);
            if(!$poj){}else{
                $ile=$poj->num_rows;                
                if($ile>0){
                    $czyzwalidowano=false;
                    $_SESSION['pojerror']="Pojazd jest zajęty o tej godzinie!";
                    echo "Pojazd jest zajęty o tej godzinie!";
                }
            }
        }else if($godzina+1>=22){
            $_SESSION['pojerror']="Jazda nie może trwać po 22!";
        }
        


        if($czyzwalidowano && $czyinsert){
            $i=0;
            while($i<$dlugosc){
                $idinstruktora = $_SESSION['id'];
                $dataa=date("Y-m-d H:i:s", mktime($godzina+$i, 0, 0, $msc, $day, $ye));
                $zap = 'INSERT INTO jazdy VALUES(NULL, '.$idinstruktora.', '.$idd.', '.$pojazd.', \''.$dataa.'\', NULL, 2, "'.$info.'")';
                echo $zap;
                if($conn->query($zap)){
                    echo 'ok';
                            
                }else{
                    echo $conn->error;
                    echo $conn->errno;
                }
                $i++;
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
            <p class="date"><?php echo date("Y-m-d H:i", mktime($godzina+$i, 0, 0, $msc, $day, $ye));?></p>
            <a href="kalendarzDzien.php?date=<?php echo mktime(0, 0, 0, $msc, $day, $ye);?>">Zmień</a>
        </div>
        <div class="search">
                <input type="text" class="searchInput" name="szukaj">
                <label><input type="submit"value=""style= "border-style:none;"><i class="fas fa-search"></i></label>
        </div>
            <input type="text" name="addname" class="name2 border " placeholder="Imię..."<?php if(isset($_SESSION['adname'])){echo 'value="'.$_SESSION['adname'].'"';}?>>
            <input type="text" name="addsurname" class="surname border " placeholder="Nazwisko..."<?php if(isset($_SESSION['adsurname'])){echo 'value="'.$_SESSION['adsurname'].'"';}?>>
            <input type="tel" name="addnrtel" class="phoneNumber border " placeholder="Numer telefonu..."<?php if(isset($_SESSION['adnrtel'])){echo 'value="'.$_SESSION['adnrtel'].'"';}?>>
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
                                        echo '<option value="'.$pojid.'" selected="selected">'.$pojname.'</option>';
                                    }else{
                                        echo '<option value='.$pojid.'>'.$pojname.'</option>';
                                    }
                                }else{
                                    echo '<option value='.$pojid.'>'.$pojname.'</option>';
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