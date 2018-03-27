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
<?php
include("../requerido/conexao.php");
include("../requerido/verifica.php");
include("../requerido/validacao.php");

$pega_data_inicio = data_banco($_GET[data_inicio]);
$pega_data_fim = data_banco($_GET[data_fim]);
$pega_profissional = $_GET[profissional];

$sql = "SELECT origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario from atendimento WHERE data_agendado BETWEEN '$pega_data_inicio' AND '$pega_data_fim' OR profissional = '$pega_profissional' ORDER BY data_agendado ASC, hora_agendado ASC";

	$rs = mysql_query($sql);

while(list($origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	
	$pega_titular = $cliente;
	$pega_dependente = $dependente;
	//$pega_profissional = $profissional;

	$data_dependente = data_form($data_dependente);
	$data = data_form($data);
	$nascimento_cliente = data_form($nascimento_cliente);
	$nascimento_dependente = data_form($nascimento_dependente);	
	$anterior = $codigo_cliente;
	$contador++;
	
	// INICIO CALCULO ENTRE DATAS ################################################
 
    // Define os valores a serem usados
    $data_inicial = $data_agendado; // data do agendamento
    $data_final   = date("Y-m-d"); // data atual
	
    // Usa a função strtotime() e pega o timestamp das duas datas:
    $time_inicial = strtotime($data_inicial);
    $time_final = strtotime($data_final);

    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial; // 19522800 segundos

    // Calcula a diferença de dias
    $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias

    // Exibe uma mensagem de resultado:
    //echo "A diferença entre as datas ".$data_inicial." e ".$data_final." é de <strong>".$dias."</strong> dias";
    // A diferença entre as datas 23/03/2009 e 04/11/2009 é de 225 dias
	
	//FIM CALCULO ENTRE DATAS ####################################################
	
 	$contador++;

$sqlcliente = "SELECT nome as nome_titular from cliente where cliente = '$pega_titular'";
$rscliente = mysql_query($sqlcliente);
	
	while(list($nome_titular) = mysql_fetch_row($rscliente)) {

$sqldependente = "SELECT nome as nome_dependente from dependente where dependente = '$pega_dependente'";
$rsdependente = mysql_query($sqldependente);
	
	while(list($nome_dependente) = mysql_fetch_row($rsdependente)) {

$sqlprofissional = "SELECT nome as nome_profissional from medico where medico = '$pega_profissional'";
$rsprofissional = mysql_query($sqlprofissional);
	
	while(list($nome_profissional) = mysql_fetch_row($rsprofissional)) {
?>
<br/>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: RELATÓRIO ANALÍTICO POR MÉDICO<br/>
      Agendamento: entre <?php print data_form($pega_data_inicio);?> e  <?php print data_form($pega_data_fim);?><br/>
      Profissional: <?php print $nome_profissional;?></td>
  </tr>
</table><?php }	?><?php }	?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="center" valign="middle"> RELATÓRIO ANALÍTICO POR MÉDICO</th>
  </tr>
  <tr>
    <th width="600" align="center" valign="middle">CLIENTE | DEPENDENTE</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
 <?php 
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
      <td width="700" valign="middle">Relatorio: RELATÓRIO ANALÍTICO POR MÉDICO<br/>Médico: <?php print $pega_tipo;?> - <?php print $nome_tipo;?><br/>Período: início <?php print $pega_classificacao;?> - fim <?php print $nome_classificacao;?></td>
  </tr>
</table>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="center" valign="middle"> RELATÓRIO ANALÍTICO POR MÉDICO</th>
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
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr bgcolor="<?php
	 if ($dias < 0) {
		 echo "#008000";
	  } elseif ($dias == 0) {
		  echo "#FFFF00";
	  } elseif ($dias == 1){
          echo "#FF0000";;
	  }elseif ($dias > 1){
		  echo "#FF0000";;
	  }
	?>" valign="middle">
    <td width="90" align="left" scope="col"><?php print data_form($data_agendado);?><br />
      <?php print hora_form($hora_agendado);?></td>
    <td width="80" align="left" scope="col"><?php
	 if ($dias < 0) {
		 print "Aguarde";
	  } elseif ($dias == 0) {
		  print "Atenção<br/>Horário";
	  } elseif ($dias == 1){
          print "$dias Dia";
	  }elseif ($dias > 1){
		  print "$dias Dias";
	  }
	print $intervalo;?></td>
    <td width="210" align="left" scope="col"><?php if ($cliente == $dependente){
														print $nome_titular;
														}else{
														print $nome_dependente;}?></td>
    <td width="150" align="left" scope="col"><?php print $motivo;?></td>
    <td width="150" align="left" scope="col"><?php print $nome_profissional;?></td>
  </tr>
</table>
<?php
    $contador++;
}}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="50%" align="left" valign="middle">Quantidade Registro(s): <?php print $registros; ?></th>
    <th width="50%" align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>