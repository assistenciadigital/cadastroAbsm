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

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT carteira, codigo_titular, codigo_dependente, via  FROM carteira WHERE (codigo_titular = '$pega_cliente' and codigo_dependente = '$pega_cliente')";
$rsv = mysql_query($sqlv);


while(list($carteirav, $codigo_titularv, $codigo_dependentev, $viav) = mysql_fetch_row($rsv)) {
 $contador++;
 $pega_via = $viav;
}

if($contador >= 1) {
  #SE ENCONTROU REGISTRO DUPLICADO
  $pega_via = $pega_via + 1;
} else {
  $pega_via = 1;
}

$sql = "SELECT cliente, titular, nome, datanascimento, datainclusao, classificacao, assistencia, status, data, hora, usuario FROM cliente WHERE cliente ='$pega_cliente'";
$rs = mysql_query($sql);

list($cliente, $titular, $nome, $datanascimento, $datainclusao, $classificacao, $assistencia, $status, $data, $hora, $usuario) = mysql_fetch_row($rs);

$pega_titular = $titular;

if  ($pega_titular == "" or (empty($pega_titular))) {
	$envia_cliente = $cliente;
	$envia_nome = $nome;
	$envia_data_nascimento = $datanascimento;
	$envia_data_inclusao = $datainclusao;
}else{
$sqltitular = "SELECT cliente as codigo_titular, nome as nome_titular, datanascimento as datanascimento_titular, datainclusao as datainclusao_titular, titular FROM cliente WHERE cliente ='$pega_titular'";
$rstitular = mysql_query($sqltitular);
list($codigo_titular, $nome_titular, $datanascimento_titular, $datainclusao_titular, $titular) = mysql_fetch_row($rstitular);	
	$envia_cliente = $codigo_titular;
	$envia_nome = $nome_titular;
	$envia_data_nascimento = $datanascimento_titular;
	$envia_data_inclusao = $datainclusao_titular;
}

$pega_classificacao = $classificacao;
$pega_assistencia = $assistencia;

$sqlclassificacao = "SELECT classificacao as codigo_classificacao, descricao as descricao_classificacao FROM classificacao WHERE classificacao ='$pega_classificacao'";
$rsclassificacao = mysql_query($sqlclassificacao);
list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacao);

$sqlassistencia = "SELECT assistencia as codigo_assistencia, descricao as descricao_assistencia FROM assistencia WHERE assistencia ='$pega_assistencia'";
$rsassistencia = mysql_query($sqlassistencia);

list($codigo_assistencia, $descricao_assistencia) = mysql_fetch_row($rsassistencia);

#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

#envia data nascimento
$ndata = explode("-",$envia_data_nascimento); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$enviadatanascimento = "$ano/$mes/$dia";

#envia data inclusao
$ndata = explode("-",$envia_data_inclusao); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$enviadatainclusao = "$ano/$mes/$dia";

#data nascimento
$ndata = explode("-",$datanascimento); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_nascimento = "$ano/$mes/$dia";

#data inclusao
$ndata = explode("-",$datainclusao); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_inclusao = "$ano/$mes/$dia";

#data atual
$ndata = explode("-",date("Y-m-d")); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_atual = "$ano/$mes/$dia";

#data validade
$timestamp = strtotime(date("Y-m-d"). "+365 days");
$data_validade = date('d/m/Y', $timestamp);
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
<strong>Cadastro Carteira / Titular | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:720px; height: 380px; overflow: auto; vertical-align: left;">
<form action="ccad_carteira.php" target="_blank" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
  <fieldset>
  <legend><strong>Dados do Titular:</strong></legend>
  <table width="680" border="0" cellpadding="1" cellspacing="1">
  <tr align="left" valign="middle">
    <td width="130"><strong>Codigo:</strong></td>
    <td width="550">
      <strong>
      <input name="fcodigotitular" type="text" id="fcodigotitular" value="<?php print $envia_cliente; ?>" size="10" maxlength="10" readonly="readonly" />
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Nome:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fnometitular" type="text" id="fnometitular" value="<?php print $envia_nome; ?>" size="50" maxlength="150" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Dt Nascimento:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatanascimentotitular" type="text" id="fdatanascimentotitular" value="<?php print $enviadatanascimento; ?>" size="10" maxlength="10" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Dt Inclusão:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatainclusaotitular" type="text" id="fdatainclusaotitular" value="<?php print $enviadatainclusao; ?>" size="10" maxlength="10" readonly="readonly" />
      </strong></td>
  </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend><strong>	Dados do Dependente / Beneficiário:</strong></legend>
  <table width="680" border="0" cellpadding="1" cellspacing="1">

  <tr>
    <td width="130" align="left" valign="middle"><strong>Codigo:</strong></td>
    <td width="550" align="left" valign="middle"><strong>
      <input name="fcodigodependente" type="text" id="fcodigodependente" value="<?php print $cliente; ?>" size="10" maxlength="10" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Nome:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fnomedependente" type="text" id="fnomedependente" value="<?php print $nome; ?>" size="50" maxlength="150" readonly="readonly" />
    </strong></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><strong>Dt Nascimento:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatanascimentodependente" type="text" id="fdatanascimentodependente" value="<?php print $data_nascimento; ?>" size="11" maxlength="20" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Dt Inclusão:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdatainclusaodependente" type="text" id="fdatainclusaodependente" value="<?php print $data_inclusao; ?>" size="11" maxlength="20" readonly="readonly" />
    </strong></td>
    </tr>
  </table>
  </fieldset>
  
  
  <fieldset>
  <legend><strong>Dados do Produto Regulamentado:</strong></legend>
  <table width="680" border="0" cellpadding="1" cellspacing="1">
  
  <tr align="left" valign="middle">
    <td width="130"><strong>Assistência:</strong></td>
    <td width="550"><strong>
      <input name="fassistencia" type="text" id="fassistencia" value="<?php print $descricao_assistencia; ?>" size="50" maxlength="150" readonly="readonly" />
    </strong></td>
  </tr>
  <tr align="left" valign="middle">
    <td><strong>Produto:</strong></td>
    <td><strong>
      <input name="fprodutoregulamentado" type="text" id="fprodutoregulamentado" value="<?php print $descricao_classificacao; ?>" size="50" maxlength="150" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Acomodação</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="facomodacao" type="text" id="facomodacao" value="ENFERMARIA" size="50" maxlength="150" readonly="readonly" />
    </strong></td>
  </tr>
    </table>
</fieldset>
  

  <fieldset><legend><strong>Dados da Carteira:</strong></legend>
    <table width="680" border="0" cellpadding="1" cellspacing="1">

  <tr>
    <td width="130" align="left" valign="middle"><strong>STATUS:</strong></td>
    <td width="550" align="left" valign="middle"><strong>
    <input name="fstatus" type="text" id="fstatus" value="<?php print $status; ?>" size="15" maxlength="15" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Dt Emissão:</strong></td>
    <td align="left" valign="middle"><strong>
      <input name="fdataemissao" type="text" id="fdataemissao" value="<?php print $data_atual; ?>" size="10" maxlength="10" readonly="readonly" />
    </strong></td>
    </tr>
  <tr>
    <td><strong>Via:</strong></td>
    <td><strong>
      <input name="fvia" type="text" id="fvia" value="<?php print $pega_via; ?>" size="10" maxlength="10" readonly="readonly" />
    </strong></td>
  </tr>
  <tr>
    <td><strong>Dt Validade:</strong></td>
    <td><strong>
      <input name="fdatavalidade" type="text" id="fdatavalidade" value="<?php print $data_validade; ?>" size="10" maxlength="10" readonly="readonly" />
      <span class="style1">* 1 (um) ano de validade.</span></strong></td>
  </tr>
  </table>
</fieldset>
  
    <fieldset><legend><strong>Log's / Auditoria do Sistema:</strong></legend>
    <table width="680" border="0">

    <tr align="left" valign="middle">
      <td width="130"><strong>Data/Hora:</strong></td>
      <td width="550"><strong><?php print $data_final; ?> <?php print $hora; ?> | Usuário: <?php print $loginusuario_atual; ?></strong></td>
    </tr>
    </table>
    </fieldset>

    <fieldset><legend><strong>Concluir Cadastro ou Limpar Campos Preenchidos:</strong></legend>
    <table width="680" border="0">
    <tr align="left" valign="middle">
      <td width="680" align="center">
          <input name="cadastrar" type="submit" id="cadastrar" value="Concluir meu Cadastro!" />
          <br />
          <span class="style1">* Todos os campos s&atilde;o obrigat&oacute;rios!</span></strong>
       </td>
    </tr>
  </table>
  </fieldset>
</form>
<hr>
<table width="680" align="left">
<tr align="left" valign="middle">
    <th width="100" height="0" align="center" valign="middle" scope="col">Carteira</th>
    <th width="460" height="0" scope="col">Titular | Dependente</th>
    <th width="100" height="0" scope="col">Usuário</th>
    <th width="20" scope="col">&nbsp;</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 340px; overflow: auto; vertical-align: left;">
<?php
$sqlcarteira = "SELECT carteira, codigo_titular, nome_titular, data_nascimento_titular, data_inclusao_titular, codigo_dependente, nome_dependente, data_nascimento_dependente, data_inclusao_dependente, produto_regulamentado, assistencia, acomodacao, dataemissao, via, datavalidade, data, hora, usuario FROM carteira WHERE codigo_titular = '$pega_cliente' ORDER BY carteira";
$rscarteira = mysql_query($sqlcarteira);


while(list($carteira, $codigo_titular, $nome_titular, $data_nascimento_titular, $data_inclusao_titular, $codigo_dependente, $nome_dependente, $data_nascimento_dependente, $data_inclusao_dependente, $produto_regulamentado, $assistencia, $acomodacao, $dataemissao, $via, $datavalidade, $data, $hora, $usuario) = mysql_fetch_row($rscarteira)) {
	
#data emissao
$ndata = explode("-",$dataemissao); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_emissao = "$ano/$mes/$dia";

#data validade
$ndata = explode("-",$datavalidade); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_validade = "$ano/$mes/$dia";

$contador++;	
?>
<table width="680" align="left">
  <tr align="left" valign="middle" bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>">
    <td width="100" height="35" align="center" scope="col"><?php print $carteira; ?><br/><?php print $status; ?><br/>Via: <?php print $via; ?></td>
    <td width="460" height="35" scope="col"><?php print $codigo_titular; ?> | <?php print $nome_titular; ?><br/><?php print $codigo_dependente; ?> | <?php print $nome_dependente; ?><br/>Emissão: <?php print $data_emissao; ?> | Validade: <?php print $data_validade; ?></td>
    <td width="100" scope="col"><?php print $usuario; ?><br />
      <?php print $data_final; ?><br />
      <?php print $hora; ?></td>
    <td width="20" height="35" align="center" valign="middle" scope="col">
    <?php
	
	if($assistencia == "COMPLETA" AND $codigo_titular == $codigo_dependente) { 
	$abre_carteira = "fcar_completa.php";
	}
	if($assistencia == "COMPLETA" AND $codigo_titular != $codigo_dependente) { 
	$abre_carteira = "fcar_completa_dependente.php";
	}
	
	if($assistencia == "ODONTOLOGICA" AND $codigo_titular == $codigo_dependente) {
    $abre_carteira = "fcar_odontologica.php";
	}

	if($assistencia == "ODONTOLOGICA" AND $codigo_titular != $codigo_dependente) {
    $abre_carteira = "fcar_odontologica_dependente.php";
	}
	
	if($assistencia == "MEDICA" AND $codigo_titular == $codigo_dependente) {
    $abre_carteira = "fcar_medico.php";
	}

	if($assistencia == "MEDICA" AND $codigo_titular != $codigo_dependente) {
	$abre_carteira = "fcar_medico_dependente.php";
	}
	?>
    <a href="<?php print $abre_carteira; ?>?carteira=<?php print $carteira; ?>" target="_blank"><img src="imagem/ico-printer.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="580" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="240" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="240" align="right" scope="col"></td>
  </tr>
</table>
</div>
</div>
<hr>
</div>
</div>
</body>
</html>