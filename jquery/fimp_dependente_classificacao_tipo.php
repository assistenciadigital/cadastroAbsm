<?php
include("requerido/conexao.php");
include("requerido/verifica.php");

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
				  $("input[name='fperiodo_inicial']").mask('99/99/9999');
				  $("input[name='fperiodo_final']").mask('99/99/9999');
        })
		  
		  

</script>

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
// define variables and set to empty values
$classificacaoError = $tipoError = "";
$fclassificacao = $ftipo = "";

$data = date("d/m/Y");
$hora = date("H:i");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
   if (empty($_POST["fclassificacao"]))
     {$classificacaoError = "Classificação Requerido!";}
   else
     {$classificacao= $_POST["fclassificacao"];}
   
   if (empty($_POST["ftipo"]))
     {$tipoError = "Tipo Requerido!";}
   else
     {$tipo = $_POST["ftipo"];}

   if (empty($_POST["fstatus"]))
     {$statusError = "Status Requerido!";}
   else
     {$status = $_POST["fstatus"];}


header("Location:relatorio/crel_dependente_classificacao_tipo.php?classificacao=$classificacao&tipo=$tipo&status=$status");
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
<strong>Impressão de Dependente x Classificação x Tipo</strong>
<hr>
<span class="error">* Campo Requerido!</span><br/>
<form id="form" name="form" method="post" action="<?php $_SERVER["PHP_SELF"];?>"> 

  <table width="537" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="158" align="left" valign="middle"><strong>Classificação:</strong></td>
    <td width="366" align="left" valign="middle"><select name="fclassificacao" id="fclassificacao">
      <option value=""></option>
      <?php
 		 include("requerido/conexao.php");
         $sqlclassificacao = "SELECT * FROM classificacao WHERE titular = 'S' ORDER BY descricao";
         $rsclassificacao = mysql_query($sqlclassificacao) or die(mysql_error());
         while($ln = mysql_fetch_assoc($rsclassificacao)){
            echo '<option value="'.$ln['classificacao'].'">'.$ln['descricao'].'</option>';
         }
      ?>
    </select><span class="error">* <?php echo $classificacaoError;?></span><script language="JavaScript"> document.form.fclassificacao.focus();</script>
      </td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Tipo:</strong></td>
    <td align="left" valign="middle">
      <select name="ftipo" id="ftipo" >
        </select><span class="error">* <?php echo $tipoError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Status:</strong></td>
    <td align="left" valign="middle"><select name="fstatus" id="fstatus">
      <option value="Ativo" selected="selected">Ativo</option>
      <option value="Bloqueado">Bloqueado</option>
      <option value="Excluido">Excluido</option>
      <option value="Inativo">Inativo</option>
      <option value="Recadastrar">Recadastrar</option>
    </select><span class="error">* <?php echo $statusError;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Data/Hora:</strong><br /><strong>Usuário:</strong></td>
    <td align="left" valign="middle"><?php print $data; ?> <?php print $hora; ?><br/><?php print strtoupper($loginusuario_atual); ?></td>
  </tr>
    <tr>
      <td align="right" valign="middle">&nbsp;</td>
      <td align="left" valign="middle"><input type="submit" name="fvisualiza" id="fvisualiza" value="Visualizar" />
        <strong>
        <input type="button" name="ffechar" value="Fechar" onclick="window.close();" />
        </strong></td>
    </tr>
    </table>
</form>
<hr>
</div>
</div>
</body>
</html>