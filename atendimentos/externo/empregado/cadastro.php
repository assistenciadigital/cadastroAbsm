<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";
	include "../../../correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_empregado WHERE id='".$_GET['id']."'"));
	
	$filtra_empresa = @mysql_fetch_assoc(mysql_query("SELECT id, razao FROM convenio_empresa WHERE id='".$c[empresa]."'"));	
	$consulta_empresa = mysql_query("SELECT id, razao FROM convenio_empresa ORDER BY razao, fantasia");
	$qtde_empresa = mysql_num_rows($consulta_empresa);
	
	$consulta_uf = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf "); 
	$qtde_uf = mysql_num_rows($consulta_uf);
	$consulta_cidade = mysql_query("SELECT nome FROM _cidades WHERE uf = '".$c[uf]."' ORDER BY nome ASC");
	$qtde_cidade = mysql_num_rows($consulta_cidade);
				 		
	if ($_GET['id']) $titulo_pg = "ALTERANDO EMPREGADO CONVENIANTE";
	else $titulo_pg = "CADASTRANDO EMPREGADO CONVENIANTE";
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
<td colspan="2" align="center" valign="top">
	    
<form onsubmit="return validacampo(this)" action="processando.php<?php if ($_GET['id']) echo "?acao=alterar"?>" name="formulario" id="formulario" method="post">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" height="25" align="right">&nbsp;</td>
    <td width="90%" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6><input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="1" maxlength="1" readonly="readonly" />CPF:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="cpf" class="form_obrig" id="cpf" style=" width:100px; height: 20px;" onBlur="validar(this)" value="<?php echo $c['cpf'] ?>" size="14" maxlength="14">
      &nbsp;Identidade:&nbsp;<input name="identidade" class="form_obrig" id="identidade" style=" width:100px; height: 20px;" value="<?php echo $c['identidade'] ?>" size="11" maxlength="11" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Emissor:&nbsp;<input name="emissor" class="form_obrig" id="emissor" style=" width:100px; height: 20px;" value="<?php echo $c['emissor'] ?>" size="11" maxlength="11" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Empresa:</h6></td>
    <td width="90%" align="left"><h6>
      <select name="empresa" class="form_obrig" id="empresa" style="width:290px">
        <?php if($qtde_empresa>1){ ?>
        <option value="" <?php if(!$c['empresa']) echo "selected"?> >Empresa</option>
        <?php } ?>
        <?php while($cempresa = mysql_fetch_assoc($consulta_empresa)){ ?>
        <option value="<?=$cempresa['id']?>" <?php if($c['empresa']== $cempresa['id']) echo "selected"?> ><?php echo $cempresa['razao'] ?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Setor:&nbsp;<input name="setor" class="form_obrig" id="setor" style=" width:290px; height: 20px;" value="<?php echo $c['setor'] ?>" maxlength="20" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Função:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="funcao" class="form_obrig" id="funcao" style=" width:288px; height: 20px;" value="<?php echo $c['funcao'] ?>" maxlength="20" />&nbsp;Matrícula:&nbsp;<input name="matricula" class="form_obrig" id="matricula" style=" width:290px; height: 20px;" value="<?php echo $c['matricula'] ?>" maxlength="20" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Nome:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="nome" class="form_obrig" id="nome" style=" width:643px; height: 20px;" value="<?php echo $c['nome'] ?>" size="100" maxlength="100" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Nascimento:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="nascimento" class="form_obrig" id="nascimento" style=" width:100px; height: 20px;" value="<?php echo date_data($c['nascimento']) ?>" size="11" maxlength="11" /><img src="../../../painel/imgs/calendario.gif" id="f_trigger_c" style="cursor:hand" title="Abrir Calendário">
	<script language="javascript">
		Calendar.setup({
		inputField     :    "nascimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_c",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>&nbsp;Sexo:&nbsp;<input name="sexo" type="radio" class="form" id="sexo" value="F" <?php if($c['sexo'] == "F") echo "checked" ?>>&nbsp;Feminino&nbsp;
        <input name="sexo" type="radio" class="form" id="sexo" value="M" <?php if($c['sexo'] == "M") echo "checked" ?>/>&nbsp;Masculino</h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Endereço:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="endereco" class="form_obrig" id="endereco" style=" width:515px; height: 20px;" value="<?php echo $c['endereco'] ?>" maxlength="150" />
    Nº:
    <input name="numero" class="form_obrig" id="numero" style=" width:100px; height: 20px;" value="<?php echo $c['numero'] ?>" maxlength="5" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Complemento:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="complemento" class="form" id="complemento" style=" width:507px; height: 20px;" value="<?php echo $c['complemento'] ?>" maxlength="50" />
      CEP:
      <input name="cep" class="form_obrig" id="cep"	style=" width:100px; height: 20px;" onkeypress="formatar('##.###-###', this)" value="<?php echo $c['cep'] ?>" maxlength="10" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Bairro:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="bairro" class="form_obrig" id="bairro" style=" width:507px; height: 20px;" value="<?php echo $c['bairro'] ?>" maxlength="20" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>UF:</h6></td>
    <td width="90%" align="left"><h6>
      <select name="uf" class="form_obrig" id="uf" style="width:40px">
        <?php if($qtde_uf>1){ ?>
        <option value="" <?php if(!$c['uf']) echo "selected"?> >UF</option>
        <?php } ?>
        <?php while($cuf = mysql_fetch_assoc($consulta_uf)){ ?>
        <option value="<?=$cuf['uf']?>" <?php if($c['uf']== $cuf['uf']) echo "selected"?> ><?php echo $cuf['uf'] ?></option>
        <?php } ?>
      </select>
      Cidade: 
      <select name="cidade" class="form_obrig" id="cidade" style="width:420px">
        <?php if($qtde_cidade>1){ ?>
        <option value="" <?php if(!$c['cidade']) echo "selected"?> >Cidade</option>
        <?php } ?>
        <?php while($ccidade = mysql_fetch_assoc($consulta_cidade)){ ?>
        <option value="<?=$ccidade['nome']?>" <?php if($c['cidade']== $ccidade['nome']) echo "selected"?> ><?php echo $ccidade['nome'] ?></option>
        <?php } ?>
      </select>
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>E-mail:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="email" class="form_obrig" id="email" style=" width:290px; height: 20px;" value="<?php echo $c['email'] ?>" maxlength="150" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Celular:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="celular" class="form_obrig" id="celular" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['celular'] ?>" maxlength="14" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Telefone:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="fone" class="form_obrig" id="fone" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['fone'] ?>" maxlength="14" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>&nbsp;</h6></td>
    <td width="90%" align="left"><?php if ($_GET['id']){ ?><input type="image" src="../../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right">&nbsp;</td>
    <td width="90%" align="right" class="voltar"><img src="../../../painel/imgs/space.png" width="10" height="25"><a href="lista.php"><img src="../../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../../painel/imgs/space.png" width="10" height="25"><img src="../../../painel/imgs/spaceT.png" width="20" height="25"></td>
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