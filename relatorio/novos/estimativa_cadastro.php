<?php
ini_set("display_errors", 0 );
error_reporting(0); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<style type="text/css">
body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 10px;
}
</style>
</head>

<body>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr align="center">
    <td width="100%"><strong>ESTIMATIVA TITULAR</strong></td>
  </tr>
</table>
<br/>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%"><strong>CLASSIFICACAO</strong></td>
    <td width="10%" align="right">Ativo</td>
    <td width="10%" align="right"><strong>Bloqueado</strong></td>
    <td width="10%" align="right"><strong>Excluido</strong></td>
    <td width="10%" align="right"><strong>Inativo</strong></td>
    <td width="10%" align="right"><strong>Recadastrar</strong></td>
    <td width="10%" align="right"><strong>TOTAL</strong></td>
  </tr>
</table>
<?php

include "../../requerido/conexao.php";

$titular = mysql_query ("select
classificacao.descricao as classificacao,
SUM(CASE cliente.status WHEN 'Ativo'       THEN 1 ELSE 0 END) AS 'ativo',
SUM(CASE cliente.status WHEN 'Bloqueado'   THEN 1 ELSE 0 END) AS 'bloqueado',
SUM(CASE cliente.status WHEN 'Excluido'    THEN 1 ELSE 0 END) AS 'excluido',
SUM(CASE cliente.status WHEN 'Inativo'     THEN 1 ELSE 0 END) AS 'inativo',
SUM(CASE cliente.status WHEN 'Recadastrar' THEN 1 ELSE 0 END) AS 'recadastrar',
count(cliente.status) as total
from 
cliente
inner join classificacao
on classificacao.classificacao = cliente.classificacao
GROUP BY classificacao.descricao
ORDER BY classificacao.descricao");
if (mysql_num_rows ($titular)) {
    while ($row_titular= mysql_fetch_assoc($titular)) {
		$i++;
    	if ($i%2) $cor = '#F0F0F0';
			else $cor = '#FFFFFF';
			$soma_ativo       = $soma_ativo       + $row_titular['ativo'];
			$soma_bloqueado   = $soma_bloqueado   + $row_titular['bloqueado'];
			$soma_excluido    = $soma_excluido    + $row_titular['excluido'];
			$soma_inativo     = $soma_inativo     + $row_titular['inativo'];
			$soma_recadastrar = $soma_recadastrar + $row_titular['recadastrar'];
			$soma_total       = $soma_total       + $row_titular['total'];
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%" bgcolor="<?php echo $cor?>"><strong><?php echo $row_titular['classificacao']?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_titular['ativo'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_titular['bloqueado'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_titular['excluido'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_titular['inativo'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_titular['recadastrar'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($row_titular['total'], 0, ',', '.')?></strong></td>
  </tr>
</table>

<?php		
}}
?>

<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%" bgcolor="<?php echo $cor?>"><strong>TOTAL</strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_ativo, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_bloqueado, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_excluido, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_inativo, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_recadastrar, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_total, 0, ',', '.')?></strong></td>
  </tr>
</table>
<br/>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr align="center">
    <td width="100%"><strong>ESTIMATIVA DEPENDENTE</strong></td>
  </tr>
</table>
<br/>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%"><strong>CLASSIFICACAO</strong></td>
    <td width="10%" align="right"><strong>Ativo</strong></td>
    <td width="10%" align="right"><strong>Bloqueado</strong></td>
    <td width="10%" align="right"><strong>Excluido</strong></td>
    <td width="10%" align="right"><strong>Inativo</strong></td>
    <td width="10%" align="right"><strong>Recadastrar</strong></td>
    <td width="10%" align="right"><strong>TOTAL</strong></td>
  </tr>
</table>
<?php
$soma_ativo = 0;
$soma_bloqueado = 0;
$soma_excluido = 0;
$soma_inativo = 0;
$soma_recadastrar = 0;
$soma_total = 0;
 
include "../../requerido/conexao.php";

$dependente = mysql_query ("select
classificacao.descricao as classificacao,
SUM(CASE dependente.status WHEN 'Ativo'       THEN 1 ELSE 0 END) AS 'ativo',
SUM(CASE dependente.status WHEN 'Bloqueado'   THEN 1 ELSE 0 END) AS 'bloqueado',
SUM(CASE dependente.status WHEN 'Excluido'    THEN 1 ELSE 0 END) AS 'excluido',
SUM(CASE dependente.status WHEN 'Inativo'     THEN 1 ELSE 0 END) AS 'inativo',
SUM(CASE dependente.status WHEN 'Recadastrar' THEN 1 ELSE 0 END) AS 'recadastrar',
count(dependente.status) as total
from 
 (classificacao INNER JOIN cliente ON classificacao.classificacao = cliente.classificacao) INNER JOIN dependente ON cliente.codigomilitar = dependente.codigomilitar
WHERE (((dependente.status) Is Not Null))
GROUP BY classificacao.descricao
ORDER BY classificacao.descricao");
if (mysql_num_rows ($dependente)) {
    while ($row_dependente = mysql_fetch_assoc($dependente)) {
		$i++;
    	if ($i%2) $cor = '#F0F0F0';
			else $cor = '#FFFFFF';
			$soma_ativo       = $soma_ativo       + $row_dependente['ativo'];
			$soma_bloqueado   = $soma_bloqueado   + $row_dependente['bloqueado'];
			$soma_excluido    = $soma_excluido    + $row_dependente['excluido'];
			$soma_inativo     = $soma_inativo     + $row_dependente['inativo'];
			$soma_recadastrar = $soma_recadastrar + $row_dependente['recadastrar'];
			$soma_total       = $soma_total       + $row_dependente['total'];
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%" bgcolor="<?php echo $cor?>"><strong><?php echo $row_dependente['classificacao']?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_dependente['ativo'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_dependente['bloqueado'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_dependente['excluido'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_dependente['inativo'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><?php echo number_format($row_dependente['recadastrar'], 0, ',', '.')?></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($row_dependente['total'], 0, ',', '.')?></strong></td>
  </tr>
</table>

<?php		
}}
?>

<table width="100%" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="40%" bgcolor="<?php echo $cor?>"><strong>TOTAL</strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_ativo, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_bloqueado, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_excluido, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_inativo, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_recadastrar, 0, ',', '.')?></strong></td>
    <td width="10%" bgcolor="<?php echo $cor?>" align="right"><strong><?php echo number_format($soma_total, 0, ',', '.')?></strong></td>
  </tr>
</table>


</body>
</html>