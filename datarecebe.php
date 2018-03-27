<?php
include("requerido/conexao.php");

# FORMULARIO RECEBE DATA DO BANCO ano-mes-dia - ano/mes/dia
$data_recebe = explode("-",$_GET[data]); 
$dia_recebe = $data_recebe[0];
$mes_recebe = $data_recebe[1];
$ano_recebe = $data_recebe[2];
$data_final_recebe = "$ano_recebe/$mes_recebe/$dia_recebe";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Data Recebida:</td>
      <td><label for="fdata"></label>
      <input name="fdata" type="text" id="fdata" value="<?php print $data_final_recebe; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>