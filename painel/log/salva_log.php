<?php
/**
* Função para salvar mensagens de LOG no MySQL
*
* @param string $mensagem - A mensagem a ser salva
*
* @return bool - Se a mensagem foi salva ou não (true/false)
*/
function salvaLog($mensagem) {
// Usamos o mysql_escape_string() para poder inserir a mensagem no banco
//   sem ter problemas com aspas e outros caracteres
$mensagem = mysql_escape_string($mensagem);
include '../funcoesPHP/conexao.php';
// Monta a query para inserir o log no sistema

$sql = mysql_query("INSERT log(ip, data, usuario, observacao) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:00')."', '".$_SESSION['login_usuario']."', '".$mensagem."')");

if (mysql_query($sql)) {
return true;
} else {
return false;
}
}

?>