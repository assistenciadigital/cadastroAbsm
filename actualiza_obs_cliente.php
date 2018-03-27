<?php
include("requerido/conexao.php");
//$data_atual = date("Y-m-d");
//$hora_atual = date("H:i:s");

function tiracento($texto){

$com_acento = array('à','á','â','ã','ä','è','é','ê','ë','ì','í','î','ï','ò','ó','ô','õ','ö','ù','ú','û','ü','À','Á','Â','Ã','Ä','È','É','Ê','Ë','Ì','Í','Î','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','ç','Ç','ñ','Ñ');

$sem_acento = array('a','a','a','a','a','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U','c','C','n','N');

$texto_sem_acento = str_replace($com_acento, $sem_acento, $texto);

return $texto_sem_acento;
}

function eliminaespaco($variavel='')
{
// Elimina espaços do inicio e final
$variavel = trim($variavel);
// Troca sequência de espaços(\s)(espaço, \t, \r e \n) por um espaço
$variavel = preg_replace('/\s\s+/', ' ', $variavel);
// Retorna variavel atualizada
return $variavel;
}
?>
<table width="1100" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top">
      <td width="100">Contador</td>
      <td width="500">OBS</td>
      <td width="500">OBSERVACAO</td>
    </tr>
  </table>
<?php
$sql = "SELECT cliente, obs1, obs2, obs3, observacao FROM cliente";
$rs = mysql_query($sql);
while(list($cliente, $obs1, $obs2, $obs3, $observacao) = mysql_fetch_row($rs)) {
	$contador++;
	$pega_cliente = $cliente;	
	$pega_obs1 = tiracento(eliminaespaco($obs1));
	$pega_obs2 = tiracento(eliminaespaco($obs2));
	$pega_obs3 = tiracento(eliminaespaco($obs3));	
?>
  <table width="1100" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr align="left">
      <td width="100"><input name="fcontador" type="text" id="fcontador" value="<?php print $contador;?>" size="5" maxlength="5"></td>
      <td width="500"><textarea name="fobs1" cols="55" rows="5"><?php print $obs1;?><?php print $obs2;?><?php print $obs3;?></textarea></td>
      <td width="500"><textarea name="fobservacao" cols="55" rows="5" id="fobservacao"><?php print $observacao;?></textarea></td>
    </tr>
</table>
<?php }?>
