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


$pega_cliente = $_GET[cliente];
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

  #INICIA GRAVACAO DO LOG    
  
  $observacao = ("ALT: $data_atual, $hora_atual, Cliente: $pega_cliente, Classificacao: $classificacao, Cartao SUS: $cartaosus, Dt inclusao: $datainclusao, Assistencia: $assistencia, Tipo: $tipo, Plano: $plano, Forma pagto: $formapagto, Titular: $titular, Graduacao: $graduacao, Instituicao: $instituicao/$ufinstituicao, Status: $status, Nome: $nome, Dt nascimento: $datanascimento, CPF: $cpf, RG: $rg, Emissor: $emissorrg/$ufrg em: $dataemissaorg, Matricula: $matriculasad, Dt incorporacao: $dataincorporacao, Sexo: $sexo, Estado civil: $estadocivil, Conjugue: $conjuge, Nacionalidade: $nacionalidade, Naturalidade: $naturalidade/$ufnaturalidade, Filiacao: $pai/$mae, Profissao: $profissao, Ocupacao: $ocupacao, Endereco: $endereco, $bairro, $cidade/$uf, CEP $cep, Tel. res.: $foneres, Tel. Cel.1: $fonecel1, Tel. Cel.2: $fonecel2, Tel. Cel.3: $fonecel3, Tel. Com.: $fonecom, Tel. Rec.: $fonerec, E-mail: $email, Detalhe: $detalhe, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
    
  $sql = "UPDATE cliente SET classificacao='$classificacao',cartaosus='$cartaosus',datainclusao='$datainclusao',assistencia='$assistencia',tipo='$tipo',plano='$plano',formapagto='$formapagto',titular='$titular',graduacao='$graduacao',instituicao='$instituicao',ufinstituicao='$ufinstituicao',status='$status',nome='$nome',datanascimento='$datanascimento',cpf='$cpf',rg='$rg',emissorrg='$emissorrg',ufrg='$ufrg',dataemissaorg='$dataemissaorg',matriculasad='$matriculasad',dataincorporacao='$dataincorporacao',sexo='$sexo',estadocivil='$estadocivil',conjuge='$conjuge',nacionalidade='$nacionalidade',ufnaturalidade='$ufnaturalidade',naturalidade='$naturalidade',pai='$pai',mae='$mae',profissao='$profissao',ocupacao='$ocupacao',endereco='$endereco',bairro='$bairro',cidade='$cidade',uf='$uf',cep='$cep',foneres='$foneres',fonecel1='$fonecel1',fonecel2='$fonecel2',fonecel3='$fonecel3',fonecom='$fonecom',fonerec='$fonerec',email='$email',detalhe='$detalhe',data='$data_atual',hora='$hora_atual',usuario='$loginusuario_atual' WHERE cliente=$pega_cliente";
  $rs = mysql_query($sql);

#header("Location: fcon_cliente.php");

header("Location:fsus_cliente.php?cliente=$pega_cliente&classificacao=$classificacao&cartaosus=$cartaosus&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");//"Location:fsus_cliente.php?cliente=$pega_cliente&classificacao=$classificacao&cartaosus=$cartaosus&datainclusao=$datainclusao&assistencia=$assistencia&tipo=$tipo&plano=$plano&formapagto=$formapagto&titular=$titular&graduacao=$graduacao&instituicao=$instituicao&ufinstituicao=$ufinstituicao&status=$status&nome=$nome&datanascimento=$datanascimento&cpf=$cpf&rg=$rg&emissorrg=$emissorrg&dataemissaorg=$dataemissaorg&ufrg=$ufrg&matriculasad=$matriculasad&dataincorporacao=$dataincorporacao&sexo=$sexo&estadocivil=$estadocivil&conjuge=$conjuge&nacionalidade=$nacionalidade&ufnaturalidade=$ufnaturalidade&naturalidade=$naturalidade&pai=$pai&mae=$mae&profissao=$profissao&ocupacao=$ocupacao&endereco=$endereco&bairro=$bairro&cidade=$cidade&uf=$uf&cep=$cep&foneres=$foneres&fonecel1=$fonecel1&fonecel2=$fonecel2&fonecel3=$fonecel3&fonecom=$fonecom&fonerec=$fonerec&email=$email&detalhe=$detalhe&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");

?>
