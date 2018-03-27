<?
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../funcoesPHP/conexao.php";
	include "../funcoesPHP/data.php";
	
	$c = mysql_fetch_assoc(mysql_query("SELECT * FROM $prefixo"."usuarios WHERE id='".$_GET['id']."'"));
	
	if ($_GET['id']) $titulo_pg = "ALTERANDO DADOS DE USUÁRIO";
	else $titulo_pg = "CADASTRANDO USUÁRIO";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/calendario_marron.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../funcoesJS/funcoes.js"></script>
<script type="text/javascript" src="../funcoesJS/val.js"></script>
<script type="text/javascript" src="../funcoesJS/mascaras.js"></script>

<script type="text/javascript" src="../call/calendar.js"></script>
<script type="text/javascript" src="../call/calendario.js"></script>
<script type="text/javascript" src="../call/calendar-pt.js"></script>
<script type="text/javascript" src="../call/calendar-setup.js"></script>


</head>

<body onLoad="reajusta()">

<table id="conteudo" width="775" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="70" height="30" align="center" valign="middle" bgcolor="#4DBDCB"><img src="icon.png"></td>
<td width="725" align="left" bgcolor="#4DBDCB"><h2 class="txtBranco"><strong><?=$titulo_pg?></strong></h2></td>
</tr>
<tr>
<td colspan="2" align="center" valign="top" height="275">
	
    <br>
	<form onSubmit="return valida(this)" action="p.php<? if ($_GET['id']) echo "?acao=alterar" ?>" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
    <table width="765" border="0" cellspacing="0" cellpadding="1">
    <tr>
    <td width="100" height="30" align="right"><h6>Nome:</h6></td>
    <td><input name="nome"  class="form_obrig" id="nome" style=" width:610px; height: 20px;" value="<?= $c['nome'] ?>" maxlength="40"><input type="hidden" id="id" name="id" value="<?=$id?>"/></td>
    </tr>
    <tr>
    <td height="30" align="right"><h6>Nascimento:</h6></td>
    <td><input name="nascimento" type="text" class="form" id="nascimento" style=" width:290px; HEIGHT: 20px;" onKeyPress="return txtBoxFormat(document.formulario, 'nascimento']."', '99/99/9999']."', event);" value="<? echo date_data($c['data_nascimento']) ?>" maxlength="10">
    <img src="../imgs/calendario.gif" id="f_trigger_c" style="cursor:hand" title="Abrir Calendário"></td>
    <script language="javascript">
		Calendar.setup({
		inputField     :    "nascimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_c",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>
    </tr>
    <tr>
    <td height="30" align="right"><h6>E-mail:</h6></td>
    <td><input name="email"  class="form_obrig" id="email" style=" width:610px; HEIGHT: 20px;" value="<?= $c['email'] ?>" maxlength="60"></td>
    </tr>
    <tr>
    <td height="30" align="right"><h6>Login:</h6></td>
    <td><input name="login"  class="form_obrig" id="login" style=" width:610px; HEIGHT: 20px;" value="<?= $c['login'] ?>" maxlength="30"></td>
    </tr>
    <tr>
    <td height="30" align="right"><h6>Senha:</h6></td>
    <td><input name="senha" type="password"  class="form_obrig" id="senha" style=" width:290px; HEIGHT: 20px;" value="<?= $c['senha'] ?>" maxlength="15"></td>
    </tr>
    <tr>
    <td height="30" align="right"><h6>Confirma&ccedil;&atilde;o:</h6></td>
    <td><input name="confirmacao" type="password"  class="form_obrig" id="confirmacao" style=" width:290px; HEIGHT: 20px;" value="<?= $c['senha'] ?>" maxlength="15"></td>
    </tr>
    <tr>
    <td height="30" align="right"><h6>N&iacute;vel:</h6></td>
    <td valign="middle"><select name="nivell" class="form" id="nivell" style="width:290px; height:20">
    <? if ($_SESSION['nivel'] >=6){ ?><option value="6" <? if ($c['nivel'] ==6) echo "selected" ?>>Desenvolvedor</option><? } ?>
    <? if ($_SESSION['nivel'] >=5){ ?><option value="5" <? if ($c['nivel'] ==5) echo "selected" ?>>Proprietário</option><? } ?>
    <? if ($_SESSION['nivel'] >=3){ ?><option value="4" <? if ($c['nivel'] ==4) echo "selected" ?>>Supervisor</option><? } ?>
    <? if ($_SESSION['nivel'] >=3){ ?><option value="3" <? if ($c['nivel'] ==3) echo "selected" ?>>Gerente</option><? } ?>
    <? if ($_SESSION['nivel'] >=2){ ?><option value="2" <? if ($c['nivel'] ==2) echo "selected" ?>>Editor</option><? } ?>
    <? if ($_SESSION['nivel'] >=1){ ?><option value="1" <? if ($c['nivel'] ==1) echo "selected" ?>>Visitante</option><? } ?>
    </select>
    </td>
    </tr>
    <tr>
    <td align="right" class="recuo" >&nbsp;</td>
    <td>
    <? if ($_GET['id']){ ?><input type="image" src="../imgs/bt_alterar.png"><? } 
	else{?><input type="image" src="../imgs/bt_cadastrar.png">&nbsp;<img src="../imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/><? } ?>
    </td>
    </tr>
    <tr>
    <td align="right" >&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr> 
    <td height="26" colspan="2" align="right" valign="middle" class="voltar" ><img src="../imgs/space.png" width="10" height="25"><a href="i.php"><img src="../imgs/bt_voltar.png" border="0"></a><img src="../imgs/space.png" width="10" height="25"><img src="../imgs/spaceT.png" width="20" height="25"></td>
    </tr>
    </table>
    </form>
    
</td>
</tr>
</table>
</body>
</html>
<? }
else {
	$url_de_destino = "../expira.php";
	$target = "_parent";
	include "../funcoesPHP/redireciona.php";
}
?>