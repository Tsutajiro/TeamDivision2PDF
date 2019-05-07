<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

require_once "../../TCPDF/tcpdf.php";

session_start();

// add font
$font = new TCPDF_FONTS();

// TCPDF
$tcpdf = new TCPDF("Landscape");
$tcpdf -> AddPage();
$tcpdf -> SetFont('kozgopromedium', '', 12);

$tcpdf -> writeHTML($_SESSION['html']);
$tcpdf -> Output("test.pdf");

?>