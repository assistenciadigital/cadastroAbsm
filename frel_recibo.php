<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and  $nivelusuario_atual != "3" and $nivelusuario_atual != "4")
{
	header("location:menu.php");	
}

$pega_recibo =  $_GET[recibo];

function valor_extenso($valor=0, $maiusculas=false)
{
    // verifica se tem virgula decimal
    if (strpos($valor,",") > 0)
    {
      // retira o ponto de milhar, se tiver
      $valor = str_replace(".","",$valor);
 
      // troca a virgula decimal por ponto decimal
      $valor = str_replace(",",".",$valor);
    }
$singular = array("centavo", "real", "mil", "milhao", "bilhao", "trilhao", "quatrilhao");
$plural = array("centavos", "reais", "mil", "milhoes", "bilhoes", "trilhoes",
"quatrilhÃµes");
 
$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
$u = array("", "um", "dois", "tres", "quatro", "cinco", "seis",
"sete", "oito", "nove");
 
        $z=0;
 
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
		$cont=count($inteiro);
		        for($i=0;$i<$cont;$i++)
                for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];
 
        $fim = $cont - ($inteiro[$cont-1] > 0 ? 1 : 2);
        for ($i=0;$i<$cont;$i++) {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
                $t = $cont-1-$i;
                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")$z++; elseif ($z > 0) $z--;
                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
         if(!$maiusculas)
		 {
          return($rt ? $rt : "zero");
         } elseif($maiusculas == "2") {
          return (strtoupper($rt) ? strtoupper($rt) : "Zero");
         } else {
         return (ucwords($rt) ? ucwords($rt) : "Zero");
         }
 
}
#fim function valor_extenso

$sql_recibo = "SELECT recibo, formapagto, banco, agencia, doctopagto, datadocto, valor as valor_recibo, emitente as emitente_recibo, destinatario as destinatario_recibo, tipo, referencia as referencia_recibo, titular as titular_recibo, mes_ano as mes_ano_recibo, descricao as descricao_recibo, data as data_recibo, hora as hora_recibo, usuario as usuario_recibo from recibo where recibo = '$pega_recibo'";

$rs_recibo = mysql_query($sql_recibo);
while(list($recibo, $formapagto, $banco, $agencia, $doctopagto, $datadocto, $valor_recibo, $emitente_recibo, $destinatario_recibo, $tipo, $referencia_recibo, $titular_recibo, $mes_ano_recibo, $descricao_recibo, $data_recibo, $hora_recibo, $usuario_recibo) = mysql_fetch_row($rs_recibo)) {
	
	
		switch($formapagto){
		case "1": $formadepagto = "CONSIGNADO"; break; 
		case "2": $formadepagto = "DEBITO AUTOMATICO/CONSIGNADO"; break;
		case "3": $formadepagto = "BOLETO"; break;
		case "4": $formadepagto = "DEBITO AUTOMATICO"; break; 
		case "5": $formadepagto = "DINHEIRO"; break;
		case "6": $formadepagto = "CORTESIA AUTORIZADA"; break;		
		case "7": $formadepagto = "CONSIGNADO/BOLETO"; break; 
		case "8": $formadepagto = "CHEQUE A VISTA"; break;
		case "9": $formadepagto = "CHEQUE A PRAZO (PRE DATADO)"; break;		
		case "10": $formadepagto = "CARTAO DE DEBITO"; break;
		case "11": $formadepagto = "CHEQUINHO DA ASP (CONVENIO ASP)"; break;}
	
	
	$pega_titular = $titular_recibo;
	$pega_recibo = $recibo;
	$pega_destinatario = $destinatario_recibo;
	$pega_tipo = $tipo;
	$pega_mes_ano = $mes_ano_recibo;
	$pega_valor = number_format($valor_recibo, 2, ',', '.');
	$pega_extenso = strtoupper(trim(valor_extenso(number_format($valor_recibo, 2, ',', '.'))));
		
$sql_referencia = "SELECT referencia,emitente as emitente_referencia,descricao as descricao_referencia from recibo_referencia where referencia = '$referencia_recibo'";
$rs_referencia = mysql_query($sql_referencia);
while(list($referencia,$emitente_referencia,$descricao_referencia) = mysql_fetch_row($rs_referencia)) {

$sql_emitente = "SELECT emitente,inscricao as inscricao_emitente,razao_social as razao_emitente,nome_fantasia as nome_emitente,cep as cep_emitente,endereco as endereco_emitente,uf as uf_emitente,cidade as cidade_emitente,bairro as bairro_emitente FROM recibo_emitente where emitente = '$emitente_recibo'";
$rs_emitente = mysql_query($sql_emitente);
while(list($emitente,$inscricao_emitente,$razao_emitente,$nome_emitente,$cep_emitente,$endereco_emitente,$uf_emitente,$cidade_emitente,$bairro_emitente) = mysql_fetch_row($rs_emitente)) {
	
	$pega_cidade_emitente = $cidade_emitente;
	$pega_bairro_emitente = $bairro_emitente;
		
	$sql_cidade_emitente = "SELECT descricao as nome_cidade_emitente from cidade where cidade = '$pega_cidade_emitente'";
	$rs_cidade_emitente = mysql_query($sql_cidade_emitente);
	while(list($nome_cidade_emitente) = mysql_fetch_row($rs_cidade_emitente)) {		

	$sql_bairro_emitente = "SELECT descricao as nome_bairro_emitente from bairro where bairro = '$pega_bairro_emitente'";
	$rs_bairro_emitente = mysql_query($sql_bairro_emitente);
	while(list($nome_bairro_emitente) = mysql_fetch_row($rs_bairro_emitente)) {
	
#data
$ndata = explode("-",$data_recibo); 
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
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }


body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url();
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
<table width="680" border="1" cellspacing="1" cellpadding="1">
  <tr align="center" valign="middle">
    <td colspan="2"><strong>
    <?php print $conta_titular;?>
      <?php print $razao_emitente; ?><br/>
      CNPJ: <?php print $inscricao_emitente ;?><br/></strong>
      Endereço: <?php print $endereco_emitente ;?><br/>
      <?php print $nome_bairro_emitente ;?> - <?php print $nome_cidade_emitente ;?> - CEP: <?php print $cep_emitente ;?></td>
    <td width="159">RECIBO:
      <strong>(<?php printf("%04d", $pega_recibo); ?>)</strong><br/><br/>
      VALOR:<strong>(R$<?php print $pega_valor; ?>)</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="justify"><p>
    
    
<?php
if (!empty($pega_destinatario)){
	if ($pega_tipo == 'D') {
	$sql_destinatario = "SELECT destinatario,inscricao as inscricao_destinatario,razao_social as razao_destinatario,nome_fantasia as nome_destinatario,cep as cep_destinatario,endereco as endereco_destinatario,uf as uf_destinatario,cidade as cidade_destinatario,bairro as bairro_destinatario FROM recibo_destinatario where destinatario = '$destinatario_recibo'";
$rs_destinatario = mysql_query($sql_destinatario);
while(list($destinatario,$inscricao_destinatario,$razao_destinatario,$nome_destinatario,$cep_destinatario,$endereco_destinatario,$uf_destinatario,$cidade_destinatario,$bairro_destinatario) = mysql_fetch_row($rs_destinatario)) {	
	
print 'Recebemos de: ';
print $razao_destinatario; 
print ', portador do CPF: ';
print $inscricao_destinatario;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}else{if ($pega_tipo == 'T') {
	$sqltitular = "SELECT nome as nome_cliente, cpf as cpf_cliente FROM cliente WHERE cliente = '$destinatario_recibo'";
    $rstitular = mysql_query($sqltitular);
	while(list($nome_cliente, $cpf_cliente) = mysql_fetch_row($rstitular)) {
	
print 'Recebemos de: ';
print $nome_cliente; 
print ', portador do CPF: ';
print $cpf_cliente;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';
}

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}
}
?>  

<br/>

<?php
if (!empty($pega_titular)){

	$sqlcliente = "SELECT nome as nome_titular, cpf as cpf_titular from cliente where cliente = '$pega_titular'";
	$rscliente = mysql_query($sqlcliente);
	while(list($nome_titular, $cpf_titular) = mysql_fetch_row($rscliente)) {		

print 'Pagamento efetuado ao titular: ' ; 
print $nome_titular; 
print ', CPF: ';
print $cpf_titular;
print '.';
}
}

print '<br/><br/>Recebimento: ';
print $formadepagto;
if (!empty($banco)){print ' (Banco/Agencia: ';print $banco;}
if (!empty($agencia)){print '/';print $agencia;}
if (!empty($doctopagto)){print ' Cheque: ';print $doctopagto;}
if (!empty($datadocto)){print ' Dt: ';print data_form($datadocto);print')';}
//(($datadocto != '0000-00-00') OR 
?>

<br/><br/>Observação: <strong><?php print $descricao_recibo; ?></p></td>
  </tr>
  <tr>
    <td width="226" align="center" valign="bottom"><br/><br/>  
      Assinatura do Emissor</td>
    <td width="277" align="center" valign="bottom">Assinatura do Financeiro</td>
    <td width="159" align="center" valign="bottom"><br/><br/><?php print $nome_cidade_emitente ;?>, <?php print $data_final ;?></td>
    </tr>
  </table>
<p>Emitido por: <?php print strtoupper($idusuario_atual); ?> | <?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual); ?>, em  <?php print $data_final ;?> | <?php print $hora_recibo ;?></p>
<hr>
<table width="680" border="1" cellspacing="1" cellpadding="1">
  <tr align="center" valign="middle">
    <td colspan="2"><strong>
    <?php print $conta_titular;?>
      <?php print $razao_emitente; ?><br/>
      CNPJ: <?php print $inscricao_emitente ;?><br/></strong>
      Endereço: <?php print $endereco_emitente ;?><br/>
      <?php print $nome_bairro_emitente ;?> - <?php print $nome_cidade_emitente ;?> - CEP: <?php print $cep_emitente ;?></td>
    <td width="159">RECIBO:
      <strong>(<?php printf("%04d", $pega_recibo); ?>)</strong><br/><br/>
      VALOR:<strong>(R$<?php print $pega_valor; ?>)</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="justify"><p>
    
    
<?php
if (!empty($pega_destinatario)){
	if ($pega_tipo == 'D') {
	$sql_destinatario = "SELECT destinatario,inscricao as inscricao_destinatario,razao_social as razao_destinatario,nome_fantasia as nome_destinatario,cep as cep_destinatario,endereco as endereco_destinatario,uf as uf_destinatario,cidade as cidade_destinatario,bairro as bairro_destinatario FROM recibo_destinatario where destinatario = '$destinatario_recibo'";
$rs_destinatario = mysql_query($sql_destinatario);
while(list($destinatario,$inscricao_destinatario,$razao_destinatario,$nome_destinatario,$cep_destinatario,$endereco_destinatario,$uf_destinatario,$cidade_destinatario,$bairro_destinatario) = mysql_fetch_row($rs_destinatario)) {	
	
print 'Recebemos de: ';
print $razao_destinatario; 
print ', portador do CPF: ';
print $inscricao_destinatario;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}else{if ($pega_tipo == 'T') {
	$sqltitular = "SELECT nome as nome_cliente, cpf as cpf_cliente FROM cliente WHERE cliente = '$destinatario_recibo'";
    $rstitular = mysql_query($sqltitular);
	while(list($nome_cliente, $cpf_cliente) = mysql_fetch_row($rstitular)) {
	
print 'Recebemos de: ';
print $nome_cliente; 
print ', portador do CPF: ';
print $cpf_cliente;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';
}

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}
}
?>  

<br/>

<?php
if (!empty($pega_titular)){

	$sqlcliente = "SELECT nome as nome_titular, cpf as cpf_titular from cliente where cliente = '$pega_titular'";
	$rscliente = mysql_query($sqlcliente);
	while(list($nome_titular, $cpf_titular) = mysql_fetch_row($rscliente)) {		

print 'Pagamento efetuado ao titular: ' ; 
print $nome_titular; 
print ', CPF: ';
print $cpf_titular;
print '.';
}
}

print '<br/><br/>Recebimento: ';
print $formadepagto;
if (!empty($banco)){print ' (Banco/Agencia: ';print $banco;}
if (!empty($agencia)){print '/';print $agencia;}
if (!empty($doctopagto)){print ' Cheque: ';print $doctopagto;}
if (!empty($datadocto)){print ' Dt: ';print data_form($datadocto);print')';}

?>

<br/><br/>Observação: <strong><?php print $descricao_recibo; ?></p></td>
  </tr>
  <tr>
    <td width="226" align="center" valign="bottom"><br/><br/>  
      Assinatura do Emissor</td>
    <td width="277" align="center" valign="bottom">Assinatura do Financeiro</td>
    <td width="159" align="center" valign="bottom"><br/><br/><?php print $nome_cidade_emitente ;?>, <?php print $data_final ;?></td>
    </tr>
  </table>
<p>Emitido por: <?php print strtoupper($idusuario_atual); ?> | <?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual); ?>, em  <?php print $data_final ;?> | <?php print $hora_recibo ;?></p>
<hr>
<table width="680" border="1" cellspacing="1" cellpadding="1">
  <tr align="center" valign="middle">
    <td colspan="2"><strong>
    <?php print $conta_titular;?>
      <?php print $razao_emitente; ?><br/>
      CNPJ: <?php print $inscricao_emitente ;?><br/></strong>
      Endereço: <?php print $endereco_emitente ;?><br/>
      <?php print $nome_bairro_emitente ;?> - <?php print $nome_cidade_emitente ;?> - CEP: <?php print $cep_emitente ;?></td>
    <td width="159">RECIBO:
      <strong>(<?php printf("%04d", $pega_recibo); ?>)</strong><br/><br/>
      VALOR:<strong>(R$<?php print $pega_valor; ?>)</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="justify"><p>
    
    
<?php
if (!empty($pega_destinatario)){
	if ($pega_tipo == 'D') {
	$sql_destinatario = "SELECT destinatario,inscricao as inscricao_destinatario,razao_social as razao_destinatario,nome_fantasia as nome_destinatario,cep as cep_destinatario,endereco as endereco_destinatario,uf as uf_destinatario,cidade as cidade_destinatario,bairro as bairro_destinatario FROM recibo_destinatario where destinatario = '$destinatario_recibo'";
$rs_destinatario = mysql_query($sql_destinatario);
while(list($destinatario,$inscricao_destinatario,$razao_destinatario,$nome_destinatario,$cep_destinatario,$endereco_destinatario,$uf_destinatario,$cidade_destinatario,$bairro_destinatario) = mysql_fetch_row($rs_destinatario)) {	
	
print 'Recebemos de: ';
print $razao_destinatario; 
print ', portador do CPF: ';
print $inscricao_destinatario;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}else{if ($pega_tipo == 'T') {
	$sqltitular = "SELECT nome as nome_cliente, cpf as cpf_cliente FROM cliente WHERE cliente = '$destinatario_recibo'";
    $rstitular = mysql_query($sqltitular);
	while(list($nome_cliente, $cpf_cliente) = mysql_fetch_row($rstitular)) {
	
print 'Recebemos de: ';
print $nome_cliente; 
print ', portador do CPF: ';
print $cpf_cliente;
print ', a importancia de R$';
print $pega_valor;
print ', (';
print $pega_extenso;
print '), referente a: ';
print $descricao_referencia;
print '.';
}

if (!empty($pega_mes_ano)){
print ' Mês/Ano: ';
print $mes_ano_recibo;	
}

}
}
}
?>  

<br/>

<?php
if (!empty($pega_titular)){

	$sqlcliente = "SELECT nome as nome_titular, cpf as cpf_titular from cliente where cliente = '$pega_titular'";
	$rscliente = mysql_query($sqlcliente);
	while(list($nome_titular, $cpf_titular) = mysql_fetch_row($rscliente)) {		

print 'Pagamento efetuado ao titular: ' ; 
print $nome_titular; 
print ', CPF: ';
print $cpf_titular;
print '.';
}
}

print '<br/><br/>Recebimento: ';
print $formadepagto;
if (!empty($banco)){print ' (Banco/Agencia: ';print $banco;}
if (!empty($agencia)){print '/';print $agencia;}
if (!empty($doctopagto)){print ' Cheque: ';print $doctopagto;}
if (!empty($datadocto)){print ' Dt: ';print data_form($datadocto);print')';}

?>

<br/><br/>Observação: <strong><?php print $descricao_recibo; ?></p></td>
  </tr>
  <tr>
    <td width="226" align="center" valign="bottom"><br/><br/>  
      Assinatura do Emissor</td>
    <td width="277" align="center" valign="bottom">Assinatura do Financeiro</td>
    <td width="159" align="center" valign="bottom"><br/><br/><?php print $nome_cidade_emitente ;?>, <?php print $data_final ;?></td>
    </tr>
  </table>
<p>Emitido por: <?php print strtoupper($idusuario_atual); ?> | <?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual); ?>, em  <?php print $data_final ;?> | <?php print $hora_recibo ;?></p>
<hr>
<?php 
}
}
}
}
}
?>
</body>
</html>