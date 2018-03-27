<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

$cliente = $_GET[cliente];
$classificacao = $_GET[classificacao];
$cartaosus = $_GET[cartaosus];
$assistencia = $_GET[assistencia];
$tipo = $_GET[tipo];
$plano = $_GET[plano];
$formapagto = $_GET[formapagto];
$titular = $_GET[titular];
$graduacao = $_GET[graduacao];
$instituicao = $_GET[instituicao];
$status = $_GET[status];
$nome = $_GET[nome];
$cpf = $_GET[cpf];
$rg = $_GET[rg];
$emissorrg = $_GET[emissorrg];
$ufrg = $_GET[ufrg];
$matriculasad = $_GET[matriculasad];
$sexo = $_GET[sexo];
$estadocivil = $_GET[estadocivil];
$conjuge = $_GET[conjuge];
$nacionalidade = $_GET[nacionalidade];
$ufnaturalidade = $_GET[ufnaturalidade];
$naturalidade = $_GET[naturalidade];
$pai = $_GET[pai];
$mae = $_GET[mae];
$profissao = $_GET[profissao];
$ocupacao = $_GET[ocupacao];
$endereco = $_GET[endereco];
$bairro = $_GET[bairro];
$cidade = $_GET[cidade];
$uf = $_GET[uf];
$cep = $_GET[cep];
$foneres = $_GET[foneres];
$fonecel1 = $_GET[fonecel1];
$fonecel2 = $_GET[fonecel2];
$fonecel3 = $_GET[fonecel3];
$fonecom = $_GET[fonecom];
$fonerec = $_GET[fonerec];
$email = $_GET[email];
$detalhe = $_GET[detalhe];
$usuario = $_GET[usuario];

#data atual
$ndata_atual = explode("-",$_GET[data_atual]); 
$dia_atual = $ndata_atual[0];
$mes_atual = $ndata_atual[1];
$ano_atual = $ndata_atual[2];
$data_atual = "$ano_atual/$mes_atual/$dia_atual";  

$hora = $_GET[hora_atual];

$ndata_inclusao = explode("-",$_GET[datainclusao]); 
$dia_inclusao = $ndata_inclusao[0];
$mes_inclusao = $ndata_inclusao[1];
$ano_inclusao = $ndata_inclusao[2];
$datadeinclusao = "$ano_inclusao/$mes_inclusao/$dia_inclusao";

#data
$ndata_nascimento = explode("-",$_GET[datanascimento]); 
$dia_nascimento = $ndata_nascimento[0];
$mes_nascimento = $ndata_nascimento[1];
$ano_nascimento = $ndata_nascimento[2];
$datadenascimento = "$ano_nascimento/$mes_nascimento/$dia_nascimento";

#data
$ndata_emissaorg = explode("-",$_GET[dataemissaorg]);  
$dia_emissaorg = $ndata_emissaorg[0];
$mes_emissaorg = $ndata_emissaorg[1];
$ano_emissaorg = $ndata_emissaorg[2];
$datadeemissaorg = "$ano_emissaorg/$mes_emissaorg/$dia_emissaorg";

#data
$ndata_incorporacao = explode("-",$_GET[dataincorporacao]); 
$dia_incorporacao = $ndata_incorporacao[0];
$mes_incorporacao = $ndata_incorporacao[1];
$ano_incorporacao = $ndata_incorporacao[2];
$datadeincorporacao = "$ano_incorporacao/$mes_incorporacao/$dia_incorporacao";  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>

<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript">

      $(document).ready(function(){
	  
		$("input[name='fdatainclusao']").mask('99/99/9999');
		$("input[name='fdatanascimento']").mask('99/99/9999');
		$("input[name='fdataemissaorg']").mask('99/99/9999');
		$("input[name='fdataincorporacao']").mask('99/99/9999');
		$("input[name='fdatainclusao']").mask('99/99/9999');	
		$("input[name='ffoneres']").mask('(99)9999-9999');	
		$("input[name='ffonecel']").mask('(99)9999-9999');	
		$("input[name='ffonecom']").mask('(99)9999-9999');	
		$("input[name='ffonerec']").mask('(99)9999-9999');	
		$("input[name='fcep']").mask('99.999-999');	
		$("input[name='fcpf']").mask('999.999.999-99');	
  }) 
</script>

<style type="text/css">

body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 700px;
height: 700px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>

</head>

<body>
<div id="tudo">
<div id="conteudo">
<hr>
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Cadastro realizado com sucesso! | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:700px; height:800px; overflow: auto; vertical-align: center;">
<form id="form1" name="form1" method="post" action="">
  <table width="580" border="1" cellpadding="1" cellspacing="1">
    <tr>
      <td width="130" align="left" valign="middle"><strong>Cliente:</strong></td>
      <td width="450" align="left" valign="middle"><strong><?php print $cliente; ?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Assistencia:</strong></td>
      <td align="left" valign="middle"><?php $sqlassistencia = "SELECT descricao FROM assistencia WHERE assistencia = '$assistencia'";
         $rsassistencia = mysql_query($sqlassistencia) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsassistencia)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Data Inclusão:</strong></td>
      <td align="left" valign="middle"><?php print $datadeinclusao; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Status</strong><strong>: </strong></td>
      <td align="left" valign="middle"><?php print $status; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Classificação</strong><strong>: </strong></td>
      <td align="left" valign="middle"><?php $sqlclassificacao = "SELECT descricao FROM classificacao WHERE classificacao = '$classificacao'";
         $rsclassificacao = mysql_query($sqlclassificacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsclassificacao)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Tipo:</strong></td>
      <td align="left" valign="middle"><?php $sqltipo = "SELECT descricao FROM tipo WHERE tipo = '$tipo'";
         $rstipo = mysql_query($sqltipo) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rstipo)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Plano:</strong></td>
      <td align="left" valign="middle"><?php $sqlplano = "SELECT descricao FROM plano WHERE plano = '$plano'";
         $rsplano = mysql_query($sqlplano) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsplano)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Forma Pagto:</strong></td>
      <td align="left" valign="middle"><?php $sqlformapagto = "SELECT descricao FROM formapagto WHERE formapagto = '$formapagto'";
         $rsformapagto = mysql_query($sqlformapagto) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsformapagto)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Titular:</strong></td>
      <td align="left" valign="middle">
       <?php 
		$sqltitular = "select cliente as codigo_titular, nome as nome_titular, cpf as cpf_titular from cliente where cliente = '$titular'";
		$rstitular = mysql_query($sqltitular);
		while(list($codigo_titular, $nome_titular, $cpf_titular) = mysql_fetch_row($rstitular)) {
		?>
        Código: <?php print $codigo_titular; ?><br/>Nome..: <?php print $nome_titular; ?><br/>CPF...: <?php print $cpf_titular; ?>
        <?php 
		}
		?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>CNS SUS:</strong></td>
      <td align="left" valign="middle"><?php print $cartaosus; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Graduação:</strong></td>
      <td align="left" valign="middle"><?php $sqlgraduacao = "SELECT descricao FROM insignia WHERE insignia = '$graduacao'";
         $rsgraduacao = mysql_query($sqlgraduacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsgraduacao)){
         echo $ln['descricao'];}?><strong> |  Matricula SAD: </strong><?php print $matriculasad; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Instituição:</strong></td>
      <td align="left" valign="middle"><?php print $instituicao; ?><strong> | Data de Incorporação: </strong><?php print $datadeincorporacao; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Nome:</strong></td>
      <td align="left" valign="middle"><?php print $nome; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Sexo:</strong></td>
      <td align="left" valign="middle"><?php print $sexo; ?><strong> | Data Nascimento: </strong><?php print $datadenascimento; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>CPF:</strong></td>
      <td align="left" valign="middle"><?php print $cpf; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>RG:</strong></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php print $rg; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Emissor RG:</strong></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php print $emissorrg; ?>/<?php print $ufrg; ?><strong> |  Data Emissão: </strong><?php print $datadeemissaorg; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Nacionalidade:</strong></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php print $nacionalidade; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Naturalidade:</strong></td>
      <td align="left" valign="middle" nowrap="nowrap"><?php $sqlnaturalidade = "SELECT descricao FROM cidade WHERE cidade = '$naturalidade'";
         $rsnaturalidade = mysql_query($sqlnaturalidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsnaturalidade)){echo $ln['descricao'];}?>/<?php $sqlufnaturalidade = "SELECT uf FROM cidade WHERE cidade = '$naturalidade'";
         $rsufnaturalidade = mysql_query($sqlufnaturalidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsufnaturalidade)){echo $ln['uf'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Filiação:</strong></td>
      <td align="left" valign="middle" nowrap="nowrap">Pai: <?php print $pai; ?><br/>Mãe: <?php print $mae; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Estado Civil:</strong></td>
      <td align="left" valign="middle"><?php $sqlestadocivil = "SELECT descricao FROM estadocivil WHERE estadocivil = '$estadocivil'";
         $rsestadocivil = mysql_query($sqlestadocivil) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsestadocivil)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Conjugue:</strong></td>
      <td align="left" valign="middle"><?php print $conjuge; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Profissão:</strong></td>
      <td align="left" valign="middle"><?php $sqlprofissao = "SELECT descricao FROM profissao WHERE profissao = '$profissao'";
         $rsprofissao = mysql_query($sqlprofissao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsprofissao)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Ocupação:</strong></td>
      <td align="left" valign="middle"><?php $sqlocupacao = "SELECT descricao FROM ocupacao WHERE ocupacao = '$ocupacao'";
         $rsocupacao = mysql_query($sqlocupacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsocupacao)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Endereço:</strong></td>
      <td align="left" valign="middle"><?php print $endereco; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Bairro:</strong></td>
      <td align="left" valign="middle"><?php $sqlbairro = "SELECT descricao FROM bairro WHERE bairro = '$bairro'";
         $rsbairro = mysql_query($sqlbairro) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsbairro)){
         echo $ln['descricao'];}?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Cidade:</strong></td>
      <td align="left" valign="middle">
	     <?php $sqlcidade = "SELECT descricao FROM cidade WHERE cidade = '$cidade'";
         $rscidade = mysql_query($sqlcidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rscidade)){
         echo $ln['descricao'];}?>/<?php $sqlufcidade = "SELECT uf FROM cidade WHERE cidade = '$cidade'";
         $rsufcidade = mysql_query($sqlufcidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsufcidade)){echo $ln['uf'];}?><strong> | CEP: </strong><?php print $cep; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>UF:</strong></td>
      <td align="left" valign="middle"><?php print $uf; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Telefone(s):<br/><br/><br/>E-mail:</strong></td>
      <td align="left" valign="middle"><strong>Res..:</strong><?php print $foneres; ?><strong> | Com..:</strong><?php print $fonecom; ?><br/>
                                       <strong>Cel.1:</strong><?php print $fonecel1; ?><strong> | Cel.2:</strong><?php print $fonecel2; ?><br/>
                                       <strong>Cel.3:</strong><?php print $fonecel3; ?><strong> | Rec..:</strong><?php print $fonerec; ?><br/><?php print $email; ?><strong> </td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Observação:</strong></td>
      <td align="left" valign="middle"><?php print $detalhe; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Data/Hora:</strong></td>
      <td align="left" valign="middle"><?php print $data_atual; ?> | <?php print $hora; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Usuário:</strong></td>
      <td align="left" valign="middle"><?php print $loginusuario_atual; ?></td>
    </tr>
    </table>
</form>
<hr>
</div>
</div>
</body>
</html>