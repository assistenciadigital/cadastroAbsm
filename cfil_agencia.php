<?php

mysql_connect("localhost", "root", "");
mysql_select_db("absm_teste");

$pega_banco = $_POST['fbanco'];

$sql = "SELECT agencia, descricao FROM agencia WHERE banco = '$pega_banco' ORDER BY banco, agencia ASC";
$qr = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Selecione Banco').'</option>';
   
}else{
	if(mysql_num_rows($qr) == 1){
	   while($ln = mysql_fetch_assoc($qr)){
	      echo '<option value="'.$ln['agencia'].'">'.$ln['agencia'].' - '.$ln['descricao'].'</option>';}
	   }else{
        echo '<option value="">Selecione o Agência</option>';
        while($ln = mysql_fetch_assoc($qr)){
 	       echo '<option value="'.$ln['agencia'].'">'.$ln['descricao'].'</option>';}	  
   }
}

?>