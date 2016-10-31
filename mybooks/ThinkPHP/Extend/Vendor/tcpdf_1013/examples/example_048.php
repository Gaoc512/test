<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
// 

function url_exists($url) {
	    $ch = curl_init(); 
	    curl_setopt ($ch, CURLOPT_URL, $url); 
	    //不下载
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    //设置超时
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	    curl_exec($ch);
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    if($http_code == 200) {
	        return true;
	    }
	    return false;
	}
 
$test = url_exists('http://106.38.65.206:8010/Upload/picimg/m_56a6e65396302.jpg');
var_dump($test);die;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('gaoccc');
$pdf->SetTitle('TCPDF Example 048');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
/*
// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Example of HTML tables 搞成', '', 0, 'L', true, 0, false, false, 0);

// add a page
$pdf->AddPage();
*/
$pdf->AddPage();
//$pdf->SetFont('msungstdlight','', 12);
$pdf ->SetFont( 'droidsansfallback' , '' ,12);



$html  = '<img src="http://106.38.65.206:8010/Upload/picimg/m_56a6e65396302.jpg" style="width:50%;height:50% " />';
//$html = '<p>搞成</p>';





$pdf->writeHTML($html, true, false, false, false, '');


// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+