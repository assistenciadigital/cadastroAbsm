<?php
session_start();
$_SESSION['status'] = "bloqueado";
session_destroy();
header("Location: index.php");
?>