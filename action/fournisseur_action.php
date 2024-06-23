<?php

// Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $query = $connect->prepare('INSERT INTO fournisseur (nom_fournisseur, prenom_fournisseur, societe, adresse, telephone) VALUES(?, ?, ?, ?, ?)');
        $query->bindValue(1, $_POST['nom_fournisseur']);
        $query->bindValue(2, $_POST['prenom_fournisseur']);
        $query->bindValue(3, $_POST['societe']);
        $query->bindValue(4, $_POST['adresse']);
        $query->bindValue(5, $_POST['telephone']);
        $query->execute();
        echo '<p>Donnée Insérée...</p>';
    }

    if ($_POST["action"] == "fetch_single") {
        $query = "SELECT * FROM fournisseur WHERE ref_fournisseur = :id";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['nom_fournisseur'] = $row['nom_fournisseur'];
            $output['prenom_fournisseur'] = $row['prenom_fournisseur'];
            $output['societe'] = $row['societe'];
            $output['adresse'] = $row['adresse'];
            $output['telephone'] = $row['telephone'];
        }
        echo json_encode($output);
    }

    if ($_POST["action"] == "update") {
        $query = "
        UPDATE fournisseur 
        SET nom_fournisseur = :nom_fournisseur, 
            prenom_fournisseur = :prenom_fournisseur, 
            societe = :societe, 
            adresse = :adresse, 
            telephone = :telephone
        WHERE ref_fournisseur = :hidden_id
        ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':nom_fournisseur', $_POST['nom_fournisseur']);
        $statement->bindValue(':prenom_fournisseur', $_POST['prenom_fournisseur']);
        $statement->bindValue(':societe', $_POST['societe']);
        $statement->bindValue(':adresse', $_POST['adresse']);
        $statement->bindValue(':telephone', $_POST['telephone']);
        $statement->bindValue(':hidden_id', $_POST['hidden_id'], PDO::PARAM_INT);
        $statement->execute();
        echo '<p>Donnée Mise à jour</p>';
    }

    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM fournisseur WHERE ref_fournisseur = :id";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $statement->execute();
        echo '<p>Donnée Supprimée</p>';
    }

    if ($_POST["action"] == "fetch_single_detail") {
        $query = "SELECT * FROM fournisseur WHERE ref_fournisseur = :id";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['nom_fournisseur'] = $row['nom_fournisseur'];
            $output['prenom_fournisseur'] = $row['prenom_fournisseur'];
            $output['societe'] = $row['societe'];
            $output['adresse'] = $row['adresse'];
            $output['telephone'] = $row['telephone'];
        }
        echo json_encode($output);
    }
}
?>
