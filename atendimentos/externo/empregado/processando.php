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
			$result_log = mysql_query("select * from convenio_empregado where id='".$_GET['id']."'");
			if (!$result_log) {
				echo 'Could not run query: ' . mysql_error();
				exit;
			}
			if (mysql_num_rows($result_log) > 0) {
				while ($row = mysql_fetch_assoc($result_log)) {
						$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', CPF: '.$row[cpf].', Identidade:'.$row[identidade].', Emissor: '.$row[emissor].', Empresa: '.$row[empresa].', Matricula: '.$row[matricula].', Funcao: '.$row[funcao].', Setor: '.$row[setor].', Nome: '.$row[nome].', Nascimento: '.$row[nascimento].', Sexo: '.$row[sexo].', Endereco: '.$row[endereco].', Numero: '.$row[numero].', Complemento: '.$row[complemento].', Bairro: '.$row[bairro].', Cidade: '.$row[cidade].', UF: '.$row[uf].', CEP: '.$row[cep].', Celular: '.$row[celular].', Fone: '.$row[fone].', E-mail: '.$row[email].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
					}
				}	
				$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
				
			// fim guarda informacao para o log		
	
	
			mysql_query ("DELETE FROM convenio_empregado WHERE id='".$_GET['id']."'");
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
		$result_log = mysql_query("select * from convenio_empregado where id='".$_POST['id']."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
				$observacao = ($_GET['acao'].', Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', CPF: '.$row[cpf].', Identidade:'.$row[identidade].', Emissor: '.$row[emissor].', Empresa: '.$row[empresa].', Matricula: '.$row[matricula].', Funcao: '.$row[funcao].', Setor: '.$row[setor].', Nome: '.$row[nome].', Nascimento: '.$row[nascimento].', Sexo: '.$row[sexo].', Endereco: '.$row[endereco].', Numero: '.$row[numero].', Complemento: '.$row[complemento].', Bairro: '.$row[bairro].', Cidade: '.$row[cidade].', UF: '.$row[uf].', CEP: '.$row[cep].', Celular: '.$row[celular].', Fone: '.$row[fone].', E-mail: '.$row[email].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
			}
		}	
		
		$insere_log = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$observacao."')");
		
	// fim guarda informacao para o log	

			$altera = mysql_query("UPDATE convenio_empregado SET cpf='".$_POST['cpf']."', identidade='".trim(addslashes(htmlentities(strtoupper($_POST['identidade']))))."', emissor='".trim(addslashes(htmlentities(strtoupper($_POST['emissor']))))."', empresa='".$_POST['empresa']."', matricula='".trim(addslashes(htmlentities(strtolower($_POST['matricula']))))."', funcao='".trim(addslashes(htmlentities(strtoupper($_POST['funcao']))))."', setor='".trim(addslashes(htmlentities(strtoupper($_POST['setor']))))."', nome='".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', nascimento='".data_date($_POST['nascimento'])."', sexo='".$_POST['sexo']."', cep='".$_POST['cep']."', endereco='".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', numero='".$_POST['numero']."', complemento='".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', bairro='".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', cidade='".trim(addslashes(htmlentities(strtoupper($_POST['cidade']))))."', uf='".trim(addslashes(htmlentities(strtoupper($_POST['uf']))))."', celular='".$_POST['celular']."', fone='".$_POST['fone']."', email='".trim(addslashes(htmlentities(strtolower($_POST['email']))))."', data='".date('Y-m-d H:i:00')."', usuario='".$_SESSION['login_usuario']."' where id='".$_POST['id']."'");
			if($altera) $resultado = "Registro alterado ".$_POST['id']." com sucesso";
			else $resultado = "Erro ao alterar o registro: ".$_POST['id'].".";

	}
	else $resultado = "Você não tem permissão para alterar o registro ".$_POST['id'].", contacte o administrador do sistema!";
	}

//------------------------------------->> INCLUIR
	else{
		
		if(base64_decode($_SESSION['nivel_usuario'])<=2){
		
		if (!(mysql_num_rows (mysql_query ("SELECT id FROM convenio_empregado WHERE cpf='".$_POST['cpf']."'")))) {		
			$insere = mysql_query ("INSERT convenio_empregado(cpf, identidade, emissor, empresa, matricula, funcao, setor, nome, nascimento, sexo, cep, endereco, numero, complemento, bairro, cidade, uf, celular, fone, email, data, usuario) VALUES ('".$_POST['cpf']."', '".$_POST['identidade']."', '".trim(addslashes(htmlentities(strtoupper($_POST['emissor']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['empresa']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['matricula']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['funcao']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['setor']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['nome']))))."', '".data_date($_POST['nascimento'])."', '".$_POST['sexo']."', '".$_POST['cep']."', '".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', '".$_POST['numero']."', '".trim(addslashes(htmlentities(strtoupper($_POST['complemento']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['cidade']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['uf']))))."', '".$_POST['celular']."', '".$_POST['fone']."', '".trim(addslashes(htmlentities(strtolower($_POST['email']))))."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."')");
		$id = mysql_insert_id();
			
		// inicio guarda informacao para o log
		$result_log = mysql_query("select * from convenio_empregado where id='".mysql_insert_id()."'");
		if (!$result_log) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if (mysql_num_rows($result_log) > 0) {
			while ($row = mysql_fetch_assoc($result_log)) {
				$observacao = ('inclusao, Date: '.date('Y-m-d H:i:00').', User: '.$_SESSION['login_usuario'].', ID: '.$row[id].', CPF: '.$row[cpf].', Identidade: '.$row[identidade].', Emissor: '.$row[emissor].',  Empresa: '.$row[empresa].',  Matricula: '.$row[matricula].',  Setor: '.$row[setor].',  Funcao: '.$row[funcao].',  Nome: '.$row[nome].',  Nascimento: '.$row[nascimento].', Sexo: '.$row[sexo].', Endereco: '.$row[endereco].', Numero: '.$row[numero].', Complemento: '.$row[complemento].', Bairro: '.$row[bairro].', Cidade: '.$row[cidade].', UF: '.$row[uf].', CEP: '.$row[cep].', Celular: '.$row[celular].', Fone: '.$row[fone].', E-mail: '.$row[email].', Autorizador: '.$row[autorizador].', Funcao: '.$row[funcao].', Setor: '.$row[setor].', Data/Hora: '.$row[data].', Usuario: '.$row[usuario]);
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