<?php
session_start();
require_once "connect.php";
require "functions.php";
$id = $_SESSION['id'];
if(isset($_GET['dzien'])){
    $dzien = $_GET['dzien'];
}
$day = date('d', $dzien);
$msc = date('m', $dzien);
$ye = date('y', $dzien);
$ilejazd;
$wydatki;
$wplaty;
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_errno!=0){
    $con = false;
}else{
    $dzp=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
    $dzk=date("Y-m-d H:i:s", mktime(23, 0, 0, date("m", $dzien), date("d", $dzien), date("y", $dzien)));
    $zap = 'SELECT * FROM jazdy WHERE data_jazdy>"'.$dzp.'" and data_jazdy < "'.$dzk.'" and id_instruktora='.$id.'';
    echo $zap;
    $dzien=$conn->query($zap);
    if(!$dzien){
    }else{
        $ilejazd = $dzien->num_rows;
        $i = 0;
        while($ilejazd>$i){
            $jazdrow = $dzien->fetch_assoc();
            $idj = $jazdrow['id'];
            $zap = 'SELECT * FROM rozliczeniaJazd WHERE id_jazdy="'.$idj;
            echo $zap;
            $roz=$conn->query($zap);
            if(!$roz){
            }else{
                $ileroz = $roz->num_rows;
                if($ileroz>0){
                    $rozrow=$roz->fetch_assoc();
                    $idr = $rozrow['id'];
                    $zap = 'SELECT * FROM wplaty WHERE id_rozliczenia="'.$idr;
                    echo $zap;
                    $wpl=$conn->query($zap);
                    if(!$wpl){
                    }else{
                        $ilewpl = $wpl->num_rows;
                        if($ilewpl>0){
                            $wplrow=$wpl->fetch_assoc();
                            $wplaty = $wplaty + $wplrow['wielkosc'];
                            
                        }
                    }
                    $zap = 'SELECT * FROM wydatki WHERE id_rozliczenia="'.$idr;
                    echo $zap;
                    $wyd=$conn->query($zap);
                    if(!$wyd){
                    }else{
                        $ilewyd = $wyd->num_rows;
                        if($ilewyd>0){
                            $wydrow=$wyd->fetch_assoc();
                            $wydatki = $wydatki + $wydrow['wielkosc'];
                            
                        }
                    }
                }
            }
            $i++;
        }
    }
    $zap = 'INSERT INTO rozliczeniaDnia VALUES(NULL, '.$id.', '.$dzien.', NULL, '.$ilejazd.', '.$wydatki.', \''.$wplaty.')';
    echo $zap;
    if($conn->query($zap)){
                
    }else{
        
    }

}

$conn->close();
//header('Location: rozliczDzien.php');
//exit();
?>