﻿<?php
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
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

include("requerido/conexao.php");

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT destinatario,inscricao,razao_social,nome_fantasia,cep,endereco,uf,cidade,bairro,data,hora,usuario FROM recibo_destinatario WHERE inscricao = '$inscricao'";
$rsv = mysql_query($sqlv);


while(list($destinatariov,$inscricaov,$razao_socialv,$nome_fantasiav,$cepv,$enderecov,$ufv,$cidadev,$bairrov,$datav,$horav,$usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into recibo_destinatario(inscricao,razao_social,nome_fantasia,cep,endereco,uf,cidade,bairro,data,hora,usuario)
          VALUES('$inscricao','$razao_social','$nome_fantasia','$cep','$endereco','$uf','$cidade','$bairro','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
     
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT destinatario,inscricao,razao_social,nome_fantasia,cep,endereco,uf,cidade,bairro,data,hora,usuario FROM recibo_destinatario WHERE inscricao = '$inscricao'";
  $rsc = mysql_query($sqlc);

while(list($destinatario,$inscricao,$razao_social,$nome_fantasia,$cep,$endereco,$uf,$cidade,$bairro,$data,$hora,$usuario) = mysql_fetch_row($rsc)) {;}
 
    
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Destinatario: $destinatario, Inscricao: $inscricao, Razao: $razao_social, Fantasia: $nome_fantasia, Endereco: $endereco, Bairro: $bairro, Cidade: $cidade, UF: $uf, CEP: $cep, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fcad_recibo_destinatario.php");
}
?>