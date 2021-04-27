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

}
$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
$conn->query("SET NAMES 'utf8'");
if($conn->connect_errno!=0){
    $con=false;
}else{
    $zap = 'DELETE FROM jazdy WHERE id="'.$id_jazdy.'"';
    $rezu=$conn->query($zap);
    if(!$rezu){
    }else{
    }
}
$conn->close();
header('Location: kalendarzDzien.php');



?>