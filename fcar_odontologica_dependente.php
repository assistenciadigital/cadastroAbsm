<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2")
{
	header("location:fcon_cliente.php");	
}

$pega_carteira = $_GET[carteira];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM-Saúde - Carteira Completa - Atendimento Odontológico e Médico</title>
<style type="text/css">
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
#apDiv1 {
	position: absolute;
	left: 15px;
	top: 110px;
	width: 385px;
	height: 200px;
	z-index: 1;
    background:;
	color: #000;
}
#apDiv2 {
	position: absolute;
	left: 415px;
	top: 50px;
	width: 385px;
	height: 255px;
	z-index: 2;
    background:;
	color: #000;
}
#apDiv3 {
	position: absolute;
	left: 88px;
	top: 50px;
	width: 315px;
	height: 48px;
	z-index: 3;
}
</style>
</head>
<body>
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");
//include("requerido/verifica.php");

$sql = "SELECT carteira, codigo_titular, nome_titular, data_nascimento_titular, data_inclusao_titular, codigo_dependente, nome_dependente, data_nascimento_dependente, data_inclusao_dependente, produto_regulamentado, acomodacao, datavalidade, via from carteira where carteira = '$pega_carteira'";
$rs = mysql_query($sql);


while(list($carteira, $codigo_titular, $nome_titular, $data_nascimento_titular, $data_inclusao_titular, $codigo_dependente, $nome_dependente, $data_nascimento_dependente, $data_inclusao_dependente, $produto_regulamentado, $acomodacao, $datavalidade, $via) = mysql_fetch_row($rs)) {
	
#data inclusao titular
$ndata = explode("-",$data_inclusao_titular); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$datainclusaotitular = "$ano/$mes/$dia";

#data inclusao dependente
$ndata = explode("-",$data_inclusao_dependente); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$datainclusaodependente = "$ano/$mes/$dia";

#data nascimento titular
$ndata = explode("-",$data_nascimento_titular); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$dtnascimentotitular = "$ano$mes$dia";
$datanascimentotitular = "$ano/$mes/$dia";

#data nascimento dependente
$ndata = explode("-",$data_nascimento_dependente); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$dtnascimentodependente = "$ano$mes$dia";
$datanascimentodependente = "$ano/$mes/$dia";

#data validade
$ndata = explode("-",$datavalidade); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_validade = "$ano/$mes/$dia";

#data atual
$ndata = explode("-",date("Y-m-d")); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_atual = "$ano/$mes/$dia";
?>
<hr>
<table width="791" align="left">
  <tr>
  <th height="248" scope="col"><img src="imagem/carteirinhas/carteirinha_odontologica.png" width="791" height="248" /></th>  </tr>
</table>
<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>
<table width="791" align="left">
  <tr>
    <td style="font-size:14px;"  align="justify" height="248" scope="col"><strong>TERMO DE RECEBIMENTO</strong>
<p>Eu, <strong><?php print $nome_titular; ?></strong>, nascido em: <strong><?php print $datanascimentotitular; ?></strong>, rebeci a carteira de indentificação do(a) beneficiário e/ou dependente: <strong><?php print $nome_dependente; ?></strong>, nascido em: <strong><?php print $datanascimentodependente; ?></strong>, emitida em: <strong><?php print $data_atual; ?></strong>, com vencimento em: <strong><?php print $data_validade; ?></strong>, na condição de <strong>Beneficiário e/ou Dependente</strong>: <strong><?php print $produto_regulamentado; ?></strong>, para atendimento ambulatorial (<strong><?php print $acomodacao; ?></strong>), neste <strong>HM - Hospital Militar</strong> e <strong>Conveniados</strong>, dando ciência aos termos abaixo:</p>
<p>I.   É imprescindível a apresentação deste cartão, juntamente com documento de identificação, com foto.</p>
<p>II.  Para atendimento ambulatorial no HM - Hospital Militar e Conveniados.</p>
<p>III. Este cartão é enumerado, nominativo, individual e sob nenhuma hipótese poderá ser cedido ou emprestado.</p>
<p>Por ser verdade, assino o referido TERMO DE RECEBIMENTO.</p>
<p>Cuiabá/MT, <?php print $data_atual; ?>.</p>
<p>&nbsp;</p>
______________________________________<br/>
<strong><?php print $nome_titular; ?></strong><br/>Assinatura do Titular e/ou Responsável</td>
  </tr>
</table>
<div id="apDiv1">
  <table width="385" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="4" scope="col"><strong><?php print $nome_dependente; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4" scope="col">Nome Beneficiário</td>
    </tr>
    <tr>
      <td colspan="2" scope="col"><strong><?php print $codigo_titular; ?><?php print $dtnascimentodependente; ?><?php print $carteira; ?>-<?php print $via; ?></strong></td>
      <td width="104" scope="col"><strong><?php print $datanascimentodependente; ?></strong></td>
      <td width="73" scope="col"><strong><?php print $datainclusaodependente; ?></strong></td>
    </tr>
    <tr>
      <td colspan="2" scope="col">Código Beneficiário</td>
      <td scope="col">Dt Nascimento</td>
      <td scope="col">Dt Adesão</td>
    </tr>
    <tr>
      <td colspan="4" scope="col"><strong><?php print $produto_regulamentado; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4" scope="col">Produto Regulamentado</td>
    </tr>
    <tr>
      <td colspan="4" scope="col"><strong><?php print $nome_titular; ?></strong></td>
    </tr>
    <tr>
      <td colspan="4" scope="col">Nome Titular</td>
    </tr>
    <tr>
      <td width="99" scope="col"><strong><?php print $datainclusaotitular; ?></strong></td>
      <td width="109" scope="col"><strong>Odontologia</strong></td>
      <td scope="col"><strong><?php print $datainclusaotitular; ?></strong></td>
      <td scope="col"><strong><?php print $data_validade; ?></strong></td>
    </tr>
    <tr>
      <td scope="col">Dt Vigência</td>
      <td scope="col">Acomodação</td>
      <td scope="col">Dt Adesão</td>
      <td scope="col">Dt Validade</td>
    </tr>
  </table>
</div>
<div id="apDiv2">
  <table width="385" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="justify" width="383" scope="col"><strong>DIRETRIZES</strong>:<br/>
        I. É imprescindível a apresentação deste cartão, juntamente com documento de identificação, com foto.
        <p>II. Para atendimento ambulatorial no HM e Conveniados.</p>
        <p>III. Este cartão é enumerado, nominativo, individual e sob nenhuma hipótese poderá ser cedido ou emprestado.</p>
      	<strong>HM - Hospital Militar</strong> - Telefone: (65) 3623-4302<br />
      ABSM - Associação Beneficente de Saúde dos Militares de MT<br/><br />
      <strong>RICARDO ALMEIDA GIL - CEL. PM/MT</strong><br />
      Diretor Presidente da ABSM<br /></td>
    </tr>
  </table>
</div>
<div id="apDiv3"><strong>HM - Hospital Militar - ODONTOLOGIA<br />ABSM - Associação Beneficente de Saúde dos Militares do Estado de Mato Grosso</strong></div>
<?php } ?>
</body>
</html>