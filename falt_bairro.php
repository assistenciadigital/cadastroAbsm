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
	header("location:fcon_bairro.php");	
}

$pega_bairro = $_GET[bairro];

$sql = "SELECT bairro, uf, cidade, descricao as descricaobairro, data, hora, usuario FROM bairro WHERE bairro=$pega_bairro";
$rs = mysql_query($sql);

list($bairro, $uf, $cidade, $descricaobairro, $data, $hora, $usuario) = mysql_fetch_row($rs);

$pega_uf = $uf;
$pega_cidade = $cidade;

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

$(document).ready(function(){
        // Evento change no campo uf  
         $("select[name=fuf]").change(function(){
            // Exibimos no campo cidade antes de concluirmos
			$("select[name=fcidade]").html('<option value="">Carregando Cidade</option>');
            // Exibimos no campo cidade antes de selecionamos a cidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
			$("select[name=fbairro]").html('<option value="">Selecione Cidade</option>');
			// Passando uf por parametro para a pagina cfil_cidade.php
            $.post("cfil_cidade.php",
                  {fuf:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
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
<strong>Confirma Alteração Bairro? | <a href="fcon_bairro.php">Retornar</a></strong>
<hr>
<form action="calt_bairro.php?bairro=<?php print $bairro;?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="580" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td width="130" align="left" valign="top"><strong>Bairro:</strong></td>
      <td width="450" align="left" valign="top"><input name="fbairro" type="text" disabled="disabled" id="fbairro" value="<?php print $bairro; ?>" size="2" maxlength="2" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>UF:</strong></td>
      <td align="left" valign="top"><strong>
        <select name="fuf" id="fuf">
          <option value="<?php print $uf; ?>"><?php print $uf; ?></option>
          <option value=""></option>
          <option value="AC">AC</option>
          <option value="AL">AL</option>
          <option value="AM">AM</option>
          <option value="AP">AP</option>
          <option value="BA">BA</option>
          <option value="CE">CE</option>
          <option value="DF">DF</option>
          <option value="ES">ES</option>
          <option value="GO">GO</option>
          <option value="MA">MA</option>
          <option value="MG">MG</option>
          <option value="MS">MS</option>
          <option value="MT">MT</option>
          <option value="PA">PA</option>
          <option value="PB">PB</option>
          <option value="PE">PE</option>
          <option value="PI">PI</option>
          <option value="PR">PR</option>
          <option value="RJ">RJ</option>
          <option value="RN">RN</option>
          <option value="RO">RO</option>
          <option value="RR">RR</option>
          <option value="RS">RS</option>
          <option value="SC">SC</option>
          <option value="SE">SE</option>
          <option value="SP">SP</option>
          <option value="TO">TO</option>
        </select>
      </strong></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Cidade:</strong></td>
      <td align="left" valign="top"><strong>
        <select name="fcidade" id="fcidade">
          <?php 
		$sqlcidade = "select cidade, descricao from cidade where cidade = '$pega_cidade'";
		$rscidade = mysql_query($sqlcidade);
		while(list($codigo, $descricao) = mysql_fetch_row($rscidade)) { ?>
          <option value="<?php print $codigo; ?>"><?php print $descricao; ?></option>
          <?php } ?>
          <option value=""></option>
          <?php 
		$sqlcidadenew = "select cidade, descricao from cidade where uf = '$pega_uf' order by descricao";
		$rscidadenew = mysql_query($sqlcidadenew);
		while(list($codigo, $descricao) = mysql_fetch_row($rscidadenew)) {
		?>
          <option value="<?php print $codigo; ?>"><?php print $descricao; ?></option>
          <?php } ?>
        </select>
      </strong></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Descrição:</strong></td>
      <td align="left" valign="top"><input name="fdescricao" type="text" id="fdescricao" value="<?php print $descricaobairro; ?>" size="30" maxlength="30" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Data/Hora:</strong></td>
      <td align="left" valign="top"><input name="fdata2" type="text" disabled="disabled" id="fdata2" value="<?php print $data_final; ?> <?php print $hora; ?>" size="16" maxlength="16" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário:</strong></td>
      <td align="left" valign="top"><input name="fusuario2" type="text" disabled="disabled" id="fusuario2" value="<?php print $usuario; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Usuário atual:</strong></td>
      <td align="left" valign="top"><input name="fusuario_atual2" type="text" disabled="disabled" id="fusuario_atual2" value="<?php print $loginusuario_atual; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="submit" name="fok2" id="fok2" value="OK" /></td>
    </tr>
  </table>
</form>
</td>
</tr>
</table>
</div>
<hr>
</div>
</body>
</html>