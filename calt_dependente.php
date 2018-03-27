<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

#data inclusao
$data_envia = explode("/",$_POST[fdatainclusao]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$datainclusao = $data_final_envia;

#data nascimento
$data_envia = explode("/",$_POST[fdatanascimento]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$datanascimento = $data_final_envia;

#data emissao rg
$data_envia = explode("/",$_POST[fdataemissaorg]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$dataemissaorg = $data_final_envia;

$pega_dependente = $_GET[dependente];
$status = $_POST[fstatus];
$parentesco = $_POST[fparentesco];
$tipo = $_POST[ftipo];
$nome = strtoupper($_POST[fnome]);
$cpf = $_POST[fcpf];
$rg = $_POST[frg];
$emissorrg = strtoupper($_POST[femissorrg]);
$ufrg = $_POST[fufrg];
$sexo = $_POST[fsexo];
$endereco = strtoupper($_POST[fendereco]);
$bairro = strtoupper($_POST[fbairro]);
$cidade = strtoupper($_POST[fcidade]);
$uf = $_POST[fuf];
$cep = $_POST[fcep];
$detalhe = trim(addslashes(htmlentities(strtoupper($_POST[fdetalhe]))));
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("ALT: $data_atual, $hora_atual, Dependente: $pega_dependente, Status: $status, Parentesco: $parentesco, Dt inclusao: $datainclusao, Tipo: $tipo, Nome: $nome, Dt nascimento: $datanascimento, CPF: $cpf, RG: $rg, Emissor: $emissorrg/$ufrg em: $dataemissaorg, Sexo: $sexo, Endereco: $endereco, $bairro, $cidade/$uf, CEP $cep, Detalhe: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
  $sql = "UPDATE dependente SET datainclusao='$datainclusao', tipo='$tipo', status='$status', parentesco='$parentesco', nome='$nome', datanascimento='$datanascimento', cpf='$cpf', rg='$rg', emissorrg='$emissorrg', ufrg='$ufrg', dataemissaorg='$dataemissaorg', sexo='$sexo', endereco='$endereco', bairro='$bairro', cidade='$cidade', uf='$uf', cep='$cep', detalhe='$detalhe', data='$data_atual', hora='$hora_atual', usuario='$loginusuario_atual' WHERE dependente=$pega_dependente";
  $rs = mysql_query($sql);

header("Location: fcon_cliente.php");
?>