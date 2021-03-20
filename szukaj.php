<?php
session_start();
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
require_once "connect.php";
if(isset($_GET['szuk'])){
    $szuk = $_GET['szuk'];
}


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
    
    <form class="searchFor" method="GET">
        <input type="text" placeholder="Szukaj..."name="szuk">
        <label class="loupe"><input type="submit" value=""><i class="fas fa-search"></i></label>
    </form>

    <?php
        $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
        $conn->query("SET NAMES 'utf8'");
        if($conn->connect_errno!=0){}else{
            $zap = 'SELECT * FROM kursanci WHERE fullname LIKE \'%'.$szuk.'%\'';
            $rezu=$conn->query($zap);            
            if(!$rezu){
            }else{
                $ile=$rezu->num_rows;
                if($ile>0){
                    $i = 1;
                    while($i <= $ile){
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
                        echo '</div> <a style="text-decoration:none; color:#000;`"href ="showRides.php?id='.$osobarow['id'].'"><i class="fas fa-clock"></i><div class="drivenHours">';
                        $ilejazd=$conn->query('SELECT id FROM jazdy WHERE id_kursanta = \''.$osobarow['id'].'\'');
                        if(!$ilejazd){}else{
                            $ilee=$ilejazd->num_rows;
                            if($ilee>0){
                                echo $ilee." g. </div></a>";
                            }else{
                                echo "0 g.</div></a>";
                            }
                        
                        }
                        if(isset($_SESSION['dublettt'])){
                            echo '<a class="choose" href=\'dubletPanel.php?id='.$osobarow['id'].'\'>Wybierz</a></div>';
                        }else{
                            echo '<a class="choose" href=\'panel.php?id='.$osobarow['id'].'\'>Wybierz</a></div>';
                        }
                        $i=$i+1;
                    }
                }else{
                    echo "Brak osób!";
                }
            }
            $conn -> close();
        }
    ?>

<!-- <a href="kalendarzTydzien.php" class="backToCalendar">
        <i class="fas fa-calendar-day"></i>
</a> -->
</body>

</html>