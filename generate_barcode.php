<?php
session_start();
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Générateur de code-barres en PNG
    $generatorPNG = new BarcodeGeneratorPNG();
    $barcodePNG = $generatorPNG->getBarcode($code, $generatorPNG::TYPE_CODE_128);

    echo '<h1>Code-barres pour le produit</h1>';
    echo '<img src="data:image/png;base64,' . base64_encode($barcodePNG) . '">';
    echo '<br><button id="printBtn" onclick="document.getElementById(\'barcode-container-multiple\').style.display = \'block\'; window.print(); setTimeout(function() {';
    echo '        document.getElementById(\'barcode-container-multiple\').style.display = \'none\';';
    echo '    }, 10);">Imprimer</button>';
}
