<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

$idusuario = $_GET[idusuario];
$login = $_GET[login];
$senha = $_GET[senha];
$nome = $_GET[nome];
$nivel = $_GET[nivel];
$ativo = $_GET[ativo];
$sms = $_GET[sms];
$usuario = $_GET[usuario];
$data = $_GET[data_atual];
$hora = $_GET[hora_atual];

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
<strong>Cadastro realizado com sucesso! | <a href="fcon_usuario.php">Retornar</a></strong>
<hr>
<form id="form1" name="form1" method="post" action="">
  <table width="580" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="130" align="left" valign="top"><strong>Id Usuário:</strong></td>
    <td width="450" align="left" valign="top"><input name="fidusuario" type="text" disabled="disabled" id="fidusuario" value="<?php print $idusuario; ?>" size="20" maxlength="20" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Login:</strong></td>
    <td align="left" valign="top"><input name="flogin" type="text" disabled="disabled" id="flogin" value="<?php print $login; ?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Senha:</strong></td>
      <td align="left" valign="top"><input name="fsenha" type="password" disabled="disabled" id="fsenha" value="12345678901" size="11" maxlength="11" readonly="readonly" />
    </td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Nome:</strong></td>
      <td align="left" valign="top"><input name="fnome" type="text" disabled="disabled" id="fnome" value="<?php print $nome; ?>" size="30" maxlength="30" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Nivel:</strong></td>
      <td align="left" valign="top"><input name="fnivel" type="text" disabled="disabled" id="fnivel" value="<?php print $nivel; ?>" size="2" maxlength="2" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Ativo:</strong></td>
      <td align="left" valign="top"><input name="fativo" type="text" disabled="disabled" id="fativo" value="<?php print $ativo; ?>" size="4" maxlength="4" readonly="readonly" />
        </td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Envia SMS?</strong></td>
      <td align="left" valign="top"><input name="fsms" type="text" disabled="disabled" id="fsms" value="<?php print $sms; ?>" size="4" maxlength="4" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Data/Hora:</strong></td>
      <td align="left" valign="top"><input name="fdata" type="text" disabled="disabled" value="<?php print $data_final; ?> <?php print $hora; ?>" size="16" maxlength="16" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário:</strong></td>
      <td align="left" valign="top"><input name="fusuario" type="text" disabled="disabled" value="<?php print $usuario; ?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
  </table>
</form>
<hr>
</div>
</div>
</body>
</html>