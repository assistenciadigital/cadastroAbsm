<?php
include("requerido/validacao.php");
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
<strong>Consulta Titular | Dependente | <a href="fcon_atendimento.php">Retornar</a></strong>
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
</table><br/>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr valign="middle">
    <th width="60" height="0" align="left" valign="middle" scope="col">&nbsp;</th>
    <th width="520" height="0" align="left" valign="middle" scope="col">Titular | Dependente</th>
    <th width="100" height="0" align="left" scope="col">Usuário</th>
    </tr>
</table>
<div style="color:#009; width:700px; height: 380px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
include("requerido/verifica.php");

$pega_nome = $_GET[fnome];
$pega_cpf = $_GET[fcpf];

//$sql = "SELECT cliente.cliente AS codigo_cliente, cliente.nome AS nome_cliente, cliente.datanascimento AS nascimento_cliente, cliente.status AS status_cliente, cliente.assistencia as assistencia_cliente, cliente.fonerec as fonerec_cliente, cliente.fonecel1 as fonecel1_cliente, cliente.fonecel2 as fonecel2_cliente, cliente.fonecel3 as fonecel3_cliente, cliente.fonerec as fonerec_cliente, cliente.fonecom as fonecom_cliente, dependente.dependente AS codigo_dependente, dependente.nome AS nome_dependente, dependente.datanascimento AS nascimento_dependente, dependente.sexo AS sexo_dependente, dependente.status AS status_dependente, dependente.data AS data_dependente, dependente.hora AS hora_dependente, dependente.usuario AS usuario_dependente, cliente.assistencia, cliente.status AS descricao_status, cliente.classificacao AS codigo_classificacao, cliente.tipo AS codigo_tipo, cliente.data, cliente.hora, cliente.usuario FROM (dependente INNER JOIN cliente ON dependente.titular = cliente.cliente) WHERE cliente.nome LIKE '$pega_nome%' AND cliente.cpf LIKE '$pega_cpf%' ORDER BY cliente.nome, dependente.nome ASC";

$sql = "SELECT cliente.cliente AS codigo_cliente, cliente.nome AS nome_cliente, cliente.datanascimento AS nascimento_cliente, cliente.status AS status_cliente, cliente.assistencia as assistencia_cliente, cliente.fonerec as fonerec_cliente, cliente.fonecel1 as fonecel1_cliente, cliente.fonecel2 as fonecel2_cliente, cliente.fonecel3 as fonecel3_cliente, cliente.fonerec as fonerec_cliente, cliente.fonecom as fonecom_cliente, dependente.dependente AS codigo_dependente, dependente.nome AS nome_dependente, dependente.datanascimento AS nascimento_dependente, dependente.sexo AS sexo_dependente, dependente.status AS status_dependente, dependente.data AS data_dependente, dependente.hora AS hora_dependente, dependente.usuario AS usuario_dependente, cliente.assistencia, cliente.status AS descricao_status, cliente.classificacao AS codigo_classificacao, cliente.tipo AS codigo_tipo, cliente.data, cliente.hora, cliente.usuario FROM (dependente INNER JOIN cliente ON dependente.titular = cliente.cliente) WHERE cliente.nome LIKE '$pega_nome%' ORDER BY cliente.nome, dependente.nome ASC";


$rs = mysql_query($sql);

while(list($codigo_cliente, $nome_cliente, $nascimento_cliente, $status_cliente, $assistencia_cliente,$fonerec_cliente, $fonecel1_cliente, $fonecel2_cliente, $fonecel3_cliente, $fonerec_cliente, $fonecom_cliente, $codigo_dependente, $nome_dependente, $nascimento_dependente, $sexo_dependente, $status_dependente, $data_dependente, $hora_dependente, $usuario_dependente, $assistencia, $descricao_status, $codigo_classificacao, $codigo_tipo, $data, $hora, $usuario) = mysql_fetch_row($rs)) {

	$data_dependente = data_form($data_dependente);
	$data = data_form($data);
	$nascimento_cliente = data_form($nascimento_cliente);
	$nascimento_dependente = data_form($nascimento_dependente);	
	$anterior = $codigo_cliente;
		
$contador++;

?>
<table width="680" border="0" align="left" cellpadding="0" cellspacing="1">
  <tr bgcolor="
  <?php
   if ($anterior <> $atual){
	switch($status_cliente){
	case "Ativo": echo "#008000"; break; //VERDE - LIBERADO
	case "Bloqueado": echo "#FF00FF"; break; // LARANJA - ATENCAO
	case "Excluido": echo "#FF0000"; break; // VERMELHO - EXCLUIDO
	case "Inativo": echo "#FF0000"; break;
	case "Recadastrar": echo "#FFFF00"; break;
	}?>" valign="middle">
    <td width="60" align="center" scope="col">
    <a href="fcad_atendimento.php?codigo_titular=<?php print $codigo_cliente; ?>&nome_titular=<?php print $nome_cliente;?>&codigo_dependente=<?php print $codigo_cliente; ?>&nome_dependente=<?php print $nome_cliente;?>&status_titular=<?php print $status_cliente;?>&assistencia_titular=<?php print $assistencia_cliente?>&status_dependente=<?php print $status_cliente;?>"><img src="imagem/iconeatendimentotitular.png" alt="" width="60" height="62"/></a></td>
    <td width="520" align="left" scope="col">
      <?php  
        		$contador_dependente = 0;
		        print "<strong>Titular: $codigo_cliente - $nome_cliente</strong><br/>";
				print "<strong>Status.:</strong> $status_cliente - Nasc.: $nascimento_cliente - Fone: $fonecel1_cliente<br/>$fonecel2_cliente$fonecel3_cliente$foneres_cliente$fonecom_cliente$fonerec_cliente";
				?></td>
    <td width="100" align="left" scope="col">
          <?php print "<strong>$data<br/>$hora<br/>$usuario</strong>";?>
                </td>
  </tr>
  <tr bgcolor="
  <?php }

	switch($status_cliente){
	case "Ativo": echo "#008000"; break; //VERDE - LIBERADO
	case "Bloqueado": echo "#FF00FF"; break; // LARANJA - ATENCAO
	case "Excluido": echo "#FF0000"; break; // VERMELHO - EXCLUIDO
	case "Inativo": echo "#FF0000"; break;
	case "Recadastrar": echo "#FFFF00"; break;
	}?>" valign="middle">
    <td width="60" align="center" scope="col"><a href="fcad_atendimento.php?codigo_titular=<?php print $codigo_cliente; ?>&nome_titular=<?php print $nome_cliente;?>&codigo_dependente=<?php print $codigo_dependente; ?>&nome_dependente=<?php print $nome_dependente;?>&status_titular=<?php print $status_cliente;?>&assistencia_titular=<?php print $assistencia_cliente?>&status_dependente=<?php print $status_dependente;?>"><img src="imagem/iconeatendimentodependente.png" alt="" width="60" height="62"/></a></td>
    <td width="520" align="left" scope="col"><?php
	    		$contador_dependente = 0;
		        print "Dependente: $codigo_dependente | $nome_dependente<br/>";
				print "Status....: $status_dependente | Nasc.: $nascimento_dependente";?></td>
    <td width="100" align="left" scope="col"><?php print "$data_dependente<br/>$hora_dependente<br/>$usuario_dependente";?></td>
  </tr>
  </table>

<?php 
$atual = $codigo_cliente;
}
?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador + 1; ?></td>
    <td width="340" align="right" scope="col">Alterar  <img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> Dependente <img src="imagem/ico-dependente.png" alt="" width="23" height="23"/> Carteira <img src="imagem/ico-carteira.png" alt="" width="23" height="23"/></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>