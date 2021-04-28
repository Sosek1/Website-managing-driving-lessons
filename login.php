<?php
session_start();

require_once "connect.php";
try{
    $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
    $conn->query("SET NAMES 'utf8'");
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
                    $_SESSION['user_name'] = $wiersz['name'];
                    $kat = $wiersz['kat'];
                    if($kat == 20){
                        $_SESSION['admin']=true;
                    }else{
                        $_SESSION['admin']=false;
                    }
                    unset($_SESSION['blad']);
                    $rezu->free_result();
                    header('Location: kalendarzTydzien.php');
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
    echo '<br> info deweloperskie:'.$e;

}
?>