<?php
$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');

if (isset($_POST["param"])) {
    switch ($_POST["param"]) {
        case "recup_fournisseur":
            $requete = "SELECT * FROM fournisseur WHERE ref_fournisseur = " . $_POST["ref_fournisseur"] . ";";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);
            $chaine = $retour["nom_fournisseur"] . "|" . $retour["prenom_fournisseur"] . "|" . $retour["societe"];
            print($chaine);
            break;

        case "recup_article":
            $requete = "SELECT * FROM produit WHERE id_produit = '" . $_POST["ref_produit"] . "';";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);
            $chaine = $retour["nom_produit"] . "|" . $retour["prix_vente"] . "|" . $retour["stock_encours"];
            print($chaine);
            break;

        case "creer_fournisseur":
            $requete = "SELECT COUNT(ref_fournisseur) AS nb FROM fournisseur WHERE nom_fournisseur='" . $_POST["nom_fournisseur"] . "' AND prenom_fournisseur='" . $_POST["prenom_fournisseur"] . "';";
            $retours = mysqli_query($liaison, $requete);
            $retour = mysqli_fetch_array($retours);
            if ($retour["nb"] > 0)
                print("nok");
            else {
                $requete = "INSERT INTO fournisseur(nom_fournisseur, prenom_fournisseur, societe) VALUES ('" . $_POST["nom_fournisseur"] . "', '" . $_POST["prenom_fournisseur"] . "', '" . $_POST["societe"] . "');";
                $retours = mysqli_query($liaison, $requete);
                if ($retours == 1)
                    print(mysqli_insert_id($liaison));
            }
            break;
        case "facturer":
            if ($_POST["paye"] != 0) {
                $requete = "SELECT Com_num FROM commandes ORDER BY Com_num DESC LIMIT 1;";
                $retours = mysqli_query($liaison, $requete);
                $retour = mysqli_fetch_array($retours);
                $derniere_com = $retour['Com_num'] + 1;
                $com_client = $_POST["ref_fournisseur"];
                $com_date = date('d/m/Y');
                $transaction_date = date('Y-m-d');
                $com_montant = $_POST["total_com"];
                $montant_paye = $_POST["paye"];
                $remise = $_POST["remise"];
                $facture_number = $com_date . "/A-00" . $derniere_com;
                $type = 2;

                $texte_com = $_POST["chaine_com"];
                $tab_com = explode('|', $texte_com);

                if ($remise > $montant_paye) {
                    print("remise_error");
                    return;
                }

                $requete = "INSERT INTO commandes(Com_client, Com_date, Com_montant, facture_number, Com_remise, montant_paye) VALUES (" . $com_client . ", '" . $com_date . "', " . $com_montant . ", '" . $facture_number . "'," . $remise . "," . $montant_paye . ");";
                $retours = mysqli_query($liaison, $requete);

                $transaction = "INSERT INTO transaction(num_facture, client_fournisseur, montant, remise, montant_paye, type, transaction_date) VALUES ('" . $facture_number . "'," . $com_client . ", " . $com_montant . ", " . $remise . ", " . $montant_paye . "," . $type . ", '" . $transaction_date . "');";
                $transa = mysqli_query($liaison, $transaction);
                if ($retours == 1) {
                    $detail_com = mysqli_insert_id($liaison);
                    for ($ligne = 0; $ligne < sizeof($tab_com); $ligne++) {
                        if ($tab_com[$ligne] != "") {
                            $ligne_com = explode(';', $tab_com[$ligne]);
                            $requete = "INSERT INTO detail(Detail_com, Detail_ref, Detail_qte, type,date_commande) VALUES ('" . $facture_number . "', '" . $ligne_com[0] . "', " . $ligne_com[1] . ",2, '" . $transaction_date . "');";
                            $retours = mysqli_query($liaison, $requete);
                            $requete = "UPDATE produit SET stock_encours=stock_encours+" . $ligne_com[1] . " WHERE id_produit='" . $ligne_com[0] . "';";
                            $retours = mysqli_query($liaison, $requete);

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
?>