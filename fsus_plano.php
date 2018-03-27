<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#data vigencia inicio
$data_envia = explode("-",$_GET[datainicio]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia/$mes_envia/$dia_envia";
$datainicio = $data_final_envia;

#data vigencia fim
$data_envia = explode("-",$_GET[datafim]); 
$dia_envia = $data_envia[0];
$mes_envia = $data_envia[1];
$ano_envia = $data_envia[2];
$data_final_envia = "$ano_envia/$mes_envia/$dia_envia";
$datafim = $data_final_envia;

$plano = $_GET[plano];
$descricao = $_GET[descricao];
$detalhe = $_GET[detalhe];
$tipo = $_GET[tipo];
$indice = $_GET[indice];
$valorindice = $_GET[valorindice];
$qtdeindice = $_GET[qtdeindice];
$inicio = $_GET[inicio];
$fim = $_GET[fim];
$valormensal = $_GET[valormensal];
$desconto = $_GET[desconto];
$acrescimo = $_GET[acrescimo];
$valorcobrado = $_GET[valorcobrado];

$usuario = $_GET[usuario];
$data = $_GET[data_atual];
$hora = $_GET[hora_atual];

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
<title>HM Saúde</title>
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
<strong>Cadastro realizado com sucesso! | <a href="fcon_plano.php">Retornar</a></strong>
    <hr>
    <div style="color:#009; width:700px; height:395px; overflow: auto; vertical-align: center;">
    
    <form action="" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
    
      <fieldset><legend><strong>Plano:</strong></legend>
      <table width="580" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td align="left" valign="top"><strong>Plano:</strong></td>
        <td align="left" valign="top"><input name="fplano" type="text" disabled="disabled" id="fplano" value="<?php print $plano; ?>" size="2" maxlength="2" readonly="readonly" /></td>
      </tr>
      <tr>
        <td width="130" align="left" valign="top"><strong>Descrição:</strong></td>
        <td width="450" align="left" valign="top"><input name="fdescricao" type="text" disabled="disabled" id="fdescricao" value="<?php print $descricao; ?>" size="50" maxlength="60" readonly="readonly" /></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Detalhe:</strong></td>
          <td align="left" valign="top"><textarea name="fdetalhe" cols="50" rows="5" disabled="disabled" readonly="readonly" id="fdetalhe"><?php print $detalhe; ?></textarea></td>
        </tr>
        </table>
        </fieldset>
    
        <fieldset>
          <legend><strong>Data Vigencia do Plano (inicio e fim):</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="fdatainicio" type="text" disabled="disabled" id="fdatainicio" value="<?php print $datainicio; ?>" size="10" maxlength="10" readonly="readonly" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Fim:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fdatafim" type="text" disabled="disabled" id="fdatafim" value="<?php print $datafim; ?>" size="10" maxlength="10" readonly="readonly" />
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
            <input name="ftipo" type="text" disabled="disabled" id="ftipo" value="<?php print $tipo; ?>" size="10" maxlength="10" readonly="readonly" />
          </strong></td>
        </tr>
        </table>
        </fieldset>
        
        <fieldset><legend><strong>Atualização por Indice:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
    
        <tr>
          <td width="130" align="left" valign="top"><strong>Indice:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="findice" type="text" disabled="disabled" id="findice" value="<?php print $indice; ?>" size="11" maxlength="11" readonly="readonly" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Valor:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fvalorindice" type="text" disabled="disabled" id="fvalorindice" value="<?php print $valorindice; ?>" size="11" maxlength="11" readonly="readonly" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Qtde:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fqtdeindice" type="text" disabled="disabled" id="fqtdeindice" value="<?php print $qtdeindice; ?>" size="11" maxlength="11" readonly="readonly" />
          </strong></td>
        </tr>
        </table>
        </fieldset>
        <fieldset><legend><strong>Atualização Faixa de Idade:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <td width="130" align="left" valign="top"><strong>Inicio:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="finicio" type="text" disabled="disabled" id="finicio" value="<?php print $inicio; ?>" size="2" maxlength="2" readonly="readonly" />
          </strong></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Fim:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="ffim" type="text" disabled="disabled" id="ffim" value="<?php print $fim; ?>" size="2" maxlength="2" readonly="readonly" />
          </strong></td>
        </tr>    
        </table>
        </fieldset>
        
        <fieldset><legend><strong>Valores:</strong></legend>
        <table width="580" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <td width="130" align="left" valign="top"><strong>Vlr Mesal:</strong></td>
          <td width="450" align="left" valign="top"><strong>
            <input name="fvalormensal" type="text" disabled="disabled" id="fvalormensal" value="<?php print $valormensal; ?>" size="11" maxlength="11" readonly="readonly" />
          </strong></td>
        </tr>
         <tr>
           <td align="left" valign="top"><strong>Desconto:</strong></td>
           <td align="left" valign="top"><strong>
             <input name="fdesconto" type="text" disabled="disabled" id="fdesconto" value="<?php print $desconto; ?>" size="11" maxlength="11" readonly="readonly" />
           </strong></td>
         </tr>
         <tr>
           <td align="left" valign="top"><strong>Acrescimo:</strong></td>
           <td align="left" valign="top"><strong>
             <input name="facrescimo" type="text" disabled="disabled" id="facrescimo" value="<?php print $acrescimo; ?>" size="11" maxlength="11" readonly="readonly" />
           </strong></td>
         </tr>
         <tr>
          <td align="left" valign="top"><strong>Vlr Cobrado:</strong></td>
          <td align="left" valign="top"><strong>
            <input name="fvalorcobrado" type="text" disabled="disabled" id="fvalorcobrado" value="<?php print $valorcobrado; ?>" size="11" maxlength="11" readonly="readonly" />
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
        </table>
      </fieldset>
      
    </form>
<hr>
</div>
</div>
</body>
</html>