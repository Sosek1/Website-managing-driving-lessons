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
?>