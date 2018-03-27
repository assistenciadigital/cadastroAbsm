<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";
	include "../../../correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_encaminha WHERE id='".$_GET['id']."'"));

	$filtra_empresa = @mysql_fetch_assoc(mysql_query("SELECT id, razao, autorizador, funcao, setor, fone, fax, email FROM convenio_empresa WHERE id='".$c[empresa]."'"));	
	$consulta_empresa = mysql_query("SELECT id, razao FROM convenio_empresa ORDER BY razao, fantasia");
	$qtde_empresa = mysql_num_rows($consulta_empresa);

	$consulta_empregado = mysql_query("SELECT id, nome FROM convenio_empregado WHERE id='".$c[empregado]."'");
	$qtde_empregado = mysql_num_rows($consulta_empregado);


	if ($_GET['id']) $titulo_pg = "ALTERANDO ENCAMINHAMENTO";
	else $titulo_pg = "CADASTRANDO ENCAMINHAMENTO";
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
	$("input[name='numero_guia']").mask('9999');	
	$("input[name='data_guia']").mask('99/99/9999');	
// Fim Máscaras

// Evento change no campo empresa 
   $("select[name=empresa]").change(function(){
		$("select[name=empregado]").html('<option value="">Carregando Empregado</option>');
        $.post("../../../painel/funcoesPHP/filtra_empregado.php",
          {empresa:$(this).val()},
		  function(valor){
           $("select[name=empregado]").html(valor);
          }
         )
	})
// Fim Evento change
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
    <table width="765" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>
          <td width="10%" height="25" align="right"><h6>Nº Guia:</h6></td>
          <td colspan="3"><input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="1" maxlength="1" readonly="readonly" /><input name="numero_guia" class="form_obrig" id="numero_guia" style=" width:100px; height: 20px;" value="<?php echo $c['numero_guia'] ?>" size="14" maxlength="14" /></td>
          </tr>
        <tr>
        <td width="10%" height="25" align="right"><h6>Data Guia:</h6></td>
        <td colspan="3"><h6><input name="data_guia" class="form_obrig" id="data_guia" style=" width:100px; height: 20px;" value="<?php echo date_data($c['data_guia']) ?>" size="11" maxlength="11" /><img src="../../../painel/imgs/calendario.gif" id="f_trigger_c" style="cursor:hand" title="Abrir Calendário"></h6></td>
        <script language="javascript">
		Calendar.setup({
		inputField     :    "data_guia",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_c",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>
        </tr>
        <tr>
          <td width="10%" height="25" align="right"><h6>Empresa:</h6></td>
          <td colspan="3">
           <select name="empresa" class="form_obrig" id="empresa" style="width:290px">
            <?php if($qtde_empresa>1){ ?><option value="" <?php if(!$c['empresa']) echo "selected"?> >Empresa</option><?php } ?>
            <?php while($cempresa = mysql_fetch_assoc($consulta_empresa)){ ?>
            <option value="<?=$cempresa['id']?>" <?php if($c['empresa']== $cempresa['id']) echo "selected"?> ><?php echo $cempresa['razao'] ?></option>
            <?php } ?>
          </select> 
           </td>
          </tr>
        <tr>
          <td width="10%" height="25" align="right"><h6>Empregado:</h6></td>
          <td colspan="3">
          <select name="empregado" class="form_obrig" id="empregado" style="width:290px">
            <?php if($qtde_empregado>1){ ?><option value="" <?php if(!$c['empregado']) echo "selected"?> >Empregado</option><?php } ?>
            <?php while($cempregado = mysql_fetch_assoc($consulta_empregado)){ ?>
            <option value="<?=$cempregado['id']?>" <?php if($c['empregado']== $cempregado['id']) echo "selected"?> ><?php echo $cempregado['nome'] ?></option>
            <?php } ?>
          </select>
			</td>
          </tr>
        <tr>
          <td width="10%" height="25" align="center" ><h6>&nbsp;</h6></td>
          <td width="90%" height="25" align="left"><h6><strong>Autorizador:</strong></h6></td>
          </tr>
        <tr>
          <td width="10%" height="25" align="left" ><h6>Nome:</h6></td>
          <td width="90%"><input name="autorizador" class="form_obrig" id="autorizador" style=" width:610px; height: 20px;" value="<?php if ($c['autorizador']) echo $c['autorizador']; else echo $filtra_empresa['autorizador']?>" maxlength="80"></td>
        </tr>
        <tr>
          <td width="10%" height="25" align="left" ><h6>Função:</h6></td>
          <td width="90%"><input name="funcao" class="form_obrig" id="funcao" style=" width:610px; height: 20px;" value="<?php if ($c['funcao']) echo $c['funcao']; else echo $filtra_empresa['funcao']?>" maxlength="80"></td>
        </tr>
        <tr>
          <td width="10%" height="25" align="left" ><h6>Setor:</h6></td>
          <td width="90%"><input name="setor" class="form_obrig" id="setor" style=" width:610px; height: 20px;" value="<?php if ($c['setor']) echo $c['setor']; else echo $filtra_empresa['setor']?>" maxlength="80"></td>
        </tr>
        <tr>
          <td width="10%" height="25" align="left" >&nbsp;</td>
          <td colspan="3">	<?php if ($_GET['id']){ ?><input type="image" src="../../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td>        </tr>
        <tr>
          <td width="10%" height="25" align="left" >&nbsp;</td>
          <td colspan="3" align="right" class="voltar"><img src="../../../painel/imgs/space.png" width="10" height="25"><a href="lista.php"><img src="../../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../../painel/imgs/space.png" width="10" height="25"><img src="../../../painel/imgs/spaceT.png" width="20" height="25"></td>
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