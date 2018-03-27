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
	header("location:fcon_plano.php");	
}

$pega_plano = $_GET[plano];

$sql = "SELECT plano,classificacao,descricao,detalhe,datainicio,datafim,tipo,indice,valorindice,qtdeindice,inicio,fim,valormensal,desconto,abatimento,acrescimo,valorcobrado,data,hora,usuario FROM plano WHERE plano=$pega_plano";
$rs = mysql_query($sql);

list($plano,$classificacao,$descricao,$detalhe,$datainicio,$datafim,$tipo,$indice,$valorindice,$qtdeindice,$inicio,$fim,$valormensal,$desconto,$abatimento,$acrescimo,$valorcobrado,$data,$hora,$usuario) = mysql_fetch_row($rs);

#data vigencia inicio
$data_envia = explode("-", $datainicio); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia/$mes_envia/$dia_envia";
$datainicio = $data_final_envia;

#data vigencia fim
$data_envia = explode("-", $datafim); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia/$mes_envia/$dia_envia";
$datafim = $data_final_envia;


#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>


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
<?php include("requerido/dataehora.php");?>
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
<strong>Confirma Alteração Plano? | <a href="fcon_plano.php">Retornar</a></strong>
    <hr>
    <div style="color:#009; width:700px; height:395px; overflow: auto; vertical-align: center;">
      <form action="calt_plano.php?plano=<?php print $plano;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
        <fieldset>
          <legend><strong>Plano:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td align="left" valign="top"><strong>Plano:</strong></td>
              <td align="left" valign="top"><input name="fplano" type="text" disabled="disabled" id="fplano" value="<?php print $plano; ?>" size="2" maxlength="2" readonly="readonly" /></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Classificação:</strong></td>
              <td align="left" valign="top"><select name="fclassificacao" id="fclassificacao">
                <?php 
		$sqlclassificacao = "select classificacao as codigo_classificacao, descricao as descricao_classificacao from classificacao where classificacao='$classificacao' and titular = 'S'";
		$rsclassificacao = mysql_query($sqlclassificacao);
		while(list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacao)) { ?>
                <option value="<?php print $codigo_classificacao; ?>"><?php print $descricao_classificacao; ?></option>
                <?php } ?>
                <option value=""></option>
                <?php 
		$sqlclassificacaonew = "select * from classificacao where titular = 'S'";
		$rsclassificacaonew = mysql_query($sqlclassificacaonew);
		while(list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacaonew)) {
		?>
                <option value="<?php print $codigo_classificacao; ?>"><?php print $descricao_classificacao; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td width="130" align="left" valign="top"><strong>Descrição:</strong></td>
              <td width="450" align="left" valign="top"><input name="fdescricao" type="text" id="fdescricao" value="<?php print $descricao; ?>" size="50" maxlength="60" /></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Detalhe:</strong></td>
              <td align="left" valign="top"><textarea name="fdetalhe" cols="50" rows="5" id="fdetalhe"><?php print $detalhe; ?></textarea></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Data Vigencia do Plano (inicio e fim):</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
              <td width="450" align="left" valign="top"><strong>
                <input name="fdatainicio" type="text" id="fdatainicio" value="<?php print $datainicio; ?>" size="10" maxlength="10" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Fim:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fdatafim" type="text" id="fdatafim" value="<?php print $datafim; ?>" size="10" maxlength="10" />
              </strong></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Tipo Atualizacao Indice ou Faixa:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="130" align="left" valign="top"><strong>Tipo:</strong></td>
              <td width="450" align="left" valign="top"><strong>
                <select name="ftipo" id="ftipo">
        <option value="<?php print $tipo;?>" selected="selected"> <?php print $tipo;?></option>
          <option value=""></option>
          <option value="Faixa">Faixa</option>
          <option value="Indice">Indice</option>
        </select>
              </strong></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Atualização por Indice:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="130" align="left" valign="top"><strong>Indice:</strong></td>
              <td width="450" align="left" valign="top"><strong>
                <input name="findice" type="text" id="findice" value="<?php print $indice; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Valor:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fvalorindice" type="text" id="fvalorindice" value="<?php print $valorindice; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Qtde:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fqtdeindice" type="text" id="fqtdeindice" value="<?php print $qtdeindice; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Atualização Faixa de Idade:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
              <td width="450" align="left" valign="top"><strong>
                <input name="finicio" type="text" id="finicio" value="<?php print $inicio; ?>" size="2" maxlength="2" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Fim:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="ffim" type="text" id="ffim" value="<?php print $fim; ?>" size="2" maxlength="2" />
              </strong></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Valores:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="130" align="left" valign="top"><strong>Vlr Mensal:</strong></td>
              <td width="450" align="left" valign="top"><strong>
                <input name="fvalormensal" type="text" id="fvalormensal" value="<?php print $valormensal; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Desconto:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fdesconto" type="text" id="fdesconto" value="<?php print $desconto; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Abatimento:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fabatimento" type="text" id="fabatimento" value="<?php print $abatimento; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Acrescimo:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="facrescimo" type="text" id="facrescimo" value="<?php print $acrescimo; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"><strong>Vlr Cobrado:</strong></td>
              <td align="left" valign="top"><strong>
                <input name="fvalorcobrado" type="text" id="fvalorcobrado" value="<?php print $valorcobrado; ?>" size="11" maxlength="11" />
              </strong></td>
            </tr>
          </table>
        </fieldset>
        <fieldset>
          <legend><strong>Log's / Auditoria do Sistema:</strong></legend>
          <table width="580" border="0" cellspacing="1" cellpadding="1">
            <tr>
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