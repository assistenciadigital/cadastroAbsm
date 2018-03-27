<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

session_start();
if($_SESSION['status_login'] != "liberado") {
header("location:index.php");	
}
?>