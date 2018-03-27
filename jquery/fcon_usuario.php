<?php
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

include("requerido/conexao.php");
include("requerido/verifica.php");
if ($nivelusuario_atual != "1" and $nivelusuario_atual != "1")
{
	header("location:menu.php");	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>

<style>
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
<strong>Consulta Usuário | <a href="menu.php">Retornar</a> | <a href="fcad_usuario.php">Novo Registro +</a></strong>
<hr>
<form action="fbus_usuario.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
  <strong>Login: </strong>
<input name="flogin" type="text" id="flogin" size="10" maxlength="20" />
<script language="JavaScript"> document.form1.flogin.focus(); </script>
<strong>Nome: </strong>
<input name="fnome" type="text" id="fnome" size="10" maxlength="30" />
<strong>Ativo: </strong>
<input name="fativo" type="text" id="fativo" size="2" maxlength="2" />
<input type="submit" name="fpesquisar" id="fpesquisar" value="Pesquisar" />
</form>
<hr>
<table width="680" align="left">
  <tr valign="bottom">
    <th width="50" height="0" align="left" scope="col">ID</th>
    <th width="160" height="0" align="left" scope="col">Login</th>
    <th width="200" height="0" align="left" scope="col">Nome</th>
    <th width="50" height="0" align="left" scope="col">Nível</th>
    <th width="50" height="0" align="left" scope="col">Ativo</th>
    <th width="95" height="0" align="left" scope="col">Usuário</th>
    <th width="75" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 340px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$login = $_POST[flogin];
$nome = $_POST[fnome];
$ativo = $_POST[fativo];

$sql = "SELECT idusuario, login, nome, nivel, ativo, sms, data, hora, usuario FROM usuario ORDER BY usuario, nome, nivel, ativo";
$rs = mysql_query($sql);


while(list($idusuario, $login, $nome, $nivel, $ativo, $sms, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

$contador++;
?>    
<table width="680">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
   <td width="50" height="0" align="center" valign="middle"><?php print $idusuario; ?><br/><a href="falt_senha_usuario.php?idusuario=<?php print $idusuario; ?>"><img src="imagem/ico-senha.png" alt="" width="46" height="43"/></a></td>       
    <td width="160" height="0" align="left" valign="middle"><?php print $login; ?><br/>Envia SMS? <?php print $sms; ?></td>
    <td width="200" height="0" align="left" valign="middle"><?php print $nome; ?></td>
    <td width="50" height="0" align="left"><?php print base64_decode($nivel); ?></td>
    <td width="50" height="0" align="left"><?php print base64_decode($ativo); ?></td>
    <td width="95" height="0" align="left"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?>
    </td>
    <td width="75" height="35" align="center"><a href="falt_usuario.php?idusuario=<?php print $idusuario; ?>"><img src="imagem/ico-refresh.png" alt="" width="33" height="33"/></a><br/><a href="fexc_usuario.php?idusuario=<?php print $idusuario; ?>"><img src="imagem/ico-delete.png" alt="" width="33" height="33"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="center" valign="top" scope="col"><img src="imagem/ico-refresh.png" alt="" width="42" height="33"/> Alterar <img src="imagem/ico-senha.png" alt="" width="38" height="33"/>Senha <img src="imagem/ico-delete.png" alt="" width="42" height="33"/> Delete</td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>