<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>

<?php
$valores = array(1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 5);
$contagem = array_count_values($valores);
foreach($contagem AS $numero => $vezes) {
echo "$numero - $vezes<br />";
}
echo "---<br />";

$valores = array(1, 2, 2, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5);
$contagem = array_count_values($valores);
foreach($contagem AS $numero => $vezes) {
if($vezes > 1) {
echo "$numero - $vezes<br />";
}
}

?>
</body>
</html>