<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}

if(isset($_GET['date'])==true){
    $dzien = $_GET['date'];
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
    $dzien=strtotime("now");
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
    <nav>
        <div class="logo"></div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="#">Panel jazd</a></li>
            <li><a href="#">Rozliczenie jazdy</a></li>
            <li><a href="#">Szukaj</a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <h1 class="name">Cześć, <?php echo $_SESSION['user_name'];?>   <a href="logout.php">[Wyloguj się]</a></h1>
    <a href="kalendarzTydzien.php"><button class="dayWeek">Tydzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <a href="kalendarzDzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <p class="date3"><a href="kalendarzDzien.php?move=1"><?php echo date("d.M", $dzien);?></a></p>
        <div class="next">
            <a href="kalendarzDzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="dayContainer">
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            $imie;
            $nazwisko;
            $kat;
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">6:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                
                <i class="fas fa-plus">
                </i>
            </div>

        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>
            ><div class="hour">7:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">8:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">9:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">10:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">11:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">12:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">13:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">14:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">15:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">16:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">17:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">18:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">19:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">20:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">21:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
        <div class="table"
        <?php 
            $conn = @new mysqli($host, $db_user, $db_pass, $db_name);
            $conn->query("SET NAMES 'utf8'");
            if($conn->connect_errno!=0){}else{
                $zap=date("Y-m-d H:i:s", mktime(22, 0, 0, $msc, $day, $ye));
                $id=$_SESSION['id'];
                $rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
                if(!$rezu){
                }else{
                    $ile = $rezu->num_rows;
                    if($ile>0){
                        $row = $rezu->fetch_assoc();
                        $idosoba = $row['id_kursanta'];
                        $osoba=$conn->query("SELECT * FROM kursanci WHERE id='$idosoba'");
                        if(!$osoba){
                        }else{
                            $ile = $osoba->num_rows;
                            if($ile>0){
                                $osobarow = $osoba->fetch_assoc();
                                $imie = $osobarow['name'];
                                $nazwisko = $osobarow['surname'];
                                $kat = $osobarow['kat'];
                            }
                        }
                        echo 'style= "background-color:red"';
                    }
                }
            $conn -> close();
            }
        ?>>
            <div class="hour">22:00</div>
            <div class="data">
            <?php 
                if(isset($imie)){
                    echo "<i>".$imie." ".$nazwisko."</i>";
                    unset($imie);
                    unset($nazwisko);
                    unset($kat);
                }
            ?>
                </div>
            <div class="addRide">
                <i class="fas fa-plus"></i>
            </div>
        </div>
    </div>

    <div class="settle">Rozlicz</div>

</body>
<script src="burger.js"></script>

</html>