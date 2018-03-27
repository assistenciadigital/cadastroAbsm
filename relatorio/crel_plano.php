<?php
include("../requerido/conexao.php");

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
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: PLANO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">PLANO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">PLANO</th>
    <th width="450" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
 
$sql = "SELECT plano.plano as codigo_plano, plano.classificacao as codigo_classificacao, classificacao.descricao as nome_classificacao, plano.descricao as nome_descricao, plano.detalhe as nome_detalhe, plano.datainicio as data_inicio, plano.datafim as data_fim,plano.tipo as tipo, plano.indice as indice, plano.valorindice as valor_indice, plano.qtdeindice as qtde_indice, plano.inicio as inicio, plano.fim as fim, plano.valormensal as valor_mensal, plano.desconto as valor_desconto, plano.abatimento as valor_abatimento, plano.acrescimo as valor_acrescimo, plano.valorcobrado as valor_cobrado, plano.data as data, plano.hora as hora, plano.usuario as usuario FROM plano INNER JOIN classificacao ON plano.classificacao = classificacao.classificacao ORDER BY classificacao.descricao, plano.descricao";
$rs = mysql_query($sql);
$soma = 0;

while(list($codigo_plano, $codigo_classificacao, $nome_classificacao, $nome_descricao, $nome_detalhe, $data_inicio, $data_fim, $tipo, $indice, $valor_indice, $qtde_indice, $inicio, $fim, $valor_mensal, $valor_desconto, $valor_abatimento, $valor_acrescimo, $valor_cobrado, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	

	
    if($contador == 15) {
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
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: PLANO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">PLANO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">PLANO</th>
    <th width="450" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
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
    <td width="150" align="center" valign="middle"><?php print $codigo_plano; ?></td>
    <td width="450" valign="middle">Classificação: <?php print $codigo_classificacao; ?> - <?php print $nome_classificacao; ?><br/>Descrição....: <?php print $nome_descricao; ?><br/>
 Detalhe......: <?php print $nome_detalhe; ?><br/>
 Período......: <?php print data_form($data_inicio); ?> - <?php print data_form($data_fim); ?> | Tipo: <?php print $tipo; ?><br/>
 Índice.......: <?php print $indice; ?> | Valor Índice: <?php print $valor_indice; ?> | Qtde: <?php print $qtde_indice; ?>
 Período......: <?php print $inicio; ?> - <?php print $fim; ?> | Valor Mensal: <?php print $valor_mensal; ?> <br/>
 Desconto.....: <?php $valor_desconto; ?> | Abatimento: <?php $valor_abatimento; ?><br/>
 Acrescímo....: <?php $valor_acrescimo; ?> | Valor Cobrado: <?php $valor_cobrado; ?>
 
 
 </td>
    <td width="100" align="left" valign="middle"><?php print $data_final ;?><br/><?php print $hora ;?><br/><?php print $usuario ;?></td>
  </tr>
</table>

<?php
    $contador++;
}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>