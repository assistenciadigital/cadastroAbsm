<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');
include("requerido/verifica.php");

session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>

<link rel="stylesheet" href="css_menu/jquery-ui.css" />
<script src="css_menu/jquery-1.9.1.js"></script>
<script src="css_menu/jquery-ui.js"></script>
<link rel="stylesheet" href="css_menu/style.css" />

 <script>
  $(function() {
    $( "#menu" ).menu();
  });
 </script>
  
<?php include("requerido/dataehora.php");?>

</head>
<body>
<div id="tudo">
<div id="conteudo">
<div align="left">
     <strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
     <hr>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" valign="middle" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="right" valign="middle" ><div align="right" id="clock"></div></td>
       </tr>
     </table>
</div>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top">
	<?php include('css_menu\lista_menu.php')?>
	<div align="left"><img src="imagem/ABSM-HM.jpg" width="250" height="45"  /></div>
</td>
    <td width="90%" align="left" valign="top" scope="col"><div><iframe align="top" marginheight="1" marginwidth="1" width="100%" height="800" frameborder="0" scrolling="No" src="abertura.php" name="palco" id="palc"></iframe></div></td>
  </tr>
</table>
</div> 
</div>
</body>
</html>