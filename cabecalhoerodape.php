<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and $nivelusuario_atual != "4")
{
	header("location:menu.php");	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>

<STYLE>
    thead { display: table-header-group;  }
    tfoot { display: table-footer-group; }
body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 12px;
}
</STYLE>

</head>

<body>


<table width="100%" align="center">

<thead>
  <tr>
     <th width=100%>
      <?php include("relatorio_superior.php");?>
      <?php include("frel_recibo_cabecalho.php");?>
     </th>
  </tr>
</thead>

<tfoot>
  <tr>
     <td width=100%>
     <?php
$pagina_total = $pagina_total + 1;
?>
      <?php include("relatorio_inferior.php");?>
     </td>
  </tr>
</tfoot>

<tbody>
<tr>
   <td width="100%">
 <?php 
  $sql_recibo = "SELECT recibo, valor as valor_recibo, emitente as emitente_recibo, destinatario as destinatario_recibo, tipo, referencia as referencia_recibo, titular as titular_recibo, mes_ano as mes_ano_recibo, descricao as descricao_recibo, data as data_recibo, hora as hora_recibo, usuario as usuario_recibo from recibo";

$rs_recibo = mysql_query($sql_recibo);
$soma = 0;
while(list($recibo, $valor_recibo, $emitente_recibo, $destinatario_recibo, $tipo, $referencia_recibo, $titular_recibo, $mes_ano_recibo, $descricao_recibo, $data_recibo, $hora_recibo, $usuario_recibo) = mysql_fetch_row($rs_recibo)) {

	$pega_titular = $titular_recibo;
	$pega_recibo = $recibo;
	$pega_destinatario = $destinatario_recibo;
	$pega_tipo = $tipo;
	$pega_mes_ano = $mes_ano_recibo;
	$pega_valor = number_format($valor_recibo, 2, ',', '.');
		
$sql_referencia = "SELECT referencia,emitente as emitente_referencia,descricao as descricao_referencia from recibo_referencia where referencia = '$referencia_recibo'";
$rs_referencia = mysql_query($sql_referencia);
while(list($referencia,$emitente_referencia,$descricao_referencia) = mysql_fetch_row($rs_referencia)) {

$sql_emitente = "SELECT emitente,inscricao as inscricao_emitente,razao_social as razao_emitente,nome_fantasia as nome_emitente,cep as cep_emitente,endereco as endereco_emitente,uf as uf_emitente,cidade as cidade_emitente,bairro as bairro_emitente FROM recibo_emitente where emitente = '$emitente_recibo'";
$rs_emitente = mysql_query($sql_emitente);
while(list($emitente,$inscricao_emitente,$razao_emitente,$nome_emitente,$cep_emitente,$endereco_emitente,$uf_emitente,$cidade_emitente,$bairro_emitente) = mysql_fetch_row($rs_emitente)) {
	
	$pega_cidade_emitente = $cidade_emitente;
	$pega_bairro_emitente = $bairro_emitente;
		
	$sql_cidade_emitente = "SELECT descricao as nome_cidade_emitente from cidade where cidade = '$pega_cidade_emitente'";
	$rs_cidade_emitente = mysql_query($sql_cidade_emitente);
	while(list($nome_cidade_emitente) = mysql_fetch_row($rs_cidade_emitente)) {		

	$sql_bairro_emitente = "SELECT descricao as nome_bairro_emitente from bairro where bairro = '$pega_bairro_emitente'";
	$rs_bairro_emitente = mysql_query($sql_bairro_emitente);
	while(list($nome_bairro_emitente) = mysql_fetch_row($rs_bairro_emitente)) {
	
#data
$ndata = explode("-",$data_recibo); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

include("frel_recibo_meio.php");

$soma_valor_recibo = $soma_valor_recibo + $valor_recibo; 


}
}
}
}
}
?>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="600" align="right" valign="middle">TOTAL R$  </th>
    <th width="100" align="right" valign="middle"><?php print number_format($soma_valor_recibo, 2, ',', '.') ;?></th>
  
  </tr>
</table>   

   </td>
   
</tr>


</tbody>
</table>
</body>
</html>