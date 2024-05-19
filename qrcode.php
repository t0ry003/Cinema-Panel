<?php

require 'vendor/autoload.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$text = (isset($_GET["text"]) ? $_GET["text"] : "0");

$qr_code = QrCode::create($text)
    ->setSize(150)
    ->setMargin(5)
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));


$writer = new PngWriter;

$result = $writer->write($qr_code);

header("Content-Type: " . " image/png");

echo $result->getString();
