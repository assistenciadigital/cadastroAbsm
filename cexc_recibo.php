﻿<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_referencia = $_GET[referencia];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT referencia,emitente,descricao,data,hora,usuario FROM recibo_emitente WHERE emitente=$pega_emitente";
$rs = mysql_query($sql);

list($referencia, $emitente, $descricao, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("EXC: $data_atual, $hora_atual, Referencia: $referencia, Descricao: $Descricao, Usuario: $idusuario_atual - $loginusuario_atual");
  
$sql_log = "INSERT into log(observacao, data, hora,idusuario, usuario)
            VALUES('$observacao', '$data_atual', '$hora_atual', '$idusuario_atual', '$loginusuario_atual')";

$rs_log = mysql_query($sql_log);
#FIM GRAVACAO DO LOG
 
$sql = "DELETE FROM recibo_referencia WHERE referencia=$pega_referencia";
$rs = mysql_query($sql);

header("Location: fcad_recibo_referencia.php");
?>
