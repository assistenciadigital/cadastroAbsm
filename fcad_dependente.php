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
	header("location:fcon_cliente.php");	
}

$pega_titular = $_GET[titular];

$sql = "SELECT cliente, nome, cpf, assistencia, classificacao, tipo, plano, cep, uf, endereco, bairro, cidade from cliente where cliente ='$pega_titular'";

$rs = mysql_query($sql);

list($cliente, $nome, $cpf, $assistencia, $classificacao, $tipo, $plano, $cep, $uf, $endereco, $bairro, $cidade) = mysql_fetch_row($rs);

$pega_classificacao = $classificacao;
$sqlclassificacao = "SELECT classificacao as codigo_classificacao, descricao as descricao_classificacao FROM classificacao WHERE classificacao ='$pega_classificacao'";
$rsclassificacao = mysql_query($sqlclassificacao);
list($codigo_classificacao, $descricao_classificacao) = mysql_fetch_row($rsclassificacao);

$pega_assistencia = $assistencia;
$sqlassistencia = "SELECT assistencia as codigo_assistencia, descricao as descricao_assistencia FROM assistencia WHERE assistencia ='$pega_assistencia'";
$rsassistencia = mysql_query($sqlassistencia);
list($codigo_assistencia, $descricao_assistencia) = mysql_fetch_row($rsassistencia);

$pega_plano = $plano;
$sqlplano = "SELECT plano as codigo_plano, descricao as descricao_plano FROM plano WHERE plano ='$pega_plano'";
$rsplano = mysql_query($sqlplano);
list($codigo_plano, $descricao_plano) = mysql_fetch_row($rsplano);

$pega_cidade = $cidade;
$sqlcidade = "SELECT cidade as codigo_cidade, descricao as descricao_cidade FROM cidade WHERE cidade ='$pega_cidade'";
$rscidade = mysql_query($sqlcidade);
list($codigo_cidade, $descricao_cidade) = mysql_fetch_row($rscidade);

$pega_bairro = $bairro;
$sqlbairro = "SELECT bairro as codigo_bairro, descricao as descricao_bairro FROM bairro WHERE bairro ='$pega_bairro'";
$rsbairro = mysql_query($sqlbairro);
list($codigo_bairro, $descricao_bairro) = mysql_fetch_row($rsbairro);

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
	
        // Evento change no campo classificacao  
         $("select[name=fclassificacao]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=ftipo]").html('<option value="">Carregando Tipo</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_tipo.php",
                  {fclassificacao:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=ftipo]").html(valor);
                  }
                  )
         })		
		 
         // Evento change no campo classificacao  
         $("select[name=fclassificacao]").change(function(){
            // Exibimos no campo naturalidade antes de concluirmos
			$("select[name=fplano]").html('<option value="">Carregando Plano</option>');
            // Exibimos no campo cidade antes de selecionamos a naturalidade, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
            $.post("cfil_plano.php",
                  {fclassificacao:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=fplano]").html(valor);
                  }
                  )
         })	
		 	
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
<strong>Cadastro Dependência / Beneficiário | <a href="fcon_cliente.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:700px; height: 380px; overflow: auto; vertical-align: left;">
<form action="ccad_dependente.php?titular=<?php print $pega_titular;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="left"><strong>Titular:
      
    </strong></td>
    <td align="left"><strong><?php print $pega_titular; ?> | <?php print $nome; ?></strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Assistência:</strong></td>
    <td align="left"><strong><?php print $descricao_assistencia; ?> | <?php print $descricao_plano; ?></strong>
      </td>
  </tr>
  <tr>
    <td align="left"><strong>Classificação:</strong></td>
    <td align="left"><strong><?php print $descricao_classificacao; ?></strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Status</strong>:</td>
    <td align="left"><strong>
    <select name="fstatus" id="fstatus">
      <option value="Ativo" selected="selected">Ativo</option>
      <option value="Bloqueado">Bloqueado</option>
      <option value="Excluido">Excluido</option>
      <option value="Inativo">Inativo</option>
      <option value="Recadastrar">Recadastrar</option>
    </select>
Data Inclusão:
<input name="fdatainclusao" type="text" size="10" maxlength="10" id="fdatainclusao" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Nome:</strong></td>
    <td align="left"><strong>
      <input name="fnome" type="text" size="50" maxlength="60" id="fnome" />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Parentesco:</strong></td>
    <td align="left"><select name="fparentesco" id="fparentesco">
      <option value=""></option>
      <?php 
		$sqlparentesco = "select parentesco, descricao, grau from parentesco order by grau, descricao";
		$rsparentesco = mysql_query($sqlparentesco);
		while(list($parentesco, $descricao, $grau) = mysql_fetch_row($rsparentesco)) {
		?>
      <option value="<?php print $parentesco; ?>"> <?php print $descricao; ?> <?php print $grau; ?>º</option>
      <?php 
		}
		?>
      </select>
      <strong>
        
        Tipo:
        <select name="ftipo" id="ftipo" style="width:300px">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqltipodependente = "SELECT tipo, descricao FROM tipo WHERE titular = 'N' ORDER BY tipo";
         $rstipodependente = mysql_query($sqltipodependente) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rstipodependente)){
            echo '<option value="'.$ln['tipo'].'">'.$ln['descricao'].'</option>';
         }
      ?>
        </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>CPF:</strong></td>
    <td align="left"><strong>
      
      <input name="fcpf" type="text" id="fcpf" size="11" maxlength="11" onblur="return verificarcpf(this.value)"/>
    </strong><strong> Data Nascimento:
    <input name="fdatanascimento" type="text" size="10" maxlength="10" />
    Sexo:
      <select name="fsexo" id="fsexo">
        <option value=""></option>
        <option value="F">F</option>
        <option value="M">M</option>
      </select>
      <br />
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>RG:</strong></td>
    <td align="left"><strong>
      <input name="frg" type="text" id="frg" size="11" maxlength="11" />
      Emissor</strong>:<strong>
        <input name="femissorrg" type="text" id="femissorrg" size="6" maxlength="11" />
        </strong> <strong>UF</strong>:<strong>
        <select name="fufrg" id="fufrg">
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
        Emissão:
        <input name="fdataemissaorg" type="text" size="10" maxlength="10" id="fdataemissaorg" />
      </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>CEP:</strong></td>
    <td align="left"><label for="fenderecotitular"><strong>
      <input name="fcep" type="text" id="fcep" value="<?php print $cep; ?>" size="10" maxlength="10" />
      UF:
      <select name="fuf" id="fuf">
        <option value="<?php print $uf; ?>"><?php print $uf; ?></option>
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
    <td align="left"><select name="fcidade" id="fcidade">
      <option value="<?php print $codigo_cidade; ?>"><?php print $descricao_cidade; ?></option>
      </select></td>
  </tr>
  <tr>
    <td align="left"><strong>Bairro:</strong></td>
    <td align="left"><strong>
      <select name="fbairro" id="fbairro">
      <option value="<?php print $codigo_bairro; ?>"><?php print $descricao_bairro; ?></option>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Descrição:</strong></td>
    <td align="left"><label for="fdescricao"></label>
      <input name="fdescricao" type="text" id="fdescricao" size="50" maxlength="60" /></td>
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
    <th width="100" height="0" align="center" valign="middle" scope="col">Dependente</th>
    <th width="437" height="0" align="left" scope="col">Nome</th>
    <th width="80" height="0" align="left" scope="col">Usuário</th>
    <th width="23" align="left" scope="col"></th>
  </tr>
</table>
<div style="color:#009; width:680px; height: 280px; overflow: auto; vertical-align: left;">
<?php
#CONSULTA NO BANCO DE DADOS

$sqldependente = "SELECT dependente, cpf, nome, sexo, parentesco, status, datanascimento, tipo, datainclusao, data, hora, usuario FROM dependente where titular = '$pega_titular'";
$rsdependente = mysql_query($sqldependente);


while(list($dependente, $cpf, $nome, $sexo, $parentesco, $status, $datanascimento, $tipo, $datainclusao, $data, $hora, $usuario) = mysql_fetch_row($rsdependente)) {
	
$pega_status = $status;
	
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

$ndata = explode("-",$datanascimento); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_nascimento = "$ano/$mes/$dia";

$ndata = explode("-",$datainclusao); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_inclusao = "$ano/$mes/$dia";

$contador++;	
?>
<table width="640" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" height="35" align="center" valign="middle" scope="col"><strong>Nº <?php print $dependente; ?></strong><br/><?php print $data_inclusao; ?><br/><strong><?php print $status;?></strong></td>
    <td width="437" height="35" align="left" scope="col"><strong><?php print $nome; ?></strong><br/>Sexo: <?php print $sexo; ?>, CPF: <?php print $cpf; ?>, Dt Nascimento: <?php print $data_nascimento; ?><br/><?php $sqllistaparentesco = "SELECT descricao FROM parentesco WHERE parentesco = '$parentesco'";
         $rslistaparentesco = mysql_query($sqllistaparentesco) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rslistaparentesco)){
         echo $ln['descricao'];}?>, <?php $sqllistatipodependente = "SELECT descricao FROM tipo WHERE tipo = '$tipo'";
         $rslistatipodependente = mysql_query($sqllistatipodependente) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rslistatipodependente)){
         echo $ln['descricao'];}?></td>
    <td width="80" align="left" scope="col"><?php print $usuario; ?><br /><?php print $data_final; ?><br /><?php print $hora; ?></td>
    <td width="23" align="left" scope="col"><a href="falt_dependente.php?dependente=<?php print $dependente; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a><br/><a href="fcad_carteira_dependente.php?titular=<?php print $pega_titular; ?>&dependente=<?php print $dependente; ?>"><img src="imagem/ico-carteira.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php } ?>
</div>
<hr>
<div id="rodape">
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="320" align="left" scope="col"><strong>Registro(s) Encontrado(s): </strong><?php print $contador; ?></td>
    <td width="320" align="right" scope="col">Alterar = <img src="imagem/ico-refresh.png" alt="" width="23" height="23"/> Carteira = <img src="imagem/ico-carteira.png" alt="" width="23" height="23"/></td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>