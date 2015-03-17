<?php
// Including all required classes
require_once('class/BCGFontFile.php');
require_once('class/BCGColor.php');
require_once('class/BCGDrawing.php');

// Including the barcode technology
require_once('class/BCGcode39.barcode.php');

// Loading Font
$font = new BCGFontFile('./font/Arial.ttf', 18);

// Don't forget to sanitize user inputs
$text = isset($_GET['text']) ? $_GET['text'] : 'YUEYOU';

// The arguments are R, G, B for color.
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);

$drawException = null;
try {
    $code = new BCGcode39();
    $code->setScale(2); // Resolution
    $code->setThickness(30); // Thickness
    $code->setForegroundColor($color_black); // Color of bars
    $code->setBackgroundColor($color_white); // Color of spaces
    $code->setFont($font); // Font (or 0)
    $code->parse($text); // Text
} catch(Exception $exception) {
    $drawException = $exception;
}

/* Here is the list of the arguments
1 - Filename (empty : display on screen)
2 - Background color */
$drawing = new BCGDrawing('../pic/yueyou', $color_white);
if($drawException) {
    $drawing->drawException($drawException);
} else {
    $drawing->setBarcode($code);
    $drawing->draw();
}

// Draw (or save) the image into PNG format.
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

echo '<p>~~Barcode PHP~~</p> <hr></hr> <img src="../pic/yueyou.png"/>';
?>
