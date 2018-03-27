<?php

if($_SERVER['HTTP_HOST']=='localhost'){
	$hostname_conexao = "localhost";
	$database_conexao = "absm_teste";
	$username_conexao = "root";
	$password_conexao = "";
	$site = "http://localhost/abs";
	$pastEditor = "/absm";

}
else {
	$hostname_conexao = "localhost";
	$database_conexao = "absm_teste";	
	$username_conexao = "root";
	$password_conexao = "";
	$site = "http://www.absm.org";
}

$prefixo = "";
$cod_cliente = "jd01";

$con = mysql_connect($hostname_conexao, $username_conexao, $password_conexao) or trigger_error(mysql_error(),E_USER_ERROR);
$db = mysql_select_db ($database_conexao, $con) or die ('Não foi possível abrir o banco de dados');
?>