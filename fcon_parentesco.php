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
<strong>Consulta Parentesco | <a href="menu.php">Retornar</a> | <a href="fcad_parentesco.php">Novo Registro +</a></strong>
<hr>
<form action="fbus_parentesco.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
  <strong>Descrição: </strong>
    <input name="fdescricao" type="text" id="fdescricao" size="30" maxlength="30" />
    <script language="JavaScript"> document.form1.fdescricao.focus(); </script>    
    <strong>Grau: </strong>
    <input name="fgrau" type="text" id="fgrau" size="1" maxlength="1" />
    <input type="submit" name="fpesquisar" id="fpesquisar" value="Pesquisar" />
</form>
<hr>
<table width="680" align="left">
  <tr valign="middle">
    <th width="100" height="0" align="left" valign="middle" scope="col">Parentesco</th>
    <th width="330" height="0" align="left" scope="col">Descrição</th>
    <th width="50" height="0" align="left" scope="col">Grau</th>
    <th width="100" height="0" align="left" scope="col">Usuário</th>
    <th width="100" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 340px; overflow: auto; vertical-align: left;">

<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$descricao = $_POST[fdescricao];
$grau = $_POST[fgrau];

$sql = "SELECT * FROM parentesco ORDER BY grau, descricao";
$rs = mysql_query($sql);


while(list($parentesco, $descricao, $grau, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

$contador++;
?>
<table width="680" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" height="35" align="left" scope="col"><?php print $parentesco; ?></td>
    <td width="330" height="35" align="left" scope="col"><?php print $descricao; ?></td>
    <td width="50" height="35" align="left" scope="col"><?php print $grau; ?></td>
    <td width="100" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="50" height="35" align="center" scope="col"><a href="falt_parentesco.php?parentesco=<?php print $parentesco; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a></td>
    <td width="50" height="35" align="center" scope="col"><a href="fexc_parentesco.php?parentesco=<?php print $parentesco; ?>"><img src="imagem/ico-delete.png" alt="" width="23" height="23"/></a></td>
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