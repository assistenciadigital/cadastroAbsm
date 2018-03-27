<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#CAMPOS DA TABELA

$pega_destinatario = $_GET[destinatario];
$inscricao = $_POST[finscricao];
$razao_social = strtoupper($_POST[frazao_social]);
$nome_fantasia = strtoupper($_POST[fnome_fantasia]);
$cep = $_POST[fcep];
$endereco = strtoupper($_POST[fendereco]);
$uf = $_POST[fuf];
$cidade = $_POST[fcidade];
$bairro = $_POST[fbairro];
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("ALT: $data_atual, $hora_atual, destinatario: $pega_destinatario, Inscricao: $inscricao, Razao: $razao_social, Fantasia: $nome_fantasia, Endereco: $endereco, Bairro: $bairro, Cidade: $cidade, UF: $uf, CEP: $cep, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
  $sql = "UPDATE recibo_destinatario SET inscricao='$inscricao', razao_social='$razao_social', nome_fantasia='$nome_fantasia', endereco='$endereco', bairro='$bairro', cidade='$cidade', uf='$uf', cep='$cep', data='$data_atual', hora='$hora_atual', usuario='$loginusuario_atual' WHERE destinatario='$pega_destinatario'";
  $rs = mysql_query($sql);

header("Location: fcad_recibo_destinatario.php");
?>