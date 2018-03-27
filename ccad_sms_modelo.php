<?php
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
$assunto = strtoupper($_POST[fassunto]);
$mensagem = strtoupper($_POST[fmensagem]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

include("requerido/conexao.php");

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT sms_modelo,assunto,mensagem,data,hora,usuario FROM sms_modelo WHERE assunto = '$assunto' AND mensagem = '$mensagem'";
$rsv = mysql_query($sqlv);


while(list($sms_modelov,$assuntov,$mensagemv,$datav,$horav,$usuariov) = mysql_fetch_row($rsv)) {
 $contador++;
 $pega_usuario = $usuariov;
}

if($contador >= 1) {
  #SE ENCONTROU REGISTRO DUPLICADO
  print("<script>
  alert('Registro duplicado, cadastrado por: $pega_usuario'); 
  history.back();
  </script>");
} else {
  
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into sms_modelo(assunto,mensagem,data,hora,usuario)
          VALUES('$assunto','$mensagem','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
     
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT sms_modelo,assunto,mensagem,data,hora,usuario FROM sms_modelo WHERE assunto = '$assunto' AND mensagem = '$mensagem'";
  $rsc = mysql_query($sqlc);

while(list($sms_modeloc,$assuntoc,$mensagemc,$datac,$horac,$usuarioc) = mysql_fetch_row($rsc)) {;}
 
    
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, SMS Modelo: $sms_modeloc, Mensagem: $mensagemc, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fcad_sms_modelo.php");
}
?>