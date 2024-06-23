<?php
include('includes/db_connexion.php');
$id = $_GET['id'];
$query ="SELECT t.num_facture, t.client_fournisseur, t.montant, t.remise, t.montant_paye, t.transaction_date, d.Detail_com, d.Detail_ref, d.Detail_qte, p.id_produit, p.nom_produit, p.code_produit, p.prix_vente, c.IdClient, c.Nom, c.Prenom FROM transaction t, clients c, detail d, produit p WHERE t.client_fournisseur = c.IdClient AND t.num_facture = d.Detail_com AND d.Detail_ref = p.id_produit AND t.num_facture= '".$id."'";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();

$query2 ="SELECT t.id_transaction, t.num_facture, t.client_fournisseur, t.montant, t.montant_paye, t.type, t.transaction_date, c.IdClient, c.Nom, c.Prenom, c.Adresse, c.Tel FROM transaction t, clients c WHERE t.client_fournisseur = c.IdClient AND t.num_facture= '".$id."'";

$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
$total_row2 = $statement2->rowCount();

$totalht = 0.00;
include('includes/header.php');
?>

<div class="ticket">
    <?php if ($total_row2 > 0) {
        foreach ($result2 as $row2) { ?>
            <p class="centered">
                <img src="dist/img/icon_stock.png" alt="Logo" width="50" height="50">
                <br>D&S Inventeur
                <br>Bamako, ACI 2000
                <br>Phone: (223) 91-93-60-13 / 78-62-85-87
                <br>Email: info@ds-mali.com
                <br><br>Date: <?php echo $row2['transaction_date']; ?>
                <br><br>Facture #: <?php echo $row2['num_facture']; ?>
                <br>Client: <?php echo $row2['Nom'] . " " . $row2['Prenom']; ?>
                <br>Adresse: <?php echo $row2['Adresse']; ?>
                <br>Phone: <?php echo $row2['Tel']; ?>
            </p>
        <?php }
    } ?>

    <table>
        <thead>
        <tr>
            <th class="description">Produit</th>
            <th class="quantity">Qty</th>
            <th class="price">Prix UHT</th>
            <th class="price">Montant HT</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($total_row > 0) {
            foreach ($result as $row) { ?>
                <tr>
                    <td class="description"><?php echo $row['nom_produit']; ?></td>
                    <td class="quantity"><?php echo $row['Detail_qte']; ?></td>
                    <td class="price"><?php echo number_format($row['prix_vente'], 2, ',', ' '); ?></td>
                    <td class="price"><?php $mth = $row['Detail_qte'] * $row['prix_vente']; echo number_format($mth, 2, ',', ' '); ?></td>
                </tr>
                <?php $totalht += $mth; $remise = $row['remise'];
            }
        } ?>
        </tbody>
    </table>
    <p class="centered">
        Montant HT: <?php echo number_format($totalht, 2, ',', ' '); ?><br>
        Remise: <?php echo number_format($remise, 2, ',', ' '); ?><br>
        Total: <?php $mtotalht = $totalht - $remise; echo number_format($mtotalht, 2, ',', ' '); ?>
    </p>
</div>

<div class="centered no-print">
    <button id="printButton">Imprimer le ticket</button>
</div>

<?php include('includes/footer.php');?>

<script>
    $(document).ready(function() {
        $('#retour').click(function(){
            document.location.href="http://localhost/stock_final/liste_vente.php";
        });

        $('#printButton').click(function(){
            window.print();
        });
    });
</script>

<style>
    .ticket {
        width: 80mm;
        max-width: 80mm;
        padding: 10px;
        font-size: 12px;
        border: 1px solid #000;
        margin: 0 auto;
        background: #fff;
    }
    .centered {
        text-align: center;
        align-content: center;
    }
    .ticket table {
        width: 100%;
        border-collapse: collapse;
    }
    .ticket th, .ticket td {
        border-top: 1px dashed black;
        border-bottom: 1px dashed black;
        padding: 5px;
    }
    .ticket .description {
        text-align: left;
    }
    .ticket .quantity, .ticket .price {
        text-align: right;
    }
    .ticket img {
        max-width: inherit;
        width: inherit;
    }
    .no-print {
        display: block;
    }
    @media print {
        .no-print {
            display: none;
        }
    }
</style>
