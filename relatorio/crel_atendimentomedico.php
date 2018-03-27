<?php
include("../requerido/conexao.php");
include("../requerido/validacao.php");

$pega_data_inicio = data_banco($_GET[data_inicio]);
$pega_data_fim = data_banco($_GET[data_fim]);
$pega_destino = $_GET[destino];
$pega_especialidade = $_GET[especialidade];
$pega_motivo = $_GET[motivo];
$pega_profissional = $_GET[profissional];
$pega_status = $_GET[status];

if (!empty($pega_destino)){$where_destino = "atendimento.destino LIKE '$pega_destino' AND ";}
	
if (!empty($pega_especialidade)){
	$tira_ = explode('-',$pega_especialidade);
	$codigo_especialidade = $tira_[0];
	$where_especialidade = "atendimento.especialidade LIKE '$tira_[0]' AND ";
	$descricao_especialidade = $tira_[1];}
	
if (!empty($pega_motivo)){$where_motivo = "atendimento.motivo LIKE '$pega_motivo' AND ";}	

if (!empty($pega_profissional)){
	$tira_ = explode('-',$pega_profissional);
	$codigo_profissional = $tira_[0];
	$where_profissional = "atendimento.profissional LIKE '$tira_[0]' AND ";
	$descricao_profissional = $tira_[1];}
	
if (!empty($pega_status)){$where_status = "atendimento.status_atendimento LIKE '$pega_status' AND ";}	

if (!empty($pega_status)){$where_status = "atendimento.status_atendimento LIKE '$pega_status' AND ";}	

$consulta = "$where_destino$where_especialidade$where_motivo$where_profissional$where_status";
?>

<table width="800" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50%" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="50%" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<table width="800" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100%" valign="middle">Relatorio...: RELATÓRIO ANALÍTICO POR MÉDICO<br/>
      Agendamento.: entre <?php print data_form($pega_data_inicio);?> e  <?php print data_form($pega_data_fim);?><br/>      
     <?php
	 
		if (empty($pega_destino)){print "Destino: --todos--<br/>";}else{print "Destino: $pega_destino<br/>";}
		if (empty($pega_especialidade)){print "Especialidade: --todas--<br/>";}else{print "Especialidade: $descricao_especialidade<br/>";}
		if (empty($pega_motivo)){print "Motivo: --todos--<br/>";}else{print "Motivo: $pega_motivo<br/>";}
		if (empty($pega_profissional)){print "Profissional: --todos--<br/>";}else{print "Profissional: $descricao_profissional<br/>";}
		if (empty($pega_status)){print "Status:--todos--<br/>";}else{print "Status: $pega_status<br/>";}
?></td>
  </tr>
</table>
<br/>
<table width="800" border="1" cellspacing="0" cellpadding="0">
  <tr valign="middle">
    <td width="50" align="center">Prot.<br/>
      nº</td>
    <td width="90" align="center">Data Hora<br/>
Agendado</td>
    <td width="90" align="center">Data Hora<br/>
Atendido </td>
    <td width="450" align="left">T=Titular<br/>
      D=Dependente | P=Paciente<br/>
      Motivo | Profissional | Especialidade | Status</td>
    <td width="120" align="left"><p>Telefone(s)<br/>
      Contato</p></td>
  </tr>
</table>
<?php 

$sql = "SELECT atendimento.atendimento, atendimento.origem, atendimento.destino AS destino_atendimento, atendimento.status_atendimento, cliente.cliente as codigocliente, cliente.codigomilitar, atendimento.cliente AS codigo_titular, cliente.nome AS nome_titular, atendimento.dependente AS codigo_dependente, dependente.nome AS nome_dependente, atendimento.data_agendado, atendimento.hora_agendado, medico.nome AS profissional, area.descricao AS especialidade, atendimento.motivo AS motivo, atendimento.data_atendido, atendimento.hora_atendido, atendimento.status_atendimento, cliente.fonerec, cliente.fonecel1, cliente.fonecel2, cliente.fonecel3, cliente.foneres, cliente.fonecom
FROM (((medico RIGHT JOIN atendimento ON medico.medico = atendimento.profissional) LEFT JOIN cliente ON atendimento.cliente = cliente.cliente) LEFT JOIN dependente ON atendimento.dependente = dependente.dependente) LEFT JOIN area ON atendimento.especialidade = area.area
WHERE $consulta atendimento.data_agendado BETWEEN '$pega_data_inicio' AND '$pega_data_fim'";

/*if (!empty($codigo_profissional)){
$sql = "SELECT atendimento.atendimento, atendimento.origem, atendimento.destino AS destino_atendimento, atendimento.status_atendimento, cliente.codigomilitar, atendimento.cliente AS codigo_titular, cliente.nome AS nome_titular, atendimento.dependente AS codigo_dependente, dependente.nome AS nome_dependente, atendimento.data_agendado, atendimento.hora_agendado, medico.nome AS profissional, area.descricao AS especialidade, atendimento.motivo AS motivo, atendimento.data_atendido, atendimento.hora_atendido, cliente.fonerec, cliente.fonecel1, cliente.fonecel2, cliente.fonecel3, cliente.foneres, cliente.fonecom
FROM (((medico RIGHT JOIN atendimento ON medico.medico = atendimento.profissional) LEFT JOIN cliente ON atendimento.cliente = cliente.cliente) LEFT JOIN dependente ON atendimento.dependente = dependente.dependente) LEFT JOIN area ON atendimento.especialidade = area.area
WHERE atendimento.profissional LIKE '$codigo_profissional' AND atendimento.data_agendado BETWEEN '$pega_data_inicio' AND '$pega_data_fim'";

}else{
 
$sql = "SELECT atendimento.atendimento, atendimento.origem, atendimento.destino AS destino_atendimento, atendimento.status_atendimento, cliente.codigomilitar, atendimento.cliente AS codigo_titular, cliente.nome AS nome_titular, atendimento.dependente AS codigo_dependente, dependente.nome AS nome_dependente, atendimento.data_agendado, atendimento.hora_agendado, medico.nome AS profissional, area.descricao AS especialidade, atendimento.motivo AS motivo, atendimento.data_atendido, atendimento.hora_atendido, cliente.fonerec, cliente.fonecel1, cliente.fonecel2, cliente.fonecel3, cliente.foneres, cliente.fonecom
FROM (((medico RIGHT JOIN atendimento ON medico.medico = atendimento.profissional) LEFT JOIN cliente ON atendimento.cliente = cliente.cliente) LEFT JOIN dependente ON atendimento.dependente = dependente.dependente) LEFT JOIN area ON atendimento.especialidade = area.area
WHERE atendimento.data_agendado BETWEEN '$pega_data_inicio' AND '$pega_data_fim'";
}*/


//atendimento.destino LIKE '$pega_destino' AND 

// and atendimento.destino LIKE '%$pega_destino%' and atendimento.especialidade LIKE '%$pega_especialidade%' and atendimento.motivo LIKE '%$pega_motivo%' and atendimento.profissional LIKE '%$pega_profissional%' and atendimento.status_atendimento LIKE '%$pega_status%' 

//or atendimento.destino LIKE '$pega_destino' and atendimento.especialidade LIKE '$pega_especialidade' and atendimento.motivo LIKE '$pega_motivo' and atendimento.profissional LIKE '$pega_profissional' and atendimento.status_atendimento LIKE '$pega_status'

	$rs = mysql_query($sql);
	$registros = mysql_affected_rows();

while(list($atendimento, $origem, $destino_atendimento, $tatus_atendimento, $codigocliente, $codigomilitar, $codigo_titular, $nome_titular, $codigo_dependente, $nome_dependente, $data_agendado, $hora_agendado, $profissional, $especialidade, $motivo, $data_atendido, $hora_atendido, $status_atendimento, $fonerec, $fonecel1, $fonecel2, $fonecel3, $foneres, $fonecom) = mysql_fetch_row($rs)) {
	
	//str_replace(' ', '',	
	$fonecel1 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel1))));
	$fonecel2 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel2))));
	$fonecel3 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel3))));
	$foneres  = trim(ltrim(rtrim(str_replace(' ', '',$foneres))));
	$fonecom  = trim(ltrim(rtrim(str_replace(' ', '',$fonecom))));
	$fonerec  = trim(ltrim(rtrim(str_replace(' ', '',$fonerec))));
	
	if ($destino_atendimento == "AMBULATORIO"){$destino_atendimento = "AMBULATORIO";}
	if ($destino_atendimento == "CONV.OFT.CL.OLHOS"){$destino_atendimento = "CONVENIO OFTALMO - CLINICA DOS OLHOS";}
	if ($destino_atendimento == "CONV.OFT.HS.OLHOS"){$destino_atendimento = "CONVENIO OFTALMO - HOSPITAL DE OLHOS";}
	if ($destino_atendimento == "CONV.RAIO-X.CEDIC"){$destino_atendimento = "CONVENIO RADIOLOGIA - CEDIC";}
	if ($destino_atendimento == "ELETROCARDIOGRAMA"){$destino_atendimento = "ELETROCARDIOGRAMA";}
	if ($destino_atendimento == "FISIOTERAPIA"){$destino_atendimento = "FISIOTERAPIA";}
	if ($destino_atendimento == "EXAME.LAB.INT.100"){$destino_atendimento = "EXAME LABORATORIAL-INTERNO";}
	if ($destino_atendimento == "EXAME.LAB.EXT.50"){$destino_atendimento = "EXAME LABORATORIAL-EXTERNO";}
	if ($destino_atendimento == "PA"){$destino_atendimento = "PA";}
	if ($destino_atendimento == "ULTRASSONOGRAFIA"){$destino_atendimento = "ULTRASSONOGRAFIA";}
	
	if (!empty($codigomilitar)){$codigoarquivo = $codigomilitar;}else{$codigoarquivo = $codigo_titular;}
		
 	//$contador++;
	
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
	
   if($contador == 14) {
	echo "<p style='page-break-after:always'></p>";	
?>
<table width="800" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50%" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="50%" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<table width="800" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100%" valign="middle">Relatorio...: RELATÓRIO ANALÍTICO<br/>
      Agendamento.: entre <?php print data_form($pega_data_inicio);?> e  <?php print data_form($pega_data_fim);?><br/>      
     <?php
	 
		if (empty($pega_destino))		{print "Destino: --todos--<br/>";}else		{print "Destino: $pega_destino<br/>";}
		if (empty($pega_especialidade))	{print "Especialidade: --todas--<br/>";}else	{print "Especialidade: $descricao_especialidade<br/>";}
		if (empty($pega_motivo))		{print "Motivo: --todos--<br/>";}else		{print "Motivo: $pega_motivo<br/>";}
		if (empty($pega_profissional))	{print "Profissional: --todos--<br/>";}else	{print "Profissional: $descricao_profissional<br/>";}
		if (empty($pega_status))		{print "Status:--todos--<br/>";}else			{print "Status: $pega_status<br/>";}
	?></td>
  </tr>
</table>
<br/>
<table width="800" border="1" cellspacing="0" cellpadding="0">
  <tr valign="middle">
    <td width="50" align="center">Prot.<br/>nº</td>
    <td width="90" align="center">Data Hora<br/>
      Agendado</td>
    <td width="90" align="center">Data Hora<br/> 
    Atendido
</td>
    <td width="450" align="left">T=Titular<br/>
D=Dependente | P=Paciente<br/>
Motivo | Profissional | Especialidade | Status</td>
    <td width="120" align="left"><p>Telefone(s)<br/>Contato</td>
  </tr>
  </table> 
<?php    
  $contador = 0;   
  }
?>
<table width="800" border="1" cellspacing="0" cellpadding="0">
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
    <td width="50" align="center" scope="col"><?php print ($atendimento);?></td>
    <td width="90" align="center" scope="col"><?php print data_form($data_agendado);?><br />
    <?php print hora_form($hora_agendado);?></td>
    <td width="90" align="center" valign="middle" scope="col"><?php
	$data_atendido = data_form($data_atendido);
	$hora_atendido = hora_form($hora_atendido);
	if (!empty($data_atendido) or (!empty($hora_atendido))){
		print "$data_atendido<br/>";
		print $hora_atendido;
	}else{
	 if ($dias < 0) {
		 print "Aguarde";
	  } elseif ($dias == 0) {
		  print "Atenção<br/>Horário";
	  } elseif ($dias == 1){
          print "$dias Dia";
	  }elseif ($dias > 1){
		  print "$dias Dias";
	  }
	}
	print $intervalo;?></td>
    <td width="450" align="left" scope="col">
      <?php 
	    print 'N:'.$codigocliente.'|A:'.$codigomilitar;
		if ($codigo_titular == $codigo_dependente){
			print "|T:$nome_titular<br/>"; //"T:($codigoarquivo) $nome_titular<br/>";
			}else{
			print "|T:$nome_titular<br/>D/P: $nome_dependente<br/>";}//"T:($codigoarquivo) $nome_titular<br/>D/P: $nome_dependente<br/>";}
			print "$motivo ($destino_atendimento) $profissional ($especialidade)<br/>$status_atendimento";
	?>
    </td>
    <td width="120" align="left" scope="col"><?php 
													if (!empty($fonecel1)){print "$fonecel1<br/>";}
													if (!empty($fonecel2)){print "$fonecel2<br/>";}
													if (!empty($fonecel3)){print "$fonecel3<br/>";}
													if (!empty($foneres)){print "$foneres<br/>";}
													if (!empty($fonecom)){print "$fonecom<br/>";}
													if (!empty($fonerec)){print "$fonerec";}?></td>
  </tr>
</table>

<?php
    $contador++;
	}
?>
<table width="800" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="50%" align="left" valign="middle">Quantidade Registro(s): <?php print $registros; ?></th>
    <th width="50%" align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>
