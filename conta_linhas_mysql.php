
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?php
include("requerido/conexao.php");

$sql_titular = "SELECT cliente, nome as nome_titular, cpf as cpf_titular from cliente";
$rs_titular = mysql_query($sql_titular);
$conta_titular =  mysql_num_rows($rs_titular);
if ($conta_titular != 0 or (empty($sql_titular))){
while(list($cliente, $nome_titular, $cpf_titular) = mysql_fetch_row($rs_titular)){

  		}
		print $conta_titular;
}else{
	print "nada encontrado";}
 ?>
</body>
</html>