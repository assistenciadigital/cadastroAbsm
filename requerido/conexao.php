<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "absm_teste";
$conexao = mysql_connect($host,$usuario,$senha);
mysql_select_db($banco,$conexao);
?>