<?php

//Traitement des informations
session_start();
include('../includes/db_connexion.php');
include('../includes/config.php');

if (isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {

        // Validate username
        if (empty(trim($_POST["login"]))) {
            $username_err = "Please enter a username.";
        } else {
            // Prepare a select statement
            $sql = "SELECT id_personnel FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["login"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        echo $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["login"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }


        // Validate password
        if (empty(trim($_POST["password"]))) {
            echo "Please enter a password.";
            return;
        } else {
            $password = trim($_POST["password"]);
        }
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            echo "Please confirm password.";
            return;
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                echo "Password did not match.";
                return;
            }
        }

        // Check input errors before inserting in database
        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

            // Prepare an insert statement
            $sql = "INSERT INTO users (username, password, role, nom, prenom, email, ajouter_par) VALUES (?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_password, $role, $nom, $prenom, $email, $user_id);

                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $role = $_POST['role'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $user_id = $_SESSION['user_id'];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    //header("location: login.php");
                    echo "Utilisateur ajouter avec success";
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        /*$query=$connect->prepare('INSERT INTO system_users (nom, prenom, login, role) VALUES(?,?,?,?)');
        $query->bindValue(1,$_POST['nom']);
        $query->bindValue(2,$_POST['prenom']);
        $query->bindValue(3,$_POST['login']);
        $query->bindValue(4,$_POST['role']);
        $query->execute();
        echo '<p>Donnée Inserer...</p>';*/
    }
    if ($_POST["action"] == "fetch_single") {
        $query = "
		SELECT * FROM users WHERE id_personnel = '" . $_POST["id"] . "'
		";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['login'] = $row['username'];
            $output['password'] = $row['password'];
            $output['role'] = $row['role'];
            $output['nom'] = $row['nom'];
            $output['prenom'] = $row['prenom'];
            $output['email'] = $row['email'];
        }
        echo json_encode($output);
    }
    if ($_POST["action"] == "update") {
        $param_password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Creates a password hash
        $query = "
		UPDATE users 
		SET username = '" . $_POST["login"] . "',
		password = '" . $param_password . "',
		role = " . $_POST["role"] . ",
		nom = '" . $_POST["nom"] . "', 
		prenom = '" . $_POST["prenom"] . "',
		email = '" . $_POST["email"] . "'		  
		WHERE id_personnel = '" . $_POST["hidden_id"] . "'
		";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Donnée Mise à jour </p>';
    }

    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM users WHERE id_personnel = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo '<p>Donnée Supprimer</p>';
    }
}
