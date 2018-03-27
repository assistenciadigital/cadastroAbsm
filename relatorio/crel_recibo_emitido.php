<?php
include("conexao.php");
?>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
</br>
<?php
include("relatorio_cabecalho.php");
?>
</br>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: RECIBO EMITIDO</td>
  </tr>
</table>
</br>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="5" align="center" valign="middle">RELATÓRIO RECIBOS EMITIDOS NO PERÍODO</th>
  </tr>
  <tr>
    <th width="60" align="center" valign="middle">RECIBO</th>
    <th width="100" align="right" valign="middle">VALOR R$</th>
    <th width="100">EMITENTE</th>
    <th width="340">FAVORECIDO / DESCRICAO</th>
    <th width="100">DATA</th>
  </tr>
  </table>
 <?php 
  $sql_recibo = "SELECT recibo,valor,emitente,referencia,destinatario,tipo,titular,mes_ano,descricao,data,hora,usuario from recibo where emitente = '1' or emitente = '2' order by emitente, data";

$rs_recibo = mysql_query($sql_recibo);
$soma = 0;
$contador = 0;
while(list($recibo,$valor,$emitente,$referencia,$destinatario,$tipo,$titular,$mes_ano,$descricao,$data,$hora,$usuario) = mysql_fetch_row($rs_recibo)) {
	
	$sql_emitente = "SELECT emitente,inscricao as inscricao_emitente,razao_social as razao_emitente,nome_fantasia as nome_emitente FROM recibo_emitente where emitente = '$emitente'";
$rs_emitente = mysql_query($sql_emitente);
while(list($emitente,$inscricao_emitente,$razao_emitente,$nome_emitente) = mysql_fetch_row($rs_emitente)) {

    if($contador == 15) {
	echo "<p style='page-break-after:always'></p>";
	
	#data
	$ndata = explode("-",$data); 
	$dia = $ndata[0];
	$mes = $ndata[1];
	$ano = $ndata[2];
	$data_final = "$ano/$mes/$dia";
?>

<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
</br>
<?php
include("relatorio_cabecalho.php");
?>
</br>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: RECIBO EMITIDO</td>
  </tr>
</table>
</br>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="5" align="center" valign="middle">RELATÓRIO RECIBOS EMITIDOS NO PERÍODO</th>
  </tr>
  <tr>
    <th width="60" align="center" valign="middle">RECIBO</th>
    <th width="100" align="right" valign="middle">VALOR R$</th>
    <th width="100">EMITENTE</th>
    <th width="340">FAVORECIDO / DESCRICAO</th>
    <th width="100">DATA</th>
  </tr>
  </table>
  
<?php    
        $contador = 0;
    }
    
?>
 <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" align="center" valign="middle"><?php print $recibo; ?></td>
    <td width="100" align="right" valign="middle"><?php print number_format($valor, 2, ',', '.'); ?></td>
    <td width="100" valign="middle"><?php print $inscricao_emitente; ?></br><?php print $nome_emitente; ?></td>
    <td width="340" valign="middle">
    
	<?php	if ($tipo == 'D') {
	$sql_destinatario = "SELECT inscricao as inscricao_destinatario,razao_social as razao_destinatario,nome_fantasia as nome_destinatario FROM recibo_destinatario where destinatario = '$destinatario'";
	$rs_destinatario = mysql_query($sql_destinatario);
	while(list($inscricao_destinatario,$razao_destinatario,$nome_destinatario) = mysql_fetch_row($rs_destinatario)) {?>
	<?php print $inscricao_destinatario; ?> - <?php print $nome_destinatario; }}?>

	<?php if ($tipo == 'T') {
	$sqltitular = "SELECT nome as nome_cliente, cpf as cpf_cliente FROM cliente WHERE cliente = '$destinatario'";
    $rstitular = mysql_query($sqltitular);
	while(list($nome_cliente, $cpf_cliente) = mysql_fetch_row($rstitular)) { ?>
	<?php print $cpf_cliente; ?> - <?php print $nome_cliente; }}?>

	<?php if (!empty($descricao)){
	print "</br>$descricao";}?>
	
	<?php if (!empty($referencia)){
	$sql_referencia = "SELECT descricao as descricao_referencia from recibo_referencia where emitente = '$emitente' and referencia = '$referencia'";
	$rs_referencia = mysql_query($sql_referencia);
	while(list($descricao_referencia) = mysql_fetch_row($rs_referencia)) {	
	print "</br>$descricao_referencia";	}}?>
	
	<?php if (!empty($mes_ano)){
	print "</br>$mes_ano";	}?>
    
    </td>
    <td width="100" valign="middle"><?php print $data_final ;?></br><?php print $hora ;?></br><?php print $usuario ;?></td>
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
    <th width="700" align="center" valign="middle">TOTAL R$ <?php print number_format($soma_valor_recibo, 2, ',', '.') ;?> </th>
  </tr>
</table>