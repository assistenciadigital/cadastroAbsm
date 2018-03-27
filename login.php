<?php
include("requerido/conexao.php");

// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (!empty($_POST) AND (empty($_POST['flogin']) OR empty($_POST['fsenha']))) {
    header("Location: index.php"); exit;
}

$login = $_POST[flogin];
$senha = md5(base64_encode($_POST[fsenha]));

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

$sql = "SELECT idusuario, login, nome, nivel, ativo FROM usuario WHERE login = '$login' AND senha = '$senha' AND ativo = 'U0lN' LIMIT 1";
$rs = mysql_query($sql);

if (mysql_num_rows($rs) != 1){
        // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
        //echo "Login inválido!";exit;
		header("Location: index.php"); exit;
    } else {
        // Salva os dados encontados na variável $resultado
	    $resultado = mysql_fetch_assoc($rs);
}
        // Se a sessão não existir, inicia uma
        if (!isset($_SESSION)) session_start();

        // Salva os dados encontrados na sessão
        $_SESSION['status_login'] = "liberado";
		$_SESSION['id_usuario'] = $resultado['idusuario'];
	    $_SESSION['login_usuario'] = $resultado['login'];
	    $_SESSION['nome_usuario'] = $resultado['nome'];
	    $_SESSION['nivel_usuario'] = $resultado['nivel'];
		
		$pega_idusuario = $resultado['idusuario'];
		$pega_login = $resultado['login'];
	    $pega_nome = $resultado['nome'];
	    $pega_nivel = $resultado['nivel'];
		
	    // INICIA GRAVACAO DO LOG  
        $observacao = ("ENTRADA NO SISTEMA, ID: $pega_idusuario, Login: $pega_login, Nome: $pega_nome, Nivel: $pega_nivel");
  
        $sql_log = "INSERT into log(observacao,data,hora,idusuario,usuario) 
                VALUES('$observacao','$data_atual','$hora_atual','$pega_idusuario','$pega_login')";
        $rs_log = mysql_query($sql_log);
        # FIM GRAVACAO DO LOG	
     	
        // Redireciona o visitante
        header("Location: menu.php"); exit;
	
       // Verifica se não há a variável da sessão que identifica o usuário
       if (!isset($_SESSION['login_usuario'])) {
       // Destrói a sessão por segurança
       session_destroy();
       // Redireciona o visitante de volta pro login
        header("Location: index.php"); exit;
}
?>