<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2")
{
	header("location:menu.php");	
}
#data
$ndata = explode("-",$data); 
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
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">

function validacampos()
{
if(document.cadastro.femitente.value=="")
	{
	alert("O Campo emitente é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdescricao.value=="")
	{
	alert("O Campo descricao é obrigatório!");
	return false;
	}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdatainclusao']").mask('99/99/9999');
				  $("input[name='fdatanascimento']").mask('99/99/9999');
				  $("input[name='fdataemissaorg']").mask('99/99/9999');
				  $("input[name='fdataincorporacao']").mask('99/99/9999');
				  $("input[name='fdatainclusao']").mask('99/99/9999');	
				  $("input[name='ffoneres']").mask('(99)9999-9999');	
				  $("input[name='ffonecel1']").mask('(99)9999-9999');	
				  $("input[name='ffonecel2']").mask('(99)9999-9999');	
				  $("input[name='ffonecel3']").mask('(99)9999-9999');	
				  $("input[name='ffonecom']").mask('(99)9999-9999');	
				  $("input[name='ffonerec']").mask('(99)9999-9999');	
				  $("input[name='fcep']").mask('99.999-999');
  }) 
</script>

</script>
<style type="text/css">

.style1 {
	color: #FF0000;
	font-size: x-small;
}
.style3 {color: #0000FF; font-size: x-small; }


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
<strong>Cadastro Referência Recibo | <a href="menu.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:700px; height: 500px; overflow: auto; vertical-align: left;">
<form action="ccad_recibo_referencia.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="180" align="left"><strong>Emitente:
      
    </strong></td>
    <td width="500" align="left">
      <select name="femitente" id="femitente">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlrecibo_emitente = "SELECT * FROM recibo_emitente ORDER BY razao_social";
         $rsrecibo_emitente = mysql_query($sqlrecibo_emitente) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsrecibo_emitente)){
            echo '<option value="'.$ln['emitente'].'">'.$ln['inscricao'].'</option>';
         }
      ?>
      </select></td>
  </tr>
  <tr>
    <td align="left"><strong>Descrição:</strong></td>
    <td align="left"><strong>
      <input name="fdescricao" type="text" id="fdescricao" size="50" maxlength="100" />
      </strong></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
</table>


</form>
<hr>
<table width="640" align="left">
<tr valign="middle">
    <th width="100" height="0" align="center" valign="middle" scope="col"><strong>Referência</strong></th>
    <th width="437" height="0" align="left" scope="col">Emitente | Descrição</th>
    <th width="80" height="0" align="left" scope="col">Usuário</th>
    <th width="23" align="left" scope="col"></th>
  </tr>
</table>
<div style="color:#009; width:680px; height: 170px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS

$sqlrecibo_referencia = "SELECT referencia,emitente,descricao,data,hora,usuario FROM recibo_referencia";
$rsrecibo_referencia = mysql_query($sqlrecibo_referencia);


while(list($referencia,$emitente,$descricao,$data,$hora,$usuario) = mysql_fetch_row($rsrecibo_referencia)) {
	
	$pega_emitente;
		
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

$contador++;	
?>
<table width="640" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" height="35" align="center" valign="middle" scope="col"><strong><?php print $referencia; ?></strong></td>
    <td width="437" height="35" align="left" scope="col"><strong><?php print $emitente; ?></strong> | <strong><?php $sqllistaemitente = "SELECT inscricao, nome_fantasia FROM recibo_emitente WHERE emitente = '$emitente'";
         $rslistaemitente = mysql_query($sqllistaemitente) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rslistaemitente)){
         echo $ln['inscricao']; echo " | ";echo $ln['nome_fantasia'];}?></strong><br/><?php print $descricao; ?></td>
    <td width="80" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="23" align="left" scope="col"><a href="falt_recibo_referencia.php?referencia=<?php print $referencia; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a><br/>
      <a href="cexc_recibo_referencia.php?referencia=<?php print $referencia; ?>"><img src="imagem/ico-delete.png" alt="" width="23" height="23" onclick="return confirm('Deseja excluir?')";/></a></td>
    </tr>
</table>
<?php }?>
</div>
<hr>
<div id="rodape">
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="320" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="320" align="right" scope="col">Alterar = <img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> Exclusão = <img src="imagem/ico-delete.png" alt="" width="23" height="23"/></td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>