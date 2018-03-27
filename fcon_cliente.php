<?php
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
<title>HM - Saúde</title>
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
<strong>Consulta Cliente | <a href="menu.php">Retornar</a> | <a href="fcad_cliente.php">Novo Registro +</a> | <a href="crel_titular.php" target="_blank">Relação - Titular</a> | <a href="crel_titular_ativos.php" target="_blank">Geral</a> | <a href="crel_titular_ativos_cbm.php" target="_blank">CBM</a> | <a href="crel_titular_ativos_pm.php" target="_blank">PM</a></strong>
<hr>
<form action="fbus_cliente.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
  <strong>Nome: </strong>
    <input name="fnome" type="text" id="fnome" size="50" maxlength="100" /><script language="JavaScript"> document.form1.fnome.focus(); </script><strong> CPF: </strong>
    <input name="fcpf" type="text" id="fcpf" size="11" maxlength="11" />
<input type="submit" name="fpesquisar" id="fpesquisar" value="Pesquisar" />
</form>
<hr>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr valign="middle">
    <th width="120" height="0" align="left" valign="middle" scope="col">Status</th>
    <th width="320" height="0" align="left" scope="col">Nome</th>
    <th width="100" height="0" align="left" scope="col">CPF</th>
    <th width="100" height="0" align="left" scope="col">Usuário</th>
    <th width="40" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 335px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$pega_nome = $_POST[fnome];
$pega_cpf = $_POST[fcpf];

$sql = "SELECT cliente, status, nome, datanascimento, cpf, data, hora, usuario FROM cliente WHERE cliente =  'C' ORDER BY nome";
$rs = mysql_query($sql);


while(list($cliente,$status,$nome,$datanascimento,$cpf,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

#data nascimento
$ndata = explode("-",$datanascimento); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_nascimento = "$ano/$mes/$dia";

$contador++;	
?>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr bgcolor="
  <?php
	switch($status){
	case "Ativo": echo "#008000"; break; //VERDE - LIBERADO
	case "Bloqueado": echo "#FF00FF"; break; // LARANJA - ATENCAO
	case "Excluido": echo "#FF0000"; break; // VERMELHO - EXCLUIDO
	case "Inativo": echo "#FF0000"; break;
	case "Recadastrar": echo "#FFFF00"; break;}
	?>" valign="middle">
    <td width="120" height="35" align="center" scope="col">
      <?php
	switch($status){
	case "Ativo": echo "<strong><font color='#000080'>$status<br/>Liberado</font></strong>"; break; 
	case "Bloqueado": echo "<strong><font color='#000080'>$status<br/>Procurar<br/>Financeiro</font></strong>"; break;
	case "Excluido": echo "<strong><font color='#000080'>$status</font></strong>"; break;
	case "Inativo": echo "<strong><font color='#000080'>$status</font></strong>"; break;
	case "Recadastrar": echo "<strong><font color='#000080'>$status<br/>Procurar<br/>Cadastro</font></strong>"; break;}
	?>    </td>
    <td width="320" height="35" align="left" scope="col"><?php echo "<strong><font color='#000080'> $cliente </font></strong>";?> - <?php echo "<strong><font color='#000080'> $nome </font></strong>";?><br/>
      Dt Nascimento: <?php echo "<strong><font color='#000080'> $data_nascimento </font></strong>";?> <a href="fcad_carteira.php?cliente=<?php print $cliente; ?>"><img src="imagem/icone_atendimento.jpg" alt="" width="33" height="44"/></a></td>
    <td width="100" height="35" align="left" scope="col"><?php echo "<strong><font color='#000080'> $cpf </font></strong>";?></td>
    <td width="100" align="left" scope="col"><?php echo "<strong><font color='#000080'> $usuario </font></strong>";?><br /><?php echo "<strong><font color='#000080'> $data_final </font></strong>";?><br /><?php echo "<strong><font color='#000080'> $hora </font></strong>";?></td>
    <td width="40" height="35" align="center" scope="col"><a href="falt_cliente.php?cliente=<?php print $cliente; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a><a href="fcad_dependente.php?titular=<?php print $cliente; ?>"><img src="imagem/ico-dependente.png" alt="" width="23" height="23"/></a><a href="fcad_carteira.php?cliente=<?php print $cliente; ?>"><img src="imagem/ico-carteira.png" alt="" width="23" height="23"/></a></td>
   </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col">Alterar <img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> Dependente <img src="imagem/ico-dependente.png" alt="" width="23" height="23"/> Carteira <img src="imagem/ico-carteira.png" alt="" width="23" height="23"/></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>