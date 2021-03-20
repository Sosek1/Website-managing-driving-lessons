<?php
function writedzienzosoba($godzina, $imie, $nazwisko, $kat, $tel, $datee, $id, $dublet, $roz, $czydublet){
    echo '<div class="table" style="background-color:red"><div class="hour" >'.$godzina.':00</div><div class="data">';
    if(!is_null($dublet)){
        echo "DUBLET !!";
    }
    echo $imie." ".$nazwisko."</div>";
    
   
    
    if($czydublet){
        echo '<label class="addRide" style= "background-color:green"><a href="dubletPanel.php?d='.$datee;
        echo '&h='.$godzina.'"><i class="fas fa-plus"></i></a></label>';
    }else{
        echo '<label class="addRide" style= "background-color:red"></label>';  
    }
    echo '<label class="info"><a href="info.php?id='.$id.'"><i class="fas fa-info"></i></a></label>';

    if(!$roz){
        echo '<label class="edit"><a href="mod.php?id='.$id.'"><i class="fas fa-edit"></i></a></label><label class="delete">';
        echo '<a href="delete.php?id='.$id.'"><i class="fas fa-trash-alt"></i></a></label>';
    }
    echo '</div>';

}
function writedzien($godzina, $datee){
    echo '<div class="table"><div class="hour">'.$godzina.':00</div><div class="data">';
    echo '</div><label class="addRide"><a href="panel.php?d='.$datee.'&h='.$godzina.'"> <i class="fas fa-plus"></i></a></label></div>';
}
function writerozliczdz($godzina){
    echo '<div class="table"><div class="hour">'.$godzina.':00</div><div class="data">';
    echo '</div></div>';
}
function writetydzien($dzien, $godzina){
    echo '<a class="record" href="panel.php?d='.$dzien.'&h='.$godzina.'"><div class="dublet"></div><div class="dublet"></div></a>';
}
function writetydzienznaleziono($id){
    echo '<a class="record"style= "background-color:red" href=info.php?id='.$id.'><div class="dublet"></div><div class="dublet"></div></a>';
}
function writetydzienznalezionodublet($id){
    echo '<a class="record" href=info.php?id='.$id.'><div class="dublet"style= "background-color:red"></div><div class="dublet" style= "background-color:green"></div></a>';
}
function writegodzina($godzina){
    echo '<a class="record"><p>'.$godzina.':00</p></a>';
}
function writerozlicz($godzina, $id, $imie, $nazwisko, $kat, $tel, $datee, $rozliczono){
    echo '<div class="table" style= "';
    if($rozliczono){
        echo 'background-color:green';
    }else{
        echo 'background-color:red';
    }
    echo '"><div class="hour">'.$godzina.':00</div><div class="data">';
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
    if($rozliczono){
        echo '</div></div>';
    }else{
        echo '</div><label class="addRide"><a style="text-decoration:none;color:#fff;"href="panelRozliczania.php?id='.$id.'">Rozlicz</a></label></div>';
    }
    
}
function retdzien($dzien){
    $day = date('d', $dzien);
    $msc = date('m', $dzien);
    $ye = date('y', $dzien);
    $dzien = mktime(0,0,0,$msc, $day, $ye);
    $startdate=strtotime("previous Sunday");
    $mon=strtotime("+1 day", $startdate);
    $sd=strtotime("+7 day", $startdate);
    while($dzien < $mon){
        $startdate = strtotime("-1 week", $startdate);
        $mon = strtotime("+1 day", $startdate);
    }
    while ($dzien > $sd){
        $startdate = strtotime("+1 week", $startdate);
        $sd = strtotime("+7 day", $startdate);
    }
    $mon=strtotime("+1 day", $startdate);
    $tue=strtotime("+2 day", $startdate);
    $wen=strtotime("+3 day", $startdate);
    $th=strtotime("+4 day", $startdate);
    $fr=strtotime("+5 day", $startdate);
    $st=strtotime("+6 day", $startdate);
    $sd=strtotime("+7 day", $startdate);
    if($mon == $dzien){
        return " poniedziałek";
    }else if($tue == $dzien){
        return " wtorek";
    }else if($wen == $dzien){
        return " środa";
    }else if($th == $dzien){
        return " czwartek";
    }else if($fr == $dzien){
        return " piątek";
    }else if($st == $dzien){
        return " sobota";
    }else if($sd == $dzien){
        return " niedziela";
    }
}
function retmiesiac($dzien){
    $msc = date('m', $dzien);
    switch ($msc){
        case 1:
            $ms = "Stycznia";
            break;
        case 2:
            $ms = "Luty";
            break;
        case 3:
            $ms = "Marca";
            break;
        case 4:
            $ms = "Kwietnia";
            break;
        case 5:
            $ms = "Maja";
            break;
        case 6:
            $ms = "Czerwca";
            break;
        case 7:
            $ms = "Lipca";
            break;
        case 8:
            $ms = "Sierpnia";
            break;
        case 9:
            $ms = "Września";
            break;
        case 10:
            $ms = "Października";
            break;
        case 11:
            $ms = "Listopada";
            break;
        case 12:
            $ms = "Grudnia";
            break;
    }
    return $ms;
}
function retdayofweek(){
    return date("w", strtotime('now'));
}
function retkat($kat){
    switch ($kat){
        case 1:
            $k = "AM";
            break;
        case 2:
            $k = "A1";
            break;
        case 3:
            $k = "A2";
            break;
        case 4:
            $k = "A";
            break;
        case 6:
            $k = "B";
            break;
    }
    return $k;
}

function retplace($place){
    switch($place){
        case 1:
            $p = 'Miasto';
            break;
        case 2:
            $p = 'Plac';
            break;
        case 3:
            $p = 'Miasto/plac';
            break;        
    }
    return $p;
}
?>