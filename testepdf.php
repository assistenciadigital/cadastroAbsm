<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HM - Saúde</title>
</head>

<body>
<?php
//fazemos a inclusão do arquivo com a classe FPDF
require_once("fpdf17/fpdf.php");

//criamos uma nova classe, que será uma extensão da classe FPDF
//para que possamos sobrescrever o método Header()
//com a formatação desejada
class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //insere e posiciona a imagem/logomarca
      $this->Image('imagem/\logo_absm_completo.png',10,8,33);

      //Informa a fonte, seu estilo e seu tamanho     
      $this->SetFont('Arial','B',12);

      //Informa o tamanho do box que receberá o cabeçalho
      //o texto que ele conterá, suas bordas e o alinhaento do texto
      $this->Cell(30,10,'Title',1,0,'C');

   }

   //Método Footer que estiliza o rodapé da página
   function Footer() {

      //posicionamos o rodapé a 1cm do fim da página
      $this->SetY(-10);
      
      //Informamos a fonte, seu estilo e seu tamanho
      $this->SetFont('Arial','I',8);

      //Informamos o tamanho do box que vai receber o conteúdo do rodapé
      //e inserimos o número da página através da função PageNo()
      //além de informar se terá borda e o alinhamento do texto
      $this->Cell(0,10,'Pagina: '.$this->PageNo().'/{nb}',0,0,'C');
   }

}

//Criamos o objeto da classe PDF
$pdf=new PDF('P');

//Inserimos a página
$pdf->AddPage();

//apontamos a fonte que será utilizada no texto
$pdf->SetFont('Times','',12);

//Aquí escribimos lo que deseamos mostrar...
$pdf->Cell(40,10,'texto a ser exibido');

//geramos a página
$pdf-> Output("testepdf.pdf");
?>
<script>window.open('testepdf.pdf'); </script>
</body>
</html>