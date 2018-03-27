<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and $nivelusuario_atual != "4")
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
		 
		      	// Evento change no campo cidade 
	 	$("select[name=fcidade]").change(function(){
            // Exibimos no campo modelo antes de concluirmos
			$("select[name=fbairro]").html('<option value="">Carregando Bairro</option>');
            // Passando marca por parametro para a pagina cfil_bairro.php
            $.post("cfil_bairro.php",
                  {fcidade:$(this).val()},
                  // Carregamos o resultado acima para o campo modelo
				  function(valor){
                     $("select[name=fbairro]").html(valor);
                  }
                  )
            
         })
	 
	  })

function validacampos()
{
if(document.cadastro.finscricao.value=="")
	{
	alert("O Campo inscricao é obrigatório!");
	return false;
	}
else
	if(document.cadastro.frazao_social.value=="")
	{
	alert("O Campo razao social é obrigatório!");
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
<?php include("requerido/dataehora.php");?>
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
<strong>Cadastro Fornecedor | <a href="menu.php">Retornar</a></strong>
<hr>
<form action="ccad_recibo_destinatario.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="180" align="left"><strong> CPF/CNPJ:
      
    </strong></td>
    <td width="500" align="left"><strong>
      <input name="finscricao" type="text" id="finscricao" size="14" maxlength="14" onblur="return verificarcpf(this.value)"/>
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Razão Social:</strong></td>
    <td align="left"><strong>
      <input name="frazao_social" type="text" id="frazao_social" size="50" maxlength="100" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Nome Fantasia:</strong></td>
    <td align="left"><strong>
      <input name="fnome_fantasia" type="text" id="fnome_fantasia" size="50" maxlength="100" onfocus="this.value=frazao_social.value"/>
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>CEP:</strong></td>
    <td align="left"><label for="fenderecotitular"><strong>
      <input name="fcep" type="text" id="fcep" size="10" maxlength="10" />
      UF:      
      <input name="fuf" type="text" id="fuf" size="2" maxlength="2" />
      </strong></label></td>
  </tr>
  <tr>
    <td align="left"><strong>Cidade:</strong></td>
    <td align="left"><strong>
      <input name="fcidade" type="text" id="fcidade" size="50" maxlength="100" />
      </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Bairro:</strong></td>
    <td align="left"><strong>
      <input name="fbairro" type="text" id="fbairro" size="50" maxlength="100" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Endereço:</strong></td>
    <td align="left"><strong>
      <input name="fendereco" type="text" id="fendereco" size="50" maxlength="100" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Número: </strong></td>
    <td align="left"><strong>
      <input name="fnumero" type="text" id="fnumero" size="10" maxlength="10" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>E-mail:</strong></td>
    <td align="left"><strong>
      <input name="femail" type="text" id="femail" size="50" maxlength="100" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Telefone:</strong></td>
    <td align="left"><strong>
      <input name="ftelefone" type="text" id="ftelefone" size="10" maxlength="10" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Fax:</strong></td>
    <td align="left"><strong>
      <input name="ffax" type="text" id="ffax" size="10" maxlength="10" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Celular:</strong></td>
    <td align="left"><strong>
      <input name="fcelular" type="text" id="fcelular" size="10" maxlength="10" />
    </strong></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"><input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
</table>
</form>
<hr>
</div>
</div>
</body>
</html>