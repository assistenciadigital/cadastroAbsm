<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>jQuery UI Autocomplete - Default functionality</title>
<link rel="stylesheet" href="jquery/jquery-ui.css" />
<script src="jquery/jquery-1.9.1.js"></script>
<script src="jquery/jquery-ui.js"></script>
<link rel="stylesheet" href="jquery/style.css" />

<script>
$(function() {

<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");

$sql = "SELECT * FROM uf ORDER BY sigla";
$rs = mysql_query($sql);

while(list($uf, $sigla, $descricao, $capital, $imagem, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
?>	
var availableTags = ["<?php echo $sigla?>",];
<?php }?>
$( "#tags" ).autocomplete({
source: availableTags
});
});
</script>
</head>

<body>
<div class="ui-widget">
<label for="tags">Tags: </label>
<input id="tags" />
</div>
</body>
</html>