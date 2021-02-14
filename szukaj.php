<?php
session_start();
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
require_once "connect.php";
if(isset($_GET['szuk'])){
    $zap = $_GET['szuk'];
}
$zap = 'SELECT * FROM kursanci WHERE fullname LIKE \'%'.$zap.'%\'';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szukaj</title>
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

    <div class="searchFor">
        <input type="text" placeholder="Szukaj...">
    </div>

    <?php
        $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
        $conn->query("SET NAMES 'utf8'");
        if($conn->connect_errno!=0){}else{
            $rezu=$conn->query($zap);            
            if(!$rezu){
            }else{
                $ile=$rezu->num_rows;
                if($ile>0){
                    echo $ile;
                    $i = 1;
                    while($i <= $ile){
                        echo $i;
                        $osobarow = $rezu->fetch_assoc();
                        echo '<div class="student"><i class="fas fa-user"></i><div class="name">'.$osobarow['fullname'].'</div>';
                        echo '<i class="fas fa-phone-alt"></i><div class="phone">'.$osobarow['nrtel'].'</div>';
                        echo '<i class="fas fa-car"></i><div class="ctg">';
                        if($osobarow['kat']==1){
                            echo "AM";
                        }else if($osobarow['kat']==2){
                            echo "A1";
                        }else if($osobarow['kat']==3){
                            echo "A2";
                        }else if($osobarow['kat']==4){
                            echo "A";
                        }else if($osobarow['kat']==6){
                            echo "B";
                        }
                        echo '</div> <i class="fas fa-clock"></i><div class="drivenHours">';
                        $ilejazd=$conn->query('SELECT id FROM jazdy WHERE id_kursanta = \''.$osobarow['id'].'\'');
                        if(!$ilejazd){}else{
                            $ilee=$ilejazd->num_rows;
                            if($ilee>0){
                                echo $ilee." g. </div>";
                            }else{
                                echo "0 g.</div>";
                            }
                        
                        }
                        echo '<a href=\'panel.php?id='.$osobarow['id'].'\'><button>Wybierz</button></a></div>';
                        $i=$i+1;
                    }
                }else{
                    echo "Brak osób!";
                }
            }
            $conn -> close();
        }
    ?>



</body>

</html>