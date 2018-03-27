<?php
include("../requerido/conexao.php");
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
      <td width="700" valign="middle">Relatorio: CLASSIFICAÇÃO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">CLASSIFICAÇÃO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">CLASSIFICAÇÃO</th>
    <th width="450" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
$sql = "SELECT classificacao, descricao, detalhe, titular, data, hora, usuario FROM classificacao ORDER BY descricao";
$rs = mysql_query($sql);
$soma = 0;

while(list($classificacao, $descricao, $detalhe, $titular, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
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
      <td width="700" valign="middle">Relatorio: CLASSIFICAÇÃO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">CLASSIFICAÇÃO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">CLASSIFICAÇÃO</th>
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
    <td width="150" align="center" valign="middle"><?php print $classificacao; ?></td>
    <td width="450" valign="middle"><?php print $descricao; ?> - Titular? <?php print $titular; ?><br/><?php print $detalhe; ?></td>
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