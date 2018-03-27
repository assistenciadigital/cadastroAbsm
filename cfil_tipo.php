<?php

mysql_connect("localhost", "root", "");
mysql_select_db("absm_teste");

$pega_classificacao = $_POST['fclassificacao'];

$sql = "SELECT tipo, descricao FROM tipo WHERE classificacao = '$pega_classificacao' AND titular = 'S' ORDER BY descricao ASC";
$qr = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($qr) == 0){
   echo  '<option value="0">'.htmlentities('Selecione Classificação').'</option>';
   
}else{
	if(mysql_num_rows($qr) == 1){
	   while($ln = mysql_fetch_assoc($qr)){
	      echo '<option value="'.$ln['tipo'].'">'.$ln['descricao'].'</option>';}
	   }else{
        echo '<option value="">Selecione o Tipo</option>';
        while($ln = mysql_fetch_assoc($qr)){
 	       echo '<option value="'.$ln['tipo'].'">'.$ln['descricao'].'</option>';}	  
   }
}

?>