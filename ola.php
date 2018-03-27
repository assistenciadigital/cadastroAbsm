<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>
    
<?php
$localizacao = array('Brasil', 'RJ', 'Rio de Janeiro', 'Centro');
$list($pais, $estado, $cidade, $bairro ) = $localizacao;

// índices não-numéricos
$bd_config = array();
$bd_config['usuario'] = 'root';
$bd_config['senha'] = 'root';
$bd_config['banco'] = 'teste';
list( $usuario, $senha, $banco ) = array_values( $bd_config );
?>
</body>
</html>