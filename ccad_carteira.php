<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#data inclusao titular
$data_envia = explode("/",$_POST[fdatainclusaotitular]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_inclusao_titular = $data_final_envia;

#data nascimento titular
$data_envia = explode("/",$_POST[fdatanascimentotitular]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_nascimento_titular = $data_final_envia;

#data inclusao dependente
$data_envia = explode("/",$_POST[fdatainclusaodependente]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_inclusao_dependente = $data_final_envia;

#data nascimento dependente
$data_envia = explode("/",$_POST[fdatanascimentodependente]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_nascimento_dependente = $data_final_envia;

#data emissao
$data_emissao = date("Y-m-d");

#data validade
$timestamp = strtotime(date("Y-m-d"). "+365 days");
$data_validade = date('Y-m-d', $timestamp);

$codigotitular = $_POST[fcodigotitular];
$nometitular = $_POST[fnometitular];
$cpftitular = $_POST['fcpftitular'];
$datanascimentotitular = $_POST[fdatanascimentotitular];
$datainclusaotitular = $_POST[datainclusaotitular];
$codigodependente = $_POST[fcodigodependente];
$nomedependente = $_POST[fnomedependente];
$datanascimentodependente = $_POST[fdatanascimentodependente];
$datainclusaodependente = $_POST[fdatainclusaodependente];
$assistencia = $_POST[fassistencia];
$produtoregulamentado = $_POST[fprodutoregulamentado];
$acomodacao = $_POST[facomodacao];
$via = $_POST[fvia];
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into carteira(codigo_titular,nome_titular,cpf_titular,data_nascimento_titular,data_inclusao_titular,codigo_dependente,nome_dependente,data_nascimento_dependente,data_inclusao_dependente,produto_regulamentado,assistencia,acomodacao,dataemissao,via,datavalidade,data,hora,usuario) VALUES('$codigotitular','$nometitular','$cpftitular','$data_nascimento_titular','$data_inclusao_titular','$codigodependente','$nomedependente','$data_nascimento_dependente','$data_inclusao_dependente','$produtoregulamentado','$assistencia','$acomodacao','$data_emissao','$via','$data_validade','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT carteira,codigo_titular FROM carteira WHERE codigo_titular = '$codigotitular'";
  $rsc = mysql_query($sqlc);

  while(list($carteirac,$codigo_titularc) = mysql_fetch_row($rsc)){
	  
  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("INC: $datac, $horac, Carteira:  $carteirac");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG

if($assistencia == "COMPLETA") {
header("Location:fcar_completa.php?carteira=$carteirac");
}

if($assistencia == "ODONTOLOGICA") {
header("Location:fcar_odontologica.php?carteira=$carteirac");
}

if($assistencia == "MEDICA") {
header("Location:fcar_medico.php?carteira=$carteirac");
}
}
?>