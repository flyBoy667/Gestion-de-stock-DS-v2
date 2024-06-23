<?php


require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$baseUrl = "https://127.0.0.1.com/vente.php";

$mysqli = new mysqli("127.0.0.1", "fly", "root", "stock_v3");

if ($mysqli->connect_error) {
    die("Échec de la connexion : " . $mysqli->connect_error);
}

$sql = "SELECT id_produit FROM produit";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['id_produit'];
        $productUrl = $baseUrl . "?id=" . $productId;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($productUrl)
            ->size(300)
            ->margin(10)
            ->build();

        $filePath = __DIR__ . "/qrcodes/produit_$productId.png";
        $result->saveToFile($filePath);

        echo "QR Code pour le produit $productId généré.<br/>";
    }
} else {
    echo "Aucun produit trouvé.";
}

$mysqli->close();


