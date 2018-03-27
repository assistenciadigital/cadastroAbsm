<?php
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
$cpf = $_POST[fcpf];
$especialidade = $_POST[fespecialidade];
$conselho = $_POST[fconselho];
$area = strtoupper($_POST[farea]);
$nome = strtoupper($_POST[fnome]);
$cep = $_POST[fcep];
$endereco = strtoupper($_POST[fendereco]);
$uf = $_POST[fuf];
$cidade = strtoupper($_POST[fcidade]);
$bairro = strtoupper($_POST[fbairro]);
$descricao = strtoupper($_POST[fobservacao]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

include("requerido/conexao.php");

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT medico,cpf,nome,cep,endereco,uf,cidade,bairro,descricao,data,hora,usuario FROM medico WHERE cpf = '$cpf'";
$rsv = mysql_query($sqlv);


while(list($medicov,$cpfv,$nomev,$cepv,$enderecov,$ufv,$cidadev,$bairrov,$descricaov,$datav,$horav,$usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into medico(cpf,especialidade,conselho,area,nome,cep,endereco,uf,cidade,bairro,descricao,data,hora,usuario)
          VALUES('$cpf','$especialidade','$conselho','$area','$nome','$cep','$endereco','$uf','$cidade','$bairro','$descricao','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
     
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT medico,cpf,especialidade,conselho,area,nome,cep,endereco,uf,cidade,bairro,descricao,data,hora,usuario FROM medico WHERE cpf = '$cpf'";
  $rsc = mysql_query($sqlc);

while(list($medicoc,$cpfc,$especialidadec,$conselhoc,$areac,$nomec,$cepc,$enderecoc,$ufc,$cidadec,$bairroc,$descricaoc,$datac,$horac,$usuarioc) = mysql_fetch_row($rsc)) {;}
 
    
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Medico: $medicoc, CPF: $cpfc, Especialidade: $especialidadec Conselho: $conselhoc, Área: $areac, Endereco: $enderecoc, Bairro: $bairroc, Cidade: $cidadec, UF: $ufc, CEP: $cepc, Obs.: $descricaoc, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fcad_medico.php");
}
?>