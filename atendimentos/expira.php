<?php
include ('../painel/funcoesPHP/conexao.php');
$consulta_info = mysql_fetch_assoc (mysql_query ("SELECT fantasia FROM dados"));
$fantasia = $consulta_info['fantasia'];
?>
<html>
<head>
<link rel="shortcut icon" href="../painel/imgs/icone.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PAINEL DIGITAL: <?= $fantasia ?></title>
<link href="../painel/css/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../painel/funcoesJS/funcoes.js"></script>
</head>

<body class="bgBody">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="middle">
    
    <table width="100%" height="312" border="0" cellpadding="2" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
    <td align="center" valign="middle" style="background:url(imgs/bgLogin.png); background-repeat:no-repeat; background-position:center center" class="top">
    
        <table width="600" border="0" cellspacing="0" cellpadding="1">
        <tr>
        <td height="36" align="center">
        
        <center><font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br><b><u>ACESSO NEGADO!</u></b><br><br></font></center>
        <center><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Por favor, identifique-se novamente para<br>continuar acessando o Painel de Controle</font></center>
        
        </td>
        </tr>
        </table>
    
    
    </td>
    </tr>
    </table>
    
</td>
</tr>
</table>
</body>
</html>
