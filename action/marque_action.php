<?php 
//Traitement des informations
include('../includes/db_connexion.php');

if (isset($_POST["action_marque"]))
{
	if($_POST["action_marque"] == "insert_marque")
	{
		$query=$connect->prepare('INSERT INTO marque (marque) VALUES(?)');
        $query->bindValue(1,$_POST['marque']);      
        $query->execute();
	    echo '<p>marque ajouter avec success...</p>';
	}
	if($_POST["action_marque"] == "fetch_marque")
	{
		$query = "
		SELECT * FROM marque WHERE id_marque = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['marque'] = $row['marque'];
		}
		echo json_encode($output);
	}
	if($_POST["action_marque"] == "update_marque")
	{
		$query = "
		UPDATE marque 
		SET marque = '".$_POST["marque"]."'
		WHERE id_marque = '".$_POST["hidden_id_marque"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>marque Mise à jour avec success</p>';
	}

	if($_POST["action_marque"] == "delete")
	{
		$query = "DELETE FROM marque WHERE id_marque = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>marque Supprimer avec success</p>';
	}
}

?>