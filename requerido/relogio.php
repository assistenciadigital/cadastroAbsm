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