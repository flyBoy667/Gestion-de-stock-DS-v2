<?php
session_start();
require 'vendor/autoload.php';

include('includes/header.php');
require_once('includes/db_connexion.php');

try {
    $stmt = $connect->prepare("SELECT id_produit, nom_produit FROM produit ORDER BY id_produit;");
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

?>
<style>
    /* Styles spécifiques pour l'impression */
    @media print {
        body * {
            visibility: hidden;
        }

        /*#barcode-container, #barcode-container * {*/
        /*    visibility: visible;*/
        /*}*/
        #barcode-container-multiple, #barcode-container-multiple * {
            visibility: visible;
        }

        #barcode-container-multiple {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;

        }

        #barcode-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 20px;
            border: none;
            box-shadow: none;
        }

        title {
            display: none;
        }

        #printBtn {
            display: none;
        }

        h1 {
            display: none;
        }
    }
</style>
<div class="container">
    <select id="ref_produit" name="ref_produit" onchange="generateBarcode(this.value);" class="custom-select mb-3">
        <option value="0">Réf. produit</option>
        <?php foreach ($produits as $produit): ?>
            <option value="<?= $produit['id_produit'] ?>"><?= $produit['id_produit'] . ' - ' . $produit['nom_produit'] ?></option>
        <?php endforeach; ?>
    </select>
    <div id="barcode-container" class="card p-3 shadow-sm">
        <!-- Contenu généré dynamiquement -->
    </div>
    <div id="barcode-container-multiple" class="card p-3 shadow-sm" style="display: none">

    </div>
</div>

<script>
    function generateBarcode(code) {
        console.log(code);
        if (code !== '0') {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'generate_barcode.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Récupérer le contenu du code-barres
                    const barcodeHTML = xhr.responseText;

                    // Afficher le premier code-barres dans #barcode-container
                    document.getElementById('barcode-container').innerHTML = barcodeHTML;

                    // Ajouter 10 lignes de 5 instances de code-barres dans #barcode-container-multiple
                    const barcodeContainerMultiple = document.getElementById('barcode-container-multiple');
                    barcodeContainerMultiple.innerHTML = ''; // Vider le conteneur actuel

                    for (let line = 0; line < 10; line++) {
                        const lineDiv = document.createElement('div');
                        lineDiv.classList.add('barcode-line');

                        for (let i = 0; i < 5; i++) {
                            const barcodeDiv = document.createElement('div');
                            barcodeDiv.classList.add('p-4');
                            barcodeDiv.classList.add('barcode-instance');
                            barcodeDiv.style.display = 'inline-block'; // Afficher en ligne
                            barcodeDiv.style.width = '20%'; // 5 instances par ligne
                            barcodeDiv.innerHTML = barcodeHTML + "<br>"; // Ajouter le contenu du code-barres
                            lineDiv.appendChild(barcodeDiv);
                        }

                        barcodeContainerMultiple.appendChild(lineDiv);
                    }
                }
            };
            xhr.send('code=' + code);
        } else {
            document.getElementById('barcode-container').innerHTML = '';
            document.getElementById('barcode-container-multiple').innerHTML = '';
        }
    }
</script>

<?php include('includes/footer.php') ?>
