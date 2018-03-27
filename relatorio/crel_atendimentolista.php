<?php
include("../requerido/conexao.php");
include("../requerido/validacao.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

$pega_atendimento = $_GET[atendimento];
$pega_codigo_titular = $_GET[codigo_titular];
$pega_codigo_dependente = $_GET[codigo_dependente];
$pega_nome_titular = $_GET[nome_titular];
$pega_nome_dependente = $_GET[nome_dependente];
$pega_status_titular = $_GET[status_cliente];

		if ($pega_codigo_titular == $pega_codigo_dependente){
		$paciente = "$pega_codigo_titular - $pega_nome_titular (Titular)";
		}else{
		$paciente = "$pega_codigo_dependente - pega_nome_dependente (Dependente)";
		}


?>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("d-m-Y");$hora = date("H:i:s"); ?> às <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<?php 
$sql = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario FROM atendimento WHERE atendimento = '$pega_atendimento'";
$rs = mysql_query($sql);


while(list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	$pega_profissional = $profissional;
	$pega_especialidade = $especialidade;
		
$sqlmedico = "SELECT medico, nome AS nome_medico, area AS area_medico, endereco as endereco_medico, bairro as bairro_medico, cidade as cidade_medico, uf as uf_medico, cep as cep_medico from medico where medico = '$pega_profissional'";
$rsmedico = mysql_query($sqlmedico);

while(list($medico, $nome_medico, $area_medico, $endereco_medico, $bairro_medico, $cidade_medico, $uf_medico, $cep_medico) = mysql_fetch_row($rsmedico)) {		


$sqlarea = "SELECT area, descricao AS nome_especialidade from area where area = '$pega_especialidade'";
$rsarea = mysql_query($sqlarea);

while(list($area, $nome_especialidade) = mysql_fetch_row($rsarea)) {	
	
	
?>
<table width="700" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td width="200" valign="middle"><strong>PROTOCOLO:</strong></td>
      <td width="500" valign="middle"><strong>nº  <?php print $pega_atendimento;?></strong></td>
  </tr>
    <tr>
      <td width="200" valign="middle"><strong>PACIENTE:</strong></td>
      <td width="500" valign="middle"><strong><?php print $paciente;?></strong></td>
  </tr>
</table>
<br/>
 <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="left" valign="middle"> ATENDIMENTO</th>
   </tr>
  <tr>
    <th width="200" align="left" valign="middle">Local:</th>
    <td width="500" valign="middle"><strong><?php print $destino;?></strong></td>
  </tr>
  <tr>
    <th width="200" align="left" valign="middle">Profissional:</th>
    <td width="500" valign="middle"><strong><?php print $nome_medico;?></strong></td>
   </tr>
  <tr>
    <th width="200" align="left" valign="middle">Especialidade:</th>
    <td width="500" valign="middle"><strong><?php print $area_medico;?></strong></td>
   </tr>
  <tr>
    <th width="200" align="left" valign="middle">Endereço:</th>
    <td width="500" valign="middle"><strong><?php print $endereco_medico;?> - Bairro: <?php print $bairro_medico;?> - <?php print $cidade_medico;?>/<?php print $uf_medico;?>, CEP <?php print $cep_medico;?></strong></td>
   </tr>
  <tr>
    <th width="200" align="left" valign="middle">Data e Hora:</th>
    <td width="500" valign="middle"><strong>dia: <?php print data_form($data_agendado);?> às: <?php print hora_form($hora_agendado);?></strong></td>
  </tr>
  <tr>
    <th align="left" valign="middle">Observação:</th>
    <td valign="middle"><strong><?php print $detalhe;?></strong></td>
  </tr>
</table>
  <br/>
  <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="200" align="left" valign="middle">Titular:</th>
    <td width="500" valign="middle"><strong><?php print $pega_codigo_titular;?> - <?php print $pega_nome_titular;?></strong></td>
  </tr>
  </table><br/>
  <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="200" align="left" valign="middle">Dependente:</th>
    <td width="500" align="left" valign="middle"><strong><?php print $pega_codigo_dependente;?> - <?php print $pega_nome_dependente;?></strong></td>
  </tr>
  </table><br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="left" valign="middle">RESPONSÁVEL PELO AGENDAMENTO</th>
  </tr>
  <tr>
    <th width="200" align="left" valign="middle">Usuário, Data e Hora:</th>
    <td width="500" valign="middle"><?php print $usuario ;?>, dia: <?php print data_form($data) ;?> às: <?php print $hora ;?></td>
  </tr>
</table><br/>

<?php
}
}
}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="200" align="left" valign="middle">Emitido por:</th>
    <th width="500" align="left" valign="middle"> <?php print strtoupper($idusuario_atual); ?> | <?php print strtoupper($loginusuario_atual); ?></th>
  </tr>
</table>
<?php    
	if($pega_status_titular == "Recadastrar" or $pega_status_titular == "") {
	echo "<p style='page-break-after:always'></p>";	?>
	<table width="700" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="350" align="left" valign="middle">Data/Hora: <?php print date("d-m-y");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
    <td width="350" align="right" valign="middle">&nbsp;</td>
  </tr>
</table>
<?php
    include("relatorio_cabecalho.php");
?>
<table width="700" border="0" cellpadding="0" cellspacing="0" align="justify">
  <tr>
    <td valign="middle" align="center"><strong><br/>
      <br/>
      TERMO DE ASSENTIMENTO<br/><br/><br/>
    </strong></td>
  </tr>
  <tr>
    <td valign="middle" align="justify"><strong><br/>
      <br/><br/><br/>
      Declaro ter ciência da obrigatoriedade de realizar o meu recadastramento e de meu(s) dependente(s) e/ou agregado(s), junto à Diretoria Administrativa da Associação Beneficente de Saúde dos Militares do Estado de Mato Grosso - ABSM-MT.<br/><br/><br/><br/>
      Declaro também que dou permissão, caso, não proceda ao recadastramento, a ABSM-MT, poderá bloquear os atendimentos médicos, odontológicos e outros, até a concretização do meu recadastramento.<br/><br/><br/><br/>Por ser verdade, firmo o presente, em duas (02) vias de igual teor e forma.<br/><br/><br/><br/>Cuiabá-MT, <?php print date("d-m-Y");$hora = date("H:i:s"); ?> às <?php print date("H:i:s"); ?>,<br/><br/><br/><br/>__________________________________________<br/>Assinatura
    </strong></td>
  </tr>
</table>
<br/>
<hr />
<br/>
<table width="700" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="350" align="left" valign="middle">Data/Hora: <?php print date("d-m-y");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
    <td width="350" align="right" valign="middle">&nbsp;</td>
  </tr>
</table>
<br/>
<?php
    include("relatorio_cabecalho.php");
?>
<table width="700" border="0" cellpadding="0" cellspacing="0" align="justify">
  <tr>
    <td valign="middle" align="center"><strong><br/>
      <br/>
      TERMO DE ASSENTIMENTO<br/><br/><br/>
    </strong></td>
  </tr>
  <tr>
    <td valign="middle" align="justify"><strong><br/>
      <br/><br/><br/>
      Declaro ter ciência da obrigatoriedade de realizar o meu recadastramento e de meu(s) dependente(s) e/ou agregado(s), junto à Diretoria Administrativa da Associação Beneficente de Saúde dos Militares do Estado de Mato Grosso - ABSM-MT.<br/><br/><br/><br/>
      Declaro também que dou permissão, caso, não proceda ao recadastramento, a ABSM-MT, poderá bloquear os atendimentos médicos, odontológicos e outros, até a concretização do meu recadastramento.<br/><br/><br/><br/>Por ser verdade, firmo o presente, em duas (02) vias de igual teor e forma.<br/><br/><br/><br/>Cuiabá-MT, <?php print date("d-m-Y");$hora = date("H:i:s"); ?> às <?php print date("H:i:s"); ?>,<br/><br/><br/><br/>__________________________________________<br/>Assinatura
    </strong></td>
  </tr>
</table>
<?php 	
}	
?>