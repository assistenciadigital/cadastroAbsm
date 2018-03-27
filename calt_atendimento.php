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
$pega_atendimento = $_GET[atendimento];
$pega_check = $_GET[check];
$pega_data_inicio = $_GET[data_inicio];
$pega_data_fim = $_GET[data_fim];

$forigem = $_POST[forigem];
$fdestino = $_POST[fdestino];
$fprofissional = $_POST[fprofissional];
$fespecialidade = $_POST[fespecialidade];
$fdataagendamento = data_banco($_POST[fdataagendamento]);
$fhoraagendamento = $_POST[fhoraagendamento];
$fdataatendimento = data_banco($_POST[fdataatendimento]);
$fhoraatendimento = $_POST[fhoraatendimento];
$fmotivo = $_POST[fmotivo];
$fstatus_atendimento = $_POST[fstatus_atendimento];
$fdetalhe = $_POST[fdetalhe];
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

if (($fdataatendimento == '00/00/0000') or (empty($fdataatendimento))){$fdataatendimento = date("d/m/y");}
if (($fhoraatendimento == '00:00') or (empty($fhoraatendimento))){$fhoraatendimento = date("H:i:s");}
	 
 #INICIA GRAVACAO DO LOG
$sql_log = "SELECT * FROM atendimento where atendimento = $pega_atendimento";
$rs_log = mysql_query($sql_log);

list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$status_atendimento,$data,$hora,$usuario) = mysql_fetch_row($rs_log);
	
  $observacao = ("ALT: $data_atual, $hora_atual, Atendimento: $atendimento, Origem: $origem, Destino: $destino, Cliente: $cliente, Dependente: $dependente, Dt e Hora Agendamento: $data_agendado - $hora_agendado, Profissional: $profissional, Especialidade: $especialidade, Motivo: $motivo, Detalhe: $detalhe, Dt e Hora Atendimento: $data_atendido - $hora_atendido, Status: $status_atendimento, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG    

  $sql = "UPDATE atendimento SET origem='$forigem', destino='$fdestino', data_agendado='$fdataagendamento', hora_agendado='$fhoraagendamento', profissional='$fprofissional', especialidade='$fespecialidade', motivo='$fmotivo', detalhe='$dfetalhe', data_atendido='$fdataatendimento', hora_atendido='$fhoraatendimento', status_atendimento='$fstatus_atendimento', data='$data_atual', hora='$hora_atual', usuario='$loginusuario_atual' WHERE atendimento = '$pega_atendimento'";
  $rs = mysql_query($sql);
    
  header("Location:fbus_atendimentolista.php?fcheck=$pega_check&fdata_inicio=$pega_data_inicio&fdata_fim=$pega_data_fim&envia=OK");
?>