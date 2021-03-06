﻿<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "1")
{
	header("location:fcon_usuario.php");	
}

$pega_idusuario = $_GET[idusuario];

$sql = "SELECT * FROM usuario WHERE idusuario=$pega_idusuario";
$rs = mysql_query($sql);

list($idusuario, $login, $senha, $nome, $nivel, $ativo, $sms, $data, $hora, $usuario) = mysql_fetch_row($rs);

$pega_nivel = base64_decode($nivel);
$pega_ativo = base64_decode($ativo);

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
<strong>Confirma Alteração da Senha do Usuário? | <a href="fcon_usuario.php">Retornar</a></strong>
<hr>
<form action="calt_senha_usuario.php?idusuario=<?php print $idusuario;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="580" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="130" align="left" valign="top"><strong>ID usuario:</strong></td>
    <td width="450" align="left" valign="top"><input name="fidusuario" type="text" disabled="disabled" id="fidusuario" value="<?php print $idusuario; ?>" size="2" maxlength="2" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Login:</strong></td>
    <td align="left" valign="top"><input name="flogin" type="text" disabled="disabled" id="flogin" value="<?php print $login; ?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Digite Senha:</strong></td>
      <td align="left" valign="top"><input name="fsenha" type="password" id="fsenha" size="25" maxlength="32" /><script language="JavaScript"> document.form1.fsenha.focus(); </script>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Confirma Senha:</strong></td>
      <td align="left" valign="top"><input name="fconfirma" type="password" id="fconfirma" size="25" maxlength="32" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Nome:</strong></td>
      <td align="left" valign="top"><input name="fnome" type="text" disabled="disabled" id="fnome" value="<?php print $nome; ?>" size="50" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Nivel:</strong></td>
      <td align="left" valign="top"><select name="fnivel" id="fnivel" disabled="disabled" readonly="readonly">
        <option value="<?php print  ($pega_nivel);?>"><?php print  ($pega_nivel);?></option>
        <option value="1">Administrador</option>
        <option value="2">Cadastro</option>
        <option value="3">Atendimento</option>
        <option value="4">Recibo</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Ativo:</strong></td>
      <td align="left" valign="top"><select name="fativo" id="fativo" disabled="disabled" readonly="readonly">
        <option value="<?php print  ($pega_ativo);?>"><?php print ($pega_ativo);?></option>
        <option value=""></option>
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Envia SMS?</strong></td>
      <td align="left" valign="top"><select name="fsms" id="fsms" disabled="disabled" readonly="readonly">
        <option value="<?php print ($sms);?>"><?php print ($sms);?></option>
        <option value=""></option>
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Data/Hora:</strong></td>
      <td align="left" valign="top"><input name="fdata" type="text" disabled="disabled" id="fdata" value="<?php print $data_final; ?> <?php print $hora; ?>" size="17" maxlength="17" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário:</strong></td>
      <td align="left" valign="top"><input name="fusuario" type="text" disabled="disabled" id="fusuario" value="<?php print $usuario; ?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário atual:</strong></td>
      <td align="left" valign="top"><input name="fusuario_atual" type="text" disabled="disabled" id="fusuario_atual" value="<?php print $loginusuario_atual; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="submit" name="fok" id="fok" value="OK" /></td>
    </tr>
  </table>
</form>
<hr>
</td>
</tr>
</table>
</div>
</div>
</body>
</html>