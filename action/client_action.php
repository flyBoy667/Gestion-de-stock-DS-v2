<?php

// Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $query = $connect->prepare('INSERT INTO clients (Client_civilite, Nom, Prenom, Adresse, Tel) VALUES(?, ?, ?, ?, ?)');
        $query->bindValue(1, $_POST['civilite']);
        $query->bindValue(2, $_POST['nom']);
        $query->bindValue(3, $_POST['prenom']);
        $query->bindValue(4, $_POST['adresse']);
        $query->bindValue(5, $_POST['tel']);
        $query->execute();
        echo '<p>Donnée Insérée...</p>';
    }

    if ($_POST["action"] == "fetch_single") {
        $query = "
    SELECT * FROM clients WHERE IdClient = :id
    ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['civilite'] = $row['Client_civilite'];
            $output['nom'] = $row['Nom'];
            $output['prenom'] = $row['Prenom'];
            $output['adresse'] = $row['Adresse'];
            $output['tel'] = $row['Tel'];
        }
        echo json_encode($output);
    }

    if ($_POST["action"] == "update") {
        $query = "
        UPDATE clients 
        SET Client_civilite = :civilite, 
            Nom = :nom, 
            Prenom = :prenom, 
            Adresse = :adresse, 
            Tel = :tel
        WHERE IdClient = :hidden_id
        ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':civilite', $_POST['civilite']);
        $statement->bindValue(':nom', $_POST['nom']);
        $statement->bindValue(':prenom', $_POST['prenom']);
        $statement->bindValue(':adresse', $_POST['adresse']);
        $statement->bindValue(':tel', $_POST['tel']);
        $statement->bindValue(':hidden_id', $_POST['hidden_id'], PDO::PARAM_INT);
        $statement->execute();
        echo '<p>Donnée Mise à jour</p>';
    }

    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM clients WHERE IdClient = :id";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $statement->execute();
        echo '<p>Donnée Supprimée</p>';
    }

    if ($_POST["action"] == "fetch_single_detail") {
        $query = "
        SELECT * FROM clients WHERE IdClient = :id
        ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['Client_civilite'] = $row['Client_civilite'];
            $output['Nom'] = $row['Nom'];
            $output['Prenom'] = $row['Prenom'];
            $output['Adresse'] = $row['Adresse'];
            $output['Tel'] = $row['Tel'];
        }
        echo json_encode($output);
    }

    if ($_POST["action"] == "fetch_single_maj") {
        $query = "
        SELECT * FROM clients WHERE IdClient = :id
        ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['Client_civilite'] = $row['Client_civilite'];
            $output['Nom'] = $row['Nom'];
            $output['Prenom'] = $row['Prenom'];
        }
        echo json_encode($output);
    }

    if ($_POST["action"] == "maj") {
        $query = "
        UPDATE clients 
        SET Client_civilite = :civilite, 
            Nom = :nom, 
            Prenom = :prenom
        WHERE IdClient = :hidden_id_maj
        ";
        $statement = $connect->prepare($query);
        $statement->bindValue(':civilite', $_POST['civilite']);
        $statement->bindValue(':nom', $_POST['nom']);
        $statement->bindValue(':prenom', $_POST['prenom']);
        $statement->bindValue(':hidden_id_maj', $_POST['hidden_id_maj'], PDO::PARAM_INT);
        $statement->execute();
        echo '<p>Donnée Mise à jour</p>';
    }
}
?>
