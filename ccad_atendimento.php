<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
$pega_status_titular = $_GET[status_titular];
$pega_codigo_titular = $_GET[codigo_titular];
$pega_nome_titular = $_GET[nome_titular];
$pega_assistencia_titular = $_GET[assistencia_titular];
$pega_nascimento_titular = $_GET[nascimento_titular];

$pega_status_dependente = $_GET[status_dependente];
$pega_codigo_dependente = $_GET[codigo_dependente];
$pega_nome_dependente = $_GET[nome_dependente];
$pega_nascimento_dependente = $_GET[nascimento_dependente];

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

  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into atendimento(origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data,hora,usuario)
          VALUES('$origem','$destino','$pega_codigo_titular','$pega_codigo_dependente','$dataagendamento','$horaagendamento','$profissional','$especialidade','$motivo','$detalhe','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
  $atendimento = mysql_insert_id();
  //$id = mysql_insert_id();

    #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Atendimento: $atendimento, Origem: $origem, Destino: $destino, Cliente: $pega_codigo_titular, Dependente: $pega_codigo_dependente, Dt e Hora Agendamento: $dataagendamento - $horaagendamento, Profissional: $profissional, Especialidade: $especialidade, Motivo: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG  
  
  header("Location: fcad_atendimento.php?codigo_titular=$pega_codigo_titular&nome_titular=$pega_nome_titular&codigo_dependente=$pega_codigo_dependente&nome_dependente=$pega_nome_dependente&status_titular=$pega_status_titular&assistencia_titular=$pega_assistencia_titular&status_dependente=$pega_status_dependente&nascimento_titular=$pega_nascimento_titular&nascimento_dependente=$pega_nascimento_dependente");
?>