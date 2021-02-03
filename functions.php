<?php
function czyjazda($dzien, $godzina){
    require_once connect.php;
    try{
        $conn -> new mysqli($host, $db_user, $db_pass, $db_name);
        if($conn->connect_errno!=0){
            throw new Excepnion(mysqli_connect_errno());
        }else{
            $rezu=$conn->query("SELECT id, miejsce FROM jazdy WHERE data_jazdy ='$godzina' AND godzina_jazdy = '$godzina'");
            echo '<script> alert("Hello\nHow are you?");</script>';
        }
    }catch(Excepnion $e){
        echo '<span style= "color:red"> Błąd serwera!</span>';
    }

}
?>