<?php

include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");

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
$pega_codigo_titular = $_GET[codigo_titular];
$pega_codigo_dependente = $_GET[codigo_dependente];
$pega_nome_titular = $_GET[nome_titular];
$pega_nome_dependente = $_GET[nome_dependente];
$pega_status_cliente = $_GET[status_cliente];

$sqltesta1consulta = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario FROM atendimento WHERE cliente = '$pega_codigo_titular' AND dependente = '$pega_codigo_dependente' ORDER BY data_agendado, hora_agendado";

$rstesta1consulta = mysql_query($sqltesta1consulta);

while(list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$data,$hora,$usuario) = mysql_fetch_row($rstesta1consulta)) {

$testa1consulta++;
}

if($pega_status_cliente == "Ativo" or $pega_status_cliente == "Recadastrar" and $testa1consulta == 0){ //or $pega_status_cliente == "Bloqueado"
	$pega_status_cliente = "Ativo";
	}
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
if(document.cadastro.fstatus_cliente.value!="Ativo")
	{
	alert("Impossível prosseguir, favor procure o Cadastro para maiores informações!");
	return false;
	}
else
if(document.cadastro.forigem.value=="")
	{
	alert("O Campo origem é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdestino.value=="")
	{
	alert("O Campo destino é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fprofissional.value=="")
	{
	alert("O Campo profissional é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fespecialidade.value=="")
	{
	alert("O Campo especialidade é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdataagendamento.value=="")
	{
	alert("O Campo data agendamento é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fhoraagendamento.value=="")
	{
	alert("O Campo hora agendamento é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fmotivo.value=="")
	{
	alert("O Campo motivo é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fmotivo.value=="")
	{
	alert("O Campo motivo é obrigatório!");
	return false;
	}
else

return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdataagendamento']").mask('99/99/9999');
				  $("input[name='fhoraagendamento']").mask('99:99');
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
<strong>Cadastro  Agendamento | <a href="fcon_atendimento.php">Retornar</a></strong>
<hr>

<form action="ccad_atendimento.php?codigo_titular=<?php print $pega_codigo_titular;?>&nome_titular=<?php print $pega_nome_titular;?>&codigo_dependente=<?php print $pega_codigo_dependente;?>&nome_dependente=<?php print $pega_nome_dependente;?>&status_cliente=<?php $pega_status_cliente;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="170" align="left" valign="top"><strong>Titular: </strong></td>
    <td colspan="3" align="left" valign="top"><strong><?php print $pega_codigo_titular;?> - <?php print $pega_nome_titular;?><input name="fstatus_cliente" type="text" disabled="disabled" id="fstatus_cliente"  style="border-color:transparent; background-color:transparent; font-style:normal; color: transparent"  value="<?php print $pega_status_cliente;?>" size="11" maxlength="11" readonly="readonly" />
    </strong></td>
    </tr>
  <tr>
    <td width="170" align="left" valign="top"><strong>Dependente: </strong></td>
    <td colspan="3" align="left" valign="top"><strong><?php print $pega_codigo_dependente;?> - <?php print $pega_nome_dependente;?></strong></td>
    </tr>
  <tr>
    <td width="170" align="left" valign="top"><strong>Origem:</strong></td>
    <td width="170" align="left" valign="top"><strong>
      <select name="forigem" id="forigem" style="width:200px">
        <option value=""></option>
        <option value="PESSOALMENTE">PESSOALMENTE</option>
        <option value="TELEFONE">TELEFONE</option>
        <option value="E-MAIL">E-MAIL</option>
      </select>
    </strong></td>
    <td width="170" align="left" valign="top"><strong>Destino: </strong></td>
    <td width="170" align="left" valign="top"><strong>
      <select name="fdestino" id="fdestino" style="width:200px">
        <option value=""></option>
        <option value="AMBULATORIO">AMBULATORIO</option>
        <option value="PA">PA</option>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td width="170" align="left"><strong>Profissional</strong></td>
    <td width="170" align="left"><strong>
      <select name="fprofissional" id="fprofissional" style="width:200px">
        <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         $sqlmedico = "SELECT * FROM medico ORDER BY nome";
         $rsmedico = mysql_query($sqlmedico) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsmedico)){
            echo '<option value="'.$ln['medico'].'">'.$ln['nome'].'</option>';
         }
      ?>
      </select>
    </strong></td>
    <td width="170" align="left"><strong>Especialidade: </strong></td>
    <td width="170" align="left"><strong>
      <select name="fespecialidade" id="fespecialidade" style="width:200px">
        <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         $sqlarea = "SELECT * FROM area ORDER BY descricao";
         $rsarea = mysql_query($sqlarea) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsarea)){
            echo '<option value="'.$ln['area'].'">'.$ln['descricao'].'</option>';
         }
      ?>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td width="170" align="left"><strong> Agendamento:</strong></td>
    <td width="170" align="left"><strong>
      <input name="fdataagendamento" type="text" id="fdataagendamento" size="10" maxlength="10" />
      - 
      <input name="fhoraagendamento" type="text" id="fhoraagendamento" size="5" maxlength="5" />
      </strong></td>
    <td width="170" align="left"><strong>Motivo:</strong></td>
    <td width="170" align="left"><strong>
      <select name="fmotivo" id="fmotivo" style="width:200px">
        <option value=""></option>
        <option value="CONSULTA">CONSULTA</option>
        </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="top"><strong>Observação: </strong></td>
    <td colspan="3" align="left" valign="top"><textarea name="fdetalhe" id="fdetalhe" cols="50" rows="2"></textarea>
   <input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
  </table>
</form>
<hr>
<table width="670" align="left">
  <tr valign="middle">
    <th width="100" height="0" align="center" scope="col"><strong>Agendamento</strong></th>
    <th width="170" height="0" align="left" scope="col">Paciente</th>
    <th width="170" align="left" scope="col">Médico</th>
    <th width="170" height="0" align="left" scope="col">Motivo</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 200px; overflow: auto; vertical-align: left;">

<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");

$sql = "SELECT atendimento,origem,destino,cliente,dependente,data_agendado,hora_agendado,profissional,especialidade,motivo,detalhe,data_atendido,hora_atendido,data,hora,usuario FROM atendimento WHERE cliente = '$pega_codigo_titular' AND dependente = '$pega_codigo_dependente' ORDER BY data_agendado, hora_agendado";
$rs = mysql_query($sql);


while(list($atendimento,$origem,$destino,$cliente,$dependente,$data_agendado,$hora_agendado,$profissional,$especialidade,$motivo,$detalhe,$data_atendido,$hora_atendido,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	$pega_profissional = $profissional;
	if ($cliente == $dependente){
		$paciente = $pega_nome_titular;
		}else{
		$paciente = $pega_nome_dependente;
		}
$contador++;
		
$sqlmedico = "SELECT medico, nome AS nome_medico from medico where medico = '$pega_profissional'";
$rsmedico = mysql_query($sqlmedico);


while(list($medico, $nome_medico) = mysql_fetch_row($rsmedico)) {		
		
?>
<table width="670" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" align="center" scope="col"><?php print data_form($data_agendado); ?> <?php print hora_form($hora_agendado);?> </td>
    <td width="170" align="left" scope="col"><?php print $paciente; ?></td>
    <td width="170" align="left" scope="col"><?php print $nome_medico; ?></td>
    <td width="135" align="left" scope="col"><?php print $motivo; ?></td>
    <td width="35" align="center" valign="middle" scope="col"><a href="relatorio/crel_atendimento.php?atendimento=<?php print $atendimento; ?>&codigo_titular=<?php print $pega_codigo_titular;?>&nome_titular=<?php print $pega_nome_titular;?>&codigo_dependente=<?php print $pega_codigo_dependente;?>&nome_dependente=<?php print $pega_nome_dependente;?>" target="_blank"><img src="imagem/impressao.jpg" alt="" width="35" height="35"/></a></td>
    </tr>
</table>
<?php } }?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col"><strong></strong><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> = Alterar <img src="imagem/ico-delete.png" alt="" width="23" height="23"/> = Delete</td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>