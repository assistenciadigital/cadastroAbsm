<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>
</head>
<body>

<?php

function valor_extenso($valor=0, $maiusculas=false)
{
    // verifica se tem virgula decimal
    if (strpos($valor,",") > 0)
    {
      // retira o ponto de milhar, se tiver
      $valor = str_replace(".","",$valor);
 
      // troca a virgula decimal por ponto decimal
      $valor = str_replace(",",".",$valor);
    }
$singular = array("centavo", "real", "mil", "milhao", "bilhao", "trilhao", "quatrilhao");
$plural = array("centavos", "reais", "mil", "milhoes", "bilhoes", "trilhoes",
"quatrilhÃµes");
 
$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
$u = array("", "um", "dois", "tres", "quatro", "cinco", "seis",
"sete", "oito", "nove");
 
        $z=0;
 
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
		$cont=count($inteiro);
		        for($i=0;$i<$cont;$i++)
                for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];
 
        $fim = $cont - ($inteiro[$cont-1] > 0 ? 1 : 2);
        for ($i=0;$i<$cont;$i++) {
                $valor = $inteiro[$i];
                $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
                $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
                $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
                $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
                $t = $cont-1-$i;
                $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")$z++; elseif ($z > 0) $z--;
                if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
                if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
         if(!$maiusculas)
		 {
          return($rt ? $rt : "zero");
         } elseif($maiusculas == "2") {
          return (strtoupper($rt) ? strtoupper($rt) : "Zero");
         } else {
         return (ucwords($rt) ? ucwords($rt) : "Zero");
         }
 
}
#fim function valor_extenso
?>

<?php

#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");

?>

<?php

$sql_recibo = "SELECT recibo,valor,emitente,referencia,destinatario,tipo,titular,mes_ano,descricao,data,hora,usuario from recibo";

$rs_recibo = mysql_query($sql_recibo);
	
// Caminho para o arquivo fpdf.php
require_once("fpdf17/fpdf.php");

// New - Novo documento PDF com orientaçao P - Retrato (Picture) que pode ser também L - Paisagem (Landscape)
$pdf= new FPDF('P');
$pdf-> Open();

// Definindo Fonte
$pdf->SetFont('Courier','B',10);
//posicao vertical no caso -1 e o limite da margem
$pdf->SetY("-2");
		//::::::::::::::::::Cabecalho::::::::::::::::::::
		$pdf->Image('imagem/\ABSM-HM-LOGO.JPG');
		
		$pdf->Cell(0,5,'ABSM - Associacao Beneficente de Saude dos Militares do Estado de Mato Grosso',0,1,'C');
		$pdf->Cell(0,5,'HOSPITAL MILITAR',0,0,'L');
		$pdf->Cell(0,5,'HM Saude',0,1,'R');
		$pdf->Cell(0,0,'',1,1,'L'); #linha

		$pdf->Ln(4);	#pula 4 linhas	

		$pdf-> SetFont('Courier','B',10);
		$pdf-> SetFillColor(122,122,122);

		$pdf-> SetFont('Courier','B',12);
		$pdf-> Cell(27,5,'Relatorio:',0,0);
		$pdf-> SetFont('Courier','',12);
		$pdf-> Cell(0,5,'Recibo',0,1);
		$pdf-> Ln(4); #pula 4 linhas
		
    	$pdf-> SetFont('Courier','B',9);
		$pdf-> Cell(13,4,'RECIBO',0,0);
		$pdf-> Cell(15,4,'EMISSOR',0,0);
		$pdf-> Cell(21,4,'FAVORECIDO',0,0);
		$pdf-> Cell(21,4,'REFERENCIA',0,0);
		$pdf-> Cell(25,4,'VALOR R$',0,0,'R');
		$pdf-> Cell(25,4,'DESCRICAO',0,0,'R');
		$pdf-> Cell(20,4,'DATA',0,0);
		$pdf-> Cell(17,4,'HORA',0,0);
		$pdf-> Cell(20,4,'USUARIO',0,1);
		$pdf->Cell(0,0,'',1,1,'L'); #linha
		$pdf-> Ln(2); #pula 2 linhas
  	    
		while(list($recibo,$valor,$emitente,$referencia,$destinatario,$tipo,$titular,$mes_ano,$descricao,$data,$hora,$usuario) = mysql_fetch_row($rs_recibo)) {
			
			$pega_emitente = $emitente;
			$pega_destinatario = $destinatario;
		
		#data
		$ndata = explode("-",$data); 
		$dia = $ndata[0];
		$mes = $ndata[1];
		$ano = $ndata[2];
		$data_final = "$ano/$mes/$dia";
		
		$pdf-> SetFont('Courier','',9);
		$pdf-> Cell(13,5,''.$recibo.'',0,0,'R');
		$pdf-> Cell(15,5,''.$emitente.'',0,0,'R');
		$pdf-> Cell(21,5,''.$destinatario.'',0,0,'R');
		$pdf-> Cell(21,5,''.$referencia.'',0,0,'R');
		$pdf-> Cell(25,5,''.number_format($valor, 2, ',', '.').'',0,0,'R');
		$pdf-> Cell(20,5,''.$data_final.'',0,0);
		$pdf-> Cell(17,5,''.$hora.'',0,0);
		$pdf-> Cell(20,5,''.$usuario.'',0,0);
		$pdf-> Cell(21,5,''.$descricao.'',0,1);		
		$pdf-> Ln(1); #pula 1 linhas
		}
		$pdf-> Output("relatorio_recibo.pdf"); 
		
?>

<script>window.open('relatorio_recibo.pdf'); </script>

</body>
</html>