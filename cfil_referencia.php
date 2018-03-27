<?php

mysql_connect("localhost", "root", "");
mysql_select_db("absm_teste");

$pega_emitente = $_POST['femitente'];

$sql = "SELECT referencia, descricao FROM recibo_referencia WHERE emitente = '$pega_emitente' ORDER BY descricao ASC";
$qr = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Selecione Emitente').'</option>';
   
}else{
   	  echo '<option value="">Referencia</option>';
   while($ln = mysql_fetch_assoc($qr)){
      echo '<option value="'.$ln['referencia'].'">'.$ln['descricao'].'</option>';
	  
   }
}

?>