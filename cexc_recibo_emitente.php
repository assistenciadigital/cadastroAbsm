﻿<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_emitente = $_GET[emitente];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT emitente,inscricao,razao_social,nome_fantasia,cep,endereco,uf,cidade,bairro,data,hora,usuario FROM recibo_emitente WHERE emitente=$pega_emitente";
$rs = mysql_query($sql);

list($emitente,$inscricao,$razao_social,$nome_fantasia,$cep,$endereco,$uf,$cidade,$bairro, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("EXC: $data_atual, $hora_atual, Emitente: $emitente, Inscricao: $inscricao, Razao: $razao_social, Fantasia: $nome_fantasia, CEP $cep, Endereco: $endereco, UF: $uf, Cidade: $cidade, Bairro: $bairro, Usuario: $idusuario_atual - $loginusuario_atual");
  
$sql_log = "INSERT into log(observacao, data, hora,idusuario, usuario)
            VALUES('$observacao', '$data_atual', '$hora_atual', '$idusuario_atual', '$loginusuario_atual')";

$rs_log = mysql_query($sql_log);
#FIM GRAVACAO DO LOG
 
$sql = "DELETE FROM recibo_emitente WHERE emitente=$pega_emitente";
$rs = mysql_query($sql);

header("Location: fcad_recibo_emitente.php");
?>
