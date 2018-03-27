<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
$pega_medico = $_GET[medico];

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2")
{
	header("location:fcon_cliente.php");	
}

$sql = "SELECT medico,especialidade,conselho,area,limite,telefone,cpf,nome,cep,endereco,uf,cidade,bairro,descricao,data,hora,usuario from medico WHERE medico='$pega_medico'";

$rs = mysql_query($sql);

list($medico,$especialidade,$conselho,$area,$limite,$telefone,$cpf,$nome,$cep,$endereco,$uf,$cidade,$bairro,$descricao_medico,$data,$hora,$usuario) = mysql_fetch_row($rs);

$pega_uf  = $uf;
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
if(document.cadastro.fnome.value=="")
	{
	alert("O Campo nome é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fparentesco.value=="")
	{
	alert("O Campo parentesco é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fsexo.value=="")
	{
	alert("O Campo sexo é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdatanascimento.value=="")
	{
	alert("O Campo data de nascimento é obrigatório!");
	return false;
	}
else
	if(document.cadastro.ftipodependente.value=="")
	{
	alert("O Campo tipo é obrigatório!");
	return false;
	}
else

return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdatainclusao']").mask('99/99/9999');
  				  //$("input[name='flimite']").mask('99');	
				  $("input[name='ftelefone']").mask('(99)9999-9999');	
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
<strong>Alteração Médico | <a href="fcad_medico.php">Retornar</a> </strong>
<hr>
<form action="calt_medico.php?medico=<?php print $pega_medico;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
  <table width="680" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td align="left"><strong>Médico: </strong></td>
      <td align="left"><strong>
      <input name="femitente" type="text" disabled="disabled" id="femitente" onblur="return verificarcpf(this.value)" value="<?php print $pega_medico; ?>" size="10" maxlength="10" readonly="readonly"/>
      </strong></td>
    </tr>
    <tr>
      <td align="left" valign="top"><strong>Especialidade:</strong></td>
      <td align="left" valign="top"><strong>
        <select name="fespecialidade" id="fespecialidade">
          <option value="<?php print $especialidade;?>" selected="selected"> <?php print $especialidade;?></option>
          <option value=""></option>
          <option value="MEDICO">MEDICO</option>
          <option value="ODONTOLOGIA">ODONTOLOGIA</option>
        </select>
      Conselho:
      <input name="fconselho" type="text" id="fconselho" onblur="return" value="<?php print $conselho; ?>" size="20" maxlength="20"/>
      Limite: 
      <input name="flimite" type="text" id="flimite" onblur="return" value="<?php print $limite; ?>" size="2" maxlength="2"/>
      </strong></td>
    </tr>
    <tr>
      <td width="180" align="left"><strong>Área: </strong></td>
      <td width="500" align="left"><strong>
        <input name="farea" type="text" id="farea" onblur="return" value="<?php print $area; ?>" size="50" maxlength="50"/>
        CPF:

        <input name="fcpf" type="text" id="fcpf" onblur="return verificarcpf(this.value)" value="<?php print $cpf; ?>" size="14" maxlength="14"/>
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Nome:</strong></td>
      <td align="left"><strong>
        <input name="fnome" type="text" id="fnome" value="<?php print $nome; ?>" size="50" maxlength="100" />
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>CEP:</strong></td>
      <td align="left"><label for="fenderecotitular"><strong>
        <input name="fcep" type="text" id="fcep" value="<?php print $cep; ?>" size="10" maxlength="10" />
      UF:
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
      Telefone: </strong></label>
        <label for="ftelefone"></label>
        <input name="ftelefone" type="text" id="ftelefone" value="<?php print $telefone; ?>" size="14" maxlength="14" />
        <label for="fenderecotitular"><strong>
        </strong></label></td>
    </tr>
    <tr>
      <td align="left"><strong>Endereço:</strong></td>
      <td align="left"><strong>
        <input name="fendereco" type="text" id="fendereco" value="<?php print $endereco; ?>" size="50" maxlength="100" />
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Cidade:</strong></td>
      <td align="left"><strong>
        <input name="fcidade" type="text" id="fcidade" value="<?php print $cidade; ?>" size="50" maxlength="100" />
        </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Bairro:</strong></td>
      <td align="left"><strong>
        <input name="fbairro" type="text" id="fbairro" value="<?php print $bairro; ?>" size="50" maxlength="100" />
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Observação:</strong></td>
      <td align="left"><strong>
        <textarea name="fdescricao" cols="50" id="fdescricao"><?php print $descricao_medico; ?></textarea>
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