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
	header("location:fcon_formapagto.php");	
}

$pega_formapagto = $_GET[formapagto];

$sql = "SELECT * FROM formapagto WHERE formapagto=$pega_formapagto";
$rs = mysql_query($sql);

list($formapagto, $descricao, $detalhe, $data, $hora, $usuario) = mysql_fetch_row($rs);

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
<strong>Confirma Forma de Pagamento? | <a href="fcon_formapagto.php">Retornar</a></strong>
<hr>
<form action="calt_formapagto.php?formapagto=<?php print $formapagto;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<table width="580" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="130" align="left" valign="top"><strong>Forma Pagto:</strong></td>
    <td width="450" align="left" valign="top"><input name="fformapagto" type="text" disabled="disabled" value="<?php print $formapagto; ?>" size="2" maxlength="2" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Descrição:</strong></td>
    <td align="left" valign="top"><input name="fdescricao" type="text" value="<?php print $descricao; ?>" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Detalhe:</strong></td>
    <td align="left" valign="top"><textarea name="fdetalhe" cols="65" rows="5"><?php print $detalhe; ?></textarea></td>
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