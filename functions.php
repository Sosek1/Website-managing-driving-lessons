<?php
function writedzienzosoba($godzina, $imie, $nazwisko, $kat, $tel, $datee){
    echo '<div class="table" style= "background-color:red"><div class="hour">'.$godzina.':00</div><div class="data">';
    echo $imie." ".$nazwisko." Nr telefonu:".$tel."  Kategoria:";
    if($kat==1){
        echo "AM";
    }else if($kat==2){
        echo "A1";
    }else if($kat==3){
        echo "A2";
    }else if($kat==4){
        echo "A";
    }else if($kat==6){
        echo "B";
    }
   if(false){
        echo '</div><label class="addRide"><a href="panel.php?d='.$datee.'&h='.$godzina.'"> <i class="fas fa-plus"></i></a></label></div>';
    }else{
        echo '</div></div>';
    }
}
function writedzien($godzina, $datee){
    echo '<div class="table"><div class="hour">'.$godzina.':00</div><div class="data">';
    echo '</div><label class="addRide"><a href="panel.php?d='.$datee.'&h='.$godzina.'"> <i class="fas fa-plus"></i></a></label></div>';
}
function writetydzien(){
    echo '<a class="record"><div class="dublet"></div><div class="dublet"></div></a>';
}
function writetydzienznaleziono(){
    echo '<a class="record"style= "background-color:red"><div class="dublet"></div><div class="dublet"></div></a>';
}
function writetydzienznalezionodublet(){
    echo '<a class="record"><div class="dublet"style= "background-color:red"></div><div class="dublet" style= "background-color:green"></div></a>';
}
function writegodzina($godzina){
    echo '<a class="record"><p>'.$godzina.':00</p></a>';
}
?>