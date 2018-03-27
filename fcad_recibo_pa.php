<?php
include("requerido/conexao.php");
include("requerido/verifica.php");
#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

if ($nivelusuario_atual != "1" and $nivelusuario_atual != "2" and $nivelusuario_atual != "3" and $nivelusuario_atual != "4")
{
	header("location:menu.php");	
}
#data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";

function valor_extenso($valor=0, $maiusculas=false)
{
    // verifica se tem virgula decimal
    if (strpos($valor,",") > 0)
    {
      // retira o ponto de milhar, se tiver
      $valor = str_replace(".","",$valor);
 
      // troca a virgula decimal por ponto decimal
      $valor = str_replace(",",".",$valor);
    }
$singular = array("centavo", "real", "mil", "milhao", "bilhao", "trilhao", "quatrilhao");
$plural = array("centavos", "reais", "mil", "milhoes", "bilhoes", "trilhoes",
"quatrilhÃµes");
 
$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
$u = array("", "um", "dois", "tres", "quatro", "cinco", "seis",
"sete", "oito", "nove");
 
        $z=0;
 
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
		$cont=count($inteiro);
		        for($i=0;$i<$cont;$i++)
                for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];
 
        $fim = $cont - ($inteiro[$cont-1] > 0 ? 1 : 2);
        for ($i=0;$i<$cont;$i++) {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
                $t = $cont-1-$i;
                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")$z++; elseif ($z > 0) $z--;
                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
         if(!$maiusculas)
		 {
          return($rt ? $rt : "zero");
         } elseif($maiusculas == "2") {
          return (strtoupper($rt) ? strtoupper($rt) : "Zero");
         } else {
         return (ucwords($rt) ? ucwords($rt) : "Zero");
         }
 
}
#fim function valor_extenso

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

         // Evento change no campo emitente  
         $("select[name=fbanco]").change(function(){
            // Exibimos no campo referencia antes de concluirmos
			$("select[name=fagencia]").html('<option value="">Carregando Agencia</option>');
            // Exibimos no campo referencia antes de selecionamos a referencia, serve também em caso
			// do usuario ja ter selecionado o uf e resolveu trocar, com isso limpamos a
			// seleção antiga caso tenha feito.
			$.post("cfil_agencia.php",
                  {fbanco:$(this).val()},
                  // Carregamos o resultado acima para o campo referencia
				  function(valor){
                     $("select[name=fagencia]").html(valor);
                  }
                  )
         })
		   })


function validacampos()
{
if(document.cadastro.fvalor.value=="")
	{
	alert("O Campo valor é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fformapagto.value=="")
	{
	alert("O Campo forma de pagamento é obrigatório!");
	return false;
	}
else
	if(document.cadastro.fdestinatario.value=="")
	{
	alert("O Campo destinatario é obrigatório!");
	return false;
	}
else
	if(document.cadastro.femitente.value=="")
	{
	alert("O Campo emitente é obrigatório!");
	return false;
	}
else
	if(document.cadastro.freferencia.value=="")
	{
	alert("O Campo referencia é obrigatório!");
	return false;
	}
else
return true;
}
<!-- Fim do JavaScript que validará os campos obrigatórios! -->
      $(document).ready(function(){
				  $("input[name='fdatainclusao']").mask('99/99/9999');
				  $("input[name='fdatadocto']").mask('99/99/9999');
				  $("input[name='fdataemissaorg']").mask('99/99/9999');
				  $("input[name='fdataincorporacao']").mask('99/99/9999');
				  $("input[name='fdatainclusao']").mask('99/99/9999');	
				  $("input[name='ffoneres']").mask('(99)9999-9999');	
				  $("input[name='ffonecel1']").mask('(99)9999-9999');	
				  $("input[name='ffonecel2']").mask('(99)9999-9999');	
				  $("input[name='ffonecel3']").mask('(99)9999-9999');	
				  $("input[name='ffonecom']").mask('(99)9999-9999');	
				  $("input[name='ffonerec']").mask('(99)9999-9999');	
				  $("input[name='fvalor']").mask('');
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
<strong>Cadastro  Recibo | <a href="menu.php">Retornar</a></strong>
<hr>
<div style="color:#009; width:700px; height: 500px; overflow: auto; vertical-align: left;">
<form action="ccad_recibo_pa.php" method="post" enctype="multipart/form-data" name="cadastro" id="cadastro" onsubmit="return validacampos(); return false;">
<table width="680" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="150" align="left"><strong>Valor R$:</strong></td>
    <td width="530" align="left"><input name="fvalor" type="text" id="fvalor" size="20" maxlength="20" style="width:130px" />      <strong>(formato: 0.00)</strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Forma:</strong></td>
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
    <td align="left"><strong> Emitente: </strong></td>
    <td align="left"><select name="femitente" id="femitente" style="width:130px">
      <?php 
		$sqlemitente = "select emitente, inscricao from recibo_emitente where emitente = '1'";
		$rsemitente = mysql_query($sqlemitente);
		while(list($emitente, $inscricao) = mysql_fetch_row($rsemitente)) {
		?>
      <option value="<?php print $emitente; ?>"><?php print $inscricao; ?></option>
      <?php } ?>
      </select>
      <strong>Referência: 
        <select name="freferencia" id="freferencia" style="width:200px">
          <option value=""></option>
          <?php 
		$sqlreferencia = "select referencia, descricao from recibo_referencia where emitente = '1'";
		$rsreferencia = mysql_query($sqlreferencia);
		while(list($referencia, $descricao) = mysql_fetch_row($rsreferencia)) {
		?>
          <option value="<?php print $referencia; ?>"><?php print $descricao; ?></option>
          <?php } ?>
          </select>
        </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Destinatário:</strong></td>
    <td align="left"><select name="fdestinatario" id="fdestinatario">
      <option value=""></option>
      <option value="">--Relação Destinatarios--</option>    
      <?php 
		$sqlrecibo_destinatario = "SELECT destinatario,inscricao,razao_social FROM recibo_destinatario ORDER BY razao_social";
		$rsrecibo_destinatario = mysql_query($sqlrecibo_destinatario);
		while(list($destinatario, $inscricao, $razao_social) = mysql_fetch_row($rsrecibo_destinatario)) {
		?>
      <option value="D<?php print $destinatario; ?>"><?php print $razao_social; ?>-CPF: <?php print $inscricao; ?></option>
      <?php } ?>
      <option value=""></option>              
      <option value="">--Relação Associados / Titulares--</option>            
      <?php 
		$sqltitular = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' ORDER BY nome";
		$rstitular = mysql_query($sqltitular);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitular)) {
		?>
      <option value="T<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option>
      <?php } ?>
      </select>
      <label for="fvalor"></label></td>
  </tr>
  <tr>
    <td align="left"><strong>Titular: </strong></td>
    <td align="left"><strong>
      <select name="ftitular" id="ftitular">
        <option value=""></option>
        <?php 
		$sqltitular = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' ORDER BY nome";
		$rstitular = mysql_query($sqltitular);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitular)) {
		?>
        <option value="<?php print $cliente; ?>"><?php print $nome; ?>-CPF: <?php print $cpf; ?></option><?php } ?>      
        </select>
      </strong></td>
  </tr>
  <tr>
    <td align="left"><strong>Descrição: </strong></td>
    <td align="left"><label for="fdescricao"></label>
      <input name="fdescricao" type="text" id="fdescricao" size="50" maxlength="100" />
      <input type="submit" name="fok" id="fok" value="OK" /></td>
  </tr>
  </table>


</form>
<hr>
<table width="640" align="left">
<tr valign="middle">
    <th width="100" height="0" align="center" valign="middle" scope="col"><strong>Recibo</strong></th>
    <th width="437" height="0" align="left" scope="col">Emitente | Destinatario</th>
    <th width="80" height="0" align="left" scope="col">Usuário</th>
    <th width="23" align="left" scope="col"></th>
  </tr>
</table>
<div style="color:#009; width:680px; height: 175px; overflow: auto; vertical-align: left;">
<?php
//######### INICIO Paginação
$numreg = 3; // Quantos registros por página vai ser mostrado
if (!isset($pg)) {
$pg = 0;
}

$inicial = @$_GET['pg'] * $numreg;
$registro_por_pagina = $inicial + $numreg;

//######### FIM dados Paginação

// Faz o Select pegando o registro inicial até a quantidade de registros para página
$sql = mysql_query("select * from recibo where emitente = '1' order by recibo LIMIT $inicial, $numreg");

// Serve para contar quantos registros você tem na seua tabela para fazer a paginação
$sql_conta = mysql_query("SELECT * FROM recibo where emitente = '1'");

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

//echo "<br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo

while ($aux = mysql_fetch_array($sql)) {

$contador++;

$pega_emitente = $aux['emitente'];
$pega_destinatario = $aux['destinatario'];
$pega_tipo = $aux['tipo'];
$numero = $aux['valor'];
$pega_valor = number_format($aux['valor'], 2, ',', '.');
			
#data
$ndata = explode("-",$aux['data']); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
	
?>
<table width="640" align="left">
  <tr bgcolor="<?php if($contador % 2) { echo "#FFFF00"; }?>" valign="middle">
    <td width="100" height="35" align="center" valign="middle" scope="col"><strong><?php print $aux['recibo']; ?></strong></td>
    <td width="437" height="35" align="justify" scope="col">
	
    	<?php $sqllistaemitente = "SELECT inscricao as inscricao_emitente, nome_fantasia as nome_fantasia_emitente FROM recibo_emitente WHERE emitente = '$pega_emitente'";
         $rslistaemitente = mysql_query($sqllistaemitente) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rslistaemitente)){
         echo $ln['nome_fantasia_emitente']; echo " | ";echo $ln['inscricao_emitente'];}?></strong><br/>		 
	  
		<?php 
		
		if ($pega_tipo == 'D'){
		
		$sqldestinatario = "select destinatario,inscricao,razao_social from recibo_destinatario where destinatario='$pega_destinatario'";
		$rsdestinatario = mysql_query($sqldestinatario);
		while(list($destinatario, $inscricao, $razao_social) = mysql_fetch_row($rsdestinatario)) { ?>
        <?php print $razao_social; ?> | <?php print $inscricao; ?>
        <?php
		}
		}else{if ($pega_tipo == 'T') {			
		
		$sqltitular = "SELECT cliente, nome, cpf FROM cliente WHERE status = 'Ativo' and cliente='$destinatario'";
		$rstitular = mysql_query($sqltitular);
		while(list($cliente, $nome, $cpf) = mysql_fetch_row($rstitular)) { ?>
        <?php print $nome; ?> | <?php print $cpf; ?></option>
		<?php
		}
		}
		}
        ?>
    </strong><br/>
         R$ <?php print $pega_valor; ?></td>
    <td width="80" align="left" scope="col"><?php print $aux['usuario']; ?><br /><?php print $data_final; ?><br /><?php print $aux['hora']; ?></td>
    <td width="23" align="left" scope="col"><a href="falt_recibo_pa.php?recibo=<?php print $aux['recibo']; ?>"><img src="imagem/ico-refresh.png" alt="" width="23" height="23"/></a><br/>
      <a href="frel_recibo.php?recibo=<?php print $aux['recibo']; ?>" target="_blank"><img src="imagem/ico-printer.png" alt="" width="23" height="23"/></a></td>
    </tr>
</table>
<?php }?>
</div>
<hr>
<div id="rodape">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left" scope="col"><?php include("paginacao/paginacao.php")?></td>
    <td width="50%" align="right" scope="col"><?php if ($registro_por_pagina > $quantreg){$registro_por_pagina = $quantreg;}else{$registro_por_pagina=$registro_por_pagina;}; print 'Registro(s) ['.$registro_por_pagina.'] de ['.$quantreg.']'?></td>
    </tr>
</table>
</div>
</div>
</div>
</div>

</body>
</html>