<?php
session_start();
$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');

if (!$liaison) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["param"])) {
    switch ($_POST["param"]) {
        case "recup_client":
            $requete = "SELECT * FROM clients WHERE IdClient = " . $_POST["ref_client"] . ";";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);
            $chaine = $retour["Client_civilite"] . "|" . $retour["Nom"] . "|" . $retour["Prenom"];
            print($chaine);
            break;

        case "recup_article":
            $requete = "SELECT * FROM produit WHERE id_produit = '" . $_POST["ref_produit"] . "';";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);
            $chaine = $retour["nom_produit"] . "|" . $retour["prix_vente"] . "|" . $retour["stock_encours"] . "|" . $retour["id_produit"];
            print($chaine);
            break;

        case "creer_client":
            // Verifie si le client est deja present dans la base de donnees
            $nom_client = mysqli_real_escape_string($liaison, $_POST["nom_client"]);
            $prenom_client = mysqli_real_escape_string($liaison, $_POST["prenom_client"]);
            $civilite = mysqli_real_escape_string($liaison, $_POST["civilite"]);

            $requete = "SELECT COUNT(IdClient) AS nb FROM clients WHERE Nom='$nom_client' AND Prenom='$prenom_client';";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);

            if ($retour["nb"] > 0) {
                print("nok");
                return;
            } elseif (empty($_POST["Tel"]) || empty($_POST["Adresse"]) || empty($prenom_client) || empty($nom_client) || empty($civilite)) {
                //recuperation des informations supplementaires
                print("info");
                return;

            } else {

                $tel = mysqli_real_escape_string($liaison, $_POST["Tel"]);
                $adresse = mysqli_real_escape_string($liaison, $_POST["Adresse"]);

                $requete = "INSERT INTO clients(Client_civilite, Nom, Prenom, Tel, Adresse) VALUES ('$civilite', '$nom_client', '$prenom_client', '$tel', '$adresse')";
                $retours = mysqli_query($liaison, $requete);
                if ($retours == 1) {
                    $last_id = mysqli_insert_id($liaison);

                    // Récupérer les informations supplémentaires
                    $query = "SELECT Nom, Prenom FROM clients WHERE IdClient = ?";
                    $stmt = mysqli_prepare($liaison, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $last_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $nom, $prenom);
                    mysqli_stmt_fetch($stmt);

                    $chaine = $last_id . "|" . $prenom . "|" . $nom;
                    print($chaine);

                    mysqli_stmt_close($stmt);
                }
            }
            break;
        case
        "facturer":
            if ($_POST["paye"] != 0) {
                $requete = "SELECT Com_num FROM commandes ORDER BY Com_num DESC LIMIT 1;";
                $retours = mysqli_query($liaison, $requete);
                $retour = mysqli_fetch_array($retours);
                $derniere_com = $retour['Com_num'] + 1;
                $com_client = $_POST["ref_client"];
                $com_date = date('d/m/Y');
                $transaction_date = date('Y-m-d');
                $com_montant = $_POST["total_com"];
                $montant_paye = $_POST["paye"];
                $remise = $_POST["remise"];
                $facture_number = $com_date . "/S-00" . $derniere_com;
                $type = 1;
                // les restes de la commandes
                $restant = 0;
                $texte_com = $_POST["chaine_com"];
                $tab_com = explode('|', $texte_com);
                //Appliquation de la remise
                if ($remise > $com_montant) {
                    print("remise_error");
                    return;
                }
                $com_montant = $com_montant - $remise;

                if ($com_montant > $montant_paye) {
                    $restant = $com_montant - $montant_paye;
                }

                if ($montant_paye === "" || $montant_paye > $com_montant) {
                    print("somme_error");
                    return;
                }

                $requete = "INSERT INTO commandes(Com_client, Com_date, Com_montant, facture_number, Com_remise, montant_paye, Ajouter_pat) VALUES (" . $com_client . ", '" . $com_date . "', " . $com_montant . ", '" . $facture_number . "'," . $remise . "," . $montant_paye . ", " . $_SESSION['user_id'] . ");";
                $retours = mysqli_query($liaison, $requete);

                $transaction = "INSERT INTO transaction(num_facture, client_fournisseur, montant, remise, montant_paye, type, transaction_date, restant, ajouter_par) VALUES ('"
                    . $facture_number . "', "
                    . $com_client . ", "
                    . $com_montant . ", "
                    . $remise . ", "
                    . $montant_paye . ", "
                    . $type . ", '"
                    . $transaction_date . "', "
                    . $restant . ", "
                    . $_SESSION['user_id'] . ");";

                $transa = mysqli_query($liaison, $transaction);
                if ($retours == 1) {
                    $detail_com = mysqli_insert_id($liaison);
                    for ($ligne = 0; $ligne < sizeof($tab_com); $ligne++) {
                        if ($tab_com[$ligne] != "") {
                            $ligne_com = explode(';', $tab_com[$ligne]);
                            $requete = "INSERT INTO detail(Detail_com, Detail_ref, Detail_qte, type,date_commande) VALUES ('" . $facture_number . "', '" . $ligne_com[0] . "', " . $ligne_com[1] . ",1, '" . $transaction_date . "');";
                            $retours = mysqli_query($liaison, $requete);
                            $requete = "UPDATE produit SET stock_encours=stock_encours-" . $ligne_com[1] . " WHERE id_produit='" . $ligne_com[0] . "';";
                            $retours = mysqli_query($liaison, $requete);
                            //Requête des sortie de stock
                            /*$req= "INSERT INTO sortie (ref_produit, quantite) VALUES('".$ligne_com[0]."',".$ligne_com[1].")";
                            $reponse =  mysqli_query($liaison, $req);*/

                        }
                    }
                    $last_transac_query = "SELECT * FROM transaction ORDER BY id_transaction DESC LIMIT 1;";
                    $last_transac = mysqli_query($liaison, $last_transac_query);
                    $last_transac = mysqli_fetch_array($last_transac);
                    print($last_transac["num_facture"]);
                } else
                    print("nok");

                break;
            }
    }
}

mysqli_close($liaison);