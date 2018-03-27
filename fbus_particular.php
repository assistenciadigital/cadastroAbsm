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
<strong>Consulta  Particular / Convênio SUS  | <a href="fcon_particular.php">Retornar</a> | <a href="fcad_particular.php">Novo Registro +</a> | <a href="crel_particular.php" target="_blank">Relação</a></strong>
<hr>
<table width="680" align="left">
  <tr valign="middle">
    <th width="80" height="0" align="left" valign="middle" scope="col">Paciente</th>
    <th width="277,5" height="0" align="left" scope="col">Nome</th>
    <th width="90" height="0" align="left" scope="col">Nascimento</th>
    <th width="100" height="0" align="left" scope="col">CPF</th>
    <th width="95" height="0" align="left" scope="col">Usuário</th>
    <th width="37,5" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 340px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$pega_nome = $_GET[fnome];
$pega_cpf = $_GET[fcpf];

$sql = "SELECT particular,cartaosus,formapagto,nome,sexo,datanascimento,cpf,rg,emissorrg,ufrg,dataemissaorg,fonerec,fonecel1,fonecel2,fonecel3,foneres,fonecom,endereco,bairro,cidade,uf,cep,nacionalidade,naturalidade,ufnaturalidade,pai,mae,estadocivil,conjuge,profissao,ocupacao,email,detalhe,data,hora,usuario FROM particular WHERE nome LIKE '$pega_nome%' AND cpf LIKE '$pega_cpf%' ORDER BY nome";
$rs = mysql_query($sql);


while(list($particular,$cartaosus,$formapagto,$nome,$sexo,$datanascimento,$cpf,$rg,$emissorrg,$ufrg,$dataemissaorg,$fonerec,$fonecel1,$fonecel2,$fonecel3,$foneres,$fonecom,$endereco,$bairro,$cidade,$uf,$cep,$nacionalidade,$naturalidade,$ufnaturalidade,$pai,$mae,$estadocivil,$conjuge,$profissao,$ocupacao,$email,$detalhe,$data,$hora,$usuario) = mysql_fetch_row($rs)) {
	
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
<table width="680" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="80" height="35" align="center" scope="col"><?php print $particular; ?></td>
    <td width="277,5" height="35" align="left" scope="col"><?php print $nome; ?></td>
    <td width="90" height="35" align="left" scope="col"><?php print $data_nascimento; ?></td>
    <td width="100" height="35" align="left" scope="col"><?php print $cpf; ?></td>
    <td width="95" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="37,5" height="35" align="center" scope="col"><a href="falt_particular.php?particular=<?php print $particular; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col">Alterar = <img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>