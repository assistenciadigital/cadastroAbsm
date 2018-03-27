<?php
include("../requerido/conexao.php");
$pega_classificacao = $_GET[classificacao];
$pega_tipo = $_GET[tipo];
$pega_status = $_GET[status];

$sqlclassificacao = "SELECT descricao as nome_classificacao from classificacao where classificacao = '$pega_classificacao'";
$rsclassificacao = mysql_query($sqlclassificacao);
while(list($nome_classificacao) = mysql_fetch_row($rsclassificacao)) {
	
$sqltipo = "SELECT descricao as nome_tipo from tipo where tipo = '$pega_tipo'";
$rstipo = mysql_query($sqltipo);
while(list($nome_tipo) = mysql_fetch_row($rstipo)) {	
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
      <td width="700" valign="middle"><p>Relatorio: CLIENTE X CLASSIFICAÇÃO X TIPO<br/>Classificação: <?php print $pega_classificacao;?> - <?php print $nome_classificacao;?><br/>
Tipo: <?php print $pega_tipo;?> - <?php print $nome_tipo;?><br/>
Status: <?php print $pega_status;?></td>
  </tr>
</table><?php }	?><?php }	?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">CLIENTE X CLASSIFICAÇÃO X TIPO</th>
  </tr>
  <tr>
    <th width="150" align="center" valign="middle">CLIENTE</th>
    <th width="450" align="left">NOME</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
$sql = "SELECT cliente.cliente AS codigo_cliente, codigomilitar, cliente.nome AS nome_cliente, cliente.assistencia, cliente.status AS descricao_status, cliente.classificacao AS codigo_classificacao, classificacao.descricao AS descricao_classificacao, cliente.tipo AS codigo_tipo, tipo.descricao AS descricao_tipo, cliente.data, cliente.hora, cliente.usuario
FROM (cliente INNER JOIN classificacao ON cliente.classificacao = classificacao.classificacao) INNER JOIN tipo ON cliente.tipo = tipo.tipo WHERE cliente.classificacao = '$pega_classificacao' AND cliente.tipo = '$pega_tipo' AND cliente.status = '$pega_status' ORDER BY cliente.nome";
$rs = mysql_query($sql);
$soma = 0;

$registros = mysql_affected_rows();

while(list($codigo_cliente, $codigomilitar, $nome_cliente, $assistencia, $descricao_status, $codigo_classificacao, $descricao_classificacao, $codigo_tipo, $descricao_tipo, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
	switch($assistencia){
	case "1": $assistencia = "COMPLETA"; break; 
	case "2": $assistencia = "MEDICA"; break;
	case "3": $assistencia = "ODONTOLOGICA"; break;}
	
    if($contador == 16) {
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
      <td width="700" valign="middle">Relatorio: CLIENTE X CLASSIFICAÇÃO X TIPO<br/>Classificação: <?php print $pega_classificacao;?> - <?php print $descricao_classificacao;?><br/>
Tipo: <?php print $pega_tipo;?> - <?php print $descricao_tipo;?><br/>
Status: <?php print $pega_status;?></td>
  </tr>
</table>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="3" align="center" valign="middle">CLIENTE X CLASSIFICAÇÃO X TIPO</th>
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
    <td width="150" align="center" valign="middle"><?php print 'N: '.$codigo_cliente.'<br/>A: '.$codigomilitar; ?></td>
    <td width="450" valign="middle"><?php print $nome_cliente; ?><br/>Assistência: <?php print $assistencia; ?></td>
    <td width="100" align="left" valign="middle"><?php print $data_final ;?><br/><?php print $hora ;?><br/><?php print $usuario ;?></td>
  </tr>
</table>

<?php
    $contador++;
}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="50%" align="left" valign="middle">Quantidade Registro(s): <?php print $registros; ?></th>
    <th width="50%" align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>