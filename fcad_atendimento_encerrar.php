<?php

include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");

$pega_atendimento = $_GET[atendimento];
$pega_check = $_GET[check];
$pega_data_inicio = ($_GET[data_inicio]);
$pega_data_fim = ($_GET[data_fim]);

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and $nivelusuario_atual != "3")
{
	header("location:menu.php");	
}

$sqlatendimento = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,status_atendimento,data,hora,usuario FROM atendimento WHERE atendimento = '$pega_atendimento'";

$rsatendimento = mysql_query($sqlatendimento);

while(list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$status_atendimento,$data,$hora,$usuario) = mysql_fetch_row($rsatendimento)){
	
	$pega_titular = $cliente;
	$pega_dependente = $dependente;	
	$pega_profissional = $profissional;	
	$pega_especialidade = $especialidade;	
	$pega_detalhe = $detalhe;
	
	$sqlcliente = "select cliente as codigo_titular, nome as nome_titular, datanascimento as nascimento_titular, assistencia from cliente where cliente = '$pega_titular'";
	$rscliente = mysql_query($sqlcliente);
	while(list($codigo_titular, $nome_titular, $nascimento_titular, $assistencia) = mysql_fetch_row($rscliente)){
			
			$dtnascimento_titular = explode("-", $nascimento_titular);
			$idade_titular = date("Y") - $dtnascimento_titular[0];
			$pega_assistencia_titular = $assistencia;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">

function validacampos()
{
if(document.cadastroencerrar.forigem.value=="")
	{
	alert("O Campo origem é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fdestino.value=="")
	{
	alert("O Campo destino é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fprofissional.value=="")
	{
	alert("O Campo profissional é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fespecialidade.value=="")
	{
	alert("O Campo especialidade é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fdataagendamento.value=="")
	{
	alert("O Campo data agendamento é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fhoraagendamento.value=="")
	{
	alert("O Campo hora agendamento é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fmotivo.value=="")
	{
	alert("O Campo motivo é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fdataatendimento.value=="")
	{
	alert("O Campo data atendimento é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fhoraatendimento.value=="")
	{
	alert("O Campo hora atendimento é obrigatório!");
	return false;
	}
else
	if(document.cadastroencerrar.fstatus_atendimento.value=="")
   	{
	alert("O Campo status atendimento é obrigatório!");
	return false;
	}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->


      $(document).ready(function(){
				  $("input[name='fdataagendamento']").mask('99/99/9999');
				  $("input[name='fhoraagendamento']").mask('99:99');
				  $("input[name='fdataatendimento']").mask('99/99/9999');
				  $("input[name='fhoraatendimento']").mask('99:99');				  
  }) 

</script>
<style type="text/css">

.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }


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
width: 700px;
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
<strong>Cadastro Agendamento / Atendimento | <a href="fbus_atendimentolista.php?fcheck=<?php print $pega_check;?>&fdata_inicio=<?php print $pega_data_inicio;?>&fdata_fim=<?php print $pega_data_fim;?>&envia=OK">Retornar</a></strong>
<hr>
<form action="calt_atendimento.php?atendimento=<?php print $pega_atendimento;?>&check=<?php print $pega_check;?>&data_inicio=<?php print $pega_data_inicio;?>&data_fim=<?php print $pega_data_fim;?>" method="post" enctype="multipart/form-data" name="cadastroencerrar" id="cadastroencerrar" onsubmit="return validacampos(); return false;">

<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left" valign="top"><strong>Protocolo: </strong></td>
    <td colspan="3" align="left" valign="top"><strong>
      <label for="fatendimento"></label>
      <input name="fatendimento" type="text" disabled="disabled" id="fatendimento" value="<?php print $pega_atendimento;?>" size="10" maxlength="10" readonly="readonly" />
      <label for="ftitular"></label>
      <input name="ftitular" type="text" disabled="disabled" id="ftitular" style="background: transparent; border: transparent;font-style:normal; color: transparent" value="<?php print $pega_titular;?>" readonly="readonly" />
      <label for="fdependente"></label>
      <input name="fdependente" type="text" disabled="disabled" id="fdependente" style="background: transparent; border: transparent;font-style:normal; color: transparent" value="<?php print $pega_dependente;?>" readonly="readonly"<?php print $pega_dependente;?> />
    </strong></td>
  </tr>
  <tr>
    <td width="170" align="left" valign="top"><strong>Origem:</strong></td>
    <td width="170" align="left" valign="top"><strong>
      <select name="forigem" id="forigem" style="width:200px">
        <option value="<?php print $origem; ?>"><?php print $origem; ?></option>
        <option value=""></option>
        <option value="PESSOALMENTE">PESSOALMENTE</option>
        <option value="TELEFONE">TELEFONE</option>
        <option value="E-MAIL">E-MAIL</option>
        </select>
      </strong><script language="JavaScript"> document.cadastroencerrar.forigem.focus(); </script></td>
    <td width="170" align="left" valign="top"><strong>Destino: </strong></td>
    <td width="170" align="left" valign="top"><strong>
      <select name="fdestino" id="fdestino" style="width:200px">
        <option value="<?php print $destino; ?>"><?php 
										if ($destino == "AMBULATORIO"){print "AMBULATORIO";}
										if ($destino == "CONV.OFT.CL.OLHOS"){print "CONVENIO OFTALMO - CLINICA DOS OLHOS";}
										if ($destino == "CONV.OFT.HS.OLHOS"){print "CONVENIO OFTALMO - HOSPITAL DE OLHOS";}
										if ($destino == "CONV.RAIO-X.CEDIC"){print "CONVENIO RADIOLOGIA - CEDIC";}
										if ($destino == "ELETROCARDIOGRAMA"){print "ELETROCARDIOGRAMA";}
										if ($destino == "FISIOTERAPIA"){print "FISIOTERAPIA";}
										if ($destino == "EXAME.LAB.INT.EXT"){print "EXAME LABORATORIAL-INT/EXT";}
										if ($destino == "EXAME.LAB.INT.100"){print "EXAME LABORATORIAL-INTERNO";}
										if ($destino == "EXAME.LAB.EXT.50"){print "EXAME LABORATORIAL-EXTERNO";}
										if ($destino == "PA"){print "PA";}
										if ($destino == "ULTRASSONOGRAFIA"){print "ULTRASSONOGRAFIA";}?></option>
        <option value=""></option>
        <option value="AMBULATORIO">AMBULATORIO</option>
        <option value="CONV.OFT.CL.OLHOS">CONVENIO OFTALMO - CLINICA DOS OLHOS</option>
        <option value="CONV.OFT.HS.OLHOS">CONVENIO OFTALMO - HOSPITAL DE OLHOS</option>
        <option value="CONV.RAIO-X.CEDIC">CONVENIO RADIOLOGIA - CEDIC</option>
        <option value="ELETROCARDIOGRAMA">ELETROCARDIOGRAMA</option>
        <option value="FISIOTERAPIA">FISIOTERAPIA</option>
        <option value="EXAME.LAB.INT.EXT">EXAME LABORATORIAL-INTERNO/EXTERNO</option>
        <option value="EXAME.LAB.INT.100">EXAME LABORATORIAL-INTERNO 100% COOP</option>
        <option value="EXAME.LAB.EXT.50">EXAME LABORATORIAL-EXTERNO 50% COOP</option>
        <option value="PA">PA</option>
        <option value="ULTRASSONOGRAFIA">ULTRASSONOGRAFIA</option>
        </select>
      </strong></td>
  </tr>
  <tr>
    <td width="170" align="left"><strong>Profissional:</strong></td>
    <td width="170" align="left"><strong>
      <select name="fprofissional" id="fprofissional" style="width:200px">
		<?php 
		$sqlmedico = "select medico, nome as nome_profissional, limite from medico where medico = '$pega_profissional'";
		$rsmedico = mysql_query($sqlmedico);
		while(list($medico, $nome_profissional) = mysql_fetch_row($rsmedico)) { ?>
          <option value="<?php print $medico; ?>"><?php print $nome_profissional; }?></option>
          <option value=""></option>
        <?php
		switch($pega_assistencia_titular){
		case "1": $sqlmedico = "SELECT * FROM medico ORDER BY nome"; break;//COMPLETA
		case "2": $sqlmedico = "SELECT * FROM medico WHERE especialidade = 'MEDICO' ORDER BY nome"; break;//MEDICA
		case "3": $sqlmedico = "SELECT * FROM medico WHERE especialidade = 'ODONTOLOGIA' ORDER BY nome"; break;}//ODONTOLOGICA

        $rsmedico = mysql_query($sqlmedico) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsmedico)){
            echo '<option value="'.$ln['medico'].'">'.$ln['nome'].' | '.$ln['limite'].'</option>';}
      ?>
      </select>
    </strong></td>
    <td width="170" align="left"><strong>Especialidade: </strong></td>
    <td width="170" align="left"><strong>
      <select name="fespecialidade" id="fespecialidade" style="width:200px">
		<?php 
		$sqlespecialidade = "select area as codigo_area, descricao as descricao_area FROM area where area= '$pega_especialidade'";
		$rsespecialidade = mysql_query($sqlespecialidade);
		while(list($medico, $nome_profissional) = mysql_fetch_row($rsespecialidade)) { ?>
          <option value="<?php print $medico; ?>"><?php print $nome_profissional; }?></option>
          <option value=""></option>
        <?php
		switch($pega_assistencia_titular){
		case "1": $sqlespecialidade = "SELECT area as codigo_area, descricao as descricao_area FROM area ORDER BY descricao"; break;//COMPLETA
		case "2": $sqlespecialidade = "SELECT area as codigo_area, descricao as descricao_area FROM area WHERE especialidade = 'M' ORDER BY descricao"; break;//MEDICA
		case "3": $sqlespecialidade = "SELECT area as codigo_area, descricao as descricao_area FROM area WHERE especialidade = 'O' ORDER BY descricao"; break;}//ODONTOLOGICA
		
        $rsespecialidade = mysql_query($sqlespecialidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsespecialidade)){
            echo '<option value="'.$ln['codigo_area'].'">'.$ln['descricao_area'].'</option>';}
      ?>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td width="170" align="left"><strong> Agendamento:</strong></td>
    <td width="170" align="left"><strong>
      <input name="fdataagendamento" type="text" id="fdataagendamento" value="<?php print data_form($data_agendado);?>" size="10" maxlength="10" />
      - 
      <input name="fhoraagendamento" type="text" id="fhoraagendamento" value="<?php print hora_form($hora_agendado);?>" size="5" maxlength="5" />
      </strong></td>
    <td width="170" align="left"><strong>Motivo:</strong></td>
    <td width="170" align="left"><strong>
      <select name="fmotivo" id="fmotivo" style="width:200px">
        <option value="<?php print $motivo;?>"><?php print $motivo;?></option>
        <option value=""></option>
        <option value="CONSULTA">CONSULTA</option>
        <option value="EMERGENCIA">EMERGENCIA</option>
        <option value="ENCAIXE">ENCAIXE</option>
        <option value="EXAME">EXAME</option>
        <option value="PA">PRONTO ATENDIMENTO</option>
        <option value="URGENCIA">URGENCIA</option>
        </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Observação: </strong></td>
    <td colspan="3" align="left" valign="top"><textarea name="fdetalhe" cols="59" rows="2" id="fdetalhe" value="$pega_detalhe"><?php print $detalhe;?></textarea></td>
  </tr>
  <tr bgcolor="#FFFF66">
    <td align="left"><strong> Conclusão:</strong></td>
    <td colspan="3" align="left"><strong>
      <input name="fdataatendimento" type="text" id="fdataatendimento" value="<?php print data_form($data_atendido);?>" size="10" maxlength="10" />-<input name="fhoraatendimento" type="text" id="fhoraatendimento" value="<?php print hora_form($hora_atendido);?>" size="5" maxlength="5" />
      Motivo:
      <select name="fstatus_atendimento" id="fstatus_atendimento" style="width:310px">
        <option value="<?php print $status_atendimento;?>"><?php print $status_atendimento;?></option>
        <option value="Atendimento data/hora informada">Atendimento data/hora informada</option>
        <option value="Cancelamento Justificado-Paciente Ausente">Cancelamento Justificado-Paciente Ausente</option>
        <option value="Cancelamento Nao Justificado-Paciente Ausente">Cancelamento Nao Justificado-Paciente Ausente</option>
        <option value="Cancelamento Justificado-Profissional Ausente">Cancelamento Justificado-Profissional Ausente</option>
        <option value="Cancelamento Nao Justificado-Profissional Ausente">Cancelamento Nao Justificado-Profissional Ausente</option>
        <option value="Cancelamento Justificado-Estabelecimento">Cancelamento Justificado-Estabelecimento</option>
        </select>
    </strong></td>
    </tr>
  <tr bgcolor="#FFFF66">
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td colspan="3" align="left" bgcolor="#FFFFFF"><input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
  </table>
</form>
<?php }} ?>
</div>
</div>
</div>
</body>
</html>