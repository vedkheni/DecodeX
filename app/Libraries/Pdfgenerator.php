<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once __DIR__ . '/vendor/autoload.php';
require_once("dompdf_0-8-2/dompdf/autoload.inc.php");
// require_once("dompdf_0-8-2/dompdf/autoload.php");
use Dompdf\Dompdf;

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
   $dompdf = new Dompdf();
    $dompdf->loadHtml($html,'UTF-8');
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
		$dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }
  
 //  public function generate_and_save($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait",$path)
 //  {
	// $dompdf = new DOMPDF();
 //    $dompdf->loadHtml($html,'UTF-8');
 //    $dompdf->setPaper($paper, $orientation);
 //    $dompdf->render();
 //    if ($stream) {
	// 	 //$path1=$_SERVER['DOCUMENT_ROOT']."/assets/reports/".$path."/zone/";
	// 	 //$path=$_SERVER['DOCUMENT_ROOT']."/assets/";
	// 	$output = $dompdf->output();
	// 	file_put_contents($path.$filename.".pdf", $output);
 //    } else {
 //        return $dompdf->output();
 //    } 
   
 //  }
}