<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
<?php

/**
 * Entrada das 4 notas do aluno
 */
$nota1 = 10;
$nota2 = 10;
$nota3 = 10;
$nota4 = 10;

/**
 * Obtendo a média do aluno
 */
$resultado = ($nota1 + $nota2 + $nota3 + $nota4) / 4;

/**
 * Crio a mensagem
 */
$mensagem = '';
if ( $resultado >= 7 and $resultado != 10 ) {

  $mensagem = ' o aluno foi aprovado.';

} elseif ( $resultado == 0 ) {

  $mensagem = ' estude mais, você não acertou nada.';

} elseif ( $resultado == 10 ) {

  $mensagem = ' parabéns! Aprovado com nota máxima.';

} else {

  $mensagem = ' o aluno foi reprovado.';

}

/**
 * Retornando a média
 */
echo $resultado . $mensagem;

?>
</body>
</html>