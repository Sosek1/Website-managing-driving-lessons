<?php
session_start();
require_once "connect.php";
require "functions.php";
$id = $_SESSION['id'];
if(isset($_GET['data'])){
    $dzien = $_GET['data'];
}else if($_SESSION['dataroz']){
    $dzien = $_SESSION['dataroz'];
}
if(isset($_POST['teoria'])){
    $teoria = $_POST['teoria'];
}else{
    $teoria = 0;
}
$ilejaz;
$wydatki=0;
$wplaty=0;
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_errno!=0){
    $con = false;
}else{
    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
    $dz =date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
    $day=$conn->query($zap);
    if(!$day){
    }else{
        $ilejazd = $day->num_rows;
        $i = 0;
        $ilejaz=$ilejazd;
        while($ilejazd>$i){
            $jazdrow = $day->fetch_assoc();
            $idj = $jazdrow['id'];
            $zap = 'SELECT * FROM rozliczeniaJazd WHERE id_jazdy='.$idj;
            $roz=$conn->query($zap);
            if(!$roz){
            }else{
                $ileroz = $roz->num_rows;
                if($ileroz>0){
                    $rozrow=$roz->fetch_assoc();
                    $idr = $rozrow['id'];
                    $zap = 'SELECT * FROM wplaty WHERE id_rozliczenia='.$idr;
                    $wpl=$conn->query($zap);
                    if(!$wpl){
                    }else{
                        $ilewpl = $wpl->num_rows;
                        if($ilewpl>0){
                            $wplrow=$wpl->fetch_assoc();
                            $wplaty = $wplaty + $wplrow['wielkosc'];
                            
                        }
                    }
                    $zap = 'SELECT * FROM wydatki WHERE id_rozliczenia='.$idr;
                    $wyd=$conn->query($zap);
                    if(!$wyd){
                    }else{
                        $ilewyd = $wyd->num_rows;
                        if($ilewyd>0){
                            $wydrow=$wyd->fetch_assoc();
                            $wydatki = $wydatki + $wydrow['wielkosc'];
                            echo "ok";
                        }
                    }
                }
            }
            $i++;
        }
    }
    $zapp = 'INSERT INTO rozliczeniaDnia VALUES(NULL, '.$id.', "'.$dz.'", NULL, '.$ilejaz.', '.$wydatki.', '.$wplaty.', '.$teoria.')';
    if($conn->query($zapp)){
                
    }

}

$conn->close();
echo '<meta http-equiv="refresh" content="0; url=rozliczDzien.php">';

?>