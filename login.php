<?php
session_start();

if((!isset($_POST['login']))||(!isset($_POST['pass']))){
    header('Location: index.php');
    exit();
}


require_once "connect.php";
try{
    $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
    if($conn->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
    }else{
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $rezu = $conn->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
            mysqli_real_escape_string($conn, $login)));
        if(!$rezu){
            throw new Exception($conn->error);
        }else{
            $ilu_user = $rezu->num_rows;
            if($ilu_user>0){
                $wiersz = $rezu->fetch_assoc();
                if(password_verify($pass, $wiersz['pass'])==true)
                {
                    $_SESSION['logIn'] = true;                                    
                    $_SESSION['id'] = $wiersz['id'];
                    unset($_SESSION['blad']);
                    $rezu->free_result();
                    header('Location: gra.php');
                }else{
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');        
                }
            }else{
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');        
            }
        }    $conn->close();

    }

}catch(Exception $e){
    echo '<span style= "color:red"> Błąd serwera!</span>';
}
?>