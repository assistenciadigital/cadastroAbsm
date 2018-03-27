<?php
include("conexao.php");

$sql = "SELECT total FROM contador_de_acesso where contador = '1'";
$rs = mysql_query($sql);


while(list($total) = mysql_fetch_row($rs)) {
$contador = $total ++;	
}
$sqlatualiza = "UPDATE contador_de_acesso SET total = '$contador' WHERE contador= '1'";
$rsatualiza = mysql_query($sqlatualiza);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">By: <a href="mailto:halext@hotmail.com"><font color="#333333">Alex Bueno</font></a> - <?php print  saudacao(); ?></font></td>
    <td width="50%"> 
      <div align="right"><font size="2" face="Arial, Helvetica, sans-serif"><?php print  $contador; ?> acessos</font></div></td>
  </tr>
</table>
