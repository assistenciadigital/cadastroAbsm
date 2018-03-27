<?php
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
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
<strong>Consulta Titular Sistema Anterior | <a href="menu.php">Retornar</a> | <a href="fcad_cliente.php">Novo Registro +</a></strong>
<hr>
<form action="fbus_cliente.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
  <strong>Nome: </strong>
    <input name="fnome" type="text" id="fnome" size="50" maxlength="100" />    <script language="JavaScript"> document.form1.fnome.focus(); </script>
    <strong>    CPF:</strong>
    <input name="fcpf" type="text" id="fcpf" size="11" maxlength="11" />
<input type="submit" name="fpesquisar" id="fpesquisar" value="Pesquisar" />
</form>
<hr>
<table width="680" align="left">
<tr valign="middle">
    <th width="100" height="0" align="left" valign="middle" scope="col">Cliente</th>
    <th width="100" height="0" align="left" valign="middle" scope="col">Unidade</th>
    <th width="347,5" height="0" align="left" scope="col">Nome</th>
    <th width="95" height="0" align="left" scope="col">Usuário</th>
    <th width="37,5" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 335px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$pega_nome = $_POST[fnome];
$pega_cpf = $_POST[fcpf];

$sql = "SELECT codpm, codbat, nompm, dtnasc, cpf, dtincs, usuario FROM cad_pm ORDER BY nompm";
$rs = mysql_query($sql);


while(list($codpm,$codbat,$nompm,$dtnasc,$cpf,$dtincs,$usuario) = mysql_fetch_row($rs)) {
	
#datas
$ndata = explode("-",$dtincs); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

#data nascimento
$ndata = explode("-",$dtnasc); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_nascimento = "$ano/$mes/$dia";

$contador++;	
?>
<table width="680" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" height="35" align="center" scope="col"><?php print $codpm; ?></td>
    <td width="100" height="35" align="center" scope="col"><?php print $codbat; ?></td>
    <td width="347,5" height="35" align="left" scope="col"><?php print $nompm; ?><br/><?php print $data_nascimento; ?> | <?php print $cpf; ?></td>
    <td width="95" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="37,5" height="35" align="center" scope="col"><a href="falt_cliente.php?cliente=<?php print $cliente; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a> <a href="fcad_dependente_anterior.php?titular=<?php print $codpm; ?>"><img src="imagem/ico-dependente.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col"><strong></strong><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> = Alterar <img src="imagem/ico-delete.png" alt="" width="23" height="23"/> = Delete</td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>