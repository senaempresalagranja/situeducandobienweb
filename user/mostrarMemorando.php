<?php
require '../vendor/autoload.php' ;
use  Spipu\Html2Pdf\Html2Pdf;
	ob_start();
	require_once  '../user/memorando.php';
	$html = ob_get_clean();
    $html2pdf = new HTML2PDF('p', 'A4', 'en');
    $html2pdf->setDefaultFont('Arial' );
    $html2pdf->writeHTML($html, false);
    if(isset($_GET['D'])){
    $html2pdf->Output('memorando.pdf', 'D');
	}else{
		$html2pdf->Output('memorando.pdf', );
	}
?>