<?php
session_start();
unset($_SESSION['d']);
unset($_SESSION['h']);
unset($_SESSION['adid']);
unset($_SESSION['adname']);
unset($_SESSION['adsurname']);
unset($_SESSION['adnrtel']);
unset($_SESSION['adkat']);
unset($_SESSION['adhours']);
unset($_SESSION['adpojazd']);
unset($_SESSION['adplace']);
unset($_SESSION['adinfo']);
header('Location: panel.php');
?>