<title>HM - Saúde</title>
<?php 
header('Content-Type: text/html; charset=UTF-8');
include('correios.class.php');

if(isset($_GET['cep'])){
	die(print_r(Correios::cep($_GET['cep']),true));
}else{
        die('<form method="get">Informe o CEP no formato de 8 dígitos (00000000),<br/> sem traços ou pontos e pressione ENTER, para pesquisar: <input type="text" name="cep" size="8" maxlength="8"></form>');
}
?>