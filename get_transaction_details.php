<?php
include('includes/db_connexion.php');

if (isset($_POST['id_transaction'])) {
    $id_transaction = $_POST['id_transaction'];
    $query = "SELECT id_transaction, num_facture, client_fournisseur, montant, montant_paye, restant FROM transaction WHERE id_transaction = ?";
    $statement = $connect->prepare($query);
    $statement->execute([$id_transaction]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);
}