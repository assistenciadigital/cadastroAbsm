<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

// Formata data dd/mm/aaaa para aaaa-mm-dd
function data_banco($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}

// Formata data aaaa-mm-dd para dd/mm/aaaa
function data_form($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}

#nome do usuario
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
<title>HM Saúde</title>
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      
	  $(document).ready(function(){
		  
		          // Evento change no campo classificacao  
         $("select[name=fclassificacao]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=ftipo]").html('<option value="">Carregando Tipo</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_tipo.php",
                  {fclassificacao:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=ftipo]").html(valor);
                  }
                  )
         })		
				  $("input[name='fdata_inicio']").mask('99/99/9999');
				  $("input[name='fdata_fim']").mask('99/99/9999');
        })
		  
		  

</script>

<style>
.error {color: #FF0000;}
</style>

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

</head>
<body>

<?php
// define variables and set to empty values
$datainicioError = $datafimError = "";

$data = date("d/m/Y");
$hora = date("H:i");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
   if (empty($_POST["fdata_inicio"]))
     {$datainicioError = "Data Inicio Requerido!";}
   else
     {$datainicio= $_POST["fdata_inicio"];}
   
   if (empty($_POST["fdata_fim"]))
     {$datafimError = "Data Fim Requerido!";}
   else
     {$datafim = $_POST["fdata_fim"];}

	  
	  $destino = $_POST["fdestino"];
	  $especialidade = $_POST["fespecialidade"];
	  $motivo = $_POST["fmotivo"];
	  $profissional = $_POST["fprofissional"];	  
	  $status = $_POST["fstatus_atendimento"];
  
header("Location:relatorio/crel_atendimentomedico.php?data_inicio=$datainicio&data_fim=$datafim&destino=$destino&especialidade=$especialidade&motivo=$motivo&profissional=$profissional&status=$status");
}
?>
<div id="tudo">
<div id="conteudo">
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Impressão Relatório Analítico por Médico</strong>
<hr>
<span class="error">* Campo Requerido!</span><br/>
<form id="form" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>"> 

  <table width="537" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="158" align="left" valign="middle"><strong>Data Inicio:</strong></td>
    <td width="366" align="left" valign="middle"><span class="error">
      <input name="fdata_inicio" type="text" id="fdata_inicio" value="<?php print date('d/m/Y');?>" size="10" maxlength="10" />
      * <?php echo $classificacaoError;?></span><script language="JavaScript"> document.form.fclassificacao.focus();</script>
      </td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Data Fim:</strong></td>
    <td align="left" valign="middle"><span class="error">
      <input name="fdata_fim" type="text" id="fdata_fim" value="<?php print date('d/m/Y');?>" size="10" maxlength="10" />
      * <?php echo $tipoError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Destino</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fdestino" id="fdestino" style="width:200px">
        <option value=""></option>
        <option value="AMBULATORIO">AMBULATORIO</option>
        <option value="CONV.OFT.CL.OLHOS">CONVENIO OFTALMO - CLINICA DOS OLHOS</option>
        <option value="CONV.OFT.HS.OLHOS">CONVENIO OFTALMO - HOSPITAL DE OLHOS</option>
        <option value="CONV.RAIO-X.CEDIC">CONVENIO RADIOLOGIA - CEDIC</option>
        <option value="ELETROCARDIOGRAMA">ELETROCARDIOGRAMA</option>
        <option value="FISIOTERAPIA">FISIOTERAPIA</option>
        <option value="EXAME.LAB.INT.100">EXAME LABORATORIAL-INTERNO 100% COOP</option>
        <option value="EXAME.LAB.EXT.50">EXAME LABORATORIAL-EXTERNO 50% COOP</option>
        <option value="PA">PA</option>
        <option value="ULTRASSONOGRAFIA">ULTRASSONOGRAFIA</option>
        </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Especialidade:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fespecialidade" id="fespecialidade" style="width:200px">
        <option value=""></option>
        <?php 
		$sqlespecialidade = "select area as codigo_area, descricao as descricao_area FROM area order by descricao";
		$rsespecialidade = mysql_query($sqlespecialidade);
		while(list($area, $descricao_area) = mysql_fetch_row($rsespecialidade)) { ?>
        <option value="<?php print $area; ?>-<?php print $descricao_area;?>"><?php print $descricao_area;}?></option>
        </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Motivo:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fmotivo" id="fmotivo" style="width:200px">
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
    <td align="left" valign="middle"><strong>Profissional</strong><strong>:</strong></td>
    <td align="left" valign="middle"><span class="error"><strong>
      <select name="fprofissional" id="fprofissional" style="width:200px">
        <option value=""></option>
        <?php 
		$sqlprofissional = "select medico as codigo_profissional, nome as nome_profissional FROM medico order by nome";
		$rsprofissional = mysql_query($sqlprofissional);
		while(list($codigo_profissional, $nome_profissional) = mysql_fetch_row($rsprofissional)) { ?>
        <option value="<?php print $codigo_profissional; ?>-<?php print $nome_profissional;?>"><?php print $nome_profissional;}?></option>

        </select>
    </strong></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Status</strong><strong>:</strong></td>
    <td align="left" valign="middle"><strong>
      <select name="fstatus_atendimento" id="fstatus_atendimento" style="width:310px">
        <option value=""></option>
        <option value="Atendimento data/hora informada">Atendimento data/hora informada</option>
        <option value="Cancelamento Justificado-Paciente Ausente">Cancelamento Justificado-Paciente Ausente</option>
        <option value="Cancelamento Nao Justificado-Paciente Ausente">Cancelamento Nao Justificado-Paciente Ausente</option>
        <option value="Cancelamento Justificado-Profissional Ausente">Cancelamento Justificado-Profissional Ausente</option>
        <option value="Cancelamento Nao Justificado-Profissional Ausente">Cancelamento Nao Justificado-Profissional Ausente</option>
        <option value="Cancelamento Justificado-Estabelecimento">Cancelamento Justificado-Estabelecimento</option>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Data/Hora:</strong><br /><strong>Usuário:</strong></td>
    <td align="left" valign="middle"><?php print $data; ?> <?php print $hora; ?><br/><?php print strtoupper($loginusuario_atual); ?></td>
  </tr>
    <tr>
      <td align="right" valign="middle">&nbsp;</td>
      <td align="left" valign="middle"><input type="submit" name="fvisualiza" id="fvisualiza" value="Visualizar" />
        <strong>
        <input type="button" name="ffechar" value="Fechar" onclick="window.close();" />
        </strong></td>
    </tr>
    </table>
</form>
<hr>
</div>
</div>
</body>
</html>