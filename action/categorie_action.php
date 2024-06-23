<?php 
//Traitement des informations
include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query=$connect->prepare('INSERT INTO categorie (categorie) VALUES(?)');
        $query->bindValue(1,$_POST['categorie']);      
        $query->execute();
	    echo '<p>Categorie ajouter avec success...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM categorie WHERE id_categorie = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['categorie'] = $row['categorie'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE categorie 
		SET categorie = '".$_POST["categorie"]."'
		WHERE id_categorie = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Categorie Mise à jour avec success</p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM categorie WHERE id_categorie = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Categorie Supprimer avec success</p>';
	}
}

?>