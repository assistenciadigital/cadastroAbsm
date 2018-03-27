<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#data
$ndata = explode("-",date("Y-m-d")); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>
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
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>
<?php include("requerido/dataehora.php");?>
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
<strong>Consulta CEP | <a href="fpes_cep.php">Retornar</a></strong>
<hr>

<?php 
header('Content-Type: text/html; charset=UTF-8');
include('correio/correios.class.php');

if(isset($_GET['cep'])){
$endereco = Correios::cep($_GET['cep']);
$conta_endereco = count($endereco);
//print_r($endereco);

$endereco = $endereco[0];

$logradouro = $endereco[logradouro];
$bairro = $endereco[bairro];
$cidade = $endereco[cidade];
$uf = $endereco[uf];
$cep = $endereco[cep];

$completo = "$logradouro\n$bairro\n$cidade\n$uf\n$cep";

/*echo "Logradouro: $logradouro <br/>
	  Bairro    : $bairro <br/>
	  Cidade    : $cidade <br/>
	  UF        : $uf <br/>
	  CEP       : $cep <br/><br/>";*/
}else{
die('<form id="form" name="form" method="get">Informe o CEP no formato de 8 dígitos (00000000),<br/> sem traços ou pontos e pressione ENTER, para pesquisar: <input type="text" name="cep" size="8" maxlength="8">
<script language="JavaScript"> document.form.cep.focus(); </script>
</form>');
}
?>

<form id="form1" name="form1" method="post" action="">
  <table width="580" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="130" align="left" valign="top"><strong>Logradouro:</strong></td>
      <td width="450" align="left" valign="top"><input name="flogradouro" type="text" id="flogradouro" value="<?php print $logradouro; ?>" size="50" maxlength="160" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Bairro:</strong></td>
      <td align="left" valign="top"><input name="fbairro" type="text" id="fbairro" value="<?php print $bairro; ?>" size="50" maxlength="160" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Cidade:</strong></td>
      <td align="left" valign="top"><input name="fcidade" type="text" id="fcidade" value="<?php print $cidade; ?>" size="50" maxlength="160" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>UF</strong>:</td>
      <td align="left" valign="top"><input name="fuf" type="text" id="fuf" value="<?php print $uf; ?>" size="2" maxlength="2" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>CEP:</strong></td>
      <td align="left" valign="top"><input name="fcep" type="text" id="fcep" value="<?php print $cep; ?>" size="8" maxlength="8" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Completo:</strong></td>
      <td align="left" valign="top"><textarea name="fcompleto" cols="50" rows="4" readonly="readonly" id="fcompleto"><?php print $completo; ?></textarea></td>
    </tr>
    <tr>
      <td align="left" valign="top"><p><strong>Data/Hora:</strong></p>
        <p><strong>Usuário:<br />
          </strong></p></td>
      <td align="left" valign="top"><?php print $data_final; ?>
        <p><?php print strtoupper($loginusuario_atual); ?></p></td>
    </tr>
  </table>
</form>
</div>
</div>
</body>