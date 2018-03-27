<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM Saúde</title>
</head>
<body>
<?php
#CONSULTA NO BANCO DE DADOS
include("requerido/conexao.php");

$sql = "SELECT cliente, nome, cpf, datanascimento FROM cliente ORDER BY nome";
$rs = mysql_query($sql);
?>
<?php
// Caminho para o arquivo fpdf.php
require_once("fpdf17/fpdf.php");

// New - Novo documento PDF com orientaçao P - Retrato (Picture) que pode ser também L - Paisagem (Landscape)
$pdf= new FPDF('P', 'mm', 'A4');
$pdf-> Open();
// Definindo Fonte
$pdf->SetFont('Courier','B',10);
//posicao vertical no caso -1 e o limite da margem
$pdf->SetY("-2");
		//::::::::::::::::::Cabecalho::::::::::::::::::::
		$pdf->Image('imagem/\logo_absm_completo.png');
		
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
		$pdf-> Cell(0,5,'Titular',0,1);
		$pdf-> Ln(4); #pula 4 linhas
		
    	$pdf-> SetFont('Courier','B',9);
		$pdf-> Cell(15,4,'CLIENTE',0,0);
		$pdf-> Cell(80,4,'NOME',0,0);
		$pdf-> Cell(23,4,'CPF',0,0);
		$pdf-> Cell(23,4,'DT NASCMTO',0,1);
		$pdf->Cell(0,0,'',1,1,'L'); #linha
		$pdf-> Ln(2); #pula 2 linhas
        while(list($cliente, $nome, $cpf, $datanascimento) = mysql_fetch_row($rs)) {
			
		#data nascimento
		$ndata = explode("-",$datanascimento); 
		$dia = $ndata[0];
		$mes = $ndata[1];
		$ano = $ndata[2];
		$data_nascimento = "$ano/$mes/$dia";
			
		$pdf-> SetFont('Courier','',9);
		$pdf-> Cell(15,5,''.$cliente.'',0,0);
		$pdf-> Cell(80,5,''.$nome.'',0,0);
		$pdf-> Cell(23,5,''.$cpf.'',0,0);
		$pdf-> Cell(23,5,''.$data_nascimento.'',0,0);
		$pdf-> Cell(23,5,'_________________________',0,1);
		#$pdf->Cell(0,0,'',1,1,'L'); #linha
		$pdf-> Ln(1); #pula 1 linhas
		}
		$pdf-> Output("relatorio_dependente.pdf");
?>  
<script>window.open('relatorio_dependente.pdf'); </script>
</body>
</html>