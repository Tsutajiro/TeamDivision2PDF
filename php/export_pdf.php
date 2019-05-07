<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

require_once "../../TCPDF/tcpdf.php";

session_start();

// get heading
$heading = $_POST['heading_text'];
$htag = "<h1>" . $heading . "</h1>";

// add font
$font = new TCPDF_FONTS();

// TCPDF
$tcpdf = new TCPDF("Landscape");
$tcpdf -> AddPage();
$tcpdf -> SetFont('kozgopromedium', '', 12);

$html = $htag . $_SESSION['html'];
$tcpdf -> writeHTML($html);
$tcpdf -> Output();

?>