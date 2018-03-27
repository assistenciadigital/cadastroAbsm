<?php
session_start();
if(($_SESSION['login_usuario'])){//AND($_SESSION['nivel'])){
	
	include "../../../painel/funcoesPHP/conexao.php";
	include "../../../painel/funcoesPHP/data.php";

	$nulo = "NULL";
	$no_alt = "o Seu Nível não da permissao para esta solicitação, por favor informe seu Administrador!";
	
	if ($_POST['id']) $pega_id = $_POST['id'];
	else if ($_GET['id']) $pega_id = $_GET['id'];
			
	$c  = @mysql_fetch_assoc(mysql_query("SELECT * FROM convenio_encaminha WHERE id='$pega_id'"));
	$filtra_empresa = @mysql_fetch_assoc(mysql_query("SELECT id, razao FROM convenio_empresa WHERE id='".$c[empresa]."'"));	
	$filtra_empregado = @mysql_fetch_assoc(mysql_query("SELECT id, nome FROM convenio_empregado WHERE id='".$c[empregado]."'"));	
	
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
			$result_log = mysql_query("select * from convenio_encaminha where id='".$_GET['id']."'");
			if (!$result_log) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			if (mysql_num_rows($result_log) > 0) {
				while ($row = mysql_fetch_assoc($result_log)) {
						$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Numero Guia: '.$row[numero_guia].', Data Guia:'.$row[data_guia].', Empresa: '.$row[empresa].' - '.$filtra_empresa['razao'].', Empregado: '.$row[empregado].' - '.$filtra_empregado['nome'].', Autorizador: '.$row[autorizador].', Funcao: '.$row[funcao].', Setor: '.$row[setor].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
					}
				}	
				$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
				
			// fim guarda informacao para o log		
	
	
			mysql_query ("DELETE FROM convenio_encaminha WHERE id='".$_GET['id']."'");
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
		$result_log = mysql_query("select * from convenio_encaminha where id='".$_POST['id']."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
				$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Numero Guia: '.$row[numero_guia].', Data Guia:'.date_data($row[data_guia]).', Empresa: '.$row[empresa].' - '.$filtra_empresa['razao'].', Empregado: '.$row[empregado].' - '.$filtra_empregado['nome'].', Autorizador: '.$row[autorizador].', Funcao: '.$row[funcao].', Setor: '.$row[setor].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
			}
		}	
		
		$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
		
	// fim guarda informacao para o log	

			$altera = mysql_query("UPDATE convenio_encaminha SET numero_guia='".$_POST['numero_guia']."', data_guia='".data_date($_POST['data_guia'])."', empresa='".$_POST['empresa']."', empregado='".$_POST['empregado']."', autorizador='".trim(addslashes(htmlentities(strtolower($_POST['autorizador']))))."', funcao='".trim(addslashes(htmlentities(strtolower($_POST['funcao']))))."', setor='".trim(addslashes(htmlentities(strtolower($_POST['setor']))))."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login_usuario']."' where id='".$_POST['id']."'");
			if($altera) $resultado = "Registro alterado ".$_POST['id']." com sucesso";
			else $resultado = "Erro ao alterar o registro: ".$_POST['id'].".";

	}
	else $resultado = "Você não tem permissão para alterar o registro ".$_POST['id'].", contacte o administrador do sistema!";
	}

//------------------------------------->> INCLUIR
	else{
		
		if(base64_decode($_SESSION['nivel_usuario'])<=2){
		
		if (!(mysql_num_rows (mysql_query ("SELECT id FROM convenio_encaminha WHERE numero_guia='".$_POST['numero_guia']."' AND empresa='".$_POST['empresa']."' AND empregado='".$_POST['empregado']."'")))) {		
			$insere = mysql_query ("INSERT convenio_encaminha(numero_guia, data_guia, empresa, empregado, autorizador, funcao, setor, data, usuario) VALUES ('".$_POST['numero_guia']."', '".data_date($_POST['data_guia'])."', '".$_POST['empresa']."', '".$_POST['empregado']."', '".trim(addslashes(htmlentities(strtoupper($_POST['autorizador']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['funcao']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['setor']))))."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."')");
		$id = mysql_insert_id();
			
		// inicio guarda informacao para o log
		$result_log = mysql_query("select * from convenio_encaminha where id='".mysql_insert_id()."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
				$observacao = ('inclusao, Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', Numero Guia: '.$row[numero_guia].', Data Guia:'.date_data($row[data_guia]).', Empresa: '.$row[empresa].' - '.$filtra_empresa['razao'].', Empregado: '.$row[empregado].' - '.$filtra_empregado['nome'].', Autorizador: '.trim(addslashes(htmlentities(strtoupper($row[autorizador])))).', Funcao: '.trim(addslashes(htmlentities(strtoupper($row[funcao])))).', Setor: '.trim(addslashes(htmlentities(strtoupper($row[setor])))).', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
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
	if (!$url_de_destino) $url_de_destino = "lista.php";
	include'../../../painel/funcoesPHP/redireciona.php';
	
}
else {
	$url_de_destino = "../../expira.php";
	$target = "_parent";
	include "../../../painel/funcoesPHP/redireciona.php";
}
?>