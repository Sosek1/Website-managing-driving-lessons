<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['logIn'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['comove']==true){
    unset($_SESSION['moveweek']);
    $_SESSION['comove']=false;
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
$startdate=strtotime("previous Sunday");
$mon=strtotime("+1 day", $startdate);
$tue=strtotime("+2 day", $startdate);
$wen=strtotime("+3 day", $startdate);
$th=strtotime("+4 day", $startdate);
$fr=strtotime("+5 day", $startdate);
$st=strtotime("+6 day", $startdate);
$sd=strtotime("+7 day", $startdate);
if(isset($_SESSION['moveweek'])){
    $moved = 0;
    if($_SESSION['moveweek']>0){
        while($_SESSION['moveweek']>$moved){
            $mon=strtotime("+1 week", $mon);
            $tue=strtotime("+1 week", $tue);
            $wen=strtotime("+1 week", $wen);
            $th=strtotime("+1 week", $th);
            $fr=strtotime("+1 week", $fr);
            $st=strtotime("+1 week", $st);
            $sd=strtotime("+1 week", $sd);
            $moved++;
       }
   }else{
        while($_SESSION['moveweek']<$moved){
            $mon=strtotime("-1 week", $mon);
            $tue=strtotime("-1 week", $tue);
            $wen=strtotime("-1 week", $wen);
            $th=strtotime("-1 week", $th);
            $fr=strtotime("-1 week", $fr);
            $st=strtotime("-1 week", $st);
            $sd=strtotime("-1 week", $sd);
            $moved--;
       }
   }
}

$conn = @new mysqli($host, $db_user, $db_pass, $db_name);
if($conn->connect_errno!=0){}else{
    $czybaza = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz - tydzień</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2e3d9b3214.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>
    <nav>
        <div class="logo"></div>
        <ul class="list">
            <li><a href="kalendarzTydzien.php">Kalendarz</a></li>
            <li><a href="panel.html">Panel jazd</a></li>
            <li><a href="panelRozliczania.html">Rozliczenie jazdy</a></li>
            <li><a href="#">Szukaj</a></li>
            <li><a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            </a></li>
        </ul>
        <div class="burger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </nav>

    <h1 class="name">Cześć, <?php echo $_SESSION['user_name'];?></h1>
    <a href="kalendarzDzien.php"><button class="dayWeek">Dzień</button></a>

    <div class="arrowBox">
        <div class="prev">
            <a href="kalendarzTydzien.php?move=0"><i class="fas fa-arrow-left"></i></a>
        </div>
        <a class="date3" href="kalendarzTydzien.php?move=1">
            <?php echo date("d.M",$mon)."-".date("d.M",$sd);?></a>
        <div class="next">
            <a href="kalendarzTydzien.php?move=2"><i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="weekContainer">
        <div class="calendar">
            <div class="record">
                <p>Godzina</p>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $mon;?>">Pn</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $tue;?>">Wt</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $wen;?>">Śr</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $th;?>">Czw</a>
            </div>
            <div class="record">
               <a class="day" href="kalendarzDzien.php?date=<?php echo $fr;?>">Pt</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $st;?>">Sb</a>
            </div>
            <div class="record">
                <a class="day" href="kalendarzDzien.php?date=<?php echo $sd;?>">Nd</a>
            </div>
            <div class="record">
                <p>6:00</p>
            </div>

            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
                <div class="dublet"></div>
                <div class="dublet"></div>
            </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?></a>

            <a class="record"<?php if($czybaza){$zap=date("Y-m-d H:i:s", mktime(6, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>
            
            
            <a class="record">
                <p>7:00</p>
            </a>


            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?></a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(7, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>></a>

            <a class="record">
                <p>8:00</p>
            </a>


            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(8, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record">
                <p>9:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(9, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record">
                <p>10:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(10, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>11:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(11, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>12:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(12, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>13:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(13, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>14:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(14, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>15:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(15, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>16:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>  
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(16, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>17:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(17, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>18:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(18, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>19:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(19, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>20:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(20, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            <a class="record">
                <p>21:00</p>
            </a>
            <a class="record" <?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $mon), date("d", $mon), date("y", $mon)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $tue), date("d", $tue), date("y", $tue)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo ' style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $wen), date("d", $wen), date("y", $wen)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $th), date("d", $th), date("y", $th)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $fr), date("d", $fr), date("y", $fr)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"><?php
            if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $st), date("d", $st), date("y", $st)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>

            <a class="record"<?php if($czybaza){
            $zap=date("Y-m-d H:i:s", mktime(21, 0, 0, date("m", $sd), date("d", $sd), date("y", $sd)));
            $id=$_SESSION['id'];$rezu=$conn->query("SELECT * FROM jazdy WHERE data_jazdy='$zap'and id_instruktora='$id'");
            if(!$rezu){}else{$ile=$rezu->num_rows;if($ile>0){echo 'style= "background-color:red"';}}}?>>
            <div class="dublet"></div>
            <div class="dublet"></div>    
        </a>
            
            </div>
    </div>

    <div class="settle">Rozlicz</div>

</body>
<?php
$conn->close();
?>
</html>