<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>
</head>
<body>

<?php
include("../requerido/conexao.php");

$pega_recibo_inicial = $_GET[recibo_inicial];
$pega_recibo_final = $_GET[recibo_final];
$pega_periodo_inicial = data_banco($_GET[periodo_inicial]);
$pega_periodo_final = data_banco($_GET[periodo_final]);
$pega_emitente = $_GET[emitente];
$pega_referencia = $_GET[referencia]; 

// Formata data aaaa-mm-dd para dd/mm/aaaa
function data_form($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}
 
// Formata data dd/mm/aaaa para aaaa-mm-dd
function data_banco($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}

?>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<form id="form1" name="form1" action="">
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">
      Relatorio: RECIBO - RECEBIMENTO<br/>
      RECIBO INICIAL Nº: <?php print $pega_recibo_inicial;?> e RECIBO FINAL Nº: <?php print $pega_recibo_final;?><br/>
      PERÍODO INICIAL: <?php print $_GET[periodo_inicial];?> e PERÍODO FINAL: <?php print $_GET[periodo_final];?></td>
  </tr>
</table>
</form>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="5" align="center" valign="middle">RECEBIMENTO</th>
  </tr>
  <tr>
    <th width="60" align="center" valign="middle">RECIBO</th>
    <th width="100" align="center" valign="middle">DATA</th>
    <th width="100">FAVORECIDO</th>
    <th width="340">EMITENTE / DESCRICAO</th>
    <th width="100" align="right">VALOR R$</th>
  </tr>
  </table>
 <?php 
 
 if (!empty($pega_referencia)){
  $sql_recibo = "SELECT recibo, valor, emitente, referencia, destinatario, tipo, titular, mes_ano, descricao, data, hora, usuario from recibo where (emitente BETWEEN 1 and 2 and referencia = '$pega_referencia' and recibo BETWEEN '$pega_recibo_inicial' AND '$pega_recibo_final' and data BETWEEN '$pega_periodo_inicial' AND '$pega_periodo_final') order by data, hora, emitente";
 }else{
$sql_recibo = "SELECT recibo, valor, emitente, referencia, destinatario, tipo, titular, mes_ano, descricao, data, hora, usuario from recibo where (emitente BETWEEN 1 and 2 and recibo BETWEEN '$pega_recibo_inicial' AND '$pega_recibo_final' and data BETWEEN '$pega_periodo_inicial' AND '$pega_periodo_final') order by data, hora, emitente";	 
}

$rs_recibo = mysql_query($sql_recibo);
$soma = 0;

while(list($recibo,$valor,$emitente,$referencia,$destinatario,$tipo,$titular,$mes_ano,$descricao,$data,$hora,$usuario) = mysql_fetch_row($rs_recibo)) {
	
	$sql_emitente = "SELECT emitente,inscricao as inscricao_emitente,razao_social as razao_emitente,nome_fantasia as nome_emitente FROM recibo_emitente where emitente = '$emitente'";
$rs_emitente = mysql_query($sql_emitente);
while(list($emitente,$inscricao_emitente,$razao_emitente,$nome_emitente) = mysql_fetch_row($rs_emitente)) {

    if($contador == 17) {
	echo "<p style='page-break-after:always'></p>";
?>

<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<form id="form2" name="form2" method="post" action="">
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">
      Relatorio: RECIBO - RECEBIMENTO<br/>
      RECIBO INICIAL Nº: <?php print $pega_recibo_inicial?> e RECIBO FINAL Nº: <?php print $pega_recibo_final?><br/>
      PERÍODO INICIAL: <?php print $pega_periodo_inicial?> e PERÍODO FINAL: <?php print $pega_periodo_final?></td>
  </tr>
</table>
</form>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="5" align="center" valign="middle">RECEBIMENTO</th>
  </tr>
  <tr>
    <th width="60" align="center" valign="middle">RECIBO</th>
    <th width="100" align="center" valign="middle">DATA</th>
    <th width="100">FAVORECIDO</th>
    <th width="340">EMITENTE / DESCRICAO</th>
    <th width="100" align="right">VALOR R$</th>
  </tr>
  </table>
  
<?php
  $contador = 0;
  }    
?>

<?php #data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>

 <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" align="center" valign="middle"><?php print $recibo; ?></td>
    <td width="100" align="center" valign="middle"><?php print $data_final ;?><br/>
      <?php print $hora ;?><br/>
    <?php print $usuario ;?></td>
    <td width="100" valign="middle"><?php print $inscricao_emitente; ?><br/><?php print $nome_emitente; ?></td>
    <td width="340" valign="middle">
    
	<?php	if ($tipo == 'D') {
	$sql_destinatario = "SELECT inscricao as inscricao_destinatario,razao_social as razao_destinatario,nome_fantasia as nome_destinatario FROM recibo_destinatario where destinatario = '$destinatario'";
	$rs_destinatario = mysql_query($sql_destinatario);
	while(list($inscricao_destinatario,$razao_destinatario,$nome_destinatario) = mysql_fetch_row($rs_destinatario)) {?>
	<?php print $inscricao_destinatario; ?> - <?php print $razao_destinatario; }}?>

	<?php if ($tipo == 'T') {
	$sqltitular = "SELECT nome as nome_cliente, cpf as cpf_cliente FROM cliente WHERE cliente = '$destinatario'";
    $rstitular = mysql_query($sqltitular);
	while(list($nome_cliente, $cpf_cliente) = mysql_fetch_row($rstitular)) { ?>
	<?php print $cpf_cliente; ?> - <?php print $nome_cliente; }}?>

	<?php if (!empty($descricao)){
	print "<br/>$descricao";}?>
	
	<?php if (!empty($referencia)){
	$sql_referencia = "SELECT descricao as descricao_referencia from recibo_referencia where emitente = '$emitente' and referencia = '$referencia'";
	$rs_referencia = mysql_query($sql_referencia);
	while(list($descricao_referencia) = mysql_fetch_row($rs_referencia)) {	
	print "<br/>$descricao_referencia";	}}?>
	
	<?php if (!empty($mes_ano)){
	print " - $mes_ano";	}?>
    
    </td>
    <td width="100" align="right" valign="middle"><?php print number_format($valor, 2, ',', '.'); ?></td>
  </tr>
</table>

<?php
    $contador++;
	$soma_valor_recibo = $soma_valor_recibo + $valor; 
}
}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="350" align="left" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
    <th width="350" align="right" valign="middle">TOTAL R$ <?php print number_format($soma_valor_recibo, 2, ',', '.') ;?></th>
  </tr>
</table>
</body>
</html>