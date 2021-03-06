<?php
session_start();
require_once "connect.php";
require "functions.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}else{
    if($_SESSION['admin']){
        header('Location: adminKursanci.php');
        exit();
    }
}
if(isset($_SESSION['lastrozdzien'])){
    $dzien = $_SESSION['lastrozdzien'];
}else{
    $dzien=strtotime("now");
}

if(isset($_GET['date'])==true){
    $dzien = $_GET['date'];
    $_SESSION['lastrozdzien'] = $dzien;
}else{
    if($_SESSION['comove']==false){
        unset($_SESSION['move']);
        $_SESSION['comove']=true;
    }else{
        if(isset($_GET['move'])==true){
            if($_GET['move']==0){
                $_SESSION['moveweek']=$_SESSION['moveweek']-1;
                }else if($_GET['move']==1){
                    unset($_SESSION['moveweek']);
                }else if($_GET['move']==2){
                    $_SESSION['moveweek']=$_SESSION['moveweek']+1;
                }

        }
    }
    if(isset($_SESSION['moveweek'])){
        $moved = 0;
        if($_SESSION['moveweek']>0){
            while($_SESSION['moveweek']>$moved){
                $dzien=strtotime("+1 day", $dzien);
                $moved++;
            }
        }else{
            while($_SESSION['moveweek']<$moved){
                $dzien=strtotime("-1 day", $dzien);
                $moved--;
            }
        }
    }
}
$day = date('d', $dzien);
$msc = date('m', $dzien);
$ye = date('y', $dzien);
$id = $_SESSION['id'];
$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con=false;
}else{
    $con=true;
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

    <h1 class="name">Rozlicz dzień</h1>
    <?php
    if($con){
        $dz=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
        $zap = 'SELECT * FROM rozliczeniaDnia WHERE dzien="'.$dz.'" and id_instruktora='.$id.'';
        $rezu=$conn->query($zap);
        if(!$rezu){
        }else{
            $ile = $rezu->num_rows;
            if($ile==0){
                $czywszystkorozliczone = true;
            }else{
                $czywszystkorozliczone = false;
                echo '<h1 class="name">Rozliczono</h1>';
            }   

        }
    }
    $_SESSION['dataroz'] = $dzien;

    ?>
    <div class="arrowBox">
        <div class="prev">
            <a href="rozliczDzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <a class="date3" href="rozliczDzien.php?move=1"><?php echo date("d ", $dzien).retmiesiac($dzien).retdzien($dzien);?></a>
        <div class="next">
            <a href="rozliczDzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="dayContainer">
        <?php 
            $imie;
            $nazwisko;
            $kat;
            if($con){
                $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, $msc, $day, $ye));
                $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, $msc, $day, $ye));
                $idisnt=$_SESSION['id'];
                $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy<"'.$dzk.'" and id_instruktora='.$idisnt.' ORDER BY data_jazdy, dublet ASC';
                $rezu=$conn->query($zap);
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    $d=0;
                    while($ile>$d){
                        $d++;
                        $drow = $rezu->fetch_assoc();
                        $idosoba = $drow['id_kursanta'];
                        $idj = $drow['id'];
                        $godzina = date("H", strtotime($drow['data_jazdy']));
                        $dublet = $drow['dublet'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ileo = $osoba->num_rows;
                            if($ileo>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['imie'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                                $tel = $osobarow['nrtel'];
                            }
                        }
                        $jazdy=$conn->query("SELECT * FROM rozliczeniaJazd WHERE id_jazdy='$idj'");
                        if(!$jazdy){
                        }else{
                            $ilej = $jazdy->num_rows;
                            if($ilej>0){
                                writerozlicz($godzina, $idj, $imie, $nazwisko, $kat, $tel, $dza, true, $dublet);
                            }else{
                                writerozlicz($godzina, $idj, $imie, $nazwisko, $kat, $tel, $dza, false, $dublet);
                                $czywszystkorozliczone=false;
                            }
                        }
                    }
                }
            }
            
                    
                
            
        ?>
    </div>
    
   
    <form class="hoursform"<?php if($czywszystkorozliczone){ echo 'method="post" action="rozlicz.php"';}?>>
    <div class="hoursAmount">
        <h1>Teoria(ilosć godzin)</h1>
        <input type="number" name ="teoria" min="0" max="10">
    </div>
        <button type="submit" style="color:#fff;text-decoration:none;"class="settle2">Rozlicz</button>
    </form>


    <!-- <a href="kalendarzTydzien.php" class="backToCalendar">
        <i class="fas fa-calendar-day"></i>
    </a> -->

</body>
<?php
$conn -> close();
?>
</html>
