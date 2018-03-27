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

$sql = "SELECT cliente, nome, cpf, datanascimento, classificacao, tipo FROM cliente where status = 'Ativo' and classificacao = 1 and tipo = 1 ORDER BY nome";
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
		$pdf-> Cell(0,5,'Socio Efetivo Ativo - CBM',0,1);
		$pdf-> Ln(4); #pula 4 linhas
		
    	$pdf-> SetFont('Courier','B',9);
		$pdf-> Cell(15,4,'CODIGO',0,0);
		$pdf-> Cell(12,4,'INST',0,0);
		$pdf-> Cell(80,4,'NOME',0,0);
		$pdf-> Cell(23,4,'CPF',0,0);
		$pdf-> Cell(23,4,'DT NASCMTO',0,1);
		$pdf->Cell(0,0,'',1,1,'L'); #linha
		$pdf-> Ln(2); #pula 2 linhas
		          //cliente, nome, cpf, datanascimento, classificacao, tipo 
        while(list($cliente, $nome, $cpf, $datanascimento, $classificacao, $tipo) = mysql_fetch_row($rs)) {
						
		#data nascimento
		$ndata = explode("-",$datanascimento); 
		$dia = $ndata[0];
		$mes = $ndata[1];
		$ano = $ndata[2];
		$data_nascimento = "$ano/$mes/$dia";
		
		if ($tipo==1) $instituicao = "CBM";  else if($tipo==2) $instituicao = "PM";  
			
		$pdf-> SetFont('Courier','',9);
		$pdf-> Cell(15,5,''.$cliente.'',0,0);
		$pdf-> Cell(12,5,''.$instituicao.'',0,0);
		$pdf-> Cell(80,5,''.$nome.'',0,0);
		$pdf-> Cell(23,5,''.$cpf.'',0,0);
		$pdf-> Cell(23,5,''.$data_nascimento.'',0,0);
		$pdf-> Cell(11,5,'______________',0,1);
		#$pdf->Cell(0,0,'',1,1,'L'); #linha
		$pdf-> Ln(1); #pula 1 linhas
		
		
		}
		$contacbm   = mysql_num_rows(mysql_query("SELECT tipo from cliente where tipo =1"));
		
		$pdf-> Cell(23,5,'Qtde CBM: '.$contacbm.'',0,0);
		
		$pdf-> Output("relatorio_titular_ativos_cbm.pdf");
?>  
<script>window.open('relatorio_titular_ativos_cbm.pdf'); </script>
</body>
</html>