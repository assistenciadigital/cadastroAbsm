<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

<?php
include("../requerido/conexao.php");
?>
<style type="text/css">
body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 10px;
}
</style>

<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<form id="form1" name="form1" method="post" action="">
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: CIDADE, UF Selecionada:
          <select name="jumpMenu" id="jumpMenu" style="font:'Courier New', Courier, monospace; border:transparent; font-size:11px" onchange="MM_jumpMenu('parent',this,0)">          
          <option value=<?php  $pega_uf = $_GET[uf]; print $pega_uf; ?>><?php  $pega_uf = $_GET[uf]; print $pega_uf; ?></option>
       	  <option value="crel_cidade.php?uf=AC">AC</option>
          <option value="crel_cidade.php?uf=AL">AL</option>
          <option value="crel_cidade.php?uf=AM">AM</option>
          <option value="crel_cidade.php?uf=AP">AP</option>
          <option value="crel_cidade.php?uf=BA">BA</option>
          <option value="crel_cidade.php?uf=CE">CE</option>
          <option value="crel_cidade.php?uf=DF">DF</option>
          <option value="crel_cidade.php?uf=ES">ES</option>
          <option value="crel_cidade.php?uf=GO">GO</option>
          <option value="crel_cidade.php?uf=MA">MA</option>
          <option value="crel_cidade.php?uf=MG">MG</option>
          <option value="crel_cidade.php?uf=MS">MS</option>
          <option value="crel_cidade.php?uf=MT">MT</option>
          <option value="crel_cidade.php?uf=PA">PA</option>
          <option value="crel_cidade.php?uf=PB">PB</option>
          <option value="crel_cidade.php?uf=PE">PE</option>
          <option value="crel_cidade.php?uf=PI">PI</option>
          <option value="crel_cidade.php?uf=PR">PR</option>
          <option value="crel_cidade.php?uf=RJ">RJ</option>
          <option value="crel_cidade.php?uf=RN">RN</option>
          <option value="crel_cidade.php?uf=RO">RO</option>
          <option value="crel_cidade.php?uf=RR">RR</option>
          <option value="crel_cidade.php?uf=RS">RS</option>
          <option value="crel_cidade.php?uf=SC">SC</option>
          <option value="crel_cidade.php?uf=SE">SE</option>
          <option value="crel_cidade.php?uf=SP">SP</option>
          <option value="crel_cidade.php?uf=TO">TO</option>
  </select></td>
  </tr>
</table>
</form>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="4" align="center" valign="middle">CIDADE</th>
  </tr>
  <tr>
    <th width="100" align="center" valign="middle">CIDADE</th>
    <th width="60" align="center" valign="middle">UF</th>
    <th width="440" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
<?php 
$pega_uf = $_GET[uf];
 
$sql = "SELECT cidade, uf, descricao, tipo, data, hora, usuario FROM cidade WHERE uf = '$pega_uf' ORDER BY uf, descricao";
$rs = mysql_query($sql);
$soma = 0;

while(list($cidade, $uf, $descricao, $tipo, $data, $hora, $usuario) = mysql_fetch_row($rs)) {
	
    if($contador == 18) {
	echo "<p style='page-break-after:always'></p>";
	
?>

<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="350" align="left" valign="middle">Data/Hora: <?php print date("Y-m-d");$hora = date("H:i:s"); ?> <?php print date("H:i:s"); ?></td>
      <td width="350" align="right" valign="middle">Página: <?php print $pagina_atual = $pagina_atual + 1 ; ?></td>
    </tr>
</table>
<br/>
<?php
include("relatorio_cabecalho.php");
?>
<br/>
<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="700" valign="middle">Relatorio: CIDADE, UF Selecionada: <?php  print $pega_uf; ?></td>
  </tr>
</table>
<br/>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="4" align="center" valign="middle">CIDADE</th>
  </tr>
  <tr>
    <th width="100" align="center" valign="middle">CIDADE</th>
    <th width="60" align="center" valign="middle">UF</th>
    <th width="440" align="left">DESCRICAO</th>
    <th width="100" align="left">DATA</th>
  </tr>
  </table>
  
<?php    
  $contador = 0;   
  }
?>


<?php #data
$ndata = explode("-",$data); 
$dia = $ndata[0];
$mes = $ndata[1];
$ano = $ndata[2];
$data_final = "$ano/$mes/$dia";
?>

 <table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100" align="center" valign="middle"><?php print $cidade; ?></td>
    <td width="60" align="center" valign="middle"><?php print $uf; ?></td>
    <td width="440" valign="middle"><?php print $descricao; ?> - <?php print $tipo; ?></td>
    <td width="100" align="left" valign="middle"><?php print $data_final ;?><br/><?php print $hora ;?><br/><?php print $usuario ;?></td>
  </tr>
</table>

<?php
    $contador++;
}
?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th align="right" valign="middle">Página Total: <?php print $pagina_atual  ; ?></th>
  </tr>
</table>