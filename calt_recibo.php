<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#CAMPOS DA TABELA

$pega_recibo = $_GET[recibo];
$valor = $_POST[fvalor];
$emitente = $_POST[femitente];
$referencia = $_POST[freferencia];
$tipo = substr($_POST[fdestinatario],0,1); 
$destinatario = preg_replace("/[^0-9]/", "", $_POST[fdestinatario]); 
$titular = $_POST[ftitular];
$mes_ano = $_POST[fmes_ano];
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
  
  $observacao = ("ALT: $data_atual, $hora_atual, Recibo: $pega_recibo, Emitente: $emitente, Destinatario: $destinatario/$tipo, Referencia: $referencia, Descricao: $descricao, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
    $sql = "UPDATE recibo SET valor='$valor', emitente='$emitente', referencia='$referencia', destinatario='$destinatario', tipo='$tipo', titular='$titular', mes_ano='$mes_ano', descricao='$descricao' WHERE recibo=$pega_recibo";
  $rs = mysql_query($sql);

header("Location: fcad_recibo.php");
?>