<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
include('correio/phpQuery-onefile.php');

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#data
$ndata = explode("-",date("Y-m-d")); 
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
<strong>Pesquisa CEP Correios | <a href="menu.php">Retornar</a></strong>
<hr>
<form id="form1" name="form1" method="post" action="">
  <table width="448" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="290" align="right" valign="middle"><strong>Busca CEP - Endereço:</strong></td>
    <td width="145" align="center" valign="middle"><a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank"><img src="imagem/busca.gif" width="130" height="57" /></a></a></td>
    </tr>
    <tr>
      <td align="right" valign="middle"><strong>Busca CEP - Localidade / Logradouro:</strong></td>
      <td align="center" valign="middle"><p><a href="busca_cep.htm" target="_blank"><img src="imagem/busca.gif" alt="" width="130" height="57" /></a></p></td>
    </tr>
    <tr>
      <td align="right" valign="middle"><strong>Busca por CEP:</strong></td>
      <td align="center" valign="middle"><p><a href="busca_por_cep.htm" target="_blank"><img src="imagem/busca.gif" alt="" width="130" height="57" /></a></p></td>
    </tr>
    <tr>
      <td align="right" valign="middle"><strong>Busca CEP - Correio Móvel:</strong></td>
      <td align="center" valign="middle"><a href="http://m.correios.com.br/movel/buscaCepConfirma.do" target="_blank"><img src="imagem/busca.gif" alt="" width="130" height="57" /></a></td>
    </tr>
    <tr>
      <td align="right" valign="middle"><strong>Busca CEP - Manual:</strong></td>
      <td align="center" valign="middle"><label for="fcep"></label>
        <a href="fbus_cep.php"><img src="imagem/busca.gif" alt="" width="130" height="57" /></a></td>
    </tr>
    <tr>
      <td align="right" valign="middle"><p><strong>Data/Hora:</strong></p>
        <p><strong>Usuário:<br />
          </strong></p></td>
      <td align="left" valign="middle"><?php print $data_final; ?> <p><?php print strtoupper($loginusuario_atual); ?></p></td>
    </tr>
    </table>
</form>
<hr>
</div>
</div>
</body>
</html>