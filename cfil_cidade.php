﻿<?php

mysql_connect("localhost", "root", "");
mysql_select_db("absm_teste");

$pega_uf = $_POST['fuf'];

$sql = "SELECT cidade, descricao FROM cidade WHERE uf = '$pega_uf' ORDER BY descricao ASC";
$qr = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Selecione UF').'</option>';
   
}else{
   	  echo '<option value="">Cidade</option>';
   while($ln = mysql_fetch_assoc($qr)){
      echo '<option value="'.$ln['cidade'].'">'.$ln['descricao'].'</option>';
	  
   }
}

?>