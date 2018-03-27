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

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and  $nivelusuario_atual != "3" and $nivelusuario_atual != "4")
{
	header("location:menu.php");	
}


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
				  $("input[name='fperiodo_inicial']").mask('99/99/9999');
				  $("input[name='fperiodo_final']").mask('99/99/9999');
  })
  
  
  $(document).ready(function(){
        // Evento change no campo emitente  
         $("select[name=femitente]").change(function(){
            // Exibimos no campo referencia antes de concluirmos
			$("select[name=freferencia]").html('<option value="">Carregando Referencia</option>');
            // Exibimos no campo referencia antes de selecionamos a referencia, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
			$.post("cfil_referencia.php",
                  {femitente:$(this).val()},
                  // Carregamos o resultado acima para o campo referencia
				  function(valor){
                     $("select[name=freferencia]").html(valor);
                  }
                  )
         })
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
$tipoError = $recibo_inicialError = $recibo_finalrError = $periodo_inicialError = $periodo_finalError = "";
$ftipo = $frecibo_inicial = $frecibo_final = $fperiodo_inicial = $fperiodo_final = "";

$data = date("d/m/Y");
$hora = date("H:i");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
   if (empty($_POST["frecibo_inicial"]))
     {$recibo_inicialError = "Nº Recibo Inicial Requerido!";}
   else
     {$recibo_inicial = $_POST["frecibo_inicial"];}
   
   if (empty($_POST["frecibo_final"]))
     {$recibo_finalError = "Nº Recibo Final Requerido!";}
   else
     {$recibo_final = $_POST["frecibo_final"];}

   if (empty($_POST["fperiodo_inicial"]))
     {$periodo_inicialError = "Período Inicial Requerido!";}
   else
     {$periodo_inicial = $_POST["fperiodo_inicial"];}
   
   if (empty($_POST["fperiodo_final"]))
     {$periodo_finalError = "Período Final Requerido!";}
   else
     {$periodo_final = $_POST["fperiodo_final"];}

   if (empty($_POST["ftipo"]))
     {$tipoError = "Tipo Recibo Requerido!";}
   else
     {$tipo = $_POST["ftipo"];}
	 
	 $emitente = $_POST["femitente"];
	 $referencia = $_POST["freferencia"];

   if ($tipo=="Pagamento"){
header("Location:relatorio/crel_recibo_pagamento.php?recibo_inicial=$recibo_inicial&recibo_final=$recibo_final&periodo_inicial=$periodo_inicial&periodo_final=$periodo_final&emitente=$emitente&referencia=$referencia");}
	elseif ($tipo=="Recebimento"){
header("Location:relatorio/crel_recibo_recebimento.php?recibo_inicial=$recibo_inicial&recibo_final=$recibo_final&periodo_inicial=$periodo_inicial&periodo_final=$periodo_final&emitente=$emitente&referencia=$referencia");
}
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
<strong>Impressão de Recibos</strong>
<hr>
<span class="error">* Campo Requerido!</span><br/>
<form id="form" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>"> 

  <table width="537" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="158" align="left" valign="middle"><strong>Nº Recibo Inicial:</strong></td>
    <td width="366" align="left" valign="middle"><input name="frecibo_inicial" type="text" id="frecibo_inicial" value="1" size="10" maxlength="10"/><span class="error">* <?php echo $recibo_inicialError;?></span><script language="JavaScript"> document.form.frecibo_inicial.focus(); </script></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Nº Recibo Final:</strong></td>
    <td align="left" valign="middle"><input name="frecibo_final" type="text" id="frecibo_final" value="99999" size="10" maxlength="10" /><span class="error">* <?php echo $recibo_finalError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Período Inicial:</strong></td>
    <td align="left" valign="middle">
       <input name="fperiodo_inicial" type="text" id="fperiodo_inicial" value="<?php print $data;?>" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_inicialError;?></span></td>
  </tr>
    <tr>
      <td align="left" valign="middle"><strong>Período Final:</strong></td>
      <td align="left" valign="middle">
        <input name="fperiodo_final" type="text" id="fperiodo_final" value="<?php print $data;?>" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Tipo Recibo:</strong></td>
      <td align="left" valign="middle"><select name="ftipo" id="ftipo">
        <option value=""></option>
        <option value="Pagamento">Pagamento</option>
        <option value="Recebimento" selected="selected">Recebimento</option>
      </select><span class="error">* <?php echo $tipoError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Emitente:</strong></td>
      <td align="left" valign="middle"><select name="femitente" id="femitente" style="width:300px">
        <option value=""></option>
        <?php 
		$sqlemitente = "select emitente, inscricao from recibo_emitente order by razao_social";
		$rsemitente = mysql_query($sqlemitente);
		while(list($emitente, $inscricao) = mysql_fetch_row($rsemitente)) {
		?>
        <option value="<?php print $emitente; ?>"><?php print $inscricao; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Referência:</strong></td>
      <td align="left" valign="middle"><select name="freferencia" id="freferencia" style="width:300px">
      </select></td>
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