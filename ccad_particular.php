	<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA 

# FORMULARIO ENVIA DATA AO BANCO ano/mes/dia - ano-mes-dia

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

$classificacao = $_POST[fclassificacao];
$formapagto = $_POST[fformapagto];
$cartaosus = $_POST[fcartaosus];
$nome = strtoupper($_POST[fnome]);
$cpf = $_POST[fcpf];
$rg = $_POST[frg];
$emissorrg = strtoupper($_POST[femissorrg]);
$ufrg = $_POST[fufrg];
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
$sqlv = "SELECT particular, nome, data, hora, usuario FROM particular WHERE cpf = '$cpf'";
$rsv = mysql_query($sqlv);



while(list($particularv, $nomev, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into particular(classificacao,cartaosus,formapagto,nome,sexo,datanascimento,cpf,rg,emissorrg,ufrg,dataemissaorg,fonerec,fonecel1,fonecel2,fonecel3,foneres,fonecom,endereco,bairro,cidade,uf,cep,nacionalidade,naturalidade,ufnaturalidade,pai,mae,estadocivil,conjuge,profissao,ocupacao,email,detalhe,data,hora,usuario) VALUES('$classificacao','$cartaosus','$formapagto','$nome','$sexo','$datanascimento','$cpf','$rg','$emissorrg','$ufrg','$dataemissaorg','$fonerec','$fonecel1','$fonecel2','$fonecel3','$foneres','$fonecom','$endereco','$bairro','$cidade','$uf','$cep','$nacionalidade','$naturalidade','$ufnaturalidade','$pai','$mae','$estadocivil','$conjuge','$profissao','$ocupacao','$email','$detalhe','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM particular WHERE cpf = '$cpf'";
  $rsc = mysql_query($sqlc);

  while(list($particularc,$classificacaoc,$cartaosusc,$formapagtoc,$nomec,$sexoc,$datanascimentoc,$cpfc,$rgc,$emissorrgc,$ufrgc,$dataemissaorgc,$fonerecc,$fonecel1c,$fonecel2c,$fonecel3c,$foneresc,$fonecomc,$enderecoc,$bairroc,$cidadec,$ufc,$cepc,$nacionalidadec,$naturalidadec,$ufnaturalidadec,$paic,$maec,$estadocivilc,$conjugec,$profissaoc,$ocupacaoc,$emailc,$detalhec,$datac,$horac,$usuarioc) = mysql_fetch_row($rsc)){
	  
  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("INC: $data_atual, $hora_atual, Particular: $pega_particular, classificacao: $classificacao, Cartao SUS: $cartaosus, Forma pagto: $formapagto, Nome: $nome,  Sexo: $sexo, Dt nascimento: $datanascimento, CPF: $cpf, RG: $rg, Emissor: $emissorrg/$ufrg em: $dataemissaorg, Estado civil: $estadocivil, Conjugue: $conjuge, Nacionalidade: $nacionalidade, Naturalidade: $naturalidade/$ufnaturalidade, Filiacao: $pai/$mae, Profissao: $profissao, Ocupacao: $ocupacao, Endereco: $endereco, $bairro, $cidade/$uf, CEP $cep, Tel. res.: $foneres, Tel. Cel.1: $fonecel1, Tel. Cel.2: $fonecel2, Tel. Cel.3: $fonecel3, Tel. Com.: $fonecom, Tel. Rec.: $fonerec, E-mail: $email, Detalhe: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG

header("Location:fsus_particular.php?particular=$particularc&classificacao=$classificacao&cartaosus=$cartaosus&formapagto=$formapagto&nome=$nome&datanascimento=$datanascimento&cpf=$cpf&rg=$rg&emissorrg=$emissorrg&dataemissaorg=$dataemissaorg&ufrg=$ufrg&sexo=$sexo&estadocivil=$estadocivil&conjuge=$conjuge&nacionalidade=$nacionalidade&ufnaturalidade=$ufnaturalidade&naturalidade=$naturalidade&pai=$pai&mae=$mae&profissao=$profissao&ocupacao=$ocupacao&endereco=$endereco&bairro=$bairro&cidade=$cidade&uf=$uf&cep=$cep&foneres=$foneres&fonecel1=$fonecel1&fonecel2=$fonecel2&fonecel3=$fonecel3&fonecom=$fonecom&fonerec=$fonerec&email=$email&detalhe=$detalhe&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
}
?>