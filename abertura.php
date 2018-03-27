<?
session_start();
	if(($_SESSION['usuario_logado'])AND($_SESSION['nivel'])){
	
	include "funcoesPHP/conexao.php";
	include "funcoesPHP/data.php";
	
	$i = @mysql_fetch_assoc (mysql_query ("SELECT fantasia, email FROM $prefixo"."dados"));
	$fantasia = $i['fantasia'];
	$email = $i['email'];

	$ultimo_acesso = mysql_result (mysql_query("SELECT ultimo_acesso FROM $prefixo"."usuarios WHERE id = '".$_SESSION['usuario_logado']."'"), 0, 'ultimo_acesso'); 
	$data= datetime_datatempo($ultimo_acesso);
	$data = str_replace ("-", "às", $data);
	
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="funcoesJS/funcoes.js"></script>
<style type="text/css">
<!--
.style1 {color: #FF3300;
	font-weight: bold;
}
-->
</style>
</head>

<body onLoad="reajusta()">
<table id="conteudo" width="100%" border="0" cellspacing="0">
<tr>
  <td height="30" align="center" valign="middle">&nbsp;</td>
  </tr>
<tr>
  <td align="center" valign="middle" height="275"><p><strong>SEJA BEM-VINDO À PÁGINA INICIAL</strong></p>
    
    <table width="380" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="479" align="center" valign="middle">
          
          <h5>
            Seja bem vindo à página inicial do site Medicamentos <? echo $fantasia ?>.<br /><br />
            Caso tenha d&uacute;vidas sobre como utilizar esta ferramenta, solicite ajuda por e-mail: <a href="mailto:andre@jobdigital.com.br" class="txtAzul">alex@assistenciadigital.info</a> (preferencialmente) ou por telefone: (65) 9606-2605
            </h5>
          
          </td>
        </tr>
      </table>
    
  </td>
</tr>
</table>
</body>
</html>
<? } 
else {
	$url_de_destino = "expira.php";
	$target = "_parent";
	include "funcoesPHP/redireciona.php";
}
?>
