<?php
$liaison2 = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison2, 'stock_v3');

if (isset($_POST["tampon"]) && $_POST["tampon"] == "recup") {
    $requete = "SELECT * FROM produit WHERE id_produit = '" . $_POST["ref_produit"] . "';";
    $retours = mysqli_query($liaison2, $requete);
    $retour = mysqli_fetch_array($retours);
    $chaine = $retour["nom_produit"] . "|" . $retour["stock_encours"];
    print($chaine);
} else {
    $requete = "UPDATE produit SET stock_encours = stock_encours + " . $_POST['qte_produit'] . " WHERE id_produit = '" . $_POST["ref_produit"] . "';";
    $retours = mysqli_query($liaison2, $requete);
    if ($retours == 1) {
        print("ok");
        //Requête des entrées de stock
        /*$req= "INSERT INTO entree (ref_produit, quantite) VALUES('".$_POST["ref_produit"]."',".$_POST['qte_produit'].")";
        $reponse =  mysqli_query($liaison2, $req);*/
    } else
        print("nok");
}

mysqli_close($liaison2);