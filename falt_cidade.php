﻿<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2")
{
	header("location:fcon_cidade.php");	
}

$pega_cidade = $_GET[cidade];

$sql = "SELECT * FROM cidade WHERE cidade=$pega_cidade";
$rs = mysql_query($sql);

list($cidade, $uf, $descricao, $tipo, $data, $hora, $usuario) = mysql_fetch_row($rs);

#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
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

.style1 {	color: #FF0000;
	font-size: x-small;
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
<strong>Confirma Alteração Cidade? | <a href="fcon_cidade.php">Retornar</a></strong>
<hr>
<form action="calt_cidade.php?cidade=<?php print $cidade;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="580" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="130" align="left" valign="top"><strong>Cidade:</strong></td>
    <td width="450" align="left" valign="top"><input name="fcidade" type="text" disabled="disabled" value="<?php print $cidade; ?>" size="2" maxlength="2" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>UF:</strong></td>
    <td align="left" valign="top"><strong>
      <select name="fuf" id="fuf">
        <option value="<?php print $uf; ?>"><?php print $uf; ?></option>
        <option value=""></option>
        <option value="AC">AC</option>
        <option value="AL">AL</option>
        <option value="AM">AM</option>
        <option value="AP">AP</option>
        <option value="BA">BA</option>
        <option value="CE">CE</option>
        <option value="DF">DF</option>
        <option value="ES">ES</option>
        <option value="GO">GO</option>
        <option value="MA">MA</option>
        <option value="MG">MG</option>
        <option value="MS">MS</option>
        <option value="MT">MT</option>
        <option value="PA">PA</option>
        <option value="PB">PB</option>
        <option value="PE">PE</option>
        <option value="PI">PI</option>
        <option value="PR">PR</option>
        <option value="RJ">RJ</option>
        <option value="RN">RN</option>
        <option value="RO">RO</option>
        <option value="RR">RR</option>
        <option value="RS">RS</option>
        <option value="SC">SC</option>
        <option value="SE">SE</option>
        <option value="SP">SP</option>
        <option value="TO">TO</option>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Descrição:</strong></td>
    <td align="left" valign="top"><input name="fdescricao" type="text" value="<?php print $descricao; ?>" size="50" maxlength="50" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Tipo:</strong></td>
    <td align="left" valign="top"><input name="ftipo" type="text" id="ftipo" value="<?php print $tipo; ?>" size="1" maxlength="1" />
      <span class="style1">* INFORME: D = DISTRITO, M = MUNICIPIO, P = ?</span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Data/Hora:</strong></td>
    <td align="left" valign="top"><input name="fdata" type="text" disabled="disabled" id="fdata" value="<?php print $data_final; ?> <?php print $hora; ?>" size="17" maxlength="17" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Usuário:</strong></td>
    <td align="left" valign="top"><input name="" type="text" disabled="disabled" id="fusuario" value="<?php print $usuario; ?>" size="20" maxlength="20" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Usuário atual:</strong></td>
    <td align="left" valign="top"><input name="fusuario_atual" type="text" disabled="disabled" id="fusuario_atual" value="<?php print $loginusuario_atual; ?>" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"></td>
    <td align="left" valign="top"><input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
</table>
</form>
<hr>
</div>
</div>
</body>
</html>