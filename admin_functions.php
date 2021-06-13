<?php
function writekursant($imie, $nazwisko, $tel, $zrea, $nzrea, $ukon){
    if($ukon == 0){
        $uk = "W trakcie";
    }else{
        $uk = "Ukończono";
    }
    echo '<div class="adminPupilsOptions"><h2>'.$imie.'</h2>';
    echo '<h2>'.$nazwisko.'</h2><h2>'.$tel.'</h2><h2>'.$zrea;
    echo '</h2><h2>'.$nzrea.'</h2><h2>'.$uk.'</h2></div>';
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
function writejazda($imiekur, $imieins, $nazwins, $data, $miej, $poj_nazw, $poj_rej){
    $data = strtotime($data);
    $godzina = date("H:i", $data);
    $data = date("Y-m-d", $data);
    echo '<form class="adminJazdyTable"><div>'.$imiekur.'</div><div>'.$imieins." ".$nazwins.'</div><div>';
    echo $data.'</div><div>'.$godzina.'</div><div>'.retplace($miej).'</div><div>'.$poj_nazw." | ".$poj_rej.'</div>
</form>';
}
?>