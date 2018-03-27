<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#CAMPOS DA TABELA

$pega_referencia = $_GET[referencia];
$emitente = $_POST[femitente];
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("ALT: $data_atual, $hora_atual, Referencia: $pega_referencia, Emitente: $emitente, Descricao: $descricao, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
  $sql = "UPDATE recibo_referencia SET emitente='$emitente', descricao='$descricao', data='$data_atual', hora='$hora_atual', usuario='$loginusuario_atual' WHERE referencia='$pega_referencia'";
  $rs = mysql_query($sql);

header("Location: fcad_recibo_referencia.php");
?>