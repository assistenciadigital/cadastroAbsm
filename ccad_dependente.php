<?php
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#CAMPOS DA TABELA
$titular = $_GET[titular];
$dependente = $_POST[fdependente];
$status = $_POST[fstatus];
$parentesco = $_POST[fparentesco];
$nome = strtoupper($_POST[fnome]);
$sexo = $_POST[fsexo];
$cpf = $_POST[fcpf];
$rg = $_POST[frg];
$tipo = $_POST[ftipo];
$emissorrg = $_POST[femissorrg];
$ufrg = $_POST[fufrg];
$endereco = strtoupper($_POST[fendereco]);
$cep = $_POST[fcep];
$uf = $_POST[fuf];
$cidade = $_POST[fcidade];
$bairro = $_POST[fbairro];
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#data nascimento
$data_envia = explode("/",$_POST[fdatanascimento]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_nascimento = $data_final_envia;

#data emissao rg
$data_envia = explode("/",$_POST[fdataemissaorg]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_emissaorg = $data_final_envia;


#data inclusao
$data_envia = explode("/",$_POST[fdatainclusao]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$data_inclusao = $data_final_envia;

include("requerido/conexao.php");

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT dependente, titular, cpf, usuario FROM dependente WHERE dependente = '$dependente' AND titular = '$titular' AND cpf = '$cpf'";
$rsv = mysql_query($sqlv);


while(list($dependentev, $titularv, $cpfv, $usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into dependente(titular, status, parentesco, nome, sexo, datanascimento, datainclusao, cpf, rg, emissorrg, ufrg, dataemissaorg, tipo, endereco, bairro, cidade, uf, cep, detalhe, data, hora, usuario)
          VALUES('$titular','$status','$parentesco','$nome','$sexo','$data_nascimento','$data_inclusao','$cpf','$rg','$emissorrg','$ufrg','$data_emissaorg','$tipo','$endereco','$bairro','$cidade','$uf','$cep','$descricao','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
     
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT dependente, titular, status, parentesco, nome, sexo, datanascimento, cpf, rg, emissorrg, ufrg, dataemissaorg, tipo, endereco, bairro, cidade, uf, cep, detalhe, data, hora, usuario FROM dependente WHERE cpf = '$cpf'";
  $rsc = mysql_query($sqlc);

while(list($dependentec, $titularc, $statusc, $parentescoc, $nomec, $sexoc, $datanascimentoc, $cpfc, $rgc, $emissorrgc, $ufrgc, $dataemissaorgc, $tipoc, $enderecoc, $bairroc, $cidadec, $ufc, $cepc, $detalhec, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {;}
 
    
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Dependente: $dependentec, Titular: $titularc, Status: $statusc, Parentesco: $parentescoc, Nome: $nomec, Sexo: $sexoc, Dt Nascimento: $datanascimentoc, CPF: $cpfc, RG: $rgc - Emissor: $emissorrgc/$ufrgc, em  $dataemissaorgc, Tipo: $tipoc, Endereco: $enderecoc, Bairro: $bairroc, Cidade: $cidadec, UF: $ufc, CEP: $cepc, Detalhe: $detalhec, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fcad_dependente.php?titular=$titular");
}
?>