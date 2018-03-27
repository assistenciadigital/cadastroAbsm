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
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">

function MM_jumpMenu_uf(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function validacampos()
{
if(document.cadastro.fdata_inicio.value=="")
	{
	alert("O Campo Data Inicio é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdata_fim.value=="")
	{
	alert("O Campo Data Fim é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fstatus.value=="")
	{
	alert("O Campo status é obrigatório!");
	return false;
	}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdata_inicio']").mask('99/99/9999');
				  $("input[name='fdata_fim']").mask('99/99/9999');

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
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>
<?php
include("requerido/dataehora.php");
?>

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
<strong>Consulta Lista Agendados / Atendidos | <a href="menu.php">Retornar</a></strong>
<hr>

<form action="fbus_atendimentolista.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="200" align="left" valign="top" scope="col">
      Pesquisar por:<br/>
        <input name="check" type="checkbox" id="check_1" value="1" checked="checked" onclick="check_2.checked=false"/>
      <label>
    Data Agendado</label><br />
      <label>
        <input name="check" type="checkbox" id="check_2" value="2" onclick="check_1.checked=false"/>
        Data Atendido</label>
      <br />
  </th>
    <th width="240" align="left" valign="top" scope="col">
      Informe o período:<br/>
      <label for="fdata_agendado_inicio">Data  Inicio: </label>
      <input name="fdata_inicio" type="text" id="fdata_inicio" size="10" maxlength="10" /><br/><label for="fdata_fim">Data  Final: </label>&nbsp;<input name="fdata_fim" type="text" id="fdata_fim" size="10" maxlength="10" /></th>
    <th width="240" align="left" valign="top" scope="col"><p><strong>Nome:</strong>      
      <input name="fnome" type="text" id="fnome" size="50" maxlength="100" /><br/>
      <input type="submit" name="envia" id="envia" value="Pesquisar" />
    </th></tr>
  </table>
</form>
<script language="JavaScript"> document.form1.fnome.focus(); </script>
<hr>
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");

$pega_data_incio = $_POST[fdata_inicio];
$pega_data_fim = $_POST[fdata_fim];
$pega_nome = $_POST[fnome];
?>
</body>
</html>