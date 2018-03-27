<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";
	include "../../../correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_especialidade WHERE id='".$_GET['id']."'"));
	$filtra_empresa = @mysql_fetch_assoc(mysql_query("SELECT id, razao FROM convenio_empresa WHERE id='".$c[empresa]."'"));	
	$consulta_empresa  = mysql_query("SELECT id, razao FROM convenio_empresa ORDER BY razao, fantasia");
	
	$consulta_especialidade = mysql_query("SELECT DISTINCT especialidade FROM convenio_especialidade ORDER BY especialidade");

	$consulta_cidade = mysql_query("SELECT nome FROM _cidades WHERE uf='".$c[uf]."' ORDER BY nome");
	
	if ($_GET['id']) $titulo_pg = "ALTERANDO ESPECIALIDADE";
	else $titulo_pg = "CADASTRANDO ESPECIALIDADE";
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
  <td colspan="2" align="center" valign="middle">&nbsp;</td>
  </tr>
<tr>
  <td colspan="2" align="center" valign="top">
  	<form onsubmit="return validacampo(this)" action="processando.php<?php if ($_GET['id']) echo "?acao=alterar"?>" name="formulario" id="formulario" method="post">
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="10%" align="right"><h6>Especialidade:</h6></td>
          <td height="25" colspan="5">
            
            <select name="especialidade" class="form_obrig" id="especialidade" style="width:290px; height: 22px;;">
              <option value="<?php echo $c['especialidade'] ?>"><?php if ($c['especialidade']=='M') echo $especialidade='Medica'; elseif ($c['especialidade']=='O') echo $especialidade='Odontologica';?></option>

              <option value="M">Medica</option>
              <option value="O">Odontologica</option>
            </select>
            <input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="1" maxlength="1" readonly="readonly" />
          </tr>
        <tr>
          <td align="right"><h6>
          Nome:</h6></td>
          <td height="25" colspan="5"><input name="nome" class="form_obrig" id="nome" style=" width:600px; height: 20px;" value="<?php echo $c['nome'] ?>" size="100" maxlength="100" /></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><h6>Descrição:</h6></td>
          <td colspan="5" valign="middle"><textarea name="descricao" rows="5" class="form_obrig" id="descricao" style=" width:600px; height:auto"><?php echo $c['descricao'] ?></textarea></td>
        </tr>
        <tr>
          <td height="25" align="right" ></td>
          <td colspan="5">	<?php if ($_GET['id']){ ?><input type="image" src="../../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td></tr>
        <tr>
          <td height="25" align="right" >&nbsp;</td>
          <td colspan="5" align="right" class="voltar"><img src="../../../painel/imgs/space.png" width="10" height="25"><a href="lista.php"><img src="../../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../../painel/imgs/space.png" width="10" height="25"><img src="../../../painel/imgs/spaceT.png" width="20" height="25"></td>
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