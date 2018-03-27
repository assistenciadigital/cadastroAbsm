<title>HM - Saúde</title>

<?php
include("requerido/conexao.php");

#CAMPOS DA TABELA
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$grau = $_POST[fgrau];
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT * FROM parentesco WHERE descricao = '$descricao'";
$rsv = mysql_query($sqlv);


while(list($parentescov, $descricaov, $grauv, $datav, $horav, $usuariov) = mysql_fetch_row($rsv)) {
 $contador++;
 $pega_usuario = $usuariov;
}

if($contador >= 1) {
  #SE ENCONTROU REGISTRO DUPLICADO
  print("<script>
  alert('Registro duplicado, cadastrado por: $pega_usuario'); 
  history.back();
  </script>");
} else {
  
  #INSERE REGISTRO NO BANCO DE DADOS
  $sql = "INSERT into parentesco(descricao,grau,data,hora,usuario)
          VALUES('$descricao','$grau','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
      
  #VERIFICA CODIGO DO REGISTRO INCLUIDO  
  $sqlc = "SELECT * FROM parentesco WHERE descricao = '$descricao'";
  $rsc = mysql_query($sqlc);

  while(list($parentescoc, $descricaoc, $grauc, $datac, $horac, $usuarioc) = mysql_fetch_row($rsc)) {
  $pega_parentescoc = $parentescoc;
}  
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Parentesco: $pega_parentescoc, Descricao: $descricao, Grau: $grau, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  
  header("Location: fsus_parentesco.php?parentesco=$pega_parentescoc&descricao=$descricao&grau=$grau&data_atual=$data_atual&hora_atual=$hora_atual&usuario=$loginusuario_atual");
}
?>