<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

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
<title>HM Saúde</title>
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="jquery/jquery-validacpf.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns.js"></script>
<script type="text/javascript" src="jquery/jquery-validacns_provisorio.js"></script>
<script type="text/javascript">
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdata_fabricacao']").mask('99/99/9999');
				  $("input[name='fdata_validade']").mask('99/99/9999');
  })
</script>
<?php include("requerido/dataehora.php");?>

<style>
.error {color: #FF0000;}
</style>


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

</head>
<body>
<?php
// Formata data dd/mm/aaaa para aaaa-mm-dd
function data_banco($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}

// Formata data aaaa-mm-dd para dd/mm/aaaa
function data_form($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}
// Formata texto sem expacos e formatacao
function arruma_txt($txt)
{
	$txt =                                ltrim($txt);
	$txt =                                rtrim($txt);
	$txt =                                 trim($txt);
	$txt =                         stripslashes($txt);
	$txt =                         htmlentities($txt);
	$txt =                          utf8_decode($txt);
	$txt =                     htmlspecialchars($txt);
	$txt = utf8_decode(htmlspecialchars_decode($txt));
	$txt =                           strtoupper($txt);	
	return $txt;
}

// Tira acento do texto nao resolveu - nao usar
function tira_acento($str)
{
return strtr(utf8_decode($str),utf8_decode(‘àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ’),
                                           ’aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN’);
}

// Tira acento do texto nao resolveu - nao usar
function tirar_acento($str) {
$str = preg_replace("/[^a-zA-Z ]/", "", strtr($str, "áàãâéêíóôõúüçñÁÀÃÂÉÊÍÓÔÕÚÜÇÑ", "aaaaeeiooouucnAAAAEEIOOOUUCN"));
return $str ;
}

function remove_acento($str, $enc = 'UTF-8'){
 $acentos = array(
 
 	 'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
	 'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
	 'C' => '/&Ccedil;/',
	 'c' => '/&ccedil;/', 
	 'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/', 
	 'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/', 
	 'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/', 
	 'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/', 
	 'N' => '/&Ntilde;/', 
	 'n' => '/&ntilde;/', 
	 'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/', 
	 'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/', 
	 'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/', 
	 'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/', 
	 'Y' => '/&Yacute;/', 
	 'y' => '/&yacute;|&yuml;/', 
	 'a.' => '/&ordf;/', 
	 'o.' => '/&ordm;/' );
	  return preg_replace($acentos, array_keys($acentos), htmlentities($str,ENT_NOQUOTES, $enc)); 
 }
?>

<?php
// define variables and set to empty values
$descricaoError = $detalheError = $laboratorioError = $estoqueminimoError = $estoquemaximoError = $rateioentradaError = $rateiosaidaError = $datafabricacaoError = $datavalidadeError = $loteError = $estoqueanteriorError = $estoqueatualError = "";

$fdescricao = $fdetalhe = $flaboratorio = $festoque_minimo = $festoque_maximo = $frateio_entrada = $frateio_saida = $fdata_fabricacao = $fdata_validade = $lote = $festoque_anterior = $festoque_atual = "";

$data = date("d/m/Y");
$hora = date("H:i");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{		
if (empty($_POST["fdescricao"]))
     {$descricaoError = "Campo Requerido!";}
   else
     {
     $descricao = arruma_txt(remove_acento($_POST["fdescricao"]));
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z]*$/",$descricao))
       {
       $descricaoError = "Só Letras a-z"; 
       }
     }
   
   if (empty($_POST["frecibo_final"]))
     {$recibo_finalError = "Campo Requerido!";}
   else
     {$recibo_final = $_POST["frecibo_final"];}

   if (empty($_POST["fperiodo_inicial"]))
     {$periodo_inicialError = "Campo Requerido!";}
   else
     {$periodo_inicial = $_POST["fperiodo_inicial"];}
   
   if (empty($_POST["fperiodo_final"]))
     {$periodo_finalError = "Campo Requerido!";}
   else
     {$periodo_final = $_POST["fperiodo_final"];}

   if (empty($_POST["ftipo"]))
     {$tipoError = "Campo Requerido!";}
   else
     {$tipo = $_POST["ftipo"];}
}


?>
<div id="tudo">
<div id="conteudo">
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>
<strong>Cadastro Medicamentos</strong> | <strong><a href="menu.php">Retornar</a></strong>
<hr>
<span class="error">* Campo Requerido!</span><br/>
<form id="form" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>"> 

  <table width="700" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" align="left" valign="middle"><strong>Descrição:</strong></td>
    <td width="550" align="left" valign="middle"><input name="fdescricao" type="text" id="fdescricao" style="width: auto" value="<?php echo $descricao;?>" size="60" maxlength="200" /><script language="JavaScript"> document.form.fdescricao.focus(); </script><span class="error">* <?php echo $descricaoError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Detalhe:</strong></td>
    <td align="left" valign="middle"><input name="fdetalhe" type="text" id="fdetalhe" style="width:auto" value="" size="60" maxlength="200" /><span class="error">* <?php echo $recibo_finalError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Laboratório:</strong></td>
    <td align="left" valign="middle"><select name="flaboratorio" id="flaboratorio" style="width:383" >
      <option value=""></option>
      <?php
      $sqllaboratorio = "SELECT laboratorio, descricao FROM laboratorio ORDER BY descricao";
      $rslaboratorio = mysql_query($sqllaboratorio) or die(mysql_error());
      while($ln = mysql_fetch_assoc($rslaboratorio)){
      echo '<option value="'.$ln['laboratorio'].'">'.$ln['descricao'].'</option>';}
      ?>
    </select><span class="error">* <?php echo $tipoError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Estoque Mínimo:</strong></td>
    <td align="left" valign="middle">
       <input name="festoque_minimo" type="text" id="festoque_minimo" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_inicialError;?></span></td>
  </tr>
    <tr>
      <td align="left" valign="middle"><strong>Estoque Máximo:</strong></td>
      <td align="left" valign="middle">
        <input name="festoque_maximo" type="text" id="festoque_maximo" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Rateio Entrada:</strong></td>
      <td align="left" valign="middle"><input name="frateio_entrada" type="text" id="frateio_entrada" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Rateio Saída:</strong></td>
      <td align="left" valign="middle"><input name="frateio_saida" type="text" id="frateio_saida" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Data Fabricação:</strong></td>
      <td align="left" valign="middle"><input name="fdata_fabricacao" type="text" id="fdata_fabricacao" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Data Validade:</strong></td>
      <td align="left" valign="middle"><input name="fdata_validade" type="text" id="fdata_validade" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Lote:</strong></td>
      <td align="left" valign="middle"><input name="flote" type="text" id="flote" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Estoque Anterior:</strong></td>
      <td align="left" valign="middle"><input name="festoque_anterior" type="text" id="festoque_anterior" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Estoque Atual:</strong></td>
      <td align="left" valign="middle"><input name="festoque_atual" type="text" id="festoque_atual" size="10" maxlength="10" /><span class="error">* <?php echo $periodo_finalError;?></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Data/Hora:</strong><br /><strong>Usuário:</strong></td>
      <td align="left" valign="middle"><?php print $data; ?> <?php print $hora; ?><br/><?php print strtoupper($loginusuario_atual); ?></td>
    </tr>
    <tr>
      <td align="right" valign="middle">&nbsp;</td>
      <td align="left" valign="middle"><input type="submit" name="fgrava" id="fgrava" value="Atualizar / Gravar" /></td>
    </tr>
    </table>
</form>
<hr>
</div>
</div>
</body>
</html>