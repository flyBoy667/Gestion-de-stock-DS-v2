<?php 

//Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		// file name
		//echo $filename = $_POST["photo"]["name"];exit;

		// Location
		/*$location = 'upload/'.$filename;

		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);

		// Valid image extensions
		$image_ext = array("jpg","png","jpeg","gif");
		move_uploaded_file($_FILES['file']['tmp_name'],$location);*/

		$query=$connect->prepare('INSERT INTO produit (nom_produit, code_produit, categorie, marque, prix_achat, prix_vente, stock, stock_encours, statut) VALUES(?,?,?,?,?,?,?,?,?)');
        $query->bindValue(1,$_POST['nom']);
        $query->bindValue(2,$_POST['code']);
        $query->bindValue(3,$_POST['categorie']);  
        $query->bindValue(4,$_POST['marque']);
        $query->bindValue(5,$_POST['pa']);
        $query->bindValue(6,$_POST['pv']);   
        $query->bindValue(7,$_POST['stock']);   
        $query->bindValue(8,$_POST['stock']);  
        $query->bindValue(9,$_POST['statut']); 
        $query->execute();
	    echo '<p>Donnée Inserer...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM produit WHERE id_produit = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['nom_produit'] = $row['nom_produit'];
			$output['code_produit'] = $row['code_produit'];
			$output['categorie'] = $row['categorie'];
			$output['marque'] = $row['marque'];
			$output['prix_achat'] = $row['prix_achat'];
			$output['prix_vente'] = $row['prix_vente'];
			$output['stock'] = $row['stock'];
			$output['statut'] = $row['statut'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE produit 
		SET nom_produit = '".$_POST["nom"]."', 
		code_produit = '".$_POST["code"]."',
		categorie = '".$_POST["categorie"]."',
		marque = '".$_POST["marque"]."',
		prix_achat = '".$_POST["pa"]."',
		prix_vente = '".$_POST["pv"]."',
		stock = ".$_POST["stock"].",
		statut = ".$_POST["statut"]."
		WHERE id_produit = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Mise à jour </p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM produit WHERE id_produit = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Supprimer</p>';
	}

	if($_POST["action"] == "fetch_single_detail")
	{
		$query = "
		SELECT p.id_produit, p.code_produit, p.nom_produit, p.categorie, p.marque, p.stock, p.prix_achat, p.prix_vente, p.statut, c.id_categorie, c.categorie, m.id_marque, m.marque FROM produit p, categorie c, marque m WHERE p.categorie = c.id_categorie AND p.marque = m.id_marque AND p.id_produit = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['nom_produit'] = $row['nom_produit'];
			$output['code_produit'] = $row['code_produit'];
			$output['categorie'] = $row['categorie'];
			$output['marque'] = $row['marque'];
			$output['prix_achat'] = $row['prix_achat'];
			$output['prix_vente'] = $row['prix_vente'];
			$output['stock'] = $row['stock'];
			if ($row['statut'] == 1) {
				$output['statut'] = "Actif";
			}elseif ($row['statut'] != 1) {
				$output['statut'] = "Inactif";
			}
		}
		echo json_encode($output);
	}


	if($_POST["action"] == "fetch_single_maj")
	{
		$query = "
		SELECT * FROM produit WHERE id_produit = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['nom_produit'] = $row['nom_produit'];					
			$output['prix_achat'] = $row['prix_achat'];
			$output['prix_vente'] = $row['prix_vente'];			
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "maj")
	{
		$query = "
		UPDATE produit 
		SET nom_produit = '".$_POST["actu_nom"]."',
		prix_achat = '".$_POST["actu_pa"]."',
		prix_vente = '".$_POST["actu_pv"]."'		
		WHERE id_produit = '".$_POST["hidden_id_maj"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Mise à jour </p>';
		/*echo $_POST["actu_pa"];
		echo $_POST["actu_pv"];echo'<br>';
		echo $_POST["hidden_id_maj"];*/
	}

}

?>