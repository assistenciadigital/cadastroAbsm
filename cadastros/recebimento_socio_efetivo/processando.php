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
			$titular  = @mysql_fetch_assoc(mysql_query("SELECT titular FROM financeiro_recebimento WHERE id='".$_GET['id']."'"));
	      	mysql_query ("DELETE FROM financeiro_recebimento WHERE id='".$_GET['id']."'");
			$sucesso = mysql_affected_rows();
			if ($sucesso) $resultado = "Registro: ".$_GET['id'].", excluido com sucesso!";
			else $resultado = "Erro na exclusão do registro ".$_GET['id'];
	}
	else $resultado = "Você não tem permissão para excluír o registro ".$_GET['id'].", Contacte o Administrador do Sistema!";	
	}
//------------------------------------->> ALTERAR	
	else if ($_GET['acao'] == 'alterar'){	
	
	if(($_SESSION['nivel_usuario'])<=2){

			$altera = mysql_query("UPDATE financeiro_recebimento SET id ='".$_POST['id']."', titular='".$_POST['titular']."', descricao='".trim(addslashes(htmlentities(strtoupper($_POST['descricao']))))."', formapagto='".$_POST['formapagto']."', competencia='".data_date($_POST['competencia'])."', recebimento='".data_date($_POST['recebimento'])."', valor='".$_POST['valor']."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login']."' where id='".$_POST['id']."' AND titular='".$_POST['titular']."'");
			if($altera) $resultado = "Registro: ".$_POST['id'].", alterado com sucesso!";
			else $resultado = "Erro ao alterar o registro: ".$_POST['id'].".";

	}
	else $resultado = "Você não tem permissão para alterar o registro ".$_POST['id'].", contacte o administrador do sistema!";
	}

//------------------------------------->> INCLUIR
	else{
		
		if(($_SESSION['nivel_usuario'])<=2){
		
		if (!(mysql_num_rows (mysql_query ("SELECT id FROM financeiro_recebimento WHERE id='".$_POST['id']."' AND titular='".$_POST['titular']."'")))) {		
			$insere = mysql_query ("INSERT financeiro_recebimento(titular, descricao, formapagto, competencia, recebimento, valor, data, usuario) VALUES('".$_POST['titular']."', '".trim(addslashes(htmlentities(strtoupper($_POST['descricao']))))."', '".$_POST['formapagto']."', '".data_date($_POST['competencia'])."', '".data_date($_POST['recebimento'])."', '".$_POST['valor']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login']."')");
		$id = mysql_insert_id();
			
			if ($insere) $resultado = "Registro  ".$id." cadastrado com sucesso!";
			else $resultado = "Erro ao cadastrar registro!";
			
		}
		else $resultado = "Registro Duplicado!";
	}
	else $resultado = "Você não tem permissão para incluír resgistro, contacte o administrador do sistema!";
	}
	
	if ($_GET['acao'] == 'deleta'){
		if (!$url_de_destino) $url_de_destino = "lista.php?id=".$titular['titular'];
		} else {
			if (!$url_de_destino) $url_de_destino = "lista.php?id=".$_POST['titular'];
		}
	include'../../painel/funcoesPHP/redireciona.php';	
}
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../painel/funcoesPHP/redireciona.php";
}
?>