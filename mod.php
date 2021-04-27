<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}else{
    if($_SESSION['admin']){
        header('Location: adminUsers.php');
        exit();
    }
}
if(isset($_GET['id'])){
    $id_jazdy = $_GET['id'];
    $_SESSION['old_id_j'] = $id_jazdy;
}
$idu = $_SESSION['id'];
$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con=false;
}else{
    $zap = 'SELECT * FROM jazdy WHERE id="'.$id_jazdy.'" and id_instruktora='.$idu.'';
    $rezu=$conn->query($zap);
    if(!$rezu){
    }else{
        $ile = $rezu->num_rows;
        if($ile>0){
            $jazdarow = $rezu->fetch_assoc();
            $ido = $jazdarow['id_kursanta'];
            $idp = $jazdarow['id_pojazdu'];
            $data = $jazdarow['data_jazdy'];
            $place = $jazdarow['miejsce'];
            $info = $jazdarow['info'];
            $zap = 'SELECT * FROM kursanci WHERE id='.$ido.'';
            $osoba=$conn->query($zap);
            if(!$osoba){
            }else{
                $ileo = $osoba->num_rows;
                if($ileo>0){
                    $osobarow = $osoba->fetch_assoc();
                    $imie = $osobarow['imie'];
                    $nazw = $osobarow['surname'];
                    $nrtel = $osobarow['nrtel'];
                    $kat = $osobarow['kat'];                    
                }
            }
        }
    }
}
$_SESSION['adname'] = $imie;
$_SESSION['adsurname'] = $nazw;
$_SESSION['adnrtel'] = $nrtel;
$_SESSION['adkat'] = $kat;
$_SESSION['adhours'] = 1;
$_SESSION['adpojazd'] = $idp;
$_SESSION['adplace'] = $place;
$_SESSION['adinfo'] = $info;
$data = strtotime($data);
$day = date('d', $data);
$msc = date('m', $data);
$ye = date('y', $data);
$h = date('H', $data);
$_SESSION['d'] = mktime(0,0,0,$msc, $day, $ye);
$_SESSION['h'] = $h;
$conn -> close();
header('Location: panel.php');
?>