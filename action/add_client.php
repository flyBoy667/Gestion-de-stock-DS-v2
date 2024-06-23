<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=stock_v3;charset=utf8', 'fly', 'root');
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_civilite = $_POST['client_civilite'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $tel = $_POST['tel'];

    if (!empty($name) && !empty($email)) {
        $stmt = $pdo->prepare('INSERT INTO clients (client_civilite, nom, prenom, adresse, tel) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->execute([$client_civilite, $nom, $prenom, $adresse, $tel]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion dans la base de données']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
