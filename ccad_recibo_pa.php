<?php
include("requerido/verifica.php");
include("requerido/validacao.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

//$cnpj = $_POST['cnpj']; <--Pega o que foi digitado, se o method = POST
//$cnpj = preg_replace("/[^0-9]/", "", $cnpj); <--Deixa somente números
//$cnpj = substr($cnpj, 0, 5); <--Copia os 5 primeiros caracteres

#CAMPOS DA TABELA
$valor = $_POST[fvalor];
$formapagto = $_POST[fformapagto];
$banco = $_POST[fbanco];
$agencia = $_POST[fagencia];
$doctopagto = $_POST[fdoctopagto];
$datadocto = data_banco($_POST[fdatadocto]);
$tipo = substr($_POST[fdestinatario],0,1); 
$destinatario = preg_replace("/[^0-9]/", "", $_POST[fdestinatario]); 
$emitente = $_POST[femitente];
$referencia = $_POST[freferencia];
$titular = $_POST[ftitular];
$descricao = trim(addslashes(htmlentities(strtoupper($_POST[fdescricao]))));
$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

include("requerido/conexao.php");

#VERIFICA REGISTRO DUPLICADO
$sqlv = "SELECT recibo,valor,emitente,destinatario,referencia,descricao,data,hora,usuario FROM recibo WHERE recibo = '$recibo'";
$rsv = mysql_query($sqlv);


while(list($recibov,$valorv,$emitentev,$destinatariov,$referenciav,$descricaov,$datav,$horav,$usuariov) = mysql_fetch_row($rsv)) {
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
  $sql = "INSERT into recibo(valor,formapagto,doctopagto,banco,agencia,datadocto,emitente,destinatario,tipo,referencia,titular,mes_ano,descricao,data,hora,usuario)
          VALUES('$valor','$formapagto','$doctopagto','$banco','$agencia','$datadocto','$emitente','$destinatario','$tipo','$referencia','$titular','$mes_ano','$descricao','$data_atual','$hora_atual','$loginusuario_atual')";
  $rs = mysql_query($sql);
  $recibo = mysql_insert_id();
     
  #INICIA GRAVACAO DO LOG  
	
  $observacao = ("INC: $data_atual, $hora_atual, Recibo: $recibo, Emitente: $emitente, Destinatario: $destinatario/tipo, Referencia: $referencia, Titular: $titular, Mes/Ano: $mes_ano, Valor: $valor, Valor: $valor, Forma/Docto Pagto: $formapagto / $doctopagto, Banco/Agencia: $banco/$agencia, Data Docto: $datadocto, Descricao: $descricao, Usuario: $idusuario_atual - $loginusuario_atual");
  
  $sql_log = "INSERT into log(observacao, data, hora, idusuario, usuario) 
              VALUES('$observacao', '$data_atual', '$hora_atual','$idusuario_atual', '$loginusuario_atual')";
			  
  $rs_log = mysql_query($sql_log);
  # FIM GRAVACAO DO LOG
  header("Location: fcad_recibo_pa.php");
}
?>