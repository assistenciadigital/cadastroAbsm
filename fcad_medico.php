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
if(document.cadastro.fespecialidade.value=="")
	{
	alert("O Campo especialidade é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fconselho.value=="")
	{
	alert("O Campo conselho é obrigatório!");
	return false;
	}
else
	if(document.cadastro.flimite.value=="")
	{
	alert("O Campo limite é obrigatório!");
	return false;
	}
else
	if(document.cadastro.farea.value=="")
	{
	alert("O Campo area é obrigatório!");
	return false;
	}
else
if(document.cadastro.fcpf.value=="")
	{
	alert("O Campo cpf é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fnome.value=="")
	{
	alert("O Campo nome é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fcep.value=="")
	{
	alert("O Campo CEP é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fuf.value=="")
	{
	alert("O Campo UF é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fendereco.value=="")
	{
	alert("O Campo endereco é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fcidade.value=="")
	{
	alert("O Campo cidade é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fbairro.value=="")
	{
	alert("O Campo bairro é obrigatório!");
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
<strong>Cadastro Médico | <a href="menu.php">Retornar</a></strong>
<hr>
<form action="ccad_medico.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left" valign="top"><strong>Especialidade:</strong></td>
    <td align="left" valign="top"><strong>
      <select name="fespecialidade" id="fespecialidade">
        <option value=""></option>
        <option value="MEDICO">MEDICO</option>
        <option value="ODONTOLOGIA">ODONTOLOGIA</option>
        </select>
      Conselho:
      <input name="fconselho" type="text" id="fconselho" size="20" maxlength="20" onblur="return"/>
      Limite:
      <input name="flimite" type="text" id="flimite" size="2" maxlength="2"/>
    </strong></td>
  </tr>
  <tr>
    <td width="180" align="left"><strong>Área:</strong></td>
    <td width="500" align="left"><strong>
      <input name="farea" type="text" id="farea" size="50" maxlength="50" onblur="return"/>
      CPF:
<input name="fcpf" type="text" id="fcpf" size="14" maxlength="14" onblur="return verificarcpf(this.value)"/>
      </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Nome:</strong></td>
    <td align="left"><strong>
      <input name="fnome" type="text" id="fnome" size="50" maxlength="100" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>CEP:</strong></td>
    <td align="left"><label for="fenderecotitular"><strong>
      <input name="fcep" type="text" id="fcep" size="10" maxlength="10" />
      UF:
      <select name="fuf" id="fuf">
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
    Telefone:
      <input name="ftelefone" type="text" id="ftelefone" size="14" maxlength="14"/>
    </strong></label></td>
  </tr>
  <tr>
    <td align="left"><strong>Endereço:</strong></td>
    <td align="left"><strong>
      <input name="fendereco" type="text" id="fendereco" size="50" maxlength="100" />
      </strong></td>
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
    <td align="left"><strong>Observação:</strong></td>
    <td align="left"><strong>
      <input name="fobservacao" type="text" id="fobservacao" value="" size="50" maxlength="255" />
      <input type="submit" name="fok" id="fok" value="OK" />
      </strong></td>
  </tr>
  </table>
</form>
<hr>
<table width="640" align="left">
<tr valign="middle">
    <th width="100" height="0" align="center" valign="middle" scope="col">Médico</th>
    <th width="437" height="0" align="left" scope="col">CPF | Nome</th>
    <th width="80" height="0" align="left" scope="col">Usuário</th>
    <th width="50" align="left" scope="col"></th>
  </tr>
</table>
<div style="color:#009; width:680px; height: 190px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS

$sqlmedico = "SELECT medico,especialidade,area,limite,conselho,cpf,nome,cep,endereco,uf,cidade,bairro,telefone,descricao,data,hora,usuario FROM medico ORDER BY nome";
$rsmedico = mysql_query($sqlmedico);


while(list($medico,$especialidade,$area,$limite,$conselho,$cpf,$nome,$cep,$endereco,$uf,$cidade,$bairro,$telefone,$descricao,$data,$hora,$usuario) = mysql_fetch_row($rsmedico)) {
	
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
    <td width="100" height="35" align="center" valign="middle" scope="col"><strong><?php print $medico; ?><br/>Limite: <?php print $limite; ?></strong></td>
    <td width="437" height="35" align="left" scope="col"><strong><?php print $cpf; ?></strong> | <strong><?php print $nome; ?><br/><?php print $especialidade; ?> | <?php print $area; ?></strong></td>
    <td width="80" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="50" align="left" scope="col"><a href="falt_medico.php?medico=<?php print $medico; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a><a href="cexc_medico.php?medico=<?php print $medico; ?>"><img src="imagem/ico-delete.png" alt="" width="23" height="23" onclick="return confirm('Deseja excluir?')";/></a></td>
    </tr>
</table>
<?php } ?>
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
</body>
</html>