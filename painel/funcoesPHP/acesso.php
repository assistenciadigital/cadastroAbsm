<?

if (($_POST['login']) AND ($_POST['senha'])) {

	include "conexao.php";

	$login = addslashes ($login);
	$senha = addslashes ($senha);
	
	$cons = mysql_query ("SELECT id, nivel FROM $prefixo"."usuarios WHERE login='".$_POST['login']."' AND senha='".$_POST['senha']."' AND status IS NULL ORDER BY id DESC");

	if (mysql_num_rows ($cons)) {
			$usuario_logado = mysql_result ($cons, 0, 'id');
			$_SESSION['nivel'] = mysql_result ($cons, 0, 'nivel');
			
			session_start();
			$_SESSION['usuario_logado'] = $usuario_logado;
			$_SESSION['nivel'] = $_SESSION['nivel'];
			
			$url_de_destino = '../index.php';

			@mysql_query ("UPDATE $prefixo"."usuarios SET ultimo_acesso=novo_acesso, novo_acesso='".date('Y-m-d H:i:00')."' WHERE id='".$_SESSION['usuario_logado']."'");

	
	}
	
	else {
		$erro = urlencode ("Combinação Usuário/Senha incorretos!");
		$url_de_destino = "../login.php?erro=$erro&login=$login";
	}

}
else {
	$erro = urlencode ("Dados Incompletos, Por Favor digite um Login e Senha!");
	$url_de_destino = "../login.php?erro=$erro&login=$login";
}
include "redireciona.php";

?>