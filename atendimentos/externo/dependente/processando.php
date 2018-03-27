<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";

	$nulo = "NULL";
	$no_alt = "o Seu Nível não da permissao para esta solicitação, por favor informe seu Administrador!";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../painel/css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="../../../painel/funcoesJS/funcoes.js"></script>

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
	
	if(base64_decode($_SESSION['nivel_usuario'])<=2){
	
			// inicio guarda informacao para o log
			$result_log = mysql_query("select * from convenio_dependente where id='".$_GET['id']."'");
			if (!$result_log) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			if (mysql_num_rows($result_log) > 0) {
				while ($row = mysql_fetch_assoc($result_log)) {
					$titular = $row[titular];
					$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Titular: '.$row[titular].', Nome: '.$row[nome].', Nascimento: '.date_data($row[nascimento]).', Sexo: '.$row[sexo].', Parentesco: '.$row[parentesco].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
					}
				}	
				$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
				
			// fim guarda informacao para o log			
	
			mysql_query ("DELETE FROM convenio_dependente WHERE id='".$_GET['id']."'");
			$sucesso = mysql_affected_rows();
			if ($sucesso) $resultado = "Registro ".$_GET['id']." excluido com sucesso!";
			else $resultado = "Erro na exclusão do registro ".$_GET['id'];
	}
	else $resultado = "Você não tem permissão para excluír o registro ".$_GET['id'].", Contacte o Administrador do Sistema!";	
	}
//------------------------------------->> ALTERAR	
	else if ($_GET['acao'] == 'alterar'){	
	
	if(base64_decode($_SESSION['nivel_usuario'])<=2){

		// inicio guarda informacao para o log
		$result_log = mysql_query("select * from convenio_dependente where titular='".$_POST['titular']."' AND id='".$_POST['id']."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
						$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Titular: '.$row[titular].', Nome: '.$row[nome].', Nascimento: '.date_data($row[nascimento]).', Sexo: '.$row[sexo].', Parentesco: '.$row[parentesco].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
			}
		}	
		
		$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
		
	// fim guarda informacao para o log	

			$altera = mysql_query("UPDATE convenio_dependente SET titular='".$_POST['titular']."', nome='".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', nascimento='".data_date($_POST['nascimento'])."', sexo='".$_POST['sexo']."', parentesco='".$_POST['parentesco']."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login_usuario']."' where titular='".$_POST['titular']."' AND id='".$_POST['id']."'");
			if($altera) $resultado = "Registro alterado ".$_POST['id']." com sucesso";
			else $resultado = "Erro ao alterar o registro: ".$_POST['id'].".";

	}
	else $resultado = "Você não tem permissão para alterar o registro ".$_POST['id'].", contacte o administrador do sistema!";
	}

//------------------------------------->> INCLUIR
	else{
		
		if(base64_decode($_SESSION['nivel_usuario'])<=2){
		
		if (!(mysql_num_rows (mysql_query ("SELECT id FROM convenio_dependente WHERE titular='".$_POST['titular']."' AND nome='".$_POST['nome']."'")))) {		
			$insere = mysql_query ("INSERT convenio_dependente(titular, nome, nascimento, sexo, parentesco, data, usuario) VALUES('".$_POST['titular']."', '".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', '".data_date($_POST['nascimento'])."', '".$_POST['sexo']."', '".$_POST['parentesco']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."')");
		$id = mysql_insert_id();
			
		// inicio guarda informacao para o log
		$result_log = mysql_query("select * from convenio_dependente where id='".mysql_insert_id()."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
						$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Titular: '.$row[titular].', Nome: '.$row[nome].', Nascimento: '.date_data($row[nascimento]).', Sexo: '.$row[sexo].', Parentesco: '.$row[parentesco].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
			}
		}	
		
		$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
		
	// fim guarda informacao para o log					
					
			
			if ($insere) $resultado = "Registro  ".$id." cadastrado com sucesso!";
			else $resultado = "Erro ao cadastrar registro!";
			
		}
		else $resultado = "Registro Duplicado!";
	}
	else $resultado = "Você não tem permissão para incluír resgistro, contacte o administrador do sistema!";
	}
	
	if ($_GET['acao'] == 'deleta'){
		if (!$url_de_destino) $url_de_destino = "../dependente/lista.php?id=".$titular;
		} else {
			if (!$url_de_destino) $url_de_destino = "../dependente/lista.php?id=".$_POST['titular'];
		}
	include'../../../painel/funcoesPHP/redireciona.php';	
}
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../../painel/funcoesPHP/redireciona.php";
}
?>