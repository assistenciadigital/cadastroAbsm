﻿<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_estadocivil = $_GET[estadocivil];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT * FROM estadocivil WHERE estadocivil=$pega_estadocivil";
$rs = mysql_query($sql);

list($estadocivil, $descricao, $detalhe, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("ALT: $data_atual, $hora_atual, Estado civil: $estadocivil, Descricao: $descricao, Detalhe: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
    
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			
  $rs_log = mysql_query($sql_log);
  #FIM GRAVACAO DO LOG
  
  #PEGA DADOS DO FORMULARIO  
  $descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
  $detalhe = trim(addslashes(htmlentities(strtoupper($_POST[fdetalhe]))));
    
  $sql = "UPDATE estadocivil SET descricao='$descricao',detalhe='$detalhe',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE estadocivil=$pega_estadocivil";
  $rs = mysql_query($sql);

  header("Location: fcon_estadocivil.php");
#}
?>