<?php
namespace App\Libraries;

require_once(__DIR__ ."/vendor/autoload.php");
use Mpdf\Mpdf;
class Mpdfgenerator {
  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
      $mpdf = new Mpdf();
      // $mpdf->SetTitle($html);
      $mpdf->WriteHTML($html);
      return $mpdf->Output($filename.'.pdf','D');
  }
  public function generate_save($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
      $mpdf = new Mpdf();
      // $mpdf->SetTitle($html);
      $mpdf->WriteHTML($html);
      return $mpdf->Output($filename.'.pdf','F');
  }
  public function generate_preview($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
      $mpdf = new Mpdf();
      // $mpdf->SetTitle($html);
      $mpdf->WriteHTML($html);
      $pdf_content = $mpdf->Output('','S');
      echo '<object data="data:application/pdf;base64,'. base64_encode($pdf_content) .'" type="application/pdf" width="100%" height="100%"></object>';exit;
  }
}