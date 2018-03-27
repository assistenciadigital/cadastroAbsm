<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
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


$pega_cliente = $_GET[cliente];

$sql = "SELECT
               cliente, classificacao, cartaosus, datainclusao, assistencia, tipo, plano, formapagto, titular, graduacao,
               instituicao, ufinstituicao, status, nome,  datanascimento, cpf, rg, emissorrg, ufrg, dataemissaorg, matriculasad,
			   dataincorporacao, sexo, estadocivil, conjuge, nacionalidade, ufnaturalidade, naturalidade, pai, mae, profissao,
			   ocupacao, endereco, bairro, cidade, uf, cep, foneres, fonecel1, fonecel2, fonecel3, fonecom, fonerec, email,
			   detalhe, obs1, obs2, obs3, data, hora, usuario
			   
  	    FROM cliente WHERE cliente=$pega_cliente";
		   
$rs = mysql_query($sql);
list($cliente, $classificacao, $cartaosus, $datainclusao, $assistencia, $tipo, $plano, $formapagto, $titular, $graduacao,
     $instituicao, $ufinstituicao, $status, $nome, $datanascimento, $cpf, $rg, $emissorrg, $ufrg, $dataemissaorg, $matriculasad,
	 $dataincorporacao, $sexo, $estadocivil, $conjuge, $nacionalidade, $ufnaturalidade, $naturalidade, $pai, $mae, $profissao, $ocupacao,
	 $endereco, $bairro, $cidade, $uf, $cep, $foneres, $fonecel1, $fonecel2, $fonecel3, $fonecom, $fonerec, $email, $detalhe, $obs1, $obs2, $obs3, $data, $hora,
	 $usuario) = mysql_fetch_row($rs);

$pega_classificacao = $classificacao;
$pega_ufnaturalidade  = $ufnaturalidade;
$pega_uf  = $uf;
$pega_cidade = $cidade;

#data atual
$ndata_atual = explode("-",$data); 
$dia_atual = $ndata_atual[0];
$mes_atual = $ndata_atual[1];
$ano_atual = $ndata_atual[2];
$data_atual = "$ano_atual/$mes_atual/$dia_atual";  

$ndata_inclusao = explode("-",$datainclusao); 
$dia_inclusao = $ndata_inclusao[0];
$mes_inclusao = $ndata_inclusao[1];
$ano_inclusao = $ndata_inclusao[2];
$datadeinclusao = "$ano_inclusao/$mes_inclusao/$dia_inclusao";

#data
$ndata_nascimento = explode("-",$datanascimento); 
$dia_nascimento = $ndata_nascimento[0];
$mes_nascimento = $ndata_nascimento[1];
$ano_nascimento = $ndata_nascimento[2];
$datadenascimento = "$ano_nascimento/$mes_nascimento/$dia_nascimento";

#data
$ndata_emissaorg = explode("-",$dataemissaorg);  
$dia_emissaorg = $ndata_emissaorg[0];
$mes_emissaorg = $ndata_emissaorg[1];
$ano_emissaorg = $ndata_emissaorg[2];
$datadeemissaorg = "$ano_emissaorg/$mes_emissaorg/$dia_emissaorg";

#data
$ndata_incorporacao = explode("-",$dataincorporacao); 
$dia_incorporacao = $ndata_incorporacao[0];
$mes_incorporacao = $ndata_incorporacao[1];
$ano_incorporacao = $ndata_incorporacao[2];
$datadeincorporacao = "$ano_incorporacao/$mes_incorporacao/$dia_incorporacao";  
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
	  
        // Evento change no campo uf naturalidade  
         $("select[name=fufnaturalidade]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=fnaturalidade]").html('<option value="">Carregando Naturalidade</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_naturalidade.php",
                  {fufnaturalidade:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=fnaturalidade]").html(valor);
                  }
                  )
         })		 

        // Evento change no campo uf cidade 
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
if(document.cadastro.fassistencia.value=="")
	{
	alert("O Campo assistencia é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdatainclusao.value=="")
	{
	alert("O Campo data inclusao é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fstatus.value=="")
	{
	alert("O Campo status é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fclassificacao.value=="")
	{
	alert("O Campo classificação é obrigatório!");
	return false;
	}
else
	if(document.cadastro.ftipo.value=="")
	{
	alert("O Campo tipo é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fnome.value=="")
	{
	alert("O Campo nome é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fcpf.value=="")
	{
	alert("O Campo CPF é obrigatório!");
	return false;
	}
else
	if(document.cadastro.frg.value=="")
	{
	alert("O Campo rg é obrigatório!");
	return false;
	}
else
	if(document.cadastro.femissorrg.value=="")
	{
	alert("O Campo emissor rg é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fufrg.value=="")
	{
	alert("O Campo uf rg é obrigatório!");
	return false;
	}
else	
if(document.cadastro.sexo.value=="")
	{
	alert("O Campo sexo é obrigatório!");
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
				  //$("input[name='fcep']").mask('99.999-999');
  }) 
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
<strong>Confirma Alteração Cliente? | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>
<form action="calt_cliente.php?cliente=<?php print $cliente;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div style="color:#009; width:700px; height:390px; overflow: auto; vertical-align: center;">
<form action="calt_cliente.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">

  <fieldset><legend><strong>Dados do Associado:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  <tr align="left" valign="middle">
    <td><strong>Cliente:</strong></td>
    <td><strong><input name="fcliente" type="text" disabled="disabled" value="<?php print $pega_cliente; ?>" size="10" maxlength="10" readonly="readonly" />
    </strong></td>
  </tr>
  <tr align="left" valign="middle">
    <td width="130"><strong>Assistencia:</strong></td>
    <td width="450">      
        <select name="fassistencia" id="fassistencia" style="width:400px">           
		<?php 
		$sqlassistencia = "select * from assistencia where assistencia = '$assistencia'";
		$rsassistencia = mysql_query($sqlassistencia);
		while(list($assistencia, $descricao) = mysql_fetch_row($rsassistencia)) { ?>
        <option value="<?php print $assistencia; ?>"><?php print $descricao; ?></option><?php } ?>
        <option value=""></option>
		<?php 
		$sqlassistencianew = "select * from assistencia";
		$rsassistencianew = mysql_query($sqlassistencianew);
		while(list($assistencia, $descricao) = mysql_fetch_row($rsassistencianew)) {
		?>
        <option value="<?php print $assistencia; ?>"><?php print $descricao; ?></option><?php } ?>
      </select><script language="JavaScript"> document.form1.fassistencia.focus(); </script>
        <span class="style1">*</span></strong> </td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Data  Inclusão:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatainclusao" type="text" id="fdatainclusao" value="<?php print $datadeinclusao; ?>" size="10" maxlength="10" />
      <span class="style1">* </span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Status:</strong></td>
    <td align="left" valign="middle"><strong><select name="fstatus" id="fstatus" style="width:400px">
        <option value="<?php print $status;?>" selected="selected"> <?php print $status;?></option>
        <option value=""></option>
        <option value="Ativo">Ativo</option>
        <option value="Bloqueado">Bloqueado</option>
        <option value="Excluido">Excluido</option>
        <option value="Inativo">Inativo</option>
        <option value="Recadastrar">Recadastrar</option>
      </select>
      <span class="style1">* </span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Classificação:</strong></td>
    <td align="left" valign="middle">  
     <select name="fclassificacao" id="fclassificacao" style="width:400px">           
		<?php 
		$sqlclassificacao = "select * from classificacao where classificacao='$classificacao'";
		$rsclassificacao = mysql_query($sqlclassificacao);
		while(list($classificacao, $descricao) = mysql_fetch_row($rsclassificacao)) { ?>
        <option value="<?php print $classificacao; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqlclassificacaonew = "select * from classificacao where titular = 'S' AND associado = 'S'  order by descricao";
		$rsclassificacaonew = mysql_query($sqlclassificacaonew);
		while(list($classificacao, $descricao) = mysql_fetch_row($rsclassificacaonew)) {
		?>
        <option value="<?php print $classificacao; ?>"><?php print $descricao; ?></option><?php } ?>
      </select>
     <span class="style1">*</span>
</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Tipo:</strong></td>
    <td align="left" valign="middle">
    <select name="ftipo" id="ftipo" style="width:400px">           
		<?php 
		$sqltipo = "select tipo, descricao from tipo where tipo='$tipo'";
		$rstipo = mysql_query($sqltipo);
		while(list($tipo, $descricao) = mysql_fetch_row($rstipo)) { ?>
        <option value="<?php print $tipo; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqltiponew = "select tipo, descricao from tipo WHERE titular = 'S'  and classificacao = '$pega_classificacao' ORDER BY descricao";
		$rstiponew = mysql_query($sqltiponew);
		while(list($tipo, $descricao) = mysql_fetch_row($rstiponew)) {
		?>
        <option value="<?php print $tipo; ?>"><?php print $descricao; ?></option><?php } ?>
      </select>
    </strong><span class="style1">* </span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Plano:</strong></td>
    <td align="left" valign="middle"><select name="fplano" id="fplano" style="width:400px">
      <?php 
		$sqlplano = "select plano, descricao from plano where plano='$plano'";
		$rsplano = mysql_query($sqlplano);
		while(list($plano, $descricao) = mysql_fetch_row($rsplano)) { ?>
      <option value="<?php print $plano; ?>"><?php print $descricao; ?></option>
      <?php } ?>
      <option value=""></option>
      <?php 
		$sqlplanonew = "select plano, descricao from plano";
		$rsplanonew = mysql_query($sqlplanonew);
		while(list($plano, $descricao) = mysql_fetch_row($rsplanonew)) {
		?>
      <option value="<?php print $plano; ?>"><?php print $descricao; ?></option>
      <?php } ?>
    </select>
      <span class="style1">* </span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Forma Pagto:</strong></td>
    <td align="left" valign="middle"><select name="fformapagto" id="fformapagto" style="width:400px">
      <?php 
		$sqlformapagto = "select * from formapagto where formapagto='$formapagto'";
		$rsformapagto = mysql_query($sqlformapagto);
		while(list($formapagto, $descricao) = mysql_fetch_row($rsformapagto)) { ?>
      <option value="<?php print $formapagto; ?>"><?php print $descricao; ?></option>
      <?php } ?>
      <option value=""></option>
      <?php 
		$sqlformapagtonew = "select * from formapagto";
		$rsformapagtonew = mysql_query($sqlformapagtonew);
		while(list($formapagto, $descricao) = mysql_fetch_row($rsformapagtonew)) {
		?>
      <option value="<?php print $formapagto; ?>"><?php print $descricao; ?></option>
      <?php } ?>
    </select>
      <span class="style1">*</span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Titular:</strong></td>
    <td align="left" valign="middle"><span class="style1"><strong>
      <select name="ftitular" id="ftitular" style="width:400px">
      <?php 
		$sqltitular = "select cliente, nome, cpf from cliente where cliente='$titular'";
		$rstitular = mysql_query($sqltitular);
		while(list($formapagto, $descricao) = mysql_fetch_row($rstitular)) { ?>
      <option value="<?php print $formapagto; ?>"><?php print $descricao; ?></option>
      <?php } ?>
      <option value=""></option>
        <?php
         $sqltitularnew = "SELECT cliente, nome, cpf FROM cliente ORDER BY nome";
         $rstitularnew = mysql_query($sqltitularnew) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rstitularnew)){
            echo '<option value="'.$ln['cliente'].'">'.$ln['nome'].' - CPF: '.$ln['cpf'].'</option>';
         }
      ?>
    </select>
      * somente no caso de SÓCIO CONTRIBUINTE/DEPENDENTE</strong></span></td>
  </tr>
  </table>
  </fieldset>
  
  <fieldset><legend><strong>CNS Cartão SUS:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="130" align="left" valign="middle"><strong>  CNS SUS: </strong></td>
    <td width="450" align="left" valign="middle"><strong>
      <input name="fcartaosus" type="text" id="fcartaosus" onblur="return validacns(this.value)/></td>
  </tr>
  <tr>
    <td align=" value="<?php print $cartaosus; ?>" size="15" maxlength="15"left" valign="bottom" />
    </strong></td>
    </tr>
  </table>
  </fieldset>

  <fieldset><legend><strong>Dados da Corporação (CBM / PM):</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

  <tr>
    <td width="130" align="left" valign="middle"><strong>Instituição:</strong></td>
    <td width="450" align="left" valign="middle"><strong>
    <select name="finstituicao" id="finstituicao">
        <option value="<?php print $instituicao;?>" selected="selected"> <?php print $instituicao;?></option>
        <option value=""></option>
        <option value="CBM">CBM</option>
        <option value="PM">PM</option>
      </select><span class="style1">*</span><strong> UF: </strong>
      <select name="fufinstituicao" id="fufinstituicao">           
          <option value="<?php print $ufinstituicao; ?>"><?php print $ufinstituicao; ?></option>
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
      </select><span class="style1">*</span>

    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Graduação:</strong></td>
    <td align="left" valign="middle"><strong>
    <select name="fgraduacao" id="fgraduacao">           
		<?php 
		$sqlgraduacao= "select * from insignia where insignia='$graduacao'";
		$rsgraduacao = mysql_query($sqlgraduacao);
		while(list($insignia, $descricao) = mysql_fetch_row($rsgraduacao)) { ?>
        <option value="<?php print $insignia; ?>"><?php print $descricao; ?></option><?php } ?>		
        <option value=""></option>
		<?php 
		$sqlgraduacaonew = "select * from insignia";
		$rsgraduacaonew = mysql_query($sqlgraduacaonew);
		while(list($insignia, $descricao) = mysql_fetch_row($rsgraduacaonew)) {
		?>
        <option value="<?php print $insignia; ?>"><?php print $descricao; ?></option><?php } ?>
      </select><span class="style1">*</span>
    Data de Incorporação:
    <input name="fdataincorporacao" type="text" id="fdataincorporacao" value="<?php print $datadeincorporacao; ?>" size="10" maxlength="10" /><span class="style1">*</span>
    </strong></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><strong>Matricula:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fmatriculasad" type="text" id="fmatriculasad" value="<?php print $matriculasad; ?>" size="11" maxlength="20" /><span class="style1">* MATRÍCULA SAD novo formato de 05 dígitos: 99999</span>
    </strong></td>
    </tr>
  </table>
  </fieldset>
  
  
  <fieldset><legend><strong>Dados Pessoais:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  
  <tr align="left" valign="middle">
    <td width="130"><strong>Nome:</strong></td>
    <td width="450"><strong>
      <input name="fnome" type="text" id="fnome" value="<?php print $nome; ?>" size="50" maxlength="150" /><span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Sexo:</strong></td>
    <td align="left" valign="middle"><strong>
    
    <select name="fsexo" id="fsexo">
        <option value="<?php print $sexo;?>" selected="selected"> <?php print $sexo;?></option>
        <option value=""></option>
        <option value="F">F</option>
        <option value="M">M</option>
        </select><span class="style1">*</span>
      Data Nascimento:
      <input name="fdatanascimento" type="text" value="<?php print $datadenascimento; ?>" size="10" maxlength="10" /></strong><span class="style1">*</span></td>
    </tr>
  
    <tr align="left" valign="middle">
      <td><strong>Nacionalidade: </strong></td>
      <td><strong>
        <select name="fnacionalidade" id="fnacionalidade">
          <option value="<?php print $nacionalidade;?>" selected="selected"> <?php print $nacionalidade;?></option>
          <option value=""></option>
          <option value="Brasileira" selected="selected">Brasileira</option>
          <option value="Estrangeira">Estrangeira</option>
        </select><span class="style1">* Nacionalidade</span></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>UF:</strong></td>
      <td><strong>
        <select name="fufnaturalidade" id="fufnaturalidade">
          <option value="<?php print $ufnaturalidade; ?>"><?php print $ufnaturalidade; ?></option>
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
        </select><span class="style1">* UF Naturalidade</span></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Naturalidade:</strong></td>
      <td><strong>
        
        <select name="fnaturalidade" id="fnaturalidade">           
          <?php 
		$sqlnaturalidade = "select cidade, descricao from cidade where cidade = '$naturalidade'";
		$rsnaturalidade = mysql_query($sqlnaturalidade);
		while(list($cidade, $descricao) = mysql_fetch_row($rsnaturalidade)) { ?>
          <option value="<?php print $cidade; ?>"><?php print $descricao; ?></option><?php } ?>
          <option value=""></option>
          <?php 
		$sqlnaturalidadenew = "select cidade, descricao from cidade where uf = '$pega_ufnaturalidade' order by descricao";
		$rsnaturalidadenew = mysql_query($sqlnaturalidadenew);
		while(list($cidade, $descricao) = mysql_fetch_row($rsnaturalidadenew)) {
		?>
          <option value="<?php print $cidade; ?>"><?php print $descricao; ?></option><?php } ?>
        </select><span class="style1">* Naturalidade</span></strong></td>
    </tr>
</table>
</fieldset>
  

  <fieldset><legend><strong>Documento(s):</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

  <tr>
    <td width="130" align="left" valign="middle"><strong>CPF: </strong></td>
    <td width="450" align="left" valign="middle"><strong>
      <input name="fcpf" type="text" id="fcpf" onblur="return verificarcpf(this.value)" value="<?php print $cpf; ?>" size="11" maxlength="11"/><span class="style1">*</span></strong></td>
    </tr>
  <tr>
    <td><strong>RG:</strong></td>
    <td><strong>
      <input name="frg" type="text" id="frg" value="<?php print $rg; ?>" size="11" maxlength="11" /><span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td><strong>Órgão Emissor:</strong></td>
    <td><strong>
      <input name="femissorrg" type="text" id="femissorrg" value="<?php print $emissorrg; ?>" size="11" maxlength="11" /><span class="style1">*</span> UF:
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
          </select><span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td><strong>Data Emissão:</strong></td>
    <td><strong>
      <input name="fdataemissaorg" type="text" id="fdataemissaorg" value="<?php print $datadeemissaorg; ?>" size="10" maxlength="10" /><span class="style1">*</span></strong></td>
    </tr>
  </table>
</fieldset>

  <fieldset><legend><strong>Estado Civil:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

   <tr align="left" valign="middle">  
      <td width="130"><strong>Estado Civil:</strong></td>
      <td width="450"><strong>
        <select name="festadocivil" id="festadocivil">           
		<?php 
		$sqlestadocivil = "select * from estadocivil where estadocivil = '$estadocivil'";
		$rsestadocivil = mysql_query($sqlestadocivil);
		while(list($estadocivil, $descricao) = mysql_fetch_row($rsestadocivil)) { ?>
        <option value="<?php print $estadocivil; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqlestadocivilnew = "select * from estadocivil";
		$rsestadocivilnew = mysql_query($sqlestadocivilnew);
		while(list($estadocivil, $descricao) = mysql_fetch_row($rsestadocivilnew)) {
		?>
        <option value="<?php print $estadocivil; ?>"><?php print $descricao; ?></option><?php } ?>
      </select><span class="style1">*</span>
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Conjuge:</strong></td>
      <td><strong>
        <input name="fconjuge" type="text" id="fconjuge" value="<?php print $conjuge; ?>" size="50" maxlength="100" />
      </strong></td>
    </tr>
 </table>
</fieldset>

  <fieldset><legend><strong>Filiação:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

   <tr align="left" valign="middle">  
      <td width="130"><strong>Pai:</strong></td>
      <td width="450"><strong><input name="fpai" type="text" id="fpai" value="<?php print $pai; ?>" size="50" maxlength="100" /></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Mãe:</strong></td>
      <td><strong><input name="fmae" type="text" id="fmae" value="<?php print $mae; ?>" size="50" maxlength="100" /><span class="style1">*</span></strong></td>
    </tr>
 </table>
</fieldset>

    
  <fieldset><legend><strong>Dados Profissionais:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td width="130"><strong>Profissão:</strong></td>
      <td width="450"><strong>
       <select name="fprofissao" id="fprofissao">           
		<?php 
		$sqlprofissao = "select * from profissao where profissao = '$profissao'";
		$rsprofissao = mysql_query($sqlprofissao);
		while(list($profissao, $descricao) = mysql_fetch_row($rsprofissao)) { ?>
        <option value="<?php print $profissao; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqlprofissaonew = "select * from profissao";
		$rsprofissaonew = mysql_query($sqlprofissaonew);
		while(list($profissao, $descricao) = mysql_fetch_row($rsprofissaonew)) {
		?>
        <option value="<?php print $profissao; ?>"><?php print $descricao; ?></option><?php } ?>
      </select>
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Ocupação:</strong></td>
      <td><strong>          <select name="focupacao" id="focupacao">           
		<?php 
		$sqlocupacao= "select * from ocupacao where ocupacao = '$ocupacao'";
		$rsocupacao = mysql_query($sqlocupacao);
		while(list($ocupacao, $descricao) = mysql_fetch_row($rsocupacao)) { ?>
        <option value="<?php print $ocupacao; ?>"><?php print $descricao; ?></option><?php } ?>
		<option value=""></option>
		<?php 
		$sqlocupacaonew = "select * from ocupacao";
		$rsocupacaonew = mysql_query($sqlocupacaonew);
		while(list($ocupacao, $descricao) = mysql_fetch_row($rsocupacaonew)) {
		?>
        <option value="<?php print $ocupacao; ?>"><?php print $descricao; ?></option><?php } ?>
      </select>

      </strong></td>
    </tr>
  </table>
  </fieldset>

    <fieldset><legend><strong>Endereço Completo:</strong></legend>
    <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td><strong>CEP:</strong></td>
      <td><strong>
        <input name="fcep" type="text" id="fcep" value="<?php print $cep; ?>" size="10" maxlength="10" /><span class="style1">*</span></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>UF:</strong></td>
      <td><strong>
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
        </select><span class="style1">*</span></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td width="130"><strong>Endereço:</strong></td>
      <td width="450"><strong>
        <label for="fendereco">
          <input name="fendereco" type="text" id="fendereco" value="<?php print $endereco; ?>" size="50" maxlength="100" /><span class="style1">*</span>
        </label>
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
          
          <td><strong>Cidade:</strong></td>
      <td><strong>
        <select name="fcidade" id="fcidade">
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
    </select><span class="style1">*</span></strong></td>          
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Bairro:</strong></td>
      <td><strong>
        <select name="fbairro" id="fbairro">
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
        </select><span class="style1">*</span></strong></td>
    </tr>
    </table>
    </fieldset>    

    <fieldset>
      <legend><strong>Telefone(s) / E-mail:</strong></legend>
    <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td width="130"><strong>Cel1:</strong></td>
      <td width="450"><strong>
        
      <input name="ffonecel1" type="text" id="ffonecel1" value="<?php print $fonecel1; ?>" size="14" maxlength="14" />
      Cel2:
      <input name="ffonecel2" type="text" id="ffonecel2" value="<?php print $fonecel2; ?>" size="14" maxlength="14" />
      Cel3:
      <input name="ffonecel3" type="text" id="ffonecel3" value="<?php print $fonecel3; ?>" size="14" maxlength="14" />
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Comercial:</strong></td>
      <td><strong>
        <input name="ffonecom" type="text" id="ffonecom" value="<?php print $fonecom; ?>" size="14" maxlength="14" />
Rec.:
<input name="ffonerec" type="text" id="ffonerec" value="<?php print $fonerec; ?>" size="14" maxlength="14" />
Res.:
      <input name="ffoneres" type="text" id="ffoneres" value="<?php print $foneres; ?>" size="14" maxlength="14" />
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>E-mail:</strong></td>
      <td><strong>
        <input name="femail" type="text" id="femail" value="<?php print $email; ?>" size="50" maxlength="100" />
      </strong></td>
    </tr>
    </table>
    </fieldset>

    <fieldset><legend><strong>Observação:</strong></legend>
    <table width="580" border="0">

    <tr align="left" valign="middle">
      <td width="130" align="left" valign="middle"><strong>Observação:</strong></td>
      <td width="450" align="left" valign="middle"><label for="fdetalhe"></label>
        <label for="fobservacao"></label>Observação Importada do Sistema Anterior:
        <textarea name="fobservacao" cols="50" rows="4" readonly="readonly" id="fobservacao"><?php print $obs1;?><?php print $obs2;?><?php print $obs3;?></textarea>Observação Sistema Atual:<textarea name="fdetalhe" id="fdetalhe" cols="50" rows="5"><?php print $detalhe; ?></textarea></td>
      </tr>
    </table>
    </fieldset>
    
    <fieldset><legend><strong>Log's / Auditoria do Sistema:</strong></legend>
    <table width="580" border="0">

    <tr align="left" valign="middle">
      <td width="130"><strong>Data/Hora:</strong></td>
      <td width="450"><strong><?php print $data_atual; ?> <?php print $hora; ?></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Usuário:</strong></td>
      <td><strong><?php print $loginusuario_atual; ?></strong></td>
    </tr>
    </table>
    </fieldset>

    <fieldset><legend><strong>Concluir Cadastro ou Limpar Campos Preenchidos:</strong></legend>
    <table width="580" border="0">
    <tr align="left" valign="middle">
      <td width="580" align="center">
          <input name="cadastrar" type="submit" id="cadastrar" value="Concluir meu Cadastro!" /> ou
          <input name="limpar" type="reset" id="limpar" value="Limpar Campos preenchidos!" />
          <br />
          <span class="style1">* Campos com * s&atilde;o obrigat&oacute;rios!</span></strong>
       </td>
    </tr>
  </table>
</fieldset>
</form>
</div>
<hr>
</div>
</body>
</html>