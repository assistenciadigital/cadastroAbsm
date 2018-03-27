<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#CAMPOS DA TABELA

$pega_medico = $_GET[medico];
$cpf = $_POST[fcpf];
$especialidade = $_POST[fespecialidade];
$conselho = $_POST[fconselho];
$area = strtoupper($_POST[farea]);
$limite = $_POST[flimite];
$nome = strtoupper($_POST[fnome]);
$cep = $_POST[fcep];
$endereco = strtoupper($_POST[fendereco]);
$uf = $_POST[fuf];
$telefone = $_POST[ftelefone];
$cidade = strtoupper($_POST[fcidade]);
$bairro = strtoupper($_POST[fbairro]);
$descricao = strtoupper($_POST[fdescricao]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("ALT: $data_atual, $hora_atual, Medico: $pega_medico, Especialidade: $especialidade, Conselho: $conselho, Área: $area, Limite: $limite, CPF: $cpf, Nome: $nome, Telefone: $telefone, Endereco: $endereco, Bairro: $bairro, Cidade: $cidade, UF: $uf, CEP: $cep, Observacao: $descricao, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
  $sql = "UPDATE medico SET cpf='$cpf', especialidade='$especialidade', conselho='$conselho', area='$area',limite='$limite',telefone='$telefone',nome='$nome',endereco='$endereco', bairro='$bairro', cidade='$cidade', uf='$uf', cep='$cep', descricao='$descricao',data='$data_atual', hora='$hora_atual', usuario='$loginusuario_atual' WHERE medico='$pega_medico'";
  $rs = mysql_query($sql);

header("Location: fcad_medico.php");
?>