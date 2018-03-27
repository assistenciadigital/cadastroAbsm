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
      <td width="700" valign="middle">Relatorio: TIPO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">TIPO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">TIPO</th>
    <th width="450" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
$sql = "SELECT tipo.classificacao AS codigo_classificacao, classificacao.descricao AS descricao_classificacao, tipo.tipo AS codigo_tipo, tipo.descricao AS descricao_tipo, tipo.titular, tipo.data, tipo.hora, tipo.usuario
FROM tipo INNER JOIN classificacao ON tipo.classificacao = classificacao.classificacao
ORDER BY classificacao.descricao, tipo.descricao";
$rs = mysql_query($sql);
$soma = 0;

while(list($codigo_classificacao, $descricao_classificacao, $codigo_tipo, $descricao_tipo, $titular, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
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
      <td width="700" valign="middle">Relatorio: TIPO</td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">TIPO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">TIPO</th>
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
    <td width="150" align="center" valign="middle"><?php print $codigo_tipo; ?></td>
    <td width="450" valign="middle">Classificação: <?php print $codigo_classificacao; ?> - <?php print $descricao_classificacao; ?><br/>Tipo: <?php print $descricao_tipo; ?><br/>Titular? <?php print $titular; ?></td>
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