<?php
date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

function saudacao(){
     $hora = date(" H ");
	 $data = date("d/m/Y");

     if($hora >= 12 && $hora<18) {
          $saudacao =  "<img src='imagem/sol_tarde.png'/><br/>Tenha uma <strong>Boa Tarde!</strong>";

     }else if ($hora >= 0 && $hora <12 ){
          $saudacao = "<img src='imagem/sol_manha.png'/><br/>Tenha uma <strong>Boa Tarde!</strong>";

     }else{
          $saudacao = "<img src='imagem/sol_noite.png'/><br/>Tenha uma <strong>Boa Tarde!</strong>";
     }
     echo  "$saudacao";
}
?>

<script type="text/javascript">

var hoje    = new Date();// crio um objeto date do javascript
var dia 	= hoje.getDate();
var mes     = hoje.getMonth();
var ano     = hoje.getFullYear();

if (dia <= 9) dia = "0" + dia;
//if (mes <= 9) mes = "0" + mes;
if (ano <= 19) ano = "19" + ano;

meses = new Array(12);

meses[0] = "Janeiro";
meses[1] = "Fevereiro";
meses[2] = "Março";
meses[3] = "Abril";
meses[4] = "Maio";
meses[5] = "Junho";
meses[6] = "Julho";
meses[7] = "Agosto";
meses[8] = "Setembro";
meses[9] = "Outubro";
meses[10] = "Novembro";
meses[11] = "Dezembro";

var digital = new Date(); // crio um objeto date do javascript
//digital.setHours(15,59,56); // caso não queira testar com o php, comente a linha abaixo e descomente essa
digital.setHours(<?php echo date("H,i,s"); ?>); // seto a hora usando a hora do servidor
<!--
function clock() {
var hora 	= digital.getHours();
var minuto 	= digital.getMinutes();
var segundo = digital.getSeconds();

digital.setSeconds( segundo + 1 ); // aqui que faz a mágica

// acrescento zero
if (hora <= 9) hora = "0" + hora;
if (minuto <= 9) minuto = "0" + minuto;
if (segundo <= 9) segundo = "0" + segundo;

dispTime = dia + " de " +	meses[mes] + " de " + ano + " - " + hora + ":" + minuto + ":" + segundo;
document.getElementById("clock").innerHTML = dispTime; // coloquei este div apenas para exemplo
setTimeout("clock()", 1000); // chamo a função a cada 1 segundo

}
window.onload = clock;
//-->

</script>

<script type="text/javascript">

	d = new Date();
	hour = d.getHours();
	if(hour < 5)
	{
	   document.write("<div class='icone'><img src='imagem/sol_noite.png'></div>Tenha uma<br /><strong>Boa Noite!</strong></div>");
	}
	else
	if(hour < 8)
	{
	   document.write("<div class='icone'><img src='imagem/sol_manha.png'/></div>Tenha um<br /><strong>Bom Dia!</strong></div>");
	}
	else
	if(hour < 12)
	{
	   document.write("<div class='icone'><img src='imagem/sol_manha.png'/>Tenha um<br /><strong>Bom Dia!</strong></div>");
	}
	else
	if(hour < 18)
	{
	   document.write("<div class='icone'><img src='imagem/sol_tarde.png'/></div>Tenha uma<br /><strong>Boa Tarde!</strong></div>");
	}
	else
	{
	   document.write("<div class='icone'><img src='imagem/sol_noite.png'/></div>Tenha uma<br /><strong>Boa Noite!</strong></div>");
	}

</script>