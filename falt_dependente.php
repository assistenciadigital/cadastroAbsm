<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
$pega_dependente = $_GET[dependente];

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2")
{
	header("location:fcon_cliente.php");	
}

$sql = "SELECT dependente, status, tipo, coddep, nome, titular, codigomilitar, parentesco, datanascimento, datainclusao, sexo, cpf, rg, emissorrg, ufrg, dataemissaorg, cep, endereco, bairro, cidade, uf, detalhe, data, hora, usuario from dependente WHERE dependente='$pega_dependente'";

$rs = mysql_query($sql);

list($dependente,$status,$tipo,$coddep,$nome,$titular,$codigomilitar,$parentesco,$datanascimento,$datainclusao,$sexo,$cpf,$rg,$emissorrg,$ufrg,$dataemissaorg,$cep,$endereco,$bairro,$cidade,$uf,$detalhe,$data,$hora,$usuario) = mysql_fetch_row($rs);

$pega_uf  = $uf;
$pega_cidade = $cidade;

#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

#data
$ndata = explode("-",$datainclusao); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_inclusao = "$ano/$mes/$dia";

$ndata = explode("-",$datanascimento); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_nascimento = "$ano/$mes/$dia";

$ndata = explode("-",$dataemissaorg); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_emissaorg = "$ano/$mes/$dia";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	
        // Evento change no campo classificacao  
         $("select[name=fclassificacao]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=ftipo]").html('<option value="">Carregando Tipo</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_tipo.php",
                  {fclassificacao:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=ftipo]").html(valor);
                  }
                  )
         })		
		 
         // Evento change no campo classificacao  
         $("select[name=fclassificacao]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=fplano]").html('<option value="">Carregando Plano</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_plano.php",
                  {fclassificacao:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=fplano]").html(valor);
                  }
                  )
         })			 
		 	
        // Evento change no campo uf  
         $("select[name=fuf]").change(function(){
            // Exibimos no campo cidade antes de concluirmos
			$("select[name=fcidade]").html('<option value="">Carregando Cidade</option>');
            // Exibimos no campo cidade antes de selecionamos a cidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
			$("select[name=fbairro]").html('<option value="">Selecione Cidade</option>');
			// Passando uf por parametro para a pagina cfil_cidade.php
            $.post("cfil_cidade.php",
                  {fuf:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=fcidade]").html(valor);
                  }
                  )
         })
		 
		      	// Evento change no campo cidade 
	 	$("select[name=fcidade]").change(function(){
            // Exibimos no campo modelo antes de concluirmos
			$("select[name=fbairro]").html('<option value="">Carregando Bairro</option>');
            // Passando marca por parametro para a pagina cfil_bairro.php
            $.post("cfil_bairro.php",
                  {fcidade:$(this).val()},
                  // Carregamos o resultado acima para o campo modelo
				  function(valor){
                     $("select[name=fbairro]").html(valor);
                  }
                  )
            
         })
	 
	  })

function validacampos()
{
if(document.cadastro.fnome.value=="")
	{
	alert("O Campo nome é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fparentesco.value=="")
	{
	alert("O Campo parentesco é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fsexo.value=="")
	{
	alert("O Campo sexo é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdatanascimento.value=="")
	{
	alert("O Campo data de nascimento é obrigatório!");
	return false;
	}
else
	if(document.cadastro.ftipodependente.value=="")
	{
	alert("O Campo tipo é obrigatório!");
	return false;
	}
else

return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdatainclusao']").mask('99/99/9999');
				  $("input[name='fdatanascimento']").mask('99/99/9999');
				  $("input[name='fdataemissaorg']").mask('99/99/9999');
				  $("input[name='fdataincorporacao']").mask('99/99/9999');
				  $("input[name='fdatainclusao']").mask('99/99/9999');	
				  $("input[name='ffoneres']").mask('(99)9999-9999');	
				  $("input[name='ffonecel1']").mask('(99)9999-9999');	
				  $("input[name='ffonecel2']").mask('(99)9999-9999');	
				  $("input[name='ffonecel3']").mask('(99)9999-9999');	
				  $("input[name='ffonecom']").mask('(99)9999-9999');	
				  $("input[name='ffonerec']").mask('(99)9999-9999');	
				  $("input[name='fcep']").mask('99.999-999');
  }) 
</script>

</script>
<style type="text/css">

.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }


body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 700px;
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>
<?php include("requerido/dataehora.php");?>
</head>

<body>
<div id="tudo">
<div id="conteudo">
<hr>
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Alteração Dependência / Beneficiário | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>

<form action="calt_dependente.php?dependente=<?php print $dependente;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">

<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left" valign="middle"><strong>Dependente:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdependente" type="text" disabled="disabled" id="fdependente" value="<?php print $dependente; ?>" size="10" maxlength="10" readonly="readonly" />
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Status:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fstatus" id="fstatus">
        <option value="<?php print $status;?>" selected="selected"> <?php print $status;?></option>
        <option value=""></option>
        <option value="Ativo">Ativo</option>
        <option value="Bloqueado">Bloqueado</option>
        <option value="Excluido">Excluido</option>
        <option value="Inativo">Inativo</option>
        <option value="Recadastrar">Recadastrar</option>
        </select>
      Data Inclusão:
      <input name="fdatainclusao" type="text" id="fdatainclusao" value="<?php print $data_inclusao; ?>" size="10" maxlength="10" />
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Nome:</strong></td>
    <td align="left" valign="middle"><label for="fnome"><strong>
      <input name="fnome" type="text" id="fnome" value="<?php print $nome; ?>" size="50" maxlength="60" />
      </strong></label></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Parentesco:</strong></td>
    <td align="left" valign="middle"><select name="fparentesco" id="fparentesco" style="width:150px">           
		<?php 
		$sqlparentesco = "select * from parentesco where parentesco='$parentesco'";
		$rsparentesco = mysql_query($sqlparentesco);
		while(list($parentesco, $descricao) = mysql_fetch_row($rsparentesco)) { ?>
        <option value="<?php print $parentesco; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqlparentesconew = "select * from parentesco";
		$rsparentesconew = mysql_query($sqlparentesconew);
		while(list($parentesco, $descricao) = mysql_fetch_row($rsparentesconew)) {
		?>
        <option value="<?php print $parentesco; ?>"><?php print $descricao; ?></option><?php } ?>
      </select>
      <strong>Tipo:
      <select name="ftipo" id="ftipo" style="width:300px">
        <?php 
		$sqltipo = "select tipo, descricao from tipo where tipo='$tipo'";
		$rstipo = mysql_query($sqltipo);
		while(list($tipo, $descricao) = mysql_fetch_row($rstipo)) { ?>
        <option value="<?php print $tipo; ?>"><?php print $descricao; ?></option>
        <?php } ?>
        <option value=""></option>
        <?php 
		$sqltiponew = "select tipo, descricao from tipo WHERE titular = 'N'";
		$rstiponew = mysql_query($sqltiponew);
		while(list($tipo, $descricao) = mysql_fetch_row($rstiponew)) {
		?>
        <option value="<?php print $tipo; ?>"><?php print $descricao; ?></option>
        <?php } ?>
      </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>CPF:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fcpf" type="text" id="fcpf" onblur="return verificarcpf(this.value)" value="<?php print $cpf; ?>" size="11" maxlength="11"/>
      Data Nascimento:
        <input name="fdatanascimento" type="text" value="<?php print $data_nascimento; ?>" size="10" maxlength="10" />
    Sexo:
        <select name="fsexo" id="fsexo">
          <option value="<?php print $sexo;?>" selected="selected"> <?php print $sexo;?></option>
          <option value=""></option>
          <option value="F">F</option>
          <option value="M">M</option>
        </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>RG:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="frg" type="text" id="frg" value="<?php print $rg; ?>" size="11" maxlength="11" />
      Emissor</strong>:<strong>
        <input name="femissorrg" type="text" id="femissorrg" value="<?php print $emissorrg; ?>" size="6" maxlength="11" />
        </strong> <strong>UF</strong>:<strong>
        <select name="fufrg" id="fufrg">           
          <option value="<?php print $ufrg; ?>"><?php print $ufrg; ?></option>
          <option value=""></option>
          <option value="AC">AC</option>
          <option value="AL">AL</option>
          <option value="AM">AM</option>
          <option value="AP">AP</option>
          <option value="BA">BA</option>
          <option value="CE">CE</option>
          <option value="DF">DF</option>
          <option value="ES">ES</option>
          <option value="GO">GO</option>
          <option value="MA">MA</option>
          <option value="MG">MG</option>
          <option value="MS">MS</option>
          <option value="MT">MT</option>
          <option value="PA">PA</option>
          <option value="PB">PB</option>
          <option value="PE">PE</option>
          <option value="PI">PI</option>
          <option value="PR">PR</option>
          <option value="RJ">RJ</option>
          <option value="RN">RN</option>
          <option value="RO">RO</option>
          <option value="RR">RR</option>
          <option value="RS">RS</option>
          <option value="SC">SC</option>
          <option value="SE">SE</option>
          <option value="SP">SP</option>
          <option value="TO">TO</option>
        </select>
        Emissão:
        <input name="fdataemissaorg" type="text" id="fdataemissaorg" value="<?php print $data_emissaorg; ?>" size="10" maxlength="10" />
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>CEP:</strong></td>
    <td align="left" valign="middle"><label for="fenderecotitular"><strong>
      <input name="fcep" type="text" id="fcep" value="<?php print $cep; ?>" size="10" maxlength="10" />
      UF:
      <select name="fuf" id="fuf">
        <option value="<?php print $uf; ?>"><?php print $uf; ?></option>
        <option value=""></option>
        <option value="AC">AC</option>
        <option value="AL">AL</option>
        <option value="AM">AM</option>
        <option value="AP">AP</option>
        <option value="BA">BA</option>
        <option value="CE">CE</option>
        <option value="DF">DF</option>
        <option value="ES">ES</option>
        <option value="GO">GO</option>
        <option value="MA">MA</option>
        <option value="MG">MG</option>
        <option value="MS">MS</option>
        <option value="MT">MT</option>
        <option value="PA">PA</option>
        <option value="PB">PB</option>
        <option value="PE">PE</option>
        <option value="PI">PI</option>
        <option value="PR">PR</option>
        <option value="RJ">RJ</option>
        <option value="RN">RN</option>
        <option value="RO">RO</option>
        <option value="RR">RR</option>
        <option value="RS">RS</option>
        <option value="SC">SC</option>
        <option value="SE">SE</option>
        <option value="SP">SP</option>
        <option value="TO">TO</option>
        </select>
      </strong></label></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Endereço:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fendereco" type="text" id="fendereco" value="<?php print $endereco; ?>" size="50" maxlength="100" />
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Cidade:</strong></td>
    <td align="left" valign="middle"><select name="fcidade" id="fcidade" style="width:323px">
      <?php 
		$sqlcidade = "select cidade as codigocidade, descricao from cidade where cidade = '$pega_cidade'";
		$rscidade = mysql_query($sqlcidade);
		while(list($codigocidade, $descricao) = mysql_fetch_row($rscidade)) { ?>
      <option value="<?php print $codigocidade; ?>"><?php print $descricao; ?></option>
      <?php } ?>
      <option value=""></option>
      <?php 
		$sqlcidadenew = "select cidade as codigocidade, descricao from cidade where uf = '$pega_uf' order by descricao";
		$rscidadenew = mysql_query($sqlcidadenew);
		while(list($codigocidade, $descricao) = mysql_fetch_row($rscidadenew)) {
		?>
      <option value="<?php print $codigocidade; ?>"><?php print $descricao; ?></option>
      <?php } ?>
      </select></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Bairro:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fbairro" id="fbairro" style="width:323px">
          <?php 
		$sqlbairro = "select bairro, descricao from bairro where bairro = '$bairro'";
		$rsbairro = mysql_query($sqlbairro);
		while(list($bairro, $descricao) = mysql_fetch_row($rsbairro)) { ?>
          <option value="<?php print $bairro; ?>"><?php print $descricao; ?></option>
          <?php } ?>
          <option value=""></option>
          <?php 
		$sqlbairronew = "select bairro, descricao from bairro where cidade = '$pega_cidade' order by descricao";
		$rsbairronew = mysql_query($sqlbairronew);
		while(list($bairro, $descricao) = mysql_fetch_row($rsbairronew)) {
		?>
          <option value="<?php print $bairro; ?>"><?php print $descricao; ?></option>
          <?php } ?>
        </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Detalhe:</strong></td>
    <td align="left" valign="middle"><label for="fdetalhe"></label>
      <input name="fdetalhe" type="text" id="fdetalhe" value="<?php print $detalhe; ?>" size="50" maxlength="60" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
</table>
</form>
<hr>
</div>
</div>
</body>
</html>