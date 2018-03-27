<?php
$n_pag = floor($tot_reg/$por_pagina);
if ($tot_reg % $por_pagina) $n_pag++;
if($tot_reg >  $por_pagina){
	if($pagina<6){
		$ini = 0;
		$inc = 10;
	}
	else{ 
		$ini = $pagina - 5;
		$inc = $pagina + 5;
	}
	echo"
<style type=\"text/css\">
<!--
a{
	text-decoration: none;
	color: $cor_paginacao;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
}
a:hover{
	text-decoration: underline;
}

.pg_atual{
	color: #FFFFFF;
	background-color: $cor_paginacao;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
}
-->
</style>";
?>

<table border="0" cellspacing="0" cellpadding="2">
<tr>
	<td align="center" valign="middle" width="25" height="25"><?php if ($pagina>5){ ?><a href="<?php echo $p_name?>?<?php echo $condicao?>"><img src="../../img/bt_pg_inicio.png" border="0"></a><?php } ?></td>
    <?php if($pagina>1){?>
	<td align="center" valign="middle" width="25" height="25"><?php if ($pagina>0){ ?><a href="<?php echo $p_name?>?pagina=<?php echo $pagina-1?><?php echo $condicao?>"><img src="../../img/bt_pg_voltar.png" border="0"></a><?php } ?></td>
	<?php } 
	else{?>
   	<td align="center" valign="middle" width="25" height="25"><?php if ($pagina>0){ ?><a href="<?php echo $p_name?>?<?php echo $condicao?>"><img src="../../img/bt_pg_voltar.png" border="0"></a><?php } ?></td>
	<?php } ?>
    <td width="280" height="25" align="center" valign="middle" >
    
    	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
		<?php 
        for($p=$ini; $p<$inc; $p++){ 
        if ($p < $n_pag){ 
        ?>
		<?php if($p==$pagina){ ?>
			<td width="25" height="25" align="center" class="pg_atual"><?php echo $p?></td>
		<?php } 
		else{
		?>			
            <td width="25" height="25" align="center"><a href="<?php echo $p_name?>?pagina=<?php echo $p?><?php echo $condicao?>" class="<?php echo $classe?>"><?php echo $p?></a></td>
		<?php }}} ?>
		</tr>
		</table>
        
	</td>
    <td align="center" valign="middle" width="25" height="25"><?php if ($pagina<$n_pag-1){ ?><a href="<?php echo $p_name?>?pagina=<?php echo $pagina+1?><?php echo $condicao?>"><img src="../../img/bt_pg_avancar.png" border="0"></a><?php } ?></td>  
	<td align="center" valign="middle" width="25" height="25"><?php if ($pagina<$n_pag-3){ ?><a href="<?php echo $p_name?>?pagina=<?php echo $n_pag-1?><?php echo $condicao?>"><img src="../../img/bt_pg_fim.png" border="0"></a><?php } ?></td>
</tr>
</table>
<?php } ?>