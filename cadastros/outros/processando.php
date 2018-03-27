<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";
	include "../../painel/funcoesPHP/log.php";

	$nulo = "NULL";
	$no_alt = "o Seu Nível não da permissao para esta solicitação, por favor informe seu Administrador!";
	
	if ($_GET['id']) $pega_id = $_GET['id'];
	else if ($_POST['id']) $pega_id = $_POST['id'];
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM particular WHERE id='$pega_id'"));	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../painel/css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="../../painel/funcoesJS/funcoes.js"></script>

<body onLoad="reajusta()" class="bg_pg_internas">
<div align="center">
<br/>
<table width="100%" height="800" border="0" align="center" cellpadding="0" cellspacing="0"  id="conteudo">
<tr valign="top">
<td align="center">
    <table width="800" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center" valign="middle" bgcolor="#4DBDCB"><h1 class="txtBranco">Aguarde processando...</h1></td>
    </tr>
    </table>

</td>
</tr>
</table>
</div>
</body>
</html>
<?php	
	if ($_GET['acao'] == 'alterar'){	

	if(($_SESSION['nivel_usuario'])<=2){

			$altera = mysql_query("UPDATE particular SET cpf='".$_POST['cpf']."', rg='".$_POST['rg']."', emissorrg='".trim(addslashes(htmlentities(strtoupper($_POST['emissorrg']))))."', ufrg='".$_POST['ufrg']."', emissaorg='".data_date($_POST['emissaorg'])."', cns='".trim(addslashes(htmlentities(strtoupper($_POST['cns']))))."', classificacao='".$_POST['classificacao']."', nome='".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', cor='".$_POST['cor']."', nascimento='".data_date($_POST['nascimento'])."', sexo='".$_POST['sexo']."', ufnaturalidade='".$_POST['ufnaturalidade']."', naturalidade='".$_POST['naturalidade']."', pai='".trim(addslashes(htmlentities(strtoupper($_POST['pai']))))."', mae='".trim(addslashes(htmlentities(strtoupper($_POST['mae']))))."', estadocivil='".$_POST['estadocivil']."', conjuge='".trim(addslashes(htmlentities(strtoupper($_POST['conjuge']))))."', ocupacao='".$_POST['ocupacao']."', profissao='".$_POST['profissao']."', endereco='".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', numero='".trim(addslashes(htmlentities(strtoupper($_POST['numero']))))."', complemento='".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', bairro='".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."',  uf='".$_POST['uf']."', cidade='".$_POST['cidade']."', cep='".$_POST['cep']."', email='".trim(addslashes(htmlentities(strtoupper($_POST['email']))))."', fonecel='".$_POST['fonecel']."', foneres='".$_POST['foneres']."', fonecom='".$_POST['fonecom']."', detalhe='".trim(addslashes(htmlentities(strtoupper($_POST['observacoes']))))."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login']."' where id='".$_POST['id']."'");
			if($altera) $resultado = "Registro: ".$pega_id.", alterado com sucesso!";
			else $resultado = "Erro ao alterar o registro: ".$pega_id.".";
	}
	else $resultado = "Você não tem permissão para alterar o registro ".$pega_id.", contacte o administrador do sistema!";
	}
//------------------------------------->> INCLUIR
	else{		
		if(($_SESSION['nivel_usuario'])<=2){
		if (!(mysql_num_rows (mysql_query ("SELECT id FROM particular WHERE id='".$_POST['id']."'")))) {		
			$insere = mysql_query ("INSERT particular(cpf, rg, emissorrg, ufrg, emissaorg, cns, classificacao, nome, cor, nascimento, sexo, ufnaturalidade, naturalidade, pai, mae, estadocivil, conjuge, ocupacao, profissao, endereco, numero, complemento, bairro, uf, cidade, cep, email, fonecel, foneres, fonecom, detalhe, data, usuario) VALUES ('".$_POST['cpf']."', '".$_POST['rg']."', '".trim(addslashes(htmlentities(strtoupper($_POST['emissorrg']))))."', '".$_POST['ufrg']."', '".data_date($_POST['emissaorg'])."', '".trim(addslashes(htmlentities(strtoupper($_POST['cns']))))."', '".$_POST['classificacao']."', '".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', '".$_POST['cor']."', '".data_date($_POST['nascimento'])."', '".$_POST['sexo']."', '".$_POST['ufnaturalidade']."', '".$_POST['naturalidade']."', '".trim(addslashes(htmlentities(strtoupper($_POST['pai']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['mae']))))."', '".$_POST['estadocivil']."', '".trim(addslashes(htmlentities(strtoupper($_POST['conjuge']))))."', '".$_POST['ocupacao']."', '".$_POST['profissao']."', '".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['numero']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', '".$_POST['uf']."', '".$_POST['cidade']."', '".$_POST['cep']."', '".trim(addslashes(htmlentities(strtolower($_POST['email']))))."', '".$_POST['fonecel']."', '".$_POST['foneres']."',  '".$_POST['fonecom']."',  '".trim(addslashes(htmlentities(strtoupper($_POST['observacoes']))))."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login']."')");
		if (empty($pega_id)) $pega_id = mysql_insert_id();			
			if ($insere) $resultado = "Registro  ".$pega_id." cadastrado com sucesso!";
			else $resultado = "Erro ao cadastrar registro!";			
		}
		else $resultado = "Registro Duplicado!";
	}
	else $resultado = "Você não tem permissão para incluír resgistro, contacte o administrador do sistema!";
	}
	if (!$url_de_destino) $url_de_destino = "lista.php";
	include'../../painel/funcoesPHP/redireciona.php';
}
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../painel/funcoesPHP/redireciona.php";
}
?>