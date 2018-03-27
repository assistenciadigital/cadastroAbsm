﻿<?php

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript">
       
      $(document).ready(function(){
          
         $("select[name=fcidadeuf]").change(function(){
            $("select[name=fcidade]").html('<option value="">Carregando...</option>');
             
            $.post("cfil_cidade.php",
                  {fcidadeuf:$(this).val()},
                  function(valor){
                     $("select[name=fcidade]").html(valor);
                  }
                  )
             
         })
      })
       
</script>
<style type="text/css">

body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
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
<?php include("requerido/dataehora.php");?>
</head>

<body>
<div id="tudo">
<div id="conteudo">
<hr>
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Consulta Cidade | <a href="menu.php">Retornar</a> | <a href="fcad_cidade.php">Novo Registro +</a></strong>
<hr>
<form action="fbus_cidade.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
      <strong>UF: </strong>
      <select name="fcidadeuf">
       <option value=""></option>
        <?php
 		 include("requerido/conexao.php");
         include("requerido/verifica.php");  
		 
         $sqlufcidade = "SELECT * FROM uf ORDER BY sigla";
         $rsufcidade = mysql_query($sqlufcidade) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsufcidade)){
            echo '<option value="'.$ln['sigla'].'">'.$ln['sigla'].'</option>';
         }
      ?>        
     </select><strong> Cidade: 
     <input name="fdescricao" type="text" id="fdescricao" size="30" maxlength="30" />
     <script language="JavaScript"> document.form1.fdescricao.focus(); </script>
     </strong>
    <input type="submit" name="fpesquisar" id="fpesquisar" value="Pesquisar" />
    <label for="fdescricao"></label>
</form>
<hr>
<table width="680" align="left">
<tr valign="middle">
    <th width="60" height="0" align="left" valign="middle" scope="col">Cidade</th>
    <th width="50" height="0" align="left" scope="col">UF</th>
    <th width="400" height="0" align="left" scope="col">Descrição</th>    
    <th width="95" height="0" align="left" scope="col">Usuário</th>
    <th width="75" height="0" align="center" scope="col">Admin</th>
  </tr>
</table>
<div style="color:#009; width:700px; height: 340px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");

$uf = $_POST[fcidadeuf];
$descricao = $_POST[fdescricao];

$sql = "SELECT * FROM cidade WHERE uf = 'MT' ORDER BY uf, descricao";
$rs = mysql_query($sql);


while(list($cidade, $uf, $descricao, $tipo, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

$contador++;	
?>
<table width="680" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="60" height="35" align="left" scope="col"><?php print $cidade; ?></td>
    <td width="50" height="35" align="left" scope="col"><?php print $uf; ?></td>
    <td width="400" height="35" align="left" scope="col"><?php print $descricao; ?><br/><?php print $tipo; ?></td>
    <td width="95" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="37,5" height="35" align="center" scope="col"><a href="falt_cidade.php?cidade=<?php print $cidade; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a></td>
    <td width="37,5" height="35" align="center" scope="col"><a href="fexc_cidade.php?cidade=<?php print $cidade; ?>"><img src="imagem/ico-delete.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="340" align="right" scope="col"><strong></strong><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> = Alterar <img src="imagem/ico-delete.png" alt="" width="23" height="23"/> = Delete</td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>