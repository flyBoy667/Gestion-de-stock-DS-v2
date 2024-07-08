<?php
include('includes/db_connexion.php');

if (isset($_POST['id_transaction'])) {
    $id_transaction = $_POST['id_transaction'];
    $remboursser = $_POST['remboursser'];

    $restant = $_POST['restant'];
    $restant = $restant - $remboursser;

    $montant_a_jour = $_POST['montantPaye'] + $remboursser;

    if ($restant < 0) {
        echo json_encode(['success' => false, 'message' => 'Erreur: Impossible de payer plus de la facture.']);
        exit();
    }

    $query = "UPDATE transaction SET restant = ?, montant_paye = ? WHERE id_transaction = ?";
    $statement = $connect->prepare($query);

    try {
        $statement->execute([$restant, $montant_a_jour, $id_transaction]);
        echo json_encode(['success' => true, 'message' => 'Transaction mise à jour avec succès']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
    }
}
