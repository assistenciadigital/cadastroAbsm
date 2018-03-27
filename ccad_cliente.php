	<title>HM - Saúde</title>

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

#data incorporacao
$data_envia = explode("/",$_POST[fdataincorporacao]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia-$mes_envia-$dia_envia";
$dataincorporacao = $data_final_envia;

$assistencia = $_POST[fassistencia];
$classificacao = $_POST[fclassificacao];
$tipo = $_POST[ftipo];
$plano = $_POST[fplano];
$formapagto = $_POST[fformapagto];
$titular = $_POST[ftitular];
$cartaosus = $_POST[fcartaosus];
$graduacao = $_POST[fgraduacao];
$instituicao = $_POST[finstituicao];
$ufinstituicao = $_POST[fufinstituicao];
$status = $_POST[fstatus];
$nome = strtoupper($_POST[fnome]);
$cpf = $_POST[fcpf];
$rg = $_POST[frg];
$emissorrg = strtoupper($_POST[femissorrg]);
$ufrg = $_POST[fufrg];
$matriculasad = strtoupper($_POST[fmatriculasad]);
$sexo = $_POST[fsexo];
$estadocivil = $_POST[festadocivil];
$conjuge = strtoupper($_POST[fconjuge]);
$nacionalidade = $_POST[fnacionalidade];
$ufnaturalidade = strtoupper($_POST[fufnaturalidade]);
$naturalidade = strtoupper($_POST[fnaturalidade]);
$pai = strtoupper($_POST[fpai]);
$mae = strtoupper($_POST[fmae]);
$profissao = $_POST[fprofissao];
$ocupacao = $_POST[focupacao];
$endereco = strtoupper($_POST[fendereco]);
$bairro = strtoupper($_POST[fbairro]);
$cidade = strtoupper($_POST[fcidade]);
$uf = $_POST[fuf];
$cep = $_POST[fcep];
$foneres = $_POST[ffoneres];
$fonecel1 = $_POST[ffonecel1];
$fonecel2 = $_POST[ffonecel2];
$fonecel3 = $_POST[ffonecel3];
$fonecom = $_POST[ffonecom];
$fonerec = $_POST[ffonerec];
$email = strtolower($_POST[femail]);
$detalhe = trim(addslashes(htmlentities(strtoupper($_POST[fdetalhe]))));
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT cliente, nome, data, hora, usuario FROM cliente WHERE cpf = '$cpf'";
$rsv = mysql_query($sqlv);



while(list($clientev, $nomev, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into cliente(titular, status, classificacao, acomodacao, cartaosus, datainclusao, assistencia, tipo, plano, formapagto, codigomilitar, graduacao, instituicao, ufinstituicao, dataincorporacao, nome, sexo, datanascimento, matriculasad, cpf, rg, emissorrg, ufrg, dataemissaorg, fonerec, fonecel1, fonecel2, fonecel3, foneres, fonecom, endereco, bairro, cidade, uf, cep, nacionalidade, naturalidade, ufnaturalidade, pai, mae, estadocivil, conjuge, profissao, ocupacao, email, detalhe, data, hora, usuario) VALUES('$titular', '$status', '$classificacao', '$acomodacao', '$cartaosus', '$datainclusao', '$assistencia', '$tipo', '$plano', '$formapagto', '$matriculasad', '$graduacao', '$instituicao', '$ufinstituicao', '$dataincorporacao', '$nome', '$sexo', '$datanascimento', '$matriculasad', '$cpf', '$rg', '$emissorrg', '$ufrg', '$dataemissaorg', '$fonerec', '$fonecel1', '$fonecel2', '$fonecel3', '$foneres', '$fonecom', '$endereco', '$bairro', '$cidade', '$uf', '$cep', '$nacionalidade', '$naturalidade', '$ufnaturalidade', '$pai', '$mae', '$estadocivil', '$conjuge', '$profissao', '$ocupacao', '$email', '$detalhe', '$data_atual', '$hora_atual', '$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM cliente WHERE cpf = '$cpf'";
  $rsc = mysql_query($sqlc);

  while(list($clientec,$classificacaoc,$cartaosusc,$datainclusaoc,$assistenciac,$tipoc,$planoc,$formapagtoc, $titularc, $graduacaoc,$instituicaoc,$ufinstituicaoc,$statusc,$nomec,$datanascimentoc,$cpfc,$rgc,$emissorrgc,$ufrgc,$dataemissaorgc,$matriculasadc,$dataincorporacaoc,$sexoc,$estadocivilc,$conjugec,$nacionalidadec,$ufnaturalidadec,$naturalidadec,$paic,$maec,$profissaoc,$ocupacaoc,$enderecoc,$bairroc,$cidadec,$ufc,$cepc,$foneresc,$fonecel1c,$fonecel2c,$fonecel3c,$fonecomc,$fonerecc,$emailc, $detalhec,$datac,$horac,$usuarioc) = mysql_fetch_row($rsc)){
	  
  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("INC: $data_atual, $hora_atual, Cliente: $pega_cliente, Classificacao: $classificacao, Cartao SUS: $cartaosus, Dt inclusao: $datainclusao, Assistencia: $assistencia, Tipo: $tipo, Plano: $plano, Forma pagto: $formapagto, Titular: $titular, Graduacao: $graduacao, Instituicao: $instituicao/$ufinstituicao, Status: $status, Nome: $nome, Dt nascimento: $datanascimento, CPF: $cpf, RG: $rg, Emissor: $emissorrg/$ufrg em: $dataemissaorg, Matricula: $matriculasad, Dt incorporacao: $dataincorporacao, Sexo: $sexo, Estado civil: $estadocivil, Conjugue: $conjuge, Nacionalidade: $nacionalidade, Naturalidade: $naturalidade/$ufnaturalidade, Filiacao: $pai/$mae, Profissao: $profissao, Ocupacao: $ocupacao, Endereco: $endereco, $bairro, $cidade/$uf, CEP $cep, Tel. res.: $foneres, Tel. Cel.1: $fonecel1, Tel. Cel.2: $fonecel2, Tel. Cel.3: $fonecel3, Tel. Com.: $fonecom, Tel. Rec.: $fonerec, E-mail: $email, Detalhe: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG

header("Location:fsus_cliente.php?cliente=$clientec&classificacao=$classificacao&cartaosus=$cartaosus&datainclusao=$datainclusao&assistencia=$assistencia&tipo=$tipo&plano=$plano&formapagto=$formapagto&titular=$titular&graduacao=$graduacao&instituicao=$instituicao&ufinstituicao=$ufinstituicao&status=$status&nome=$nome&datanascimento=$datanascimento&cpf=$cpf&rg=$rg&emissorrg=$emissorrg&dataemissaorg=$dataemissaorg&ufrg=$ufrg&matriculasad=$matriculasad&dataincorporacao=$dataincorporacao&sexo=$sexo&estadocivil=$estadocivil&conjuge=$conjuge&nacionalidade=$nacionalidade&ufnaturalidade=$ufnaturalidade&naturalidade=$naturalidade&pai=$pai&mae=$mae&profissao=$profissao&ocupacao=$ocupacao&endereco=$endereco&bairro=$bairro&cidade=$cidade&uf=$uf&cep=$cep&foneres=$foneres&fonecel1=$fonecel1&fonecel2=$fonecel2&fonecel3=$fonecel3&fonecom=$fonecom&fonerec=$fonerec&email=$email&detalhe=$detalhe&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
}
?>