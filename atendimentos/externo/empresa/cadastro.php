<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";
	include "../../../correio/correios.class.php";
	
	$c = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_empresa WHERE id='".$_GET['id']."'"));

	$consulta_uf = mysql_query ("SELECT DISTINCT uf FROM _cidades ORDER BY uf "); 
	$qtde_uf = mysql_num_rows($consulta_uf);
	$consulta_cidade = mysql_query("SELECT nome FROM _cidades WHERE uf = '".$c[uf]."' ORDER BY nome ASC");
	$qtde_cidade = mysql_num_rows($consulta_cidade);
		
	if ($_GET['id']) $titulo_pg = "ALTERANDO EMPRESA CONVENIANTE";
	else $titulo_pg = "CADASTRANDO EMPRESA CONVENIANTE";
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
	$("input[name='cep']").mask('99.999-999');	
	$("input[name='fone']").mask('(99)9999-9999');	
	$("input[name='fax']").mask('(99)9999-9999');
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
<table width="575" border="0" align="center" cellpadding="0" cellspacing="0" id="conteudo">
<tr>
<td width="100" height="25" align="center" valign="middle" bgcolor="#4DBDCB"><img src="icon.png"></td>
<td width="665" style="cursor:hand" align="left" bgcolor="#4DBDCB"><h2 class="txtBranco"><strong><?php if ($_GET['id']) echo $titulo_pg." ID: ".$_GET['id']; else echo $titulo_pg?></strong></h2></td>
</tr>
<tr>
<td colspan="2" align="center" valign="top" height="275">
	<form onsubmit="return validacampo(this)" action="processando.php<?php if ($_GET['id']) echo "?acao=alterar"?>" name="formulario" id="formulario" method="post">
    <table width="765" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>
        <td width="100" height="25" align="right"><h6>
          <input name="id" class="form_obrig" id="id" style=" width:0px; height: 0px;" value="<?php echo $c['id'] ?>" size="1" maxlength="1" readonly="readonly" />
          Raz&atilde;o Social:</h6></td>
        <td colspan="3"><input name="razao" class="form_obrig" id="razao" style=" width:610px; height: 20px;" value="<?php echo $c['razao'] ?>" maxlength="80"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>Fantasia:</h6></td>
        <td colspan="3"><input name="fantasia" class="form_obrig" id="fantasia" style=" width:610px; height: 20px;" value="<?php echo $c['fantasia'] ?>" maxlength="80"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>CPF / CNPJ:</h6></td>
        <td colspan="3"><input name="inscricao"  class="form_obrig" id="inscricao" style=" width:130px; height: 20px;" onBlur="validar(this)" value="<?php echo $c['inscricao'] ?>" maxlength="18"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>Endere&ccedil;o:</h6></td>
        <td colspan="3"><input name="endereco" class="form_obrig" id="endereco" style=" width:610px; height: 20px;" value="<?php echo $c['endereco'] ?>" maxlength="150"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>Complemento:</h6></td>
        <td width="434"><input name="complemento" class="form" id="complemento" style=" width:290px; height: 20px;" value="<?php echo $c['complemento'] ?>" maxlength="50"></td>
        <td width="33" align="right" ><h6>N&ordm;:</h6></td>
        <td align="left"><input name="numero" class="form_obrig" id="numero" style=" width:120px; height: 20px;" value="<?php echo $c['numero'] ?>" maxlength="5"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>Bairro:</h6></td>
        <td><input name="bairro" class="form_obrig" id="bairro" style=" width:290px; height: 20px;" value="<?php echo $c['bairro'] ?>" maxlength="20"></td>
        <td align="right" height="25"><h6>CEP:</h6></td>
        <td align="left"><input name="cep" class="form_obrig" id="cep"	style=" width:120px; height: 20px;" OnKeyPress="formatar('##.###-###', this)" value="<?php echo $c['cep'] ?>" maxlength="10"></td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>UF:</h6></td>
        <td colspan="3">
          <select name="uf" class="form_obrig" id="uf" style="width:40px">
            <?php if($qtde_uf>1){ ?><option value="" <?php if(!$c['uf']) echo "selected"?> >UF</option><?php } ?>
            <?php while($cuf = mysql_fetch_assoc($consulta_uf)){ ?>
            <option value="<?=$cuf['uf']?>" <?php if($c['uf']== $cuf['uf']) echo "selected"?> ><?php echo $cuf['uf'] ?></option>
            <?php } ?>
          </select>&nbsp;
          <select name="cidade" class="form_obrig" id="cidade" style="width:240px">
            <?php if($qtde_cidade>1){ ?><option value="" <?php if(!$c['cidade']) echo "selected"?> >Cidade</option><?php } ?>
            <?php while($ccidade = mysql_fetch_assoc($consulta_cidade)){ ?>
            <option value="<?=$ccidade['nome']?>" <?php if($c['cidade']== $ccidade['nome']) echo "selected"?> ><?php echo $ccidade['nome'] ?></option>
            <?php } ?>
          </select>      
		</td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>E-mail:</h6></td>
        <td><input name="email" class="form_obrig" id="email" style=" width:290px; height: 20px;" value="<?php echo $c['email'] ?>" maxlength="150"></td>
        <td align="right">&nbsp;</td>
        <td align="left">&nbsp;</td>
        </tr>
        <tr>
        <td align="right" height="25"><h6>Fone:</h6></td>
        <td><input name="fone" class="form_obrig" id="fone" style=" width:290px; height: 20px;" OnKeyPress="formatar('##-####-####', this)" value="<?php echo $c['fone'] ?>" maxlength="14"></td>
        <td align="right">&nbsp;</td>
        <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" height="25"><h6>Fax:</h6></td>
          <td><input name="fax" class="form" id="fax" style=" width:290px; height: 20px;" OnKeyPress="formatar('##-####-####', this)" value="<?php echo $c['fax'] ?>" maxlength="14"></td>
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td height="25" colspan="4" align="center" ><h6><strong>Autorizador:</strong></h6></td>
          </tr>
        <tr>
          <td height="25" align="right" ><h6>Nome:</h6></td>
          <td colspan="3"><input name="autorizador" class="form_obrig" id="autorizador" style=" width:610px; height: 20px;" value="<?php echo $c['autorizador'] ?>" maxlength="80"></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Função:</h6></td>
          <td colspan="3"><input name="funcao" class="form_obrig" id="funcao" style=" width:610px; height: 20px;" value="<?php echo $c['funcao'] ?>" maxlength="80"></td>
        </tr>
        <tr>
          <td height="25" align="right" ><h6>Setor:</h6></td>
          <td colspan="3"><input name="setor" class="form_obrig" id="setor" style=" width:610px; height: 20px;" value="<?php echo $c['setor'] ?>" maxlength="80"></td>
        </tr>
        <tr>
         <td height="25" align="right" >&nbsp;</td>
          <td colspan="3">	<?php if ($_GET['id']){ ?><input type="image" src="../../../painel/imgs/bt_alterar.png">
		  					<?php }else{?><input type="image" src="../../../painel/imgs/bt_cadastrar.png">&nbsp;<img src="../../../painel/imgs/bt_limpar.png" style="cursor:hand" onClick="document.formulario.reset();"/>
							<?php } ?></td>        </tr>
        <tr>
          <td width="100" height="25" align="right" >&nbsp;</td>
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