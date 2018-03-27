<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";
	include "../../painel/funcoesPHP/correio/correios.class.php";
	
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM dependente WHERE id='".$_GET['id']."' AND titular='".$_GET['titular']."'"));

	$titular  = @mysql_fetch_assoc(mysql_query("SELECT nome FROM cadastro WHERE id='".$_GET['titular']."'"));

	if ($_GET['id']) $titulo_pg = "ALTERANDO DEPENDENTE - SOCIO EFETIVO";
	else $titulo_pg = "CADASTRANDO DEPENDENTE - SOCIO EFETIVO";
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
	$("input[name='nascimento']").mask('99/99/9999');	
	$("input[name='cep']").mask('99.999-999');	
	$("input[name='celular']").mask('(99)9999-9999');	
	$("input[name='fone']").mask('(99)9999-9999');
	if($("input[name='inscricao']").length>11) return $("input[name='inscricao']").mask('99.999.999/9999-99');

	$("input[name='emissaorg']").mask('99/99/9999');
	$("input[name='inclusao']").mask('99/99/9999');
	$("input[name='exclusao']").mask('99/99/9999');
	$("input[name='emissaorg']").mask('99/99/9999');	
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
<td colspan="2" align="center" valign="top" height="275">
	<form onsubmit="return validacampo(this)" action="processando.php<?php if ($_GET['id']) echo "?acao=alterar?titular=".$_GET['titular']?>" name="formulario" id="formulario" method="post">
    <table width="800" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="10%" align="right"><h6>&nbsp;</h6></td>
          <td width="90%" align="left"><h6><br/>
          </h6>
            <h6><strong><?php if ($_GET['id']) echo 'Titular: '.$_GET['titular'].' - '.$titular['nome']; else echo 'Titular: '.$_GET['titular'].' - '.$titular['nome']?></strong></h6>
            <h6><br/>
            </h6></td>
        </tr>
        <tr>
          <td height="25" align="right"><h6>
            <input name="titular" class="form_obrig" id="titular" style=" width:0px; height: 0px;" value="<?php echo $_GET['titular'] ?>" size="3" maxlength="3" readonly="readonly"/>
            <input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="3" maxlength="3" readonly="readonly" />
            Status:</h6></td>
          <td colspan="7"><h6>
            <select name="status2" class="form_obrig" id="status2" style="width:100px; height: 20px;">
              <option value="">Status</option>
              <?php
            $consulta_status = mysql_query ("SELECT nome from auxiliar where classificacao = 'STATUS' ORDER BY ordem");
            if (mysql_num_rows ($consulta_status)) {
            while ($u = mysql_fetch_assoc($consulta_status)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['status'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select>
            &nbsp;Inclusão:&nbsp;
            <input name="inclusao" class="form_obrig" id="inclusao" style=" width:70px; height: 20px;" value="<?php echo date_data($c['inclusao']) ?>" size="11" maxlength="11" />
            &nbsp;<img src="../../painel/imgs/calendario.gif" alt="" name="f_trigger_inc" id="f_trigger_inc" style="cursor:hand" title="Abrir Calendário" />
            <script language="javascript" type="text/javascript">
		Calendar.setup({
		inputField     :    "inclusao",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_inc",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
            </script>
            &nbsp;Exclusão:&nbsp;
            <input name="exclusao" class="form_obrig" id="exclusao" style=" width:70px; height: 20px;" value="<?php if ($c['exclusao'] != '0000-00-00') echo date_data($c['exclusao'])?>" size="11" maxlength="11" />
            &nbsp;<img src="../../painel/imgs/calendario.gif" alt="" name="f_trigger_exc" id="f_trigger_exc" style="cursor:hand" title="Abrir Calendário" />
            <script language="javascript" type="text/javascript">
		Calendar.setup({
		inputField     :    "exclusao",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_exc",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
            </script>
            &nbsp;Motivo Exclusão:&nbsp;
            <select name="motivoexclusao" class="form_obrig" id="motivoexclusao" style="width:150px; height: 20px;">
              <option value="">Motivo de Exclusao</option>
              <?php
            $consulta_motivoexclusao = mysql_query ("SELECT nome from auxiliar where classificacao = 'EXCLUSAO' ORDER BY nome");
            if (mysql_num_rows ($consulta_motivoexclusao)) {
            while ($u = mysql_fetch_assoc($consulta_motivoexclusao)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['motivoexclusao'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select>
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right"><h6>Nome:</h6></td>
          <td colspan="7"><h6>
            <input name="nome" class="form_obrig" id="nome" style=" width:600px; height: 20px;" value="<?php echo $c['nome'] ?>" size="100" maxlength="100" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right"><h6>Parenteco:</h6></td>
          <td colspan="7"><h6>
            <select name="parentesco" class="form_obrig" id="parentesco" style="width:130px; height: 20px;">
              <option value="">Parentesco</option>
              <?php
            $consulta_parentesco = mysql_query ("SELECT nome from auxiliar where classificacao = 'PARENTESCO' ORDER BY nome");
            if (mysql_num_rows ($consulta_parentesco)) {
            while ($u = mysql_fetch_assoc($consulta_parentesco)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['parentesco'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select> 
            Tipo:
            <select name="tipo" class="form_obrig" id="tipo" style="width:2	30px; height: 20px;">
              <option value="">Tipo</option>
              <?php
            $consulta_tipo = mysql_query ("SELECT nome from auxiliar where classificacao = 'TIPO' AND ordem = '1' ORDER BY nome");
            if (mysql_num_rows ($consulta_tipo)) {
            while ($u = mysql_fetch_assoc($consulta_tipo)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['tipo'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select> Estudante: <input type="radio" class="form" name="estudante" id="estudante" value="S"<?php if($c['estudante'] == "S") echo "checked" ?> />
            &nbsp;Sim&nbsp;&nbsp;
            <input type="radio" class="form" name="estudante" id="estudante" value="N"<?php if($c['estudante'] == "N") echo "checked" ?> />&nbsp;Não</h6></td>
        </tr>
        <tr>
          <td height="25" align="right"><h6>CPF:</h6></td>
          <td colspan="7"><h6>
            <input name="cpf" class="form_obrig" id="cpf" style=" width:100px; height: 20px;" onblur="validar(this)" value="<?php echo $c['cpf'] ?>" size="14" maxlength="14" />
            &nbsp;RG:&nbsp;
            <input name="rg" class="form_obrig" id="rg" style=" width:100px; height: 20px;" value="<?php echo $c['rg'] ?>" size="14" maxlength="14" />
            &nbsp;Emissor:&nbsp;
            <input name="emissorrg" class="form_obrig" id="emissorrg" style=" width:60px; height: 20px;" value="<?php echo $c['emissorrg'] ?>" size="11" maxlength="11" />
            &nbsp;UF:&nbsp;
            <select name="ufrg" class="form_obrig" id="ufrg" style="width:44px; height: 20px;">
              <option value="">UF RG</option>
              <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
              <option value="<?php echo $u['uf']?>"<?php if($c['ufrg'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
              <?php }}?>
              </select>
            &nbsp;Data:&nbsp;
            <input name="emissaorg" class="form_obrig" id="emissaorg" style=" width:70px; height: 20px;" value="<?php echo date_data($c['emissaorg']) ?>" size="11" maxlength="11" />
            &nbsp;<img src="../../painel/imgs/calendario.gif" alt="" name="f_trigger_erg" id="f_trigger_erg" style="cursor:hand" title="Abrir Calendário" />
            <script language="javascript" type="text/javascript">
		Calendar.setup({
		inputField     :    "emissaorg",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_erg",  // trigger for the calendar (button ID)
		align          :    "cl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
            </script>
            &nbsp;CNS:&nbsp;
            <input name="cns" class="form_obrig" id="cns" style=" width:100px; height: 20px;" value="<?php echo $c['cns'] ?>" size="14" maxlength="14" />
          </h6></td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Nascimento:</h6></td>
          <td colspan="7"><h6>
            <input name="nascimento" class="form_obrig" id="nascimento" style=" width:100px; height: 20px;" value="<?php echo date_data($c['nascimento']) ?>" size="11" maxlength="10" />
            <img src="../../painel/imgs/calendario.gif" name="f_trigger_nasc" id="f_trigger_nasc" style="cursor:hand" title="Abrir Calendário">
            <script language="javascript">
		Calendar.setup({
		inputField     :    "nascimento",     // id of the input field
		ifFormat       :    "dd/mm/y",      // format of the input field
		button         :    "f_trigger_nasc",  // trigger for the calendar (button ID)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true
		});
              </script>
            Cor:&nbsp;
            <select name="cor" class="form_obrig" id="cor" style="width:130px; height: 20px;">
              <option value="">Cor</option>
              <?php
            $consulta_cor = mysql_query ("SELECT nome from auxiliar where classificacao = 'COR' ORDER BY nome");
            if (mysql_num_rows ($consulta_cor)) {
            while ($u = mysql_fetch_assoc($consulta_cor)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['cor'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select>
            Sexo:
            <input type="radio" class="form" name="sexo" id="sexo" value="F"<?php if($c['sexo'] == "F") echo "checked" ?> />
            &nbsp;Feminino&nbsp;&nbsp;
            <input type="radio" class="form" name="sexo" id="sexo" value="M"<?php if($c['sexo'] == "M") echo "checked" ?> />
            &nbsp;Masculino</h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Endereço:</h6></td>
          <td colspan="7"><h6>
            <input name="endereco" class="form_obrig" id="endereco" style=" width:515px; height: 20px;" value="<?php echo $c['endereco'] ?>" maxlength="150" />
            &nbsp;Nº:&nbsp;
            <input name="numero" class="form_obrig" id="numero" style=" width:100px; height: 20px;" value="<?php echo $c['numero'] ?>" size="14" maxlength="5" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Complemento:</h6></td>
          <td colspan="7"><h6>
            <input name="complemento" class="form" id="complemento" style=" width:290px; height: 20px;" value="<?php echo $c['complemento'] ?>" maxlength="50" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bairro:&nbsp;
            <input name="bairro" class="form_obrig" id="bairro" style=" width:290px; height: 20px;" value="<?php echo $c['bairro'] ?>" maxlength="20" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>UF:</h6></td>
          <td colspan="7"><h6>
            <select name="uf" class="form_obrig" id="uf" style="width:44px; height: 20px;">
              <option value="">UF</option>
              <?php
            $consulta_estado = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf");
            if (mysql_num_rows ($consulta_estado)) {
            while ($u = mysql_fetch_assoc($consulta_estado)) {
            ?>
              <option value="<?php echo $u['uf']?>"<?php if($c['uf'] == $u['uf']) echo "selected"?>><?php echo $u['uf']?></option>
              <?php }}?>
              </select>
            &nbsp;
            <select name="cidade" class="form_obrig" id="cidade" style="width:240px; height: 20px;">
              <option value="">Cidade</option>
              <?php
            $consulta_cidade = mysql_query ("SELECT nome FROM _cidades where uf = '".$c['uf']."' ORDER BY nome");
            if (mysql_num_rows ($consulta_cidade)) {
            while ($u = mysql_fetch_assoc($consulta_cidade)) {
            ?>
              <option value="<?php echo $u['nome']?>"<?php if($c['cidade'] == $u['nome']) echo "selected"?>><?php echo $u['nome']?></option>
              <?php }}?>
              </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CEP:&nbsp;
            <input name="cep" class="form_obrig" id="cep"	style=" width:96px; height: 20px;" onkeypress="formatar('##.###-###', this)" value="<?php echo $c['cep'] ?>" size="14" maxlength="14" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>E-mail:</h6></td>
          <td colspan="7"><h6>
            <input name="email" class="form_obrig" id="email" style=" width:290px; height: 20px;" value="<?php echo $c['email'] ?>" maxlength="150" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Celular:&nbsp;
            <input name="fonecel" class="form" id="fonecel" style=" width:290px; height: 20px;" value="<?php echo $c['fonecel'] ?>" maxlength="150" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Residencial:</h6></td>
          <td colspan="7"><h6>
            <input name="foneres" class="form" id="foneres" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['foneres'] ?>" maxlength="14" />
            Comercial:&nbsp;
  <input name="fonecom" class="form" id="fonecom" style=" width:290px; height: 20px;" onkeypress="formatar('##-####-####', this)" value="<?php echo $c['fonecom'] ?>" maxlength="14" />
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Observação:</h6></td>
          <td colspan="7"><h6>
            <textarea name="observacoes" rows="4" class="form" id="observacoes" style=" width:643px"><?php if (!empty($c['obs1']))echo $c['obs1'].', '; if (!empty($c['obs2']))echo ', '.$c['obs2'];if (!empty($c['obs3']))echo ', '.$c['obs3'];if (!empty($c['detalhe']))echo $c['detalhe'];?>
          </textarea>
          </h6></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>&nbsp;</h6></td>
          <td colspan="7">	<h6>
            <?php if ($_GET['id']){ ?>
            <input type="image" src="../../painel/imgs/bt_alterar.png">
            <?php }else{?><input type="image" src="../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
            <?php } ?>
          </h6></td>        </tr>
        <tr>
          <td align="right" ><h6>&nbsp;</h6></td>
          <td colspan="7" align="right" class="voltar"><h6><img src="../../painel/imgs/space.png" width="10" height="25"><a href="lista.php?id=<?php echo $_GET['titular']?>"><img src="../../painel/imgs/bt_voltar.png" border="0"></a><img src="../../painel/imgs/space.png" width="10" height="25"><img src="../../painel/imgs/spaceT.png" width="20" height="25"></h6></td>
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