﻿<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_idusuario = $_GET[idusuario];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT * FROM usuario WHERE idusuario=$pega_idusuario";
$rs = mysql_query($sql);

list($idusuario, $login, $nome, $nivel, $ativo, $sms, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("ALT: $data_atual, $hora_atual, ID Usuario: $pega_idusuario, Login: $login, Nome: $nome, Nivel: $nivel, Ativo: $ativo, Envia SMS? $sms, Usuario: $idusuario_atual - $loginusuario_atual");
    
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			
  $rs_log = mysql_query($sql_log);
  #FIM GRAVACAO DO LOG
  
  #PEGA DADOS DO FORMULARIO  
  //$login = strtoupper($_POST[flogin]);
  $nome = strtoupper($_POST[fnome]);
  //$senha = md5(base64_encode($_POST[fsenha])); senha='$senha',
  $nivel = base64_encode(strtoupper($_POST[fnivel]));
  $ativo = base64_encode(strtoupper($_POST[fativo]));
  $sms = strtoupper($_POST[fsms]);
 
  $sql = "UPDATE usuario SET idusuario='$idusuario',nome='$nome',nivel='$nivel',ativo='$ativo',sms='$sms',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE idusuario=$pega_idusuario";
  $rs = mysql_query($sql);

  header("Location: fcon_usuario.php");
#}
?>