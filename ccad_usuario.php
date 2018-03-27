<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA
$login = strtoupper($_POST[flogin]);
$senha = md5(base64_encode($_POST[fsenha]));
$nome = trim(addslashes(htmlentities(strtoupper($_POST[fnome]))));
$nivel = base64_encode(strtoupper($_POST[fnivel]));
$ativo = base64_encode(strtoupper($_POST[fativo]));
$sms = strtoupper($_POST[fsms]);
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT * FROM usuario WHERE login = '$login'";
$rsv = mysql_query($sqlv);


while(list($idusuariov, $loginv, $nomev, $nivelv, $ativov, $smsv, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
 $contador++;
 $pega_idusuario = $idusuariov;
}

if($contador >= 1) {
  #SE ENCONTROU REGISTRO DUPLICADO
  print("<script>
  alert('Registro duplicado, cadastrado por: $pega_usuario'); 
  history.back();
  </script>");
} else {
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into usuario(login,senha,nome,nivel,ativo,sms,data,hora,usuario) VALUES('$login','$senha','$nome','$nivel','$ativo','$sms','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM usuario WHERE login = '$login'";
  $rsc = mysql_query($sqlc);

  while(list($idusuarioc, $loginc, $nomec, $nivelc, $ativoc, $smsc, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {
  $pega_idusuarioc = $idusuarioc;
}  
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, ID Usuario: $pega_idusuarioc, Login: $login, Nome: $nome, Nivel: $nivel, Ativo: $ativo, Envia SMS? $sms, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fsus_usuario.php?idusuario=$pega_idusuarioc&login=$login&nome=$nome&nivel=$nivel&ativo=$ativo&sms=$sms&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
?>