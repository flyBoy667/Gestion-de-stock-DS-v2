<?php
session_start();
require_once('includes/db_connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $connect->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id_personnel'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];

        if ($user['role'] >= 5) {
            header("Location: dashboard.php");
        } else {
            header("Location: vente.php");
        }
        exit();
    } else {
        header("Location: index.php?error=true");
    }
} else {
    header("Location: index.php");
    exit();
}

