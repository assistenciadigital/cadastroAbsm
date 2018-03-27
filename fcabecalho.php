<?php
#inicio timezone
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');
#fim timezone

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

#nome do usuario
session_start();
$idusuario_atual = $_SESSION['id_usuario'];
$loginusuario_atual = $_SESSION['login_usuario'];
$nomeusuario_atual = $_SESSION['nome_usuario'];
$nivelusuario_atual = base64_decode($_SESSION['nivel_usuario']);

  //NIVEL 1 - Administrador
  //NIVEL 2 - Cadastro
  //NIVEL 3 - Atendimento
  //NIVEL 4 - Recibo

switch($nivelusuario_atual){
	case "1": $assistencia = "COMPLETA"; break; 
	case "2": $assistencia = "MEDICA"; break;
	case "3": $assistencia = "ODONTOLOGICA"; break;
	case "4": $assistencia = "ODONTOLOGICA"; break;}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">

var hoje    = new Date();// crio um objeto date do javascript
var dia 	= hoje.getDate();
var mes     = hoje.getMonth();
var ano     = hoje.getFullYear();
if (dia <= 9) dia = "0" + dia;
if (mes <= 9) mes = "0" + mes;
if (ano <= 19) ano = "19" + ano;

if(mes == 0) 
mes = "01" 

else if(mes ==1) 
mes = "02" 

else if(mes ==2) 
mes = "03" 

else if(mes ==3) 
mes = "04" 

else if(mes ==4) 
mes = "05"

else if(mes ==5) 
mes = "06" 

else if(mes ==6) 
mes = "07" 

else if(mes ==7) 
mes = "08" 

else if(mes ==8) 
mes = "09" 

else if(mes ==9) 
mes = "10" 

else if(mes ==10) 
mes = "11" 

else if(mes ==11) 
mes = "12" 

var digital = new Date(); // crio um objeto date do javascript
//digital.setHours(15,59,56); // caso não queira testar com o php, comente a linha abaixo e descomente essa
digital.setHours(<?php echo date("H,i,s"); ?>); // seto a hora usando a hora do servidor
<!--
function clock() {
var hora 	= digital.getHours();
var minuto 	= digital.getMinutes();
var segundo = digital.getSeconds();

digital.setSeconds( segundo+1 ); // aqui que faz a mágica

// acrescento zero
if (hora <= 9) hora = "0" + hora;
if (minuto <= 9) minuto = "0" + minuto;
if (segundo <= 9) segundo = "0" + segundo;

dispTime = dia + "/" +	 mes + "/" + ano + 	" " + hora + ":" + minuto + ":" + segundo;
document.getElementById("clock").innerHTML = dispTime; // coloquei este div apenas para exemplo
setTimeout("clock()", 1000); // chamo a função a cada 1 segundo

}
window.onload = clock;
//-->

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
<style type="text/css">

body,td,th {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
}
body {
	margin: 0;
	padding: 0;
	/*background: #ccc;*/
	text-align: center; /* hack para o IE */
	background-image: url(imagem/fundo.jpg);
	background-repeat: repeat-x;
	margin-left: 20px;
	margin-top: 0px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#tudo {
width: 700px;
height: 400px;
margin:0 auto;         
text-align:left; /* "remédio" para o hack do IE */ 
}
#conteudo {
padding: 0px;
/*background-color: #eee;*/
}

</style>

</head>

<body>
<div id="tudo">
<div id="conteudo">
<hr>
<strong>ABSM/MT - Associação Beneficente de Saúde dos Militares de MT</strong>
<hr>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="50%" align="left" ><strong>Usuário: </strong><?php print strtoupper($loginusuario_atual); ?> | <?php print strtoupper($nomeusuario_atual);?></td>
         <td width="50%" align="left" ><div id="icone"></div><div align="right"; id="clock"></div></td>
       </tr>
    </table>
<hr>

</body>
</html>