<?php
require '../vendor/autoload.php' ;

use  Spipu\Html2Pdf\Html2Pdf;


	ob_start();
	require_once 'pdfPrograma.php';
	$html = ob_get_clean();


    $html2pdf = new HTML2PDF('p', 'A4', 'es');
    $html2pdf->setDefaultFont('Arial' );
    $html2pdf->writeHTML($html, false);
    $html2pdf->Output('listarProgramas.pdf','D' );

?>