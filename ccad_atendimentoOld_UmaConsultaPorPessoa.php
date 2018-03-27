<?php
include("requerido/verifica.php");
include("requerido/validacao.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
$pega_status_cliente = $_GET[status_cliente];
$pega_codigo_titular = $_GET[codigo_titular];
$pega_codigo_dependente = $_GET[codigo_dependente];
$pega_nome_titular = $_GET[nome_titular];
$pega_nome_dependente = $_GET[nome_dependente];

$origem = $_POST[forigem];
$destino = $_POST[fdestino];
$profissional = $_POST[fprofissional];
$especialidade = $_POST[fespecialidade];
$dataagendamento = data_banco($_POST[fdataagendamento]);
$horaagendamento = $_POST[fhoraagendamento];
$motivo = $_POST[fmotivo];
$detalhe = strtoupper($_POST[fdetalhe]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

include("requerido/conexao.php");

  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into atendimento(origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data,hora,usuario)
          VALUES('$origem','$destino','$pega_codigo_titular','$pega_codigo_dependente','$dataagendamento','$horaagendamento','$profissional','$especialidade','$motivo','$detalhe','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
  
  header("Location: fcad_atendimento.php?codigo_titular=$pega_codigo_titular&nome_titular=$pega_nome_titular&codigo_dependente=$pega_codigo_dependente&nome_dependente=$pega_nome_dependente&status_cliente=$pega_status_cliente");
?>