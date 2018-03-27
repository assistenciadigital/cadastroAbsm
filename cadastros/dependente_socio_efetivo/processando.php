<?php
session_start();
if(($_SESSION['login']) AND($_SESSION['nivel'])){
	
	include "../../painel/funcoesPHP/conexao.php";
	include "../../painel/funcoesPHP/data.php";

	$nulo = "NULL";
	$no_alt = "o Seu Nível não da permissao para esta solicitação, por favor informe seu Administrador!";
	
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
//------------------------------------->> DELETAR
	if ($_GET['acao'] == 'deleta'){	
	
	if(($_SESSION['nivel_usuario'])<=2){
	
			mysql_query ("DELETE FROM dependente WHERE id='".$_GET['id']."'");
			$sucesso = mysql_affected_rows();
			if ($sucesso) $resultado = "Registro: ".$_GET['id'].", excluido com sucesso!";
			else $resultado = "Erro na exclusão do registro ".$_GET['id'];
	}
	else $resultado = "Você não tem permissão para excluír o registro ".$_GET['id'].", Contacte o Administrador do Sistema!";	
	}
//------------------------------------->> ALTERAR	
	else if ($_GET['acao'] == 'alterar'){	
	
	if(($_SESSION['nivel_usuario'])<=2){

			$altera = mysql_query("UPDATE dependente SET cpf='".$_POST['cpf']."', rg='".$_POST['rg']."', emissorrg='".trim(addslashes(htmlentities(strtoupper($_POST['emissorrg']))))."', ufrg='".$_POST['ufrg']."', emissaorg='".data_date($_POST['emissaorg'])."', cns='".trim(addslashes(htmlentities(strtoupper($_POST['cns']))))."', instituicao='".$_POST['instituicao']."', ufinstituicao='".$_POST['ufinstituicao']."', patente='".$_POST['patente']."', incorporacao='".data_date($_POST['incorporacao'])."', matricula='".trim(addslashes(htmlentities(strtoupper($_POST['matricula']))))."', status='".$_POST['status']."', classificacao='Socio Efetivo', acomodacao='Ambulatorio | Enfermaria', tipo='".$_POST['instituicao']."', plano='Socio Efetivo', inclusao='".data_date($_POST['inclusao'])."', exclusao='".data_date($_POST['exclusao'])."', motivoexclusao='".$_POST['motivoexclusao']."', formapagto='".$_POST['formapagto']."', assistencia='".$_POST['assistencia']."', nome='".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', cor='".$_POST['cor']."', nascimento='".data_date($_POST['nascimento'])."', sexo='".$_POST['sexo']."', ufnaturalidade='".$_POST['ufnaturalidade']."', naturalidade='".$_POST['naturalidade']."', pai='".trim(addslashes(htmlentities(strtoupper($_POST['pai']))))."', mae='".trim(addslashes(htmlentities(strtoupper($_POST['mae']))))."', estadocivil='".$_POST['estadocivil']."', conjuge='".trim(addslashes(htmlentities(strtoupper($_POST['conjuge']))))."', ocupacao='".$_POST['ocupacao']."', profissao='".$_POST['profissao']."', endereco='".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', numero='".trim(addslashes(htmlentities(strtoupper($_POST['numero']))))."', complemento='".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', bairro='".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."',  uf='".$_POST['uf']."', cidade='".$_POST['cidade']."', cep='".$_POST['cep']."', email='".trim(addslashes(htmlentities(strtoupper($_POST['email']))))."', fonecel='".$_POST['fonecel']."', foneres='".$_POST['foneres']."', fonecom='".$_POST['fonecom']."', detalhe='".trim(addslashes(htmlentities(strtoupper($_POST['observacoes']))))."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login']."' where id='".$_POST['id']."'");
			if($altera) $resultado = "Registro: ".$_POST['id'].", alterado com sucesso!";
			else $resultado = "Erro ao alterar o registro: ".$_POST['id'].".";

	}
	else $resultado = "Você não tem permissão para alterar o registro ".$_POST['id'].", contacte o administrador do sistema!";
	}

//------------------------------------->> INCLUIR
	else{
		
		if(($_SESSION['nivel_usuario'])<=2){
		
if (!(mysql_num_rows (mysql_query ("SELECT id FROM dependente WHERE id='".$_POST['id']."'")))) {		
			$insere = mysql_query ("INSERT cadastro(cpf, rg, emissorrg, ufrg, emissaorg, cns, instituicao, ufinstituicao, patente,	 incorporacao, matricula, status, classificacao, acomodacao, tipo, plano, inclusao, exclusao, motivoexclusao, formapagto, assistencia, nome, cor, nascimento, sexo, ufnaturalidade, naturalidade, pai, mae, estadocivil, conjuge, ocupacao, profissao, endereco, numero, complemento, bairro, uf, cidade, cep, email, fonecel, foneres, fonecom, detalhe, data, usuario) VALUES ('".$_POST['cpf']."', '".$_POST['rg']."', '".trim(addslashes(htmlentities(strtoupper($_POST['emissorrg']))))."', '".$_POST['ufrg']."', '".data_date($_POST['emissaorg'])."', '".trim(addslashes(htmlentities(strtoupper($_POST['cns']))))."', '".$_POST['instituicao']."', '".$_POST['ufinstituicao']."', '".$_POST['patente']."', '".data_date($_POST['incorporacao'])."', '".trim(addslashes(htmlentities(strtoupper($_POST['matricula']))))."', '".$_POST['status']."', 'Socio Efetivo', 'Ambulatorio | Enfermaria', '".$_POST['instituicao']."', 'Socio Efetivo', '".data_date($_POST['inclusao'])."', '".data_date($_POST['exclusao'])."', '".$_POST['motivoexclusao']."', '".$_POST['formapagto']."', '".$_POST['assistencia']."', '".$_POST['cor']."','".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', '".data_date($_POST['nascimento'])."', '".$_POST['sexo']."', '".$_POST['ufnaturalidade']."', '".$_POST['naturalidade']."', '".trim(addslashes(htmlentities(strtoupper($_POST['pai']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['mae']))))."', '".$_POST['estadocivil']."', '".trim(addslashes(htmlentities(strtoupper($_POST['conjuge']))))."', '".$_POST['ocupacao']."', '".$_POST['profissao']."', '".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['numero']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', '".$_POST['uf']."', '".$_POST['cidade']."', '".$_POST['cep']."', '".trim(addslashes(htmlentities(strtolower($_POST['email']))))."', '".$_POST['fonecel']."', '".$_POST['foneres']."',  '".$_POST['fonecom']."',  '".trim(addslashes(htmlentities(strtoupper($_POST['observacoes']))))."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login']."')");
			
			if ($insere) $resultado = "Registro  ".$id." cadastrado com sucesso!";
			else $resultado = "Erro ao cadastrar registro!";
			
		}
		else $resultado = "Registro Duplicado!";
	}
	else $resultado = "Você não tem permissão para incluír resgistro, contacte o administrador do sistema!";
	}
	
	if ($_GET['acao'] == 'deleta'){
		if (!$url_de_destino) $url_de_destino = "../dependente_socio_efetivo/lista.php?id=".$titular;
		} else {
			if (!$url_de_destino) $url_de_destino = "../dependente_socio_efetivo/lista.php?id=".$_POST['titular'];
		}
	include'../../painel/funcoesPHP/redireciona.php';	
}
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../painel/funcoesPHP/redireciona.php";
}
?>