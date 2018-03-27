<?php
mysql_connect("localhost", "root", "");
mysql_select_db("absm_teste");

$pega_cidade = $_POST['fcidade'];

$sql = "SELECT bairro, descricao FROM bairro WHERE cidade = '$pega_cidade' ORDER BY descricao ASC";
$qr = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Aguardando cidade...').'</option>';
   
}else{
   	  echo '<option value="0">Bairro</option>';
   while($ln = mysql_fetch_assoc($qr)){
      echo '<option value="'.$ln['bairro'].'">'.$ln['descricao'].'</option>';
	  
   }
}
?>