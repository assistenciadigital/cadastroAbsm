<?php
include("../requerido/conexao.php");
include("../requerido/validacao.php");
$pega_classificacao = $_GET[classificacao];
//$pega_tipo = $_GET[tipo];
$pega_status = $_GET[status];

$sqlclassificacao = "SELECT descricao as nome_classificacao from classificacao where classificacao = '$pega_classificacao'";
$rsclassificacao = mysql_query($sqlclassificacao);
while(list($nome_classificacao) = mysql_fetch_row($rsclassificacao)) {
	
/*$sqltipo = "SELECT descricao as nome_tipo from tipo where tipo = '$pega_tipo'";
$rstipo = mysql_query($sqltipo);
while(list($nome_tipo) = mysql_fetch_row($rstipo)) {*/
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
//Tipo: <?php print $pega_tipo; - <?php print $nome_tipo;
?><br/>
<br/>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle"><p>Relatorio: CLIENTE - DEPENDENTE X CLASSIFICAÇÃO X TIPO<br/>Classificação: <?php print $pega_classificacao;?> - <?php print $nome_classificacao;?><br/>
Status: <?php print $pega_status;?></td>
  </tr>
</table><?php }	?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="center" valign="middle">CLIENTE - DEPENDENTE X CLASSIFICAÇÃO X TIPO</th>
  </tr>
  <tr>
    <th width="600" align="center" valign="middle">CLIENTE | DEPENDENTE</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
 
$sql = "SELECT cliente.cliente AS codigo_cliente, cliente.codigomilitar, cliente.nome AS nome_cliente, cliente.datanascimento AS nascimento_cliente, dependente.dependente AS codigo_dependente, dependente.nome AS nome_dependente, dependente.datanascimento AS nascimento_dependente, dependente.sexo AS sexo_dependente, dependente.status AS status_dependente, dependente.data AS data_dependente, dependente.hora AS hora_dependente, dependente.usuario AS usuario_dependente, cliente.assistencia, cliente.status AS descricao_status, cliente.classificacao AS codigo_classificacao, classificacao.descricao AS descricao_classificacao, cliente.tipo AS codigo_tipo, tipo.descricao AS descricao_tipo, cliente.data, cliente.hora, cliente.usuario FROM tipo INNER JOIN ((dependente INNER JOIN cliente ON dependente.titular = cliente.cliente) INNER JOIN classificacao ON cliente.classificacao = classificacao.classificacao) ON tipo.tipo = cliente.tipo WHERE (((cliente.status)='$pega_status') AND ((cliente.classificacao)='$pega_classificacao')) ORDER BY cliente.codigomilitar";
//AND ((cliente.tipo)='$pega_tipo'))

$rs = mysql_query($sql);

$registros = mysql_affected_rows();

while(list($codigo_cliente, $codigomilitar, $nome_cliente, $nascimento_cliente, $codigo_dependente, $nome_dependente, $nascimento_dependente, $sexo_dependente, $status_dependente, $data_dependente, $hora_dependente, $usuario_dependente, $assistencia, $descricao_status, $codigo_classificacao, $descricao_classificacao, $codigo_tipo, $descricao_tipo, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
	switch($assistencia){
	case "1": $assistencia = "COMPLETA"; break; 
	case "2": $assistencia = "MEDICA"; break;
	case "3": $assistencia = "ODONTOLOGICA"; break;}
	
	$anterior = $codigo_cliente;
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
      <td width="700" valign="middle">Relatorio: CLIENTE - DEPENDENTE X CLASSIFICAÇÃO X TIPO<br/>Classificação: <?php print $pega_classificacao;?> - <?php print $descricao_classificacao;?><br/>
Status: <?php print $pega_status;?></td>
  </tr>
</table>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="center" valign="middle">CLIENTE - DEPENDENTE X CLASSIFICAÇÃO X TIPO</th>
  </tr>
  <tr>
    <th width="600" align="center" valign="middle">CLIENTE | DEPEDENTE</th>
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
  <tr bgcolor="<?php if($anterior <> $atual) { echo "#FFFF00"; }?>" valign="middle">
    <td width="600" align="left" valign="middle">
    <?php  if ($anterior <> $atual){
        		$contador_dependente = 0;
		        print "Titular: <strong>A:$codigomilitar | N:$codigo_cliente - $descricao_tipo</strong><br/>";
				print "<strong>$nome_cliente</strong> - Nascimento: ";
				print data_form($nascimento_cliente);	
				print "<br/>Assistência: <strong>$assistencia</strong>";
				}?></td>
    <td width="100" align="left" valign="middle">
	
	<?php if ($anterior <> $atual){
		 		print "$data_final<br/>";
                print "$hora<br/>";
                print $usuario;
				}
				?> </td>
   </tr>
  <tr>
    <td width="600" align="left" valign="middle"><?php $contador_dependente++ ;print "<strong>$contador_dependente</strong>";print "<strong>º</strong> - $codigo_dependente"; ?> - <?php print $nome_dependente; ?> - Nascimento: <?php print data_form($nascimento_dependente); ?><?php print " - Sexo: $sexo_dependente"; ?><br/><?php print "Status: <strong>$status_dependente</strong>"; ?></td>
    <td width="100" align="left" valign="middle"><?php print data_form($data_dependente);?><br/>
      <?php print $hora_dependente;?><br/>
    <?php print $usuario_dependente;?></td>
  </tr>
</table>

<?php
    $contador++;
	$atual = $codigo_cliente;
	}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="50%" align="left" valign="middle">Quantidade Registro(s): <?php print $registros; ?></th>
    <th width="50%" align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>