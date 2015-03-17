<?php
// in :file , out: output,bmp
function gen_html_and_bmp($file){
  // $start = microtime(true); //
  $counter = array();
  $date = array();
  $time = array();
  $counter_number = 0;
  $date_number = 0;
  $time_number = 0;
  $output = "print/" . $file . ".html";
  $bmp = "print/" . $file. ".bmp";
  $fh = fopen($output, 'w') or exit("can't open file");
  $stringData = '<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html;charset=utf-8" /><title>print in hand</title></head><body>';
  
  // echo "[+] gen_html_and_bmp: openfile: ".(microtime(true) - $start). "s";

  $string = file_get_contents("data/" . $file . ".txt");
  $json_a = json_decode($string, true);

  // echo "[+] gen_html_and_bmp:  json_decode: ".(microtime(true) - $start). "s";
  foreach ($json_a["item"] as $line) {
    if($line['type'] == "picture"){
      $val = '<img src="/pic/'. $line['content'] . '.bmp">';
    }else if($line['type'] == "qrcode"){
      create_qrcode($line);
      $val = '<img src="/pic/'.$line['content'].'.bmp">'; 
    }else if($line['type'] == "barcode"){
      create_barcode($line);
      $val = '<img src="/pic/'.$line['content'].'.png">';
    }
    else if($line['type'] == "counter"){ 
      $counter[$counter_number] = $line;
      $counter_number++;
      $val = $line['content'];
    }else if($line['type'] == "date"){
      $val = $line['content'];
      $date[$date_number] = $line;
      $date_number++;
    }else if($line['type'] == "time"){
      $val = $line['content'];
      $time[$time_number] = $line;
      $time_number++;
    }else{
      $val = $line['content'];
    }

    $stringData .= '<div style="white-space:nowrap;position:absolute;left:'.$line['x'].'px;top:'.$line['y'].'px;font:'.$line['font'].';font-size:'.$line['fontsize'].'px;">'.$val.'</div>';
  }
  $stringData .= '</body></html>';
  fwrite($fh, $stringData);
  fclose($fh);

  // echo "[+] gen_html_and_bmp: write file: ".(microtime(true) - $start). "s";
  //screenshot
  //$cmd = 'xvfb-run --server-args="-screen 0, 1024x768x24" CutyCapt --url=http://127.0.0.1:8080/'.$output.' --out='. $bmp .' --out-quality=1 --min-height=128';
  $cmd = 'CutyCapt -qws --url=http://127.0.0.1:8080/'.$output.' --out='. $bmp .' --out-quality=1 --fixed-height=128';
  `$cmd`;
  // echo "[+] gen_html_and_bmp: Elapsed: ".(microtime(true) - $start);
  return array(0,$output,$bmp,$counter,$counter_number,$date_number,$time_number,$date,$time);
}

function prettyPrint($json) {
  $result = '';
  $level = 0;
  $prev_char = '';
  $in_quotes = false;
  $ends_line_level = NULL;
  $json_length = strlen($json);

  for ($i = 0; $i < $json_length; $i++) {
    $char = $json[$i];
    $new_line_level = NULL;
    $post = "";
    if ($ends_line_level !== NULL) {
      $new_line_level = $ends_line_level;
      $ends_line_level = NULL;
    }
    if ($char === '"' && $prev_char != '\\') {
      $in_quotes = !$in_quotes;
    } else if (!$in_quotes) {
      switch( $char ) {
        case '}' :
        case ']' :
        $level--;
        $ends_line_level = NULL;
        $new_line_level = $level;
        break;

        case '{' :
        case '[' :
        $level++;
        case ',' :
        $ends_line_level = $level;
        break;

        case ':' :
        $post = " ";
        break;

        case " " :
        case "\t" :
        case "\n" :
        case "\r" :
        $char = "";
        $ends_line_level = $new_line_level;
        $new_line_level = NULL;
        break;
      }
    }
    if ($new_line_level !== NULL) {
      $result .= "\n" . str_repeat("\t", $new_line_level);
    }
    $result .= $char . $post;
    $prev_char = $char;
  }

  return $result;
}

function create_qrcode($data){
  $classpath = getcwd();
  include($classpath.'/lib/phpqrcode.php'); 
  $content = $data['content'];
  $filename = $classpath.'/pic/'.$content.'.bmp';
  $errorCorrectionLevel = $data['refix'];
  $matrixPointSize = $data['size'];

  QRcode::png($content, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}

function create_barcode($data){
    // Including all required classes
  $classpath = getcwd();
  require_once($classpath.'/lib/class/BCGFontFile.php');
  require_once($classpath.'/lib/class/BCGColor.php');
  require_once($classpath.'/lib/class/BCGDrawing.php');
  require_once($classpath.'/lib/class/BCGean8.barcode.php');
  require_once($classpath.'/lib/class/BCGupca.barcode.php');
  require_once($classpath.'/lib/class/BCGs25.barcode.php');
  require_once($classpath.'/lib/class/BCGi25.barcode.php');
  require_once($classpath.'/lib/class/BCGcodabar.barcode.php');
  require_once($classpath.'/lib/class/BCGcode39.barcode.php');
  require_once($classpath.'/lib/class/BCGcode128.barcode.php');
  $code = new BCGcode39();

      // Loading Font
  $font = new BCGFontFile($classpath.'/lib/font/Arial.ttf', 18);

      //The content of barcode
  $text = $data['content'];

      // The arguments are R, G, B for color.
  $color_black = new BCGColor(0, 0, 0);
  $color_white = new BCGColor(255, 255, 255);

      //The class of exception
  $drawException = null;

  try{
    switch ($data['codetype'])
    {
      case 'EAN':
      $code = new BCGean8();
      break;

      case 'Codabar':
      $code = new BCGcodabar();
      break;

      case 'UPC':
      $code = new BCGupca();
      break;

      case 'S25':
      $code = new BCGs25();
      break;

      case 'I25':
      $code = new BCGi25();
      break;

      case 'C39':
      $code = new BCGcode39();
      break;

      case 'C128':
      $code = new BCGcode128();
      break;

      default:
      break;
    }
          $code->setScale($data['size']); // Resolution
          $code->setThickness(30); // Thickness
          $code->setForegroundColor($color_black); // Color of bars
          $code->setBackgroundColor($color_white); // Color of spaces
          $code->setFont($font); // Font (or 0)
          $code->parse($text); // Text
        } catch(Exception $exception) {
          $drawException = $exception;
        }

        $drawing = new BCGDrawing($classpath.'/pic/'.$data['content'], $color_white);
        if($drawException) {
          $drawing->drawException($drawException);
        } else {
          $drawing->setBarcode($code);
          $drawing->draw();
        }

        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
}

?>
