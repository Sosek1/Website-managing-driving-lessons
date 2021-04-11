<?php
session_start();
require_once "connect.php";
require "functions.php";

if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
$_SESSION['dublettt']=true;
$czyzwalidowano = true;
if(isset($_GET['d'])){
    $dzien=$_GET['d'];
    $_SESSION['d'] = $dzien;
}else{
    $dzien = $_SESSION['d'];
}
if(isset($_GET['h'])){
    $godzina=$_GET['h'];
    $_SESSION['h'] = $godzina;
}else{
    $godzina=$_SESSION['h'];
}
if(isset($_GET['id'])){
    $_SESSION['adid'] = $_GET['id'];
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
    if($nrtel!=0){
        $podtel=true;
    }
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
    echo $zap;
    if(!$zap==""){
        echo '<meta http-equiv="Refresh" content="0; url=szukaj.php?szuk='.$zap.'">';
        exit();
    }
}
if(isset($_POST['adddata2'])){
    $_SESSION['addata2'] = $_POST['adddata2'];
    $data2 = $_POST['adddata2'];
    echo $data2;
    $date2 = DateTime::createFromFormat('Y-m-d\TH:i', $data2);
    if($date2){
        $data2 = $date2->format('Y-m-d H:i:s');
    }else{
        $data2 = date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
    }
}else{
    $data2 = date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
}

$id;
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con=false;
    echo $conn->connect_errno;
    echo $conn->connect_error;
}else{
    $con = true;
    if(isset($_SESSION['adid'])){
        $ido = $_SESSION['adid'];
        $zap = 'SELECT * FROM kursanci WHERE id ='.$ido.'';
        $osoba=$conn->query($zap);
        if(!$osoba){}else{
            $ile=$osoba->num_rows;
            if($ile>0){
                $osobarow = $osoba->fetch_assoc();
                $idd = $osobarow['id'];
                $_SESSION['adkat'] = $osobarow['kat'];
                $_SESSION['adname'] = $osobarow['imie'];
                $_SESSION['adsurname'] = $osobarow['surname'];
                $_SESSION['adnrtel'] = $osobarow['nrtel'];
            }
        }
    }
}


if($czyinsert){

    if($con){
        if(!isset($_SESSION['adid'])){
            $zap = 'SELECT * FROM kursanci WHERE imie =\''.$name.'\' AND surname = \''.$surname.'\'';
            $osoba=$conn->query($zap);

            if(!$osoba){}else{
                $ile=$osoba->num_rows;
                if($ile>0){
                    $osobarow = $osoba->fetch_assoc();
                    $idd = $osobarow['id'];
                    $katosoby = $osobarow['kat'];
                    $name = $osobarow['imie'];
                    $surname = $osobarow['surname'];
                    $nrtel = $osobarow['nrtel'];
                }else{
                    if($podtel){
                        $zap = 'INSERT INTO kursanci VALUES(NULL, \''.$name.'\', \''.$surname.'\', \''.$name." ".$surname.'\', '.$nrtel.', \''.$kat.'\')';
                        if($conn->query($zap)){
                                    
                        }else{
                                                       
                        }
                        $katosoby=$kat;

                        $zap = 'SELECT id FROM kursanci WHERE imie =\''.$name.'\' AND surname = \''.$surname.'\'';
                        $osoba=$conn->query($zap);
                        if(!$osoba){}else{
                            $ile=$osoba->num_rows;
                            if($ile>0){
                                $osobarow=$osoba->fetch_assoc();
                                $idd = $osobarow['id'];
                            }
                        }
                    }else{
                        $czyinsert=false;
                        $_SESSION['error']="Nie podano numeru telefonu!";
                    }
                }
            }
        }else{
            $idd = $_SESSION['adid'];            
        }
        if($info==""){
            $info = "Brak";
        }
        if(isset($_SESSION['old_id_j'])){
            $old = $_SESSION['old_id_j'];
        }else{
            $old = 0;
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
            $_SESSION['error']="Zły pojazd dla tego kursanta!";
        }
        $dataa=date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
        $zap = 'SELECT * FROM jazdy WHERE id_pojazdu = '.$pojazd.' AND data_jazdy=\''.$dataa.'\'';
        $poj=$conn->query($zap);
        if(!$poj){}else{
            $ile=$poj->num_rows;                
            if($ile>0){
                $czyzwalidowano=false;
                $_SESSION['error']="Pojazd jest zajęty o tej godzinie!";
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
                    $_SESSION['error']="Pojazd jest zajęty o tej godzinie!";
                }
            }
        }else if($godzina+1>=22){
            $_SESSION['error']="Jazda nie może trwać po 22!";
        }
        if($dlugosc>2 && $godzina+2<22){
            $dataa=date("Y-m-d H:i:s", mktime($godzina, 0, 0, $msc, $day, $ye));
            $zap = 'SELECT * FROM jazdy WHERE id_pojazdu ='.$pojazd.' AND data_jazdy=\''.$dataa.'\'';
            $poj=$conn->query($zap);
            if(!$poj){}else{
                $ile=$poj->num_rows;                
                if($ile>0){
                    $czyzwalidowano=false;
                    $_SESSION['error']="Pojazd jest zajęty o tej godzinie!";
                }
            }
        }else if($godzina+1>=22){
            $_SESSION['error']="Jazda nie może trwać po 22!";
        }
        $dz = strtotime("now");
        $dz = strtotime("-1 week", $dz);
        $da = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $dz), date("d", $dz), date("y", $dz)));
        $dz = strtotime($da);
        $zap = 'SELECT id FROM rozliczeniaDnia WHERE dzien > "'.$dz.'"';
        $poj=$conn->query($zap);
        if(!$poj){}else{
            $ile=$poj->num_rows;
            if($ile<8){
                $czyinsert=false;
                $_SESSION['error'] = "Nie rozliczono dnia!";
            }
        }
        


        if($czyzwalidowano && $czyinsert){
            $i=0;
            echo $dlugosc;
            while($i<$dlugosc){
                $idinstruktora = $_SESSION['id'];
                $zap = 'INSERT INTO dublety VALUES(NULL, '.$idinstruktora.', \'  '.$dataa.' \')';
                if($conn->query($zap)){                         
                }
                $zap = 'SELECT id FROM dublety WHERE data_pap = "'.$dataa.'" AND id_instruktora='.$idinstruktora;
                $dublettttt=$conn->query($zap);
                if(!$dublettttt){}else{
                    $ile=$dublettttt->num_rows;
                    if($ile>0){
                        $dubrow = $dublettttt->fetch_assoc();
                        $iddubletu = $dubrow['id'];
                    }
                }
                $dataa=date("Y-m-d H:i:s", mktime($godzina+$i, 0, 0, $msc, $day, $ye));
                $zap = 'INSERT INTO jazdy VALUES(NULL, '.$idinstruktora.', '.$idd.', '.$pojazd.', \''.$dataa.'\', NULL, 2 , "'.$info.'", '.$iddubletu.')';
                if($conn->query($zap)){
                            
                }else{
                    
                }
                $i++;
            }

            unset($_SESSION['adid']);
            unset($_SESSION['adname']);
            unset($_SESSION['adsurname']);
            unset($_SESSION['adpojazd']);
            unset($_SESSION['adnrtel']);
            unset($_SESSION['adkat']);
            unset($_SESSION['adhours']);
            unset($_SESSION['adinfo']); 
            //header("Location: kalendarzDzien.php");
            echo '<meta http-equiv="refresh" content="0; url=kalendarzDzien.php?date='.$dzien.'">';

        }else{
        }

    }else{
        echo "blad bazy";
    }
    $conn->close();
if(isset($_SESSION['error'])){
    $er = $_SESSION['error'];
    echo "<script>alert('$er');</script>";
    unset($_SESSION['error']);
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel dubletów</title>
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2
    ?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
</head>

<body>
<nav class="topbar">
        <a href="kalendarzTydzien.php" class="logo">
            <img src="css/MotoLka.png" alt="motoelka logo">
        </a>
        <ul class="menu">
            <li>
                <a href="kalendarzTydzien.php">
                    <i class="fas fa-calendar-day"></i>
                </a>
            </li>
            <li>
                <a href="szukaj.php">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <form class="container" method='post'>
        <h1 class="heading">Panel dubletów</h1>
        <div class="datePlace">
            <p class="date"><?php echo date("Y-m-d H:i", mktime($godzina+$i, 0, 0, $msc, $day, $ye));?></p>
        </div>
        <div class="search">
            <input type="text" class="searchInput" name="szukaj">
            <label><input type="submit" value="" style="border-style:none;"><i class="fas fa-search"></i></label>
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
        <div class="chooseHour" >
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
                            $osoba=$conn->query("SELECT * FROM kursanci ");//WHERE id='$adid'");

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

                    $rezu=$conn->query("SELECT * FROM pojazdy WHERE kat<='$katosoba' ORDER BY kat, nazwa ASC");

                    if(!$rezu){}else{
                        $ile=$rezu->num_rows;
                        if($ile>0){
                            $i = 1;
                            while($i<=$ile){
                                $pojazdrow = $rezu->fetch_assoc();
                                $pojname = $pojazdrow['nazwa'];
                                $pojid = $pojazdrow['id'];
                                $pojkat = $pojazdrow['kat'];
                                $pojrej = $pojazdrow['rejestracja'];
                                if(isset($_SESSION['adpojazd'])){
                                    if($_SESSION['adpojazd']==$i){
                                        echo '<option value="'.$pojid.'" selected="selected">'.retkat($pojkat).' | '.$pojname.' | '.$pojrej.'</option>';
                                    }else{
                                        echo '<option value='.$pojid.'>'.retkat($pojkat).' | '.$pojname.' | '.$pojrej.'</option>';
                                    }
                                }else{
                                    echo '<option value='.$pojid.'>'.retkat($pojkat).' | '.$pojname.' | '.$pojrej.'</option>';
                                }

                                $i++;
                            }
                                
                        }
                        $conn -> close();       
                    }
                    ?>
                </select>
            </div>

        <textarea class="info" name="addinfo" placeholder="Napisz coś..."></textarea>
        <button class="save" type="submit">Zapisz</button>
        <button class="clear" onclick="header(Location: delete_date.php)">Usuń dane</button>       
        </div>
    </form>
    <!-- <a href="kalendarzTydzien.php" class="backToCalendar">
        <i class="fas fa-calendar-day"></i>
    </a> -->
</body>

</html>