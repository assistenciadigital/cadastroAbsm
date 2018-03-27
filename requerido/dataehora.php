<?php

date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

?>

<script type="text/javascript">

var hoje    = new Date();// crio um objeto date do javascript
var dia 	= hoje.getDate();
var mes     = hoje.getMonth();
var ano     = hoje.getFullYear();

mes = mes + 1;

if (dia <= 9) dia = "0" + dia;
if (mes <= 9) mes = "0" + mes;
if (ano <= 19) ano = "19" + ano;

meses = new Array(12);

var digital = new Date(); // crio um objeto date do javascript
//digital.setHours(15,59,56); // caso não queira testar com o php, comente a linha abaixo e descomente essa
digital.setHours(<?php echo date("H,i,s"); ?>); // seto a hora usando a hora do servidor
<!--
function clock() {
var hora 	= digital.getHours();
var minuto 	= digital.getMinutes();
var segundo = digital.getSeconds();

digital.setSeconds(segundo + 1); // aqui que faz a mágica

	if(hora < 5)
	{
	   //saudacao = ("<img src='imagem/sol_noite.png'>Tenha uma<br/><strong>Boa Noite!</strong>");
	   saudacao = ("<strong>Boa Noite!</strong>");
	}
	else
	if(hora < 8)
	{
	   //saudacao = ("<img src='imagem/sol_manha.png'/>Tenha um<br/><strong>Bom Dia!</strong>");
	   saudacao = ("<strong>Bom Dia!</strong>");
	}
	else
	if(hora < 12)
	{
	   //saudacao = ("<img src='imagem/sol_manha.png'/>Tenha um<br/><strong>Bom Dia!</strong>");
	   saudacao = ("<strong>Bom Dia!</strong>");
	}
	else
	if(hora < 18)
	{
	   //saudacao = ("<img src='imagem/sol_tarde.png'/>Tenha uma<br/><strong>Boa Tarde!</strong>");
	   saudacao = ("<strong>Boa Tarde!</strong>");
	}
	else
	{
	   //saudacao = ("<img src='imagem/sol_noite.png'/>Tenha uma<br/><strong>Boa Noite!</strong>");
	   saudacao = ("<strong>Boa Noite!</strong>");
	}

// acrescento zero
if (hora <= 9) hora = "0" + hora;
if (minuto <= 9) minuto = "0" + minuto;
if (segundo <= 9) segundo = "0" + segundo;

dispTime = saudacao + " - " + dia + "/" + mes + "/" + ano + " " + hora + ":" + minuto + ":" + segundo;
document.getElementById("clock").innerHTML = dispTime; // coloquei este div apenas para exemplo
setTimeout("clock()", 1000); // chamo a função a cada 1 segundo

}
window.onload = clock;
//-->

</script>