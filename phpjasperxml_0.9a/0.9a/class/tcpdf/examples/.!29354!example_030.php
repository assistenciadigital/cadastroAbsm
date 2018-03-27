<?php
//============================================================+
// File name   : example_030.php
// Begin       : 2008-06-09
// Last Update : 2010-08-08
//
// Description : Example 030 for TCPDF class
//               Colour gradients
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colour gradients
 * @author Nicola Asuni
 * @since 2008-06-09
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 030');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 030', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// --- first page ------------------------------------------

// add a page
$pdf->AddPage();

$pdf->Cell(0, 0, 'TCPDF Gradients', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

// set colors for gradients (r,g,b) or (grey 0-255)
$red = array(255, 0, 0);
$blue = array(0, 0, 200);
$yellow = array(255, 255, 0);
$green = array(0, 255, 0);
$white = array(255);
$black = array(0);

// set the coordinates x1,y1,x2,y2 of the gradient (see linear_gradient_coords.jpg)
$coords = array(0, 0, 1, 0);

// paint a linear gradient
$pdf->LinearGradient(20, 45, 80, 80, $red, $blue, $coords);

// write label
$pdf->Text(20, 130, 'LinearGradient()');

// set the coordinates fx,fy,cx,cy,r of the gradient (see radial_gradient_coords.jpg)
$coords = array(0.5, 0.5, 1, 1, 1.2);

// paint a radial gradient
$pdf->RadialGradient(110, 45, 80, 80, $white, $black, $coords);

// write label
$pdf->Text(110, 130, 'RadialGradient()');

// paint a coons patch mesh with default coordinates
$pdf->CoonsPatchMesh(20, 155, 80, 80, $yellow, $blue, $green, $red);

// write label
$pdf->Text(20, 240, 'CoonsPatchMesh()');

