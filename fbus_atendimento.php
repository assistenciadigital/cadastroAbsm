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
<strong>Consulta Titular | <a href="fcon_atendimento.php">Retornar</a></strong>
<hr>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr valign="middle">
    <th width="136" height="0" align="center" valign="top" bgcolor="#008000" scope="col">Ativo<br />
      Verde</th>
    <th width="136" height="0" align="center" valign="top" bgcolor="#FF00FF" scope="col">Bloqueado<br />
      Pink/Rosa</th>
    <th width="136" height="0" align="center" valign="top" bgcolor="#FF0000" scope="col">Excluído<br />
      Vermelho</th>
    <th width="136" height="0" align="center" valign="top" bgcolor="#FF0000" scope="col">Inativo<br />
      Vermelho</th>
    <th width="136" height="0" align="center" valign="top" bgcolor="#FFFF00" scope="col">Recadastrar<br />
      Amarelo</th>
  </tr>
  </table>
<br/>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr valign="middle">
    <th width="60" height="0" align="left" valign="middle" scope="col">&nbsp;</th>
    <th width="520" height="0" align="left" valign="middle" scope="col">Titular | Dependente</th>
    <th width="100" height="0" align="left" scope="col">Usuário</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 375px; overflow: auto; vertical-align: left;">
  <?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");
include("requerido/validacao.php");

$pega_nome = $_GET[fnome];
$pega_cpf = $_GET[fcpf];

$sql = "SELECT cliente.cliente AS codigo_titular, cliente.nome AS nome_titular, cliente.datanascimento AS nascimento_titular, cliente.status AS status_titular, cliente.assistencia as assistencia_titular, cliente.fonerec, cliente.fonecel1, cliente.fonecel2, cliente.fonecel3, cliente.fonerec, cliente.fonecom, dependente.dependente AS codigo_dependente, dependente.nome AS nome_dependente, dependente.datanascimento AS nascimento_dependente, dependente.sexo AS sexo_dependente, dependente.status AS status_dependente, dependente.data AS data_dependente, dependente.hora AS hora_dependente, dependente.usuario AS usuario_dependente, cliente.assistencia, cliente.status AS descricao_status, cliente.classificacao AS codigo_classificacao, cliente.tipo AS codigo_tipo, cliente.data, cliente.hora, cliente.usuario FROM dependente RIGHT JOIN cliente ON dependente.titular = cliente.cliente WHERE (((cliente.nome) Like '$pega_nome%')) ORDER BY cliente.nome, dependente.nome";

	$rs  = mysql_query($sql);
	
	while(list($codigo_titular, $nome_titular, $nascimento_titular, $status_titular, $assistencia_titular, $fonerec,$fonecel1, $fonecel2, $fonecel3, $fonerec, $fonecom, $codigo_dependente, $nome_dependente, $nascimento_dependente, $sexo_dependente, $status_dependente, $data_dependente, $hora_dependente, $usuario_dependente, $assistencia, $status_dependente,$codigo_classificacao, $codigo_tipo, $dat_titular, $hora_titular, $usuario_titular) = mysql_fetch_row($rs )) {

	$contador++;	
		
	$nascimento_titular = data_form($nascimento_titular);
	$data_titular = data_form($data_titular);
	$hora_titular = hora_form($hora_titular);
	
	$nascimento_dependente = data_form($nascimento_dependente);
	$data_dependente = data_form($data_dependente);
	$hora_dependente = hora_form($hora_dependente);
	$titular_anterior = $codigo_titular;

	$fonecel1 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel1))));
	$fonecel2 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel2))));
	$fonecel3 = trim(ltrim(rtrim(str_replace(' ', '',$fonecel3))));
	$foneres  = trim(ltrim(rtrim(str_replace(' ', '',$foneres))));
	$fonecom  = trim(ltrim(rtrim(str_replace(' ', '',$fonecom))));
	$fonerec  = trim(ltrim(rtrim(str_replace(' ', '',$fonerec))));
	
	
	
?>
  <table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
    <tr bgcolor="
  <?php
  if ($titular_anterior <> $titular_atual){
	switch($status_titular){
	case "Ativo": echo "#008000"; break; //VERDE - LIBERADO
	case "Bloqueado": echo "#FF00FF"; break; // LARANJA - ATENCAO
	case "Excluido": echo "#FF0000"; break; // VERMELHO - EXCLUIDO
	case "Inativo": echo "#FF0000"; break;
	case "Recadastrar": echo "#FFFF00"; break;}
		?>" valign="middle">
      <td width="70" align="center" scope="col"><a href="fcad_atendimento.php?codigo_titular=<?php print $codigo_titular; ?>&nome_titular=<?php print $nome_titular;?>&codigo_dependente=<?php print $codigo_titular; ?>&nome_dependente=<?php print $nome_titular;?>&status_titular=<?php print $status_titular;?>&assistencia_titular=<?php print $assistencia_titular?>&status_dependente=<?php print $status_titular;?>&nascimento_titular=<?php print $nascimento_titular?>&nascimento_dependente=<?php print $nascimento_titular?>"><img src="imagem/iconeAtendimentotitular.png" alt="" width="70" height="73"/></a></td>
      <td width="510" align="left" scope="col"><?php  
		        print "<strong>$codigo_titular - $nome_titular</strong><br/>";
				print "<strong>$status_titular</strong> - Nasc: $nascimento_titular - Fone:";
													if (!empty($fonecel1)){print "$fonecel1";}
													if (!empty($fonecel2)){print "$fonecel2";}
													if (!empty($fonecel3)){print "$fonecel3";}
													if (!empty($foneres)){print "$foneres";}
													if (!empty($fonecom)){print "$fonecom";}
													if (!empty($fonerec)){print "$fonerec";}
				print $classificacao;
													
				?></td>
      <td width="100" align="left" scope="col"><?php print "$data_titular<br/>$hora_titular<br/>$usuario_titular";?></td>
    </tr>
    <tr bgcolor="
  <?php
  }
	switch($status_titular){
	case "Ativo": echo "#008000"; break; //VERDE - LIBERADO
	case "Bloqueado": echo "#FF00FF"; break; // LARANJA - ATENCAO
	case "Excluido": echo "#FF0000"; break; // VERMELHO - EXCLUIDO
	case "Inativo": echo "#FF0000"; break;
	case "Recadastrar": echo "#FFFF00"; break;}
		?>" valign="middle">
      <td width="70" align="center" scope="col"><a href="fcad_atendimento.php?codigo_titular=<?php print $codigo_titular; ?>&nome_titular=<?php print $nome_titular;?>&codigo_dependente=<?php print $codigo_dependente; ?>&nome_dependente=<?php print $nome_dependente;?>&status_titular=<?php print $status_titular;?>&assistencia_titular=<?php print $assistencia_titular?>&status_dependente=<?php print $status_dependente;?>&nascimento_titular=<?php print $nascimento_titular?>&nascimento_dependente=<?php print $nascimento_dependente?>"><img src="imagem/iconeAtendimentodependente.png" alt="" width="70" height="73"/></a></td>
      <td width="510" align="left" scope="col"><?php  
 			    print "<strong>$codigo_dependente - $nome_dependente<br/>";
				print "<strong>$status_dependente</strong> - Nasc: $nascimento_dependente";
				?></td>
      <td width="100" align="left" scope="col"><?php print "$data_dependente<br/>$hora_dependente<br/>$usuario_dependente";?></td>
    </tr>
    </table>
  <?php 
  $titular_atual = $codigo_titular;
  }
  ?>
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