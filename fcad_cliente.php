<?php

$data = date("Y-m-d");
$hora = date("H:i:s");

#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";


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
include("requerido/verifica.php");

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

function MM_jumpMenu_uf(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

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
if(document.cadastro.fplano.value=="")
	{
	alert("O Campo plano é obrigatório!");
	return false;
	}
else
if(document.cadastro.fformapagto.value=="")
	{
	alert("O Campo forma de pagto é obrigatório!");
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
if(document.cadastro.fsexo.value=="")
	{
	alert("O Campo sexo é obrigatório!");
	return false;
	}
else
if(document.cadastro.fnacionalidade.value=="")
	{
	alert("O Campo nacionalidade é obrigatório!");
	return false;
	}
else
if(document.cadastro.fnaturalidade.value=="")
	{
	alert("O Campo naturalidade é obrigatório!");
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
<strong>Cadastro Cliente | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:700px; height:390px; overflow: auto; vertical-align: center;">
<form action="ccad_cliente.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">

  <fieldset><legend><strong>Dados do Associado:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  <tr align="left" valign="middle">
    <td width="130"><strong>Assistencia:</strong></td>
    <td width="450">
      <strong>
        <select name="fassistencia" id="fassistencia" style="width:400px">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlassistencia = "SELECT * FROM assistencia ORDER BY descricao";
         $rsassistencia = mysql_query($sqlassistencia) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsassistencia)){
            echo '<option value="'.$ln['assistencia'].'">'.$ln['descricao'].'</option>';
         }
      ?>
      </select><script language="JavaScript"> document.cadastro.fassistencia.focus(); </script>
        <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Data  Inclusão:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatainclusao" type="text" id="fdatainclusao" size="10" maxlength="10" />
      <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Status:</strong></td>
    <td align="left" valign="middle">
      <select name="fstatus" id="fstatus" style="width:400px">
        <option value="Ativo" selected="selected">Ativo</option>
        <option value="Bloqueado">Bloqueado</option>
        <option value="Excluido">Excluido</option>
        <option value="Inativo">Inativo</option>
        <option value="Recadastrar">Recadastrar</option></select>
      <span class="style1">*</span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Classificação:</strong></td>
    <td align="left" valign="middle">  <select name="fclassificacao" id="fclassificacao" style="width:400px">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlclassificacao = "SELECT * FROM classificacao WHERE titular = 'S' AND associado = 'S' ORDER BY descricao";
         $rsclassificacao = mysql_query($sqlclassificacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsclassificacao)){
            echo '<option value="'.$ln['classificacao'].'">'.$ln['descricao'].'</option>';
         }
      ?>
      </select>
      <span class="style1">*</span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Tipo:</strong></td>
    <td align="left" valign="middle"><strong>
    <select name="ftipo" id="ftipo" style="width:400px">
     </select>
    <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Plano:</strong></td>
    <td align="left" valign="middle"><strong>
    <select name="fplano" id="fplano" style="width:400px">
     </select>
    <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Forma Pagto:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fformapagto" id="fformapagto" style="width:400px">
        <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         $sqlformapagto = "SELECT * FROM formapagto ORDER BY descricao";
         $rsformapagto = mysql_query($sqlformapagto) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsformapagto)){
            echo '<option value="'.$ln['formapagto'].'">'.$ln['descricao'].'</option>';
         }
      ?>
      </select>
      <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Titular:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="ftitular" id="ftitular" style="width:400px">
        <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         $sqltitular = "SELECT cliente, nome, cpf FROM cliente ORDER BY nome";
         $rstitular = mysql_query($sqltitular) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rstitular)){
            echo '<option value="'.$ln['cliente'].'">'.$ln['nome'].' - CPF: '.$ln['cpf'].'</option>';
         }
      ?>
      </select>
      <span class="style1">*somente no caso de SÓCIO CONTRIBUINTE/DEPENDENTE</span></strong></td>
  </tr>
  </table>
  </fieldset>
  
  <fieldset><legend><strong>CNS Cartão SUS:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="130" align="left" valign="middle"><strong>  CNS SUS: </strong></td>
    <td width="450" align="left" valign="middle"><strong>
      <input name="fcartaosus" type="text" id="fcartaosus" size="15" maxlength="15" onblur="return validacns(this.value)/></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" />
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
        <option value=""></option>
        <option value="CBM">CBM</option>
        <option value="PM">PM</option>
      </select>
      <span class="style1">*</span><strong>UF: </strong>
      <select name="fufinstituicao" id="fufinstituicao">
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
      <span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Graduação:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fgraduacao" id="fgraduacao">
        <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         $sqlinsignia = "SELECT * FROM insignia ORDER BY hierarquia";
         $rsinsignia = mysql_query($sqlinsignia) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsinsignia)){
            echo '<option value="'.$ln['insignia'].'">'.$ln['sigla'].'</option>';
         }
      ?>
        </select>
      <span class="style1">* </span>Data de Incorporação:
      <input name="fdataincorporacao" type="text" id="fdataincorporacao" size="10" maxlength="10" />
      <span class="style1">*</span></strong></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><strong>Matricula:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fmatriculasad" type="text" id="fmatriculasad" size="11" maxlength="20" />
      <span class="style1">* MATRÍCULA SAD novo formato de 05 dígitos: 99999</span>
    </strong></td>
    </tr>
  </table>
  </fieldset>
  
  
  <fieldset><legend><strong>Dados Pessoais:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
  
  <tr align="left" valign="middle">
    <td width="130"><strong>Nome:</strong></td>
    <td width="450"><strong>
      <input name="fnome" type="text" id="fnome" size="50" maxlength="150" /><span class="style1">*</span></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Sexo:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fsexo" id="fsexo">
        <option value=""></option>
        <option value="F">F</option>
        <option value="M">M</option>
        </select>
      <span class="style1">*</span>
      Data Nascimento:
      <input name="fdatanascimento" type="text" size="10" maxlength="10" />
    </strong><span class="style1">*</span>
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
  
    <tr align="left" valign="middle">
    <td><strong>Nacionalidade: </strong></td>
    <td><strong>
      <select name="fnacionalidade" id="fnacionaliddade">
        <option value=""></option>
        <option value="Brasileira" selected="selected">Brasileira</option>
        <option value="Estrangeira">Estrangeira</option>
      </select>
      <span class="style1">* Nacionalidade</span>
    </strong></td>
  </tr>
    <tr align="left" valign="middle">
      <td><strong>UF:</strong></td>
      <td><strong>
        <select name="fufnaturalidade" id="fufnaturalidade">
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
        <span class="style1">* UF Naturalidade</span></strong></td>
    </tr>
    <tr align="left" valign="middle">
    <td><strong>Naturalidade:</strong></td>
    <td><strong>
      <select name="fnaturalidade" id="fnaturalidade">
      </select>
      <span class="style1">* Naturalidade</span>
    </strong></td>
  </tr>
</table>
</fieldset>
  

  <fieldset><legend><strong>Documento(s):</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

  <tr>
    <td width="130" align="left" valign="middle"><strong>CPF: </strong></td>
    <td width="450" align="left" valign="middle"><strong>
      <input name="fcpf" type="text" id="fcpf" size="11" maxlength="11" onblur="return verificarcpf(this.value)"/>
      <span class="style1">* </span></strong></td>
    </tr>
  <tr>
    <td><strong>RG:</strong></td>
    <td><strong>
      <input name="frg" type="text" id="frg" size="11" maxlength="11" />
      <span class="style1">* </span></strong></td>
  </tr>
  <tr>
    <td><strong>Órgão Emissor:</strong></td>
    <td><strong>
      <input name="femissorrg" type="text" id="femissorrg" size="11" maxlength="11" />
      <span class="style1">*</span> UF:
      <select name="fufrg" id="fufrg">
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
      <span class="style1">* </span></strong></td>
  </tr>
  <tr>
    <td><strong>Data Emissão:</strong></td>
    <td><strong>
      <input name="fdataemissaorg" type="text" id="fdataemissaorg" size="10" maxlength="10" />
      <span class="style1">* </span></strong></td>
    </tr>
  </table>
</fieldset>

  <fieldset><legend><strong>Estado Civil:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

   <tr align="left" valign="middle">  
      <td width="130"><strong>Estado Civil:</strong></td>
      <td width="450"><strong>
        <select name="festadocivil" id="festadocivil">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlestadocivil = "SELECT * FROM estadocivil ORDER BY descricao";
         $rsestadocivil = mysql_query($sqlestadocivil) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsestadocivil)){
            echo '<option value="'.$ln['estadocivil'].'">'.$ln['descricao'].'</option>';
         }
      ?>
        </select>
        <span class="style1">*</span>
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Conjuge:</strong></td>
      <td><strong>
        <input name="fconjuge" type="text" id="fconjuge" value="" size="50" maxlength="100" />
      </strong></td>
    </tr>
 </table>
</fieldset>

  <fieldset><legend><strong>Filiação:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">

   <tr align="left" valign="middle">  
      <td width="130"><strong>Pai:</strong></td>
      <td width="450"><strong><input name="fpai" type="text" id="fpai" value="" size="50" maxlength="100" /></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Mãe:</strong></td>
      <td><strong><input name="fmae" type="text" id="fmae" value="" size="50" maxlength="100" />
      <span class="style1">* </span></strong></td>
    </tr>
 </table>
</fieldset>

    
  <fieldset><legend><strong>Dados Profissionais:</strong></legend>
  <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td width="130"><strong>Profissão:</strong></td>
      <td width="450"><strong><select name="fprofissao" id="fprofissao"><option value=""></option>
         <?php
 		 include("requerido/conexao.php");
         $sqlprofissao = "SELECT * FROM profissao ORDER BY descricao";
         $rsprofissao = mysql_query($sqlprofissao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsprofissao)){
            echo '<option value="'.$ln['profissao'].'">'.$ln['descricao'].'</option>';}?></select></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Ocupação:</strong></td>
      <td><strong><select name="focupacao" id="focupacao"><option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlocupacao = "SELECT * FROM ocupacao ORDER BY descricao";
         $rsocupacao = mysql_query($sqlocupacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsocupacao)){
            echo '<option value="'.$ln['ocupacao'].'">'.$ln['descricao'].'</option>';
         }
      ?>
        </select>
      </strong></td>
    </tr>
  </table>
  </fieldset>

    <fieldset><legend><strong>Endereço Completo:</strong></legend>
    <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td width="130"><strong>CEP:</strong></td>
      <td width="450"><strong>
        <input name="fcep" type="text" id="fcep" value="" size="10" maxlength="10" />
        <span class="style1">* </span></strong></td>
    </tr>
    <tr align="left" valign="middle">
          
      <td><strong><strong>UF:</strong></strong></td>
      <td><strong>
        <select name="fuf" id="fuf">
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
        <span class="style1">* </span></strong></td>       
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Endereço:</strong></td>
      <td><strong>
        <input name="fendereco" type="text" id="fendereco" size="50" maxlength="100" />
        <span class="style1">* </span></strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Cidade:</strong></td>
      <td><strong>
      <select name="fcidade" id="fcidade">
      </select>
      <span class="style1">* </span></strong></td>
    </tr>
    <tr align="left" valign="middle">

      <td><strong>Bairro:</strong></td>
      <td><strong>
        <select name="fbairro" id="fbairro">
        </select>
        <span class="style1">* </span></strong></td>
      
    </tr>
    </table>
    </fieldset>    

    <fieldset>
    <legend><strong>Telefone(s) / E-mail:</strong></legend>
    <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr align="left" valign="middle">
      <td width="130"><strong>Cel1:</strong></td>
      <td width="450"><strong>
        
      <input name="ffonecel1" type="text" id="ffonecel1" size="14" maxlength="14" />
      Cel2:
      <input name="ffonecel2" type="text" id="ffonecel2" size="14" maxlength="14" />
      Cel3:
      <input name="ffonecel3" type="text" id="ffonecel3" size="14" maxlength="14" />
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>Com.:</strong></td>
      <td><strong>
        <input name="ffonecom" type="text" id="ffonecom" size="14" maxlength="14" />
Rec.:
<input name="ffonerec" type="text" id="ffonerec" size="14" maxlength="14" />
Res.:
      <input name="ffoneres" type="text" id="ffoneres" size="14" maxlength="14" />
      </strong></td>
    </tr>
    <tr align="left" valign="middle">
      <td><strong>E-mail:</strong></td>
      <td><strong>
        <input name="femail" type="text" id="femail" size="50" maxlength="100" />
      </strong></td>
    </tr>
    </table>
    </fieldset>

    <fieldset><legend><strong>Observação:</strong></legend>
    <table width="580" border="0">

    <tr align="left" valign="middle">
      <td width="130" align="left" valign="middle"><strong>Observação:</strong></td>
      <td width="450" align="left" valign="middle"><textarea name="fdetalhe" id="fdetalhe" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
    </fieldset>
    
    <fieldset><legend><strong>Log's / Auditoria do Sistema:</strong></legend>
    <table width="580" border="0">

    <tr align="left" valign="middle">
      <td width="100"><strong>Data/Hora:</strong></td>
      <td width="480"><strong><?php print $data_final; ?> <?php print $hora; ?> | Usuário: <?php print $loginusuario_atual; ?></strong></td>
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
          <span class="style1">* Campos com * s&atilde;o obrigat&oacute;rios!</span>
       </td>
    </tr>
  </table>
  </fieldset>
</form>
</div>
<hr>
</div>
</div>
</div>
</body>
</html>