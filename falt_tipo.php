<?php
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
	header("location:fcon_tipo.php");	
}

$pega_tipo = $_GET[tipo];

$sql = "SELECT * FROM tipo WHERE tipo=$pega_tipo";
$rs = mysql_query($sql);

list($tipo, $classificacao, $descricao, $titular, $data, $hora, $usuario) = mysql_fetch_row($rs);

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
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }

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
<strong>Confirma Alteração tipo? | <a href="fcon_tipo.php">Retornar</a></strong>
<hr>
<form action="calt_tipo.php?tipo=<?php print $tipo;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td width="130" align="left" valign="top"><strong>Tipo:</strong></td>
      <td width="450" align="left" valign="top"><input name="ftipo" type="text" disabled="disabled" id="ftipo" value="<?php print $tipo; ?>" size="2" maxlength="2" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Classificação:</strong></td>
      <td align="left" valign="top"><select name="fclassificacao" id="fclassificacao">
        <?php 
		$sqlclassificacao = "select classificacao as codigo_classificacao, descricao as descricao_classificacao from classificacao where classificacao='$classificacao' and titular = 'S'";
		$rsclassificacao = mysql_query($sqlclassificacao);
		while(list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacao)) { ?>
        <option value="<?php print $codigo_classificacao; ?>"><?php print $descricao_classificacao; ?></option>
        <?php } ?>
        <option value=""></option>
        <?php 
		$sqlclassificacaonew = "select * from classificacao where titular = 'S'";
		$rsclassificacaonew = mysql_query($sqlclassificacaonew);
		while(list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacaonew)) {
		?>
        <option value="<?php print $codigo_classificacao; ?>"><?php print $descricao_classificacao; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Descrição:</strong></td>
      <td align="left" valign="top"><input name="fdescricao" type="text" id="fdescricao" value="<?php print $descricao; ?>" size="30" maxlength="30" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Titular:</strong></td>
      <td align="left" valign="top"><select name="ftitular" id="ftitular">
        <option value="<?php print $titular;?>"><?php print $titular;?></option>
        <option value="S">S</option>
        <option value="N">N</option>
      </select>        <strong>* S = SIM ou N = NAO</strong></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Data/Hora:</strong></td>
      <td align="left" valign="top"><input name="fdata2" type="text" disabled="disabled" id="fdata2" value="<?php print $data_final; ?> <?php print $hora; ?>" size="16" maxlength="16" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário:</strong></td>
      <td align="left" valign="top"><input name="fusuario2" type="text" disabled="disabled" id="fusuario2" value="<?php print $usuario; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário atual:</strong></td>
      <td align="left" valign="top"><input name="fusuario_atual2" type="text" disabled="disabled" id="fusuario_atual2" value="<?php print $loginusuario_atual; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="submit" name="fok2" id="fok2" value="OK" /></td>
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