<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
$pega_recibo = $_GET[recibo];

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

$sql = "SELECT recibo,valor,emitente,referencia,destinatario,tipo,titular,mes_ano,descricao as descricao_recibo,data,hora,usuario from recibo WHERE recibo='$pega_recibo'";

$rs = mysql_query($sql);

list($recibo,$valor,$emitente,$referencia,$destinatario,$tipo,$titular,$mes_ano,$descricao_recibo,$data,$hora,$usuario) = mysql_fetch_row($rs);

$pega_tipo = $tipo;

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
        // Evento change no campo emitente  
         $("select[name=femitente]").change(function(){
            // Exibimos no campo referencia antes de concluirmos
			$("select[name=freferencia]").html('<option value="">Carregando Referencia</option>');
            // Exibimos no campo referencia antes de selecionamos a referencia, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
			$.post("cfil_referencia.php",
                  {femitente:$(this).val()},
                  // Carregamos o resultado acima para o campo referencia
				  function(valor){
                     $("select[name=freferencia]").html(valor);
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
				  $("input[name='fmes_ano']").mask('99/9999');
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
<strong>Alteração Referência Recibo | <a href="fcad_recibo.php">Retornar</a></strong>
<hr>
<form action="calt_recibo.php?recibo=<?php print $pega_recibo;?>&amp;tipo=<?php print $pega_tipo;?>" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
  <table width="680" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="180" align="left"><strong>Recibo: </strong></td>
      <td width="500" align="left"><strong>
      <input name="frecibo" type="text" disabled="disabled" id="frecibo" onblur="return verificarcpf(this.value)" value="<?php print $recibo; ?>" size="10" maxlength="10" readonly="readonly"/>
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Valor R$: </strong></td>
      <td align="left"><input name="fvalor" type="text" id="fvalor" value="<?php print $valor; ?>" size="20" maxlength="20" /> 
      (formato 0.00)</td>
    </tr>
    <tr>
      <td align="left"><strong>Forma: </strong></td>
      <td align="left"><strong>
        <select name="fformapagto" id="fformapagto" style="width:100px">
          <option value=""></option>
          <?php
 		 include("requerido/conexao.php");
         $sqlformapagto = "SELECT * FROM formapagto WHERE recibo = 1 ORDER BY descricao";
         $rsformapagto = mysql_query($sqlformapagto) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsformapagto)){
            echo '<option value="'.$ln['formapagto'].'">'.$ln['descricao'].'</option>';
         }
      ?>
        </select>
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Cheque|Banco:</strong></td>
      <td align="left"><strong>
      <select name="fbanco" id="fbanco" style="width:48px">
        <option value=""></option>
        <?php 
		$sqlbanco = "select banco, descricao from banco order by banco";
		$rsbanco = mysql_query($sqlbanco);
		while(list($banco, $descricao) = mysql_fetch_row($rsbanco)) {
		?>
        <option value="<?php print $banco; ?>"><?php print $banco; ?> - <?php print $descricao; ?></option>
        <?php } ?>
      </select>
      </select>
Agencia:
<select name="fagencia" id="fagencia" style="width:58px">
</select>
N°:
<input name="fdoctopagto" type="text" id="fdoctopagto" size="10" maxlength="10" />
Vencimento:
<input name="fdatadocto" type="text" id="fdatadocto" size="10" maxlength="10" />
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Emitente:</strong></td>
      <td align="left"><select name="femitente" id="femitente">
        <?php 
		$sqlemitente = "select * from recibo_emitente where emitente='$emitente'";
		$rsemitente = mysql_query($sqlemitente);
		while(list($emitente, $inscricao) = mysql_fetch_row($rsemitente)) { ?>
        <option value="<?php print $emitente; ?>"><?php print $inscricao; ?></option>
        <?php } ?>
        <option value=""></option>
        <?php 
		$sqlemitentenew = "select * from recibo_emitente";
		$rsemitentenew = mysql_query($sqlemitentenew);
		while(list($emitente, $inscricao) = mysql_fetch_row($rsemitentenew)) {
		?>
        <option value="<?php print $emitente; ?>"><?php print $inscricao; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><strong>Referência: </strong></td>
      <td align="left"><select name="freferencia" id="freferencia">
        <?php 
		$sqlreferencia = "select referencia, descricao from recibo_referencia where referencia = '$referencia'";
		$rsreferencia = mysql_query($sqlreferencia);
		while(list($referencia, $descricao) = mysql_fetch_row($rsreferencia)) { ?>
        <option value="<?php print $referencia; ?>"><?php print $descricao; ?></option>
        <?php } ?>
        <option value=""></option>
        <?php 
		$sqlreferencianew = "select referencia, descricao from recibo_referencia where referencia = '$referencia' order by descricao";
		$rsreferencianew = mysql_query($sqlreferencianew);
		while(list($referencia, $descricao) = mysql_fetch_row($rsreferencianew)) {
		?>
        <option value="<?php print $referencia; ?>"><?php print $descricao; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><strong>Destinatário: 
        
          
      </strong></td>
      <td align="left"><label for="ftipo"></label>
        <select name="fdestinatario" id="fdestinatario">
        <?php 
		
		if ($pega_tipo == 'D'){
		
		$sqldestinatario = "select destinatario, inscricao, razao_social from recibo_destinatario where destinatario='$destinatario' order by razao_social";
		$rsdestinatario = mysql_query($sqldestinatario);
		while(list($destinatario, $inscricao, $razao_social) = mysql_fetch_row($rsdestinatario)) { ?>
        <option value="D<?php print $destinatario; ?>"><?php print $razao_social; ?>-CPF: <?php print $inscricao; ?></option>
        <?php
		}
		}else{if ($pega_tipo == 'T') {			
		
		$sqltitular = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' and cliente='$destinatario' order by nome";
		$rstitular = mysql_query($sqltitular);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitular)) { ?>
       <option value="T<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option>
		<?php
		}
		}
		}
        ?>

		<option value=""></option>

	    <option value="">--Relação Destinatarios--</option>      
		<?php 
		$sqldestinatarionew = "select destinatario,inscricao,razao_social from recibo_destinatario";
		$rsdestinatarionew = mysql_query($sqldestinatarionew);
		while(list($destinatario, $inscricao, $razao_social) = mysql_fetch_row($rsdestinatarionew)) {
		?>
        <option value="D<?php print $destinatario; ?>"><?php print $razao_social; ?>-CPF: <?php print $inscricao; ?></option><?php } ?> 
        
        <option value=""></option>              
        <option value="">--Relação Associados / Titulares--</option>            
        <?php 
		$sqltitularnew = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' ORDER BY nome";
		$rstitularnew = mysql_query($sqltitularnew);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitularnew)) {
		?>
        <option value="T<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option>
        <?php } ?>
    </select></td>
    </tr>
    <tr>
      <td align="left"><strong>Titular: </strong></td>
      <td align="left"><strong>
        <select name="ftitular" id="ftitular">
          <?php 
		$sqltitular = "SELECT cliente, nome, cpf FROM cliente WHERE cliente = '$titular'";
		$rstitular = mysql_query($sqltitular);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitular)) {
		?>
          <option value="<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option>
          <?php } ?>
          <option value=""></option>
          <?php 
		$sqltitularnew = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' ORDER BY nome";
		$rstitularnew  = mysql_query($sqltitularnew );
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitularnew )) {
		?>
          <option value="<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option>
          <?php } ?>
        </select>
      </strong></td>
    </tr>
    <tr>
      <td align="left"><strong>Mês / Ano: </strong></td>
      <td align="left"><input name="fmes_ano" type="text" id="fmes_ano" value="<?php print $mes_ano; ?>" size="7" maxlength="7" /></td>
    </tr>
    <tr>
      <td align="left"><strong>Descrição:</strong></td>
      <td align="left"><strong>
        <input name="fdescricao" type="text" id="fdescricao" value="<?php print $descricao_recibo; ?>" size="50" maxlength="100" />
        <input type="submit" name="fok" id="fok" value="OK" />
      </strong></td>
    </tr>
  </table>
</form>
<hr>
</div>
</div>
</body>
</html>