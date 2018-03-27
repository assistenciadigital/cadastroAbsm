<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM financeiro_recebimento WHERE id='".$_GET['id']."'"));

	$titular  = @mysql_fetch_assoc(mysql_query("SELECT id, nome FROM cadastro WHERE id='".$_GET['titular']."'"));	

	if ($_GET['id']) $titulo_pg = "ALTERANDO RECEBIMENTO - SOCIO EFETIVO";
	else $titulo_pg = "CADASTRANDO RECEBIMENTO - SOCIO EFETIVO";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../painel/css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../painel/css/calendario_marron.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../../painel/call/calendar.js"></script>
<script type="text/javascript" src="../../painel/call/calendario.js"></script>
<script type="text/javascript" src="../../painel/call/calendar-pt.js"></script>
<script type="text/javascript" src="../../painel/call/calendar-setup.js"></script>

<script type="text/javascript" src="../../painel/funcoesJS/funcoes.js"></script>
<script type="text/javascript" src="valida_campo.js"></script>
<script type="text/javascript" src="../../painel/funcoesJS/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../../painel/funcoesJS/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="../../painel/funcoesJS/mascaras.js"></script>
<script type="text/javascript">


<!-- Fim do JavaScript que validará os campos obrigatórios! -->
// Inicio Máscaras//
$(document).ready(function(){
	$("input[name='competencia']").mask('99/99/9999');
	$("input[name='recebimento']").mask('99/99/9999');
// Fim Máscaras
})
</script>

</head>
<body onLoad="reajusta()">
<div align="center">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" id="conteudo">
<tr>
<td width="10%" height="25" align="center" valign="middle" bgcolor="#4DBDCB"><img src="icon.png"></td>
<td width="90%" style="cursor:hand" align="left" bgcolor="#4DBDCB"><h2 class="txtBranco"><strong><?php if ($_GET['id']) echo $titulo_pg." ID: ".$_GET['id']; else echo $titulo_pg?></strong></h2></td>
</tr>
<tr>
<td colspan="2" align="center" valign="top" height="275">
	<form onsubmit="return validacampo(this)" action="processando.php<?php if ($_GET['id']) echo "?acao=alterar"?>" name="formulario" id="formulario" method="post">
    <table width="800" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="10%" align="right">&nbsp;</td>
          <td width="90%" align="left"><br/><h6><strong><?php if ($_GET['id']) echo 'Socio Efetivo (Titular): '.$_GET['titular'].' - '.$titular['nome']; else echo 'Socio Efetivo (Titular): '.$_GET['titular'].' - '.$titular['nome']?></strong></h6><br/></td>
        </tr>
        <tr>
          <td width="10%" height="25" align="right"><input name="titular" class="form_obrig" id="titular" style=" width:0px; height: 0px;" value="<?php echo $_GET['titular'] ?>" size="3" maxlength="3" readonly="readonly"/><input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="3" maxlength="3" readonly="readonly" />
            <h6>Descrição:</h6></td>
          <td colspan="7"><input name="descricao" class="form_obrig" id="descricao" style=" width:400px; height: 20px;" value="<?php echo $c['descricao'] ?>" size="50" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Forma Pagto:</h6></td>
          <td colspan="7"><select name="formapagto" class="form_obrig" id="formapagto" style="width:400px; height: 20px;">
            <option value="">Forma de Pagamento</option>
            <?php
            $consulta_formapagto = mysql_query ("SELECT id, nome from auxiliar where classificacao = 'FORMA PAGTO' ORDER BY ordem");
            if (mysql_num_rows ($consulta_formapagto)) {
            while ($u = mysql_fetch_assoc($consulta_formapagto)) {
            ?>
            <option value="<?php echo $u['id']?>"<?php if($c['formapagto'] == $u['id']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
          </select></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Competência:</h6></td>
          <td colspan="7"><input name="competencia" class="form_obrig" id="competencia" style=" width:100px; height: 20px;" value="<?php echo date_data($c['competencia']) ?>" size="11" maxlength="10" /> 
            <img src="../../painel/imgs/calendario.gif" name="f_trigger_c" id="f_trigger_c" style="cursor:hand" title="Abrir Calendário">
            <script language="javascript">
		Calendar.setup({
		inputField     :    "competencia",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_c",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>
    </td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Recebimento:</h6></td>
          <td colspan="7"><input name="recebimento" class="form_obrig" id="recebimento" style=" width:100px; height: 20px;" value="<?php echo date_data($c['recebimento']) ?>" size="11" maxlength="10" />
            <img src="../../painel/imgs/calendario.gif" alt="" name="f_trigger_r" id="f_trigger_r" style="cursor:hand" title="Abrir Calendário" />
            <script language="javascript" type="text/javascript">
		Calendar.setup({
		inputField     :    "recebimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_r",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
            </script></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Valor R$:</h6></td>
          <td colspan="7"><h6>
            <input name="valor" class="form_obrig" id="valor" style=" width:100px; height: 20px; value=" value="<?php echo $c['valor'] ?>"" size="11" maxlength="10"<?php echo $c['valor'] ?>/>
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" >&nbsp;</td>
          <td colspan="7">	<?php if ($_GET['id']){ ?><input type="image" src="../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td>        </tr>
        <tr>
          <td align="right" >&nbsp;</td>
          <td colspan="7" align="right" class="voltar"><img src="../../painel/imgs/space.png" width="10" height="25"><a href="lista.php?id=<?php echo $_GET['titular']?>"><img src="../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../painel/imgs/space.png" width="10" height="25"><img src="../../painel/imgs/spaceT.png" width="20" height="25"></td>
        </tr>
        </table>
    </form>
    
</td>
</tr>
</table>
</div>
</body>
</html>
<?php }
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../painel/funcoesPHP/redireciona.php";
}
?>