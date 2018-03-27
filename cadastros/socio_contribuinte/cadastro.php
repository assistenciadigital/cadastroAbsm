<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";
	include "../../painel/funcoesPHP/correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM cadastro WHERE id='".$_GET['id']."'"));
							 		
	if ($_GET['id']) $titulo_pg = "ALTERANDO SOCIO EFETIVO CBM/PM";
	else $titulo_pg = "CADASTRANDO SOCIO EFETIVO CBM/PM";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../painel/css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../painel/css/calendario_marron.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../../painel/funcoesJS/funcoes.js"></script>

<script type="text/javascript" src="../../painel/funcoesJS/mascaras.js"></script>

<script type="text/javascript" src="../../painel/call/calendar.js"></script>
<script type="text/javascript" src="../../painel/call/calendario.js"></script>
<script type="text/javascript" src="../../painel/call/calendar-pt.js"></script>
<script type="text/javascript" src="../../painel/call/calendar-setup.js"></script>
<script type="text/javascript" src="valida_campo.js"></script>
<script type="text/javascript" src="valida_cpf.js"></script><!-- onblur="return validacpf(this.value)" -->
<script type="text/javascript" src="valida_cpf_cnpj.js"></script><!-- onBlur="validar(this)" -->
<script type="text/javascript" src="../../painel/funcoesJS/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../../painel/funcoesJS/jquery.maskedinput.min.js"></script>
<script type="text/javascript">


<!-- Fim do JavaScript que validará os campos obrigatórios! -->
// Inicio Máscaras//
$(document).ready(function(){
	$("input[name='emissaorg']").mask('99/99/9999');
	$("input[name='incorporacao']").mask('99/99/9999');
	$("input[name='inclusao']").mask('99/99/9999');
	$("input[name='exclusao']").mask('99/99/9999');
	$("input[name='emissaorg']").mask('99/99/9999');	
	$("input[name='nascimento']").mask('99/99/9999');	
	$("input[name='cep']").mask('99.999-999');
	$("input[name='fonecel']").mask('(99)9999-9999');	
	$("input[name='fonecel2']").mask('(99)9999-9999');
	$("input[name='fonecel3']").mask('(99)9999-9999');	
	$("input[name='foneres']").mask('(99)9999-9999');
	$("input[name='fonecom']").mask('(99)9999-9999');

// Fim Máscaras

// Evento change no campo uf  
   $("select[name=ufnaturalidade]").change(function(){
		$("select[name=naturalidade]").html('<option value="">Carregando Naturalidade</option>');
        $.post("../../painel/funcoesPHP/filtra_naturalidade.php",
          {ufnaturalidade:$(this).val()},
		  function(valor){
           $("select[name=naturalidade]").html(valor);
          }
         )
	})
// Fim Evento change no campo uf  

   $("select[name=uf]").change(function(){
		$("select[name=cidade]").html('<option value="">Carregando Cidade</option>');
        $.post("../../painel/funcoesPHP/filtra_cidade.php",
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
    <td width="10%" align="right">&nbsp;</td>
    <td width="90%" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6><input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="1" maxlength="1" readonly="readonly" />CPF:</h6></td>
    <td width="90%" align="left"><h6><input name="cpf" class="form_obrig" id="cpf" style=" width:100px; height: 20px;" onBlur="validar(this)" value="<?php echo $c['cpf'] ?>" size="14" maxlength="14">&nbsp;RG:&nbsp;<input name="rg" class="form_obrig" id="rg" style=" width:100px; height: 20px;" value="<?php echo $c['rg'] ?>" size="14" maxlength="14" />&nbsp;Emissor:&nbsp;<input name="emissorrg" class="form_obrig" id="emissorrg" style=" width:60px; height: 20px;" value="<?php echo $c['emissorrg'] ?>" size="11" maxlength="11" />&nbsp;UF:&nbsp;<select name="ufrg" class="form_obrig" id="ufrg" style="width:44px; height: 20px;">
            <option value="">UF RG</option>
            <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
            <option value="<?php echo $u['uf']?>"<?php if($c['ufrg'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
            <?php }}?>
            </select>&nbsp;Data:&nbsp;<input name="emissaorg" class="form_obrig" id="emissaorg" style=" width:70px; height: 20px;" value="<?php echo date_data($c['emissaorg']) ?>" size="11" maxlength="11" />&nbsp;<img src="../../painel/imgs/calendario.gif" name="f_trigger_erg" id="f_trigger_erg" style="cursor:hand" title="Abrir Calendário">
	    <script language="javascript">
		Calendar.setup({
		inputField     :    "emissaorg",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_erg",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
        </script>
    &nbsp;CNS:&nbsp;<input name="cns" class="form_obrig" id="cns" style=" width:100px; height: 20px;" value="<?php echo $c['cns'] ?>" size="14" maxlength="14" /></h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Instituicao:</h6></td>
    <td width="90%" align="left"><h6>
      <select name="instituicao" class="form_obrig" id="instituicao" style="width:44px; height: 20px;">
            <option value="">Instituição</option>
            <?php
            $consulta_instituicao = mysql_query ("SELECT nome from auxiliar where classificacao = 'INSTITUICAO' ORDER BY nome");
            if (mysql_num_rows ($consulta_instituicao)) {
            while ($u = mysql_fetch_assoc($consulta_instituicao)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['instituicao'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select>&nbsp;UF:&nbsp;<select name="ufinstituicao" class="form_obrig" id="ufinstituicao" style="width:44px; height: 20px;">
            <option value="">UF Instituição</option>
            <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
            <option value="<?php echo $u['uf']?>"<?php if($c['ufinstituicao'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
            <?php }}?>
            </select>
            &nbsp;Patente:&nbsp;
            <select name="patente" class="form_obrig" id="patente" style="width:100px; height: 20px;">
            <option value="">Patente</option>
            <?php
            $consulta_patente = mysql_query ("SELECT nome from auxiliar where classificacao = 'PATENTE' ORDER BY ordem");
            if (mysql_num_rows ($consulta_patente)) {
            while ($u = mysql_fetch_assoc($consulta_patente)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['patente'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select>&nbsp;Incorporação:&nbsp;<input name="incorporacao" class="form_obrig" id="incorporacao" style=" width:70px; height: 20px;" value="<?php echo date_data($c['incorporacao']) ?>" size="11" maxlength="11" />&nbsp;<img src="../../painel/imgs/calendario.gif" name="f_trigger_inc" id="f_trigger_inc" style="cursor:hand" title="Abrir Calendário">
      <script language="javascript">
		Calendar.setup({
		inputField     :    "incorporacao",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_inc",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
        </script>
      &nbsp;Matrícula:&nbsp;<input name="matricula" class="form_obrig" id="matricula" style=" width:100px; height: 20px;" value="<?php echo $c['matricula'] ?>" size="11" maxlength="11" />
      </h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Status:</h6></td>
    <td align="left"><h6>
      <select name="status" class="form_obrig" id="status" style="width:100px; height: 20px;">
        <option value="">Status</option>
        <?php
            $consulta_status = mysql_query ("SELECT nome from auxiliar where classificacao = 'STATUS' ORDER BY ordem");
            if (mysql_num_rows ($consulta_status)) {
            while ($u = mysql_fetch_assoc($consulta_status)) {
            ?>
        <option value="<?php echo $u['nome']?>"<?php if($c['status'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
      </select>&nbsp;Inclusão:&nbsp;<input name="inclusao" class="form_obrig" id="inclusao" style=" width:70px; height: 20px;" value="<?php echo date_data($c['inclusao']) ?>" size="11" maxlength="11" />&nbsp;<img src="../../painel/imgs/calendario.gif" name="f_trigger_excl" id="f_trigger_excl" style="cursor:hand" title="Abrir Calendário">
	    <script language="javascript">
		Calendar.setup({
		inputField     :    "inclusao",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_excl",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
        </script>&nbsp;Exclusão:&nbsp;<input name="exclusao" class="form_obrig" id="exclusao" style=" width:70px; height: 20px;" value="<?php if ($c['exclusao'] != '0000-00-00') echo date_data($c['exclusao'])?>" size="11" maxlength="11" />&nbsp;<img src="../../painel/imgs/calendario.gif" name="f_trigger_exc" id="f_trigger_exc" style="cursor:hand" title="Abrir Calendário">
	    <script language="javascript">
		Calendar.setup({
		inputField     :    "exclusao",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_exc",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
        </script>&nbsp;Motivo Exclusão:&nbsp;
        <select name="motivoexclusao" class="form_obrig" id="motivoexclusao" style="width:150px; height: 20px;">
        <option value="">Motivo de Exclusao</option>
        <?php
            $consulta_motivoexclusao = mysql_query ("SELECT nome from auxiliar where classificacao = 'EXCLUSAO' ORDER BY nome");
            if (mysql_num_rows ($consulta_motivoexclusao)) {
            while ($u = mysql_fetch_assoc($consulta_motivoexclusao)) {
            ?>
        <option value="<?php echo $u['nome']?>"<?php if($c['motivoexclusao'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
      </select></h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Forma Pagto:</h6></td>
    <td align="left"><h6>
      <select name="formapagto" class="form_obrig" id="formapagto" style="width:300px; height: 20px;">
        <option value="">Forma Pagamento</option>
        <?php
          $consulta_formapagto = mysql_query ("SELECT id, nome from auxiliar where classificacao = 'FORMA PAGTO' AND descricao <> 'NO RECIBO' ORDER BY nome");
          if (mysql_num_rows ($consulta_formapagto)) {
          while ($u = mysql_fetch_assoc($consulta_formapagto)) {
          ?>
       <option value="<?php echo $u['id']?>"<?php if($c['formapagto'] == $u['id']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
      </select>&nbsp;Assistência:&nbsp;<select name="assistencia" class="form_obrig" id="assistencia" style="width:130px; height: 20px;">
        <option value="">Assistencia</option>
        <?php
            $consulta_assistencia = mysql_query ("SELECT nome from auxiliar where classificacao = 'ASSISTENCIA' ORDER BY nome");
            if (mysql_num_rows ($consulta_assistencia)) {
            while ($u = mysql_fetch_assoc($consulta_assistencia)) {
            ?>
        <option value="<?php echo $u['nome']?>"<?php if($c['assistencia'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
      </select>&nbsp;Cor:&nbsp;<select name="cor" class="form_obrig" id="cor" style="width:130px; height: 20px;">
        <option value="">Cor</option>
        <?php
            $consulta_cor = mysql_query ("SELECT nome from auxiliar where classificacao = 'COR' ORDER BY nome");
            if (mysql_num_rows ($consulta_cor)) {
            while ($u = mysql_fetch_assoc($consulta_cor)) {
            ?>
        <option value="<?php echo $u['nome']?>"<?php if($c['cor'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
      </select>
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
      <input name="nascimento" class="form_obrig" id="nascimento" style=" width:70px; height: 20px;" value="<?php echo date_data($c['nascimento']) ?>" size="11" maxlength="11" />&nbsp;<img src="../../painel/imgs/calendario.gif" name="f_trigger_nasc" id="f_trigger_nasc" style="cursor:hand" title="Abrir Calendário">
      <script language="javascript">
		Calendar.setup({
		inputField     :    "nascimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_nasc",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
    </script>&nbsp;|&nbsp;Sexo:&nbsp;<input name="sexo" type="radio" class="form_obrig" id="sexo" value="F" <?php if($c['sexo'] == "F") echo "checked" ?>>&nbsp;Feminino&nbsp;<input name="sexo" type="radio" class="form_obrig" id="sexo" value="M" <?php if($c['sexo'] == "M") echo "checked" ?>/>&nbsp;Masculino&nbsp;|&nbsp;Naturalidade:&nbsp;<select name="ufnaturalidade" class="form_obrig" id="ufnaturalidade" style="width:44px; height: 20px;">
      <option value="">UF Naturalidade</option>
      <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
      <option value="<?php echo $u['uf']?>"<?php if($c['ufnaturalidade'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
      <?php }}?>
      </select>&nbsp;
      <select name="naturalidade" class="form_obrig" id="naturalidade" style="width:240px; height: 20px;">
        <option value="">Naturalidade</option>
        <?php
            $consulta_cidade = mysql_query ("SELECT nome FROM _cidades where uf = '".$c['ufnaturalidade']."' ORDER BY nome");
            if (mysql_num_rows ($consulta_cidade)) {
            while ($u = mysql_fetch_assoc($consulta_cidade)) {
            ?>
        <option value="<?php echo $u['nome']?>"<?php if($c['naturalidade'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
        <?php }}?>
        </select> </h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Pai:</h6></td>
    <td align="left"><h6>
      <input name="pai" class="form" id="pai" style=" width:290px; height: 20px;" value="<?php echo $c['pai'] ?>" maxlength="150" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mãe:&nbsp;<input name="mae" class="form_obrig" id="mae" style=" width:290px; height: 20px;" value="<?php echo $c['mae'] ?>" maxlength="150" /></h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Estado Civil:</h6></td>
    <td align="left"><h6><select name="estadocivil" class="form_obrig" id="estadocivil" style="width:130px; height: 20px;">
            <option value="">Estado Civil</option>
            <?php
            $consulta_estadocivil = mysql_query ("SELECT nome from auxiliar where classificacao = 'ESTADO CIVIL' ORDER BY nome");
            if (mysql_num_rows ($consulta_estadocivil)) {
            while ($u = mysql_fetch_assoc($consulta_estadocivil)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['estadocivil'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se Casado, informe Conjuge: 
    <input name="conjuge" class="form" id="conjuge" style=" width:290px; height: 20px;" value="<?php echo $c['conjuge'] ?>" maxlength="150" /></h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Ocupação:</h6></td>
    <td align="left"><h6><select name="ocupacao" class="form_obrig" id="ocupacao" style="width:290px; height: 20px;">
            <option value="">Ocupação</option>
            <?php
            $consulta_ocupacao = mysql_query ("SELECT nome from auxiliar where classificacao = 'OCUPACAO' ORDER BY nome");
            if (mysql_num_rows ($consulta_ocupacao)) {
            while ($u = mysql_fetch_assoc($consulta_ocupacao)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['ocupacao'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select>&nbsp;Profissão:&nbsp;<select name="profissao" class="form_obrig" id="profissao" style="width:290px; height: 20px;">
            <option value="">Profissão</option>
            <?php
            $consulta_profissao = mysql_query ("SELECT nome from auxiliar where classificacao = 'PROFISSAO' ORDER BY nome");
            if (mysql_num_rows ($consulta_profissao)) {
            while ($u = mysql_fetch_assoc($consulta_profissao)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['profissao'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select> 
            </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Endereço:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="endereco" class="form_obrig" id="endereco" style=" width:515px; height: 20px;" value="<?php echo $c['endereco'] ?>" maxlength="150" />&nbsp;Nº:&nbsp;<input name="numero" class="form_obrig" id="numero" style=" width:100px; height: 20px;" value="<?php echo $c['numero'] ?>" size="14" maxlength="5" />
    </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>Complemento:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="complemento" class="form" id="complemento" style=" width:290px; height: 20px;" value="<?php echo $c['complemento'] ?>" maxlength="50" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bairro:&nbsp;<input name="bairro" class="form_obrig" id="bairro" style=" width:290px; height: 20px;" value="<?php echo $c['bairro'] ?>" maxlength="20" />
      
      </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>UF:</h6></td>
    <td width="90%" align="left"><h6>
      <select name="uf" class="form_obrig" id="uf" style="width:44px; height: 20px;">
            <option value="">UF</option>
            <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
            <option value="<?php echo $u['uf']?>"<?php if($c['uf'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
            <?php }}?>
            </select>&nbsp;
            <select name="cidade" class="form_obrig" id="cidade" style="width:240px; height: 20px;">
            <option value="">Cidade</option>
            <?php
            $consulta_cidade = mysql_query ("SELECT nome FROM _cidades where uf = '".$c['uf']."' ORDER BY nome");
            if (mysql_num_rows ($consulta_cidade)) {
            while ($u = mysql_fetch_assoc($consulta_cidade)) {
            ?>
            <option value="<?php echo $u['nome']?>"<?php if($c['cidade'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
            <?php }}?>
            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CEP:&nbsp;<input name="cep" class="form_obrig" id="cep"	style=" width:96px; height: 20px;" onkeypress="formatar('##.###-###', this)" value="<?php echo $c['cep'] ?>" size="14" maxlength="14" />
      </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6>E-mail:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="email" class="form_obrig" id="email" style=" width:290px; height: 20px;" value="<?php echo $c['email'] ?>" maxlength="150" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Celular:&nbsp;
      <input name="fonecel" class="form" id="fonecel" style=" width:290px; height: 20px;" value="<?php echo $c['fonecel'] ?>" maxlength="150" />
      </h6></td>
  </tr>
  <tr>
    <td width="10%" height="25" align="right"><h6> Residencial:</h6></td>
    <td width="90%" align="left"><h6>
      <input name="foneres" class="form" id="foneres" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['foneres'] ?>" maxlength="14" />
       Comercial:&nbsp;
      <input name="fonecom" class="form" id="fonecom" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['fonecom'] ?>" maxlength="14" />
      </h6></td>
  </tr>
  <tr>
    <td height="25" align="right"><h6>Observação:</h6></td>
    <td align="left"><h6><textarea name="observacoes" rows="4" class="form" id="observacoes" style=" width:643px"><?php if (!empty($c['obs1']))echo $c['obs1'].', '; if (!empty($c['obs2']))echo ', '.$c['obs2'];if (!empty($c['obs3']))echo ', '.$c['obs3'];if (!empty($c['detalhe']))echo $c['detalhe'];?>
       </textarea>
    </h6></td>
  </tr>
  <tr>
    <td width="10%" align="right"><h6>&nbsp;</h6></td>
    <td width="90%" align="left"><?php if ($_GET['id']){ ?><input type="image" src="../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?></td>
  </tr>
  <tr>
    <td width="10%" align="right">&nbsp;</td>
    <td width="90%" align="right" class="voltar"><img src="../../painel/imgs/space.png" width="10" height="25"><a href="lista.php"><img src="../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../painel/imgs/space.png" width="10" height="25"><img src="../../painel/imgs/spaceT.png" width="20" height="25"></td>
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