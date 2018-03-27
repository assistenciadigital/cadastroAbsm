<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

 function saudacao(){
     $hora = date(" H ");
	 $data = date("d/m/Y");

     if($hora >= 12 && $hora<18) {
          $saudacao = "Boa tarde! $data";

     }else if ($hora >= 0 && $hora <12 ){
          $saudacao = "Bom dia! $data";

     }else{
          $saudacao = "Boa noite! $data";
     }
     echo  "$saudacao";
}

// Formata data aaaa-mm-dd para dd/mm/aaaa
function data_form($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}
 
// Formata data dd/mm/aaaa para aaaa-mm-dd
function data_banco($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}
?>