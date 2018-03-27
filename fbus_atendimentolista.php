<?php
include("requerido/validacao.php");
#nome do usuario

$pega_check = $_GET[fcheck];
$pega_data_inicio = data_banco($_GET[fdata_inicio]);
$pega_data_fim = data_banco($_GET[fdata_fim]);

session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<script>
$(document).ready(function() {
	$('a#print').click(function() {
		window.print();
		return false;
	});
});
</script>

<style type="text/css">

body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 720px;
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>
<?php include("requerido/dataehora.php");?>
</head>

<body>
<div id="tudo">
<div id="conteudo">
<hr>
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Consulta Agendamento | Atendimento | <a href="fcon_atendimentolista.php">Retornar</a></strong>
<hr>
<table width="700" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr valign="middle">
    <th width="80" align="left" valign="middle" scope="col">Protocolo</th>
    <th width="100" height="0" align="left" valign="middle" scope="col">Agendamento</th>
    <th width="100" align="left" scope="col">Atendimento</th>
    <th width="220" align="left" scope="col">Paciente</th>
    <th width="150" align="left" scope="col">Médico / Motivo</th>
    <th width="50" height="0" align="left" scope="col">&nbsp;</th>
    </tr>
</table>
<div style="color:#009; width:720px; height: 372px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$pega_check = $_GET[fcheck];
$pega_data_inicio = data_banco($_GET[fdata_inicio]);
$pega_data_fim = data_banco($_GET[fdata_fim]);
$pega_nome = $_GET[fnome];

if ($pega_check == 1){
$sql = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario from atendimento WHERE data_agendado BETWEEN '$pega_data_inicio' AND '$pega_data_fim' ORDER BY data_agendado ASC, hora_agendado ASC";
}else{
$sql = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario from atendimento WHERE data_atendido BETWEEN '$pega_data_inicio' AND '$pega_data_fim' ORDER BY data_agendado ASC, hora_agendado ASC";
}
	$rs = mysql_query($sql);

while(list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	
	$pega_titular = $cliente;
	$pega_dependente = $dependente;
	$pega_profissional = $profissional;

	$data_dependente = data_form($data_dependente);
	$data = data_form($data);
	$nascimento_cliente = data_form($nascimento_cliente);
	$nascimento_dependente = data_form($nascimento_dependente);	
	$anterior = $codigo_cliente;
	
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

$sqlcliente = "SELECT nome as nome_titular, fonerec, fonecel1, fonecel2, fonecel3, foneres, fonecom from cliente where cliente = '$pega_titular'";
$rscliente = mysql_query($sqlcliente);
	
	while(list($nome_titular, $codigomilitar, $fonerec, $fonecel1, $fonecel2, $fonecel3, $foneres, $fonecom,) = mysql_fetch_row($rscliente)) {
		
	$fonecel1 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel1))));
	$fonecel2 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel2))));
	$fonecel3 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel3))));
	$foneres  = trim(ltrim(rtrim(str_replace(' ', '',$foneres))));
	$fonecom  = trim(ltrim(rtrim(str_replace(' ', '',$fonecom))));
	$fonerec  = trim(ltrim(rtrim(str_replace(' ', '',$fonerec))));

$sqldependente = "SELECT nome as nome_dependente from dependente where dependente = '$pega_dependente'";
$rsdependente = mysql_query($sqldependente);
	
	while(list($nome_dependente) = mysql_fetch_row($rsdependente)) {

$sqlprofissional = "SELECT nome as nome_profissional from medico where medico = '$pega_profissional'";
$rsprofissional = mysql_query($sqlprofissional);
	
	while(list($nome_profissional) = mysql_fetch_row($rsprofissional)) {
?>
<table width="700" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr bgcolor="<?php
	if (!empty($data_atendido) or (!empty($hora_atendido))){
		 echo "#008000";
		}else{
	 if ($dias < 0) {
		 echo "#008000";
	  } elseif ($dias == 0) {
		  echo "#FFFF00";
	  } elseif ($dias == 1){
          echo "#FF0000";;
	  }elseif ($dias > 1){
		  echo "#FF0000";;
	  }
	}
	?>" valign="middle">
    <td width="80" align="center" valign="middle" scope="col"><?php print $atendimento;?></td>
    <td width="100" align="center" valign="middle" scope="col"><?php print data_form($data_agendado);?><br>
    <?php print hora_form($hora_agendado);?></td>
    <td width="100" align="center" scope="col">
	
	
	<?php
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
    <td width="220" align="left" scope="col"><?php if ($cliente == $dependente){
														print $nome_titular;
														}else{
														print $nome_dependente;}?>
          </td>
    <td width="150" align="left" scope="col"><?php print $nome_profissional;?><br/>
      <?php print $motivo;?></td>
    <td width="50" align="center" scope="col"><a href="fcad_atendimento_encerrar.php?atendimento=<?php print $atendimento;?>&check=<?php print $pega_check;?>&data_inicio=<?php print data_form($pega_data_inicio);?>&data_fim=<?php print data_form($pega_data_fim);?>"><img src="imagem/icone_ok.jpg" width="51" height="51" /></a></td>
  </tr>
  </table>
<?php }}}}?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col"></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>