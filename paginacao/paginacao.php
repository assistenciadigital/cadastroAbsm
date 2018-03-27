<style type="text/css">
<!--
.pgoff {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #FF0000; text-decoration: none}
a.pg {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #003366; text-decoration: none}
a:hover.pg {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #0066cc; text-decoration:underline}
-->
</style>

<?php
$quant_pg = ceil($quantreg/$numreg);
$quant_pg++;
$total_pg = $quant_pg - 1;
//<img src="bt_pg_inicio.png" width="19" height="19" />

// Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
if ( @$_GET['pg'] > 0) {
echo "<a href=".$_SERVER['PHP_SELF']."?pg=0"." class=pg ><b>Primeiro</b></a>";
echo " ";
//echo "<a href=".$_SERVER['PHP_SELF']."?pg=".(@$_GET['pg']-1)." class=pg ><b>Anterior</b></a>";
echo "<a href=".$_SERVER['PHP_SELF']."?pg=".(@$_GET['pg']-1)." class=pg ><b>&laquo;</b></a>";
} else {
echo "<font color=#CCCCCC>Primeiro</font>";
echo " ";
//echo "<font color=#CCCCCC>Anterior</font>";
echo "<font color=#CCCCCC>&laquo;</font>";
}

// Faz aparecer os numeros das página entre o ANTERIOR e PROXIMO

for($i_pg=1; $i_pg<$quant_pg;$i_pg++) {
// Verifica se a página que o navegante esta e retira o link do número para identificar visualmente

if (@$_GET['pg'] == ($i_pg-1)) {
echo "&nbsp;<span class=pgoff>Página(s) [$i_pg] de [$total_pg]</span>&nbsp;";
} else {
$i_pg2 = $i_pg-1;
//echo "&nbsp;<a href=".$_SERVER['PHP_SELF']."?pg=$i_pg2 class=pg><b>$i_pg</b></a>&nbsp;";
}
}
$ultimapg = $quant_pg-2;

// Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
if ((@$_GET['pg']+2) < $quant_pg) {
echo "<a href=".$_SERVER['PHP_SELF']."?pg=".(@$_GET['pg']+1)." class=pg ><b>&raquo;</b></a>";
//echo "<a href=".$_SERVER['PHP_SELF']."?pg=".(@$_GET['pg']+1)." class=pg ><b>Próximo</b></a>";
echo " ";
echo "<a href=".$_SERVER['PHP_SELF']."?pg=".($total_pg-1)." class=pg ><b>Último</b></a>";
} else {
echo "<font color=#CCCCCC>&raquo;</font>";
//echo "<font color=#CCCCCC>Próximo</font>";
echo " ";
echo "<font color=#CCCCCC>Último</font>";
}
?> 