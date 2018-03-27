<?php
include("requerido/conexao.php");
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");
$sql = "UPDATE cidade SET data='$data_atual',hora='$hora_atual',usuario='ALEX'";

$rs = mysql_query($sql);

echo 'ok';
?>