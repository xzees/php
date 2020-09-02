<?php

namespace App\Helpers;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class PdfManager
{
  /*
  public static function genPdf($svg,$code,$template_dir,$template_css,$order_code){
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    
    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path(). '/fonts',
        ]),
        'fontdata' => $fontData + [
            'th_dbheaventmedv' => [
                'R' => 'DBHeavent/DBHeaventv.ttf',
            ]
        ],
        'default_font' => 'th_dbheaventmedv',
        'mode' => 'utf-8', 
        'format' => 'A4',
        'tempDir' => public_path() . '/template/tmp'
    ]);
    $html = view($template_dir,array(
      "ref1" => substr($code,16,18),
      "ref2"=> substr($code,35,18),
      "barcode"=>str_replace('<?xml version="1.0" standalone="no" ?>',"",$svg),
      "barcodeText"=>$code
    ))->render();

    $stylesheet = file_get_contents($template_css.'stylepdf.css');
    $cssToInlineStyles = new CssToInlineStyles();

    $visualHtml = $cssToInlineStyles->convert(
        $html,
        $stylesheet
    );
    $mpdf->SetTitle($order_code);
    $mpdf->WriteHTML($visualHtml);
    $mpdf->Output(public_path().'/pdf/bill-'.$order_code.'.pdf', 'F');
    $mpdf->Output('bill-'.$order_code.'.pdf', 'D');
  }
  */
}
