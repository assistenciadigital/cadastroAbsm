<title>HM - Saúde</title>
<?php
include("requerido/conexao.php");

$pega_plano = $_GET[plano];

$data_atual = date("Y-m-d");
$hora_atual = date("H:i:s");

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#INICIA GRAVACAO DO LOG
$sql = "SELECT * FROM plano WHERE plano=$pega_plano";
$rs = mysql_query($sql);

list($plano, $descricao, $detalhe, $datainicio, $datafim, $tipo, $indice, $valorindice, $qtdeindice, $inicio, $fim, $valormensal, $desconto, $acrescimo, $valorcobrado, $data, $hora, $usuario) = mysql_fetch_row($rs);

$observacao = ("EXC: $data_atual, $hora_atual, Plano: $plano, Descricao: $descricao, Detalhe: $detalhe, Data inicio: $datainicio, Data fim: $datafim, Tipo: $tipo, Indice: $indice, Vlr indice: $valorindice, Qtde indice: $qtdeindice, Vlr mensal: $valormensal, Desconto: $desconto, Acrescimo: $acrescimo, Vlr cobrado: $valorcobrado, Usuario: $idusuario_atual - $loginusuario_atual");
  
$sql_log = "INSERT into log(observacao, data, hora,idusuario, usuario)
            VALUES('$observacao', '$data_atual', '$hora_atual', '$idusuario_atual', '$loginusuario_atual')";

$rs_log = mysql_query($sql_log);
#FIM GRAVACAO DO LOG
 
$sql = "DELETE FROM plano WHERE plano=$pega_plano";
$rs = mysql_query($sql);

header("Location: fcon_plano.php");
?>
