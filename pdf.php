<?php
include('pdf/mpdf.php');
include('url.php');
$bill_number=$_SERVER['QUERY_STRING'];	
$mpdf=new mPDF();
$url=$default_url_set.'print-bill.php?'.$bill_number;
  $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL,$url );
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsonData = curl_exec($curlSession);
    curl_close($curlSession);
	
	$footer = '<div style=" font-size:8px">Powered By: <b>taxDoctor</b></div>';
$mpdf->SetFooter($footer);

$mpdf->WriteHTML($jsonData);
$mpdf->Output('GSTInvoice.pdf','I');   exit;
 ?>