<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

#data
$ndata = explode("-",$data_recibo); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<style type="text/css">
.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }


body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url();
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 700px;
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}
</style>
</head>
<body>
<div id="tudo">
<div id="conteudo">

<?php

$sql = "SELECT carteira, codigo_titular, nome_titular, data_nascimento_titular, data_inclusao_titular, codigo_dependente, nome_dependente, data_nascimento_dependente, data_inclusao_dependente, produto_regulamentado, assistencia, acomodacao, dataemissao, via, datavalidade, data, hora, usuario FROM carteira";
$rs = mysql_query($sql);
while(list($carteira, $codigo_titular, $nome_titular, $data_nascimento_titular, $data_inclusao_titular, $codigo_dependente, $nome_dependente, $data_nascimento_dependente, $data_inclusao_dependente, $produto_regulamentado, $assistencia, $acomodacao, $dataemissao, $via, $datavalidade, $data, $hora, $usuario) = mysql_fetch_row($rs)) {

$dados = array($carteira, $codigo_titular, $nome_titular, $data_nascimento_titular, $data_inclusao_titular, $codigo_dependente, $nome_dependente, $data_nascimento_dependente, $data_inclusao_dependente, $produto_regulamentado, $assistencia, $acomodacao, $dataemissao, $via, $datavalidade, $data, $hora, $usuario);
$arrlength=count($dados);

for($x=0;$x<$arrlength;$x++)
   {
   echo $dados[$x];
   echo "<br>";
   }

}
?>
</body>
</html>