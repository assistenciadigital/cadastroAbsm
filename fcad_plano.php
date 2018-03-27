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
	header("location:fcon_plano.php");	
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

function validacampos()
{
if(document.cadastro.fdescricao.value=="")
	{
	alert("O Campo descrição é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdetalhe.value=="")
	{
	alert("O Campo detalhe é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdatainicio.value=="")
	{
	alert("O Campo data inicio é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdatafim.value=="")
	{
	alert("O Campo data fim é obrigatório!");
	return false;
	}
else
	if(document.cadastro.ftipo.value=="")
	{
	alert("O Campo tipo é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fvalormensal.value=="")
	{
	alert("O Campo valor mensal é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdesconto.value=="")
	{
	alert("O Campo desconto é obrigatório!");
	return false;
	}
else
	if(document.cadastro.facrescimo.value=="")
	{
	alert("O Campo acrescimo é obrigatório!");
	return false;
	}
else	
if(document.cadastro.fvalorcobrado.value=="")
	{
	alert("O Campo valor cobrado é obrigatório!");
	return false;
	}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->

      $(document).ready(function(){
				  $("input[name='fdatainicio']").mask('99/99/9999');
				  $("input[name='fdatafim']").mask('99/99/9999');
				  $("input[name='fvalorindice']").mask('99.99');
				  $("input[name='fqtdeindice']").mask('9.999');
				  //$("input[name='finicio']").mask('99');	
				  //$("input[name='ffim']").mask('99');	
				  $("input[name='fvalormensal']").mask('999.99');	
				  $("input[name='fdesconto']").mask('99.99');	
				  $("input[name='facrescimo']").mask('99.99');	
				  $("input[name='fvalorcobrado']").mask('999.99');	
  }) 
</script>
<?php include("requerido/dataehora.php");?>

<style type="text/css">

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
<strong>Cadastro Plano | <a href="fcon_plano.php">Retornar</a></strong>
    <hr>
    <div style="color:#009; width:700px; height:395px; overflow: auto; vertical-align: center;">
    
    <form action="ccad_plano.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
    
      <fieldset><legend><strong>Plano:</strong></legend>
      <table width="580" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td align="left" valign="top"><strong>Classificação:</strong></td>
        <td align="left" valign="top"><select name="fclassificacao" id="fclassificacao">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlclassificacao = "SELECT * FROM classificacao where titular = 'S' ORDER BY descricao";
         $rsclassificacao = mysql_query($sqlclassificacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsclassificacao)){
            echo '<option value="'.$ln['classificacao'].'">'.$ln['descricao'].'</option>';
         }
      ?>
        </select></td>
      </tr>
      <tr>
        <td width="130" align="left" valign="top"><strong>Descrição:</strong></td>
        <td width="450" align="left" valign="top"><input name="fdescricao" type="text" id="fdescricao" size="50" maxlength="60" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Detalhe:</strong></td>
          <td align="left" valign="top"><textarea name="fdetalhe" cols="50" rows="5" id="fdetalhe"></textarea></td>
        </tr>
        </table>
        </fieldset>
    
        <fieldset>
          <legend><strong>Data Vigencia do Plano (inicio e fim):</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="fdatainicio" type="text" size="10" maxlength="10" id="fdatainicio" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Fim:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fdatafim" type="text" size="10" maxlength="10" id="fdatafim" />
          </strong></td>
        </tr>
        </table>
        </fieldset>
    
     <fieldset><legend><strong>Tipo Atualizacao Indice ou Faixa:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
    
        <tr>
          <td width="130" align="left" valign="top"><strong>Tipo:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <label for="ftipo"></label>
            <select name="ftipo" id="ftipo">
    <option value="Indice" selected="selected">Indice</option>
    <option value="Faixa">Faixa</option>
            </select>
          </strong></td>
        </tr>
        </table>
        </fieldset>
        
        <fieldset><legend><strong>Atualização por Indice:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
    
        <tr>
          <td width="130" align="left" valign="top"><strong>Indice:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="findice" type="text" size="11" maxlength="11" id="findice" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Valor:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fvalorindice" type="text" size="11" maxlength="11" id="fvalorindice" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Qtde:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fqtdeindice" type="text" size="11" maxlength="11" id="fqtdeindice" />
          </strong></td>
        </tr>
        </table>
        </fieldset>
        <fieldset><legend><strong>Atualização Faixa de Idade:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="finicio" type="text" size="2" maxlength="2" id="finicio" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Fim:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="ffim" type="text" size="2" maxlength="2" id="ffim" />
          </strong></td>
        </tr>    
        </table>
        </fieldset>
        
        <fieldset><legend><strong>Valores:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <td width="130" align="left" valign="top"><strong>Valor Mensal:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="fvalormensal" type="text" size="11" maxlength="11" id="fvalormensal" />
          </strong></td>
        </tr>
         <tr>
           <td align="left" valign="top"><strong>Desconto:</strong></td>
           <td align="left" valign="top"><strong>
             <input name="fdesconto" type="text" size="11" maxlength="11" id="fdesconto" />
           </strong></td>
         </tr>
         <tr>
           <td align="left" valign="top"><strong>Acrescimo:</strong></td>
           <td align="left" valign="top"><strong>
             <input name="facrescimo" type="text" size="11" maxlength="11" id="facrescimo" />
           </strong></td>
         </tr>
         <tr>
          <td align="left" valign="top"><strong>Valor Cobrado:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fvalorcobrado" type="text" size="11" maxlength="11" id="fvalorcobrado" />
          </strong></td>
        </tr>    
        </table>
        </fieldset>    
        
        <fieldset><legend><strong>Log's / Auditoria do Sistema:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
    
          <td width="130" align="left" valign="top"><strong>Data/Hora:</strong></td>
          <td width="450" align="left" valign="top"><input name="fdata" type="text" disabled="disabled" id="fdata" value="<?php print $data_final; ?> <?php print $hora; ?>" size="17" maxlength="17" readonly="readonly" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Usuário:</strong></td>
          <td align="left" valign="top"><input name="fusuario" type="text" disabled="disabled" id="fusuario" value="<?php print $loginusuario_atual; ?>" size="20" maxlength="20" readonly="readonly" /></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top"><input type="submit" name="fok" id="fok" value="OK" /></td>
        </tr>
      </table>
      </fieldset>
      
    </form>
</div>
</div>
<hr>
</div>
</body>
</html>