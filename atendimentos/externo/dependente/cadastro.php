<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";
	include "../../../correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_dependente WHERE id='".$_GET['id']."' AND titular='".$_GET['titular']."'"));

	$titular  = @mysql_fetch_assoc(mysql_query("SELECT nome FROM convenio_empregado WHERE id='".$_GET['titular']."'"));

	if ($_GET['id']) $titulo_pg = "ALTERANDO DEPENDENTE";
	else $titulo_pg = "CADASTRANDO DEPENDENTE";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../painel/css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../../painel/css/calendario_marron.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../../../painel/funcoesJS/funcoes.js"></script>

<script type="text/javascript" src="../../../painel/funcoesJS/mascaras.js"></script>

<script type="text/javascript" src="../../../painel/call/calendar.js"></script>
<script type="text/javascript" src="../../../painel/call/calendario.js"></script>
<script type="text/javascript" src="../../../painel/call/calendar-pt.js"></script>
<script type="text/javascript" src="../../../painel/call/calendar-setup.js"></script>
<script type="text/javascript" src="valida_campo.js"></script>
<script type="text/javascript" src="valida_cpf.js"></script><!-- onblur="return validacpf(this.value)" -->
<script type="text/javascript" src="valida_cpf_cnpj.js"></script><!-- onBlur="validar(this)" -->
<script type="text/javascript" src="../../../jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../../../jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript">


<!-- Fim do JavaScript que validará os campos obrigatórios! -->
// Inicio Máscaras//
$(document).ready(function(){
	$("input[name='nascimento']").mask('99/99/9999');	
	$("input[name='cep']").mask('99.999-999');	
	$("input[name='celular']").mask('(99)9999-9999');	
	$("input[name='fone']").mask('(99)9999-9999');
	if($("input[name='inscricao']").length>11) return $("input[name='cep']").mask('99.999.999/9999-99');

// Fim Máscaras

// Evento change no campo uf  
   $("select[name=uf]").change(function(){
		$("select[name=cidade]").html('<option value="">Carregando Cidade</option>');
        $.post("../../../painel/funcoesPHP/filtra_cidade.php",
          {uf:$(this).val()},
		  function(valor){
           $("select[name=cidade]").html(valor);
          }
         )
	})
// Fim Evento change no campo uf  
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
          <td width="90%" align="left"><br/><h6><strong><?php if ($_GET['id']) echo 'Titular: '.$_GET['titular'].' - '.$titular['nome']; else echo 'Titular: '.$_GET['titular'].' - '.$titular['nome']?></strong></h6><br/></td>
        </tr>
        <tr>
          <td width="10%" height="25" align="right"><input name="titular" class="form_obrig" id="titular" style=" width:0px; height: 0px;" value="<?php echo $_GET['titular'] ?>" size="3" maxlength="3" readonly="readonly"/><input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="3" maxlength="3" readonly="readonly" /><h6>Nome:</h6></td>
          <td colspan="7"><input name="nome" class="form_obrig" id="nome" style=" width:600px; height: 20px;" value="<?php echo $c['nome'] ?>" size="100" maxlength="100" /></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Nascimento:</h6></td>
          <td colspan="7"><input name="nascimento" class="form_obrig" id="nascimento" style=" width:100px; height: 20px;" value="<?php echo date_data($c['nascimento']) ?>" size="11" maxlength="10" /><img src="../../../painel/imgs/calendario.gif" id="f_trigger_c" style="cursor:hand" title="Abrir Calendário">
    <script language="javascript">
		Calendar.setup({
		inputField     :    "nascimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_c",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>
    </td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Sexo:</h6></td>
          <td colspan="7"><h6><input type="radio" class="form" name="sexo" id="sexo" value="F"<?php if($c['sexo'] == "F") echo "checked" ?> />&nbsp;Feminino&nbsp;&nbsp;<input type="radio" class="form" name="sexo" id="sexo" value="M"<?php if($c['sexo'] == "M") echo "checked" ?> />&nbsp;Masculino</h6></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Parenteco:</h6></td>
          <td colspan="7"><h6><input name="parentesco" type="radio" class="form" id="parentesco" value="Filho(a)"<?php if($c['parentesco'] == "Filho(a)") echo "checked" ?>/>&nbsp;Filho(a)&nbsp;&nbsp;&nbsp;&nbsp;<input name="parentesco" type="radio" class="form" id="parentesco" value="Esposo(a)"<?php if($c['parentesco'] == "Esposo(a)") echo "checked" ?>/>&nbsp;Esposo(a)</h6></td>
        </tr>
        <tr>
          <td height="25" align="right" >&nbsp;</td>
          <td colspan="7">	<?php if ($_GET['id']){ ?><input type="image" src="../../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td>        </tr>
        <tr>
          <td height="25" align="right" >&nbsp;</td>
          <td colspan="7" align="right" class="voltar"><img src="../../../painel/imgs/space.png" width="10" height="25"><a href="lista.php?id=<?php echo $_GET['titular']?>"><img src="../../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../../painel/imgs/space.png" width="10" height="25"><img src="../../../painel/imgs/spaceT.png" width="20" height="25"></td>
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
	include "../../../painel/funcoesPHP/redireciona.php";
}
?>