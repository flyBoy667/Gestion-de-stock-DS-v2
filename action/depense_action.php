<?php 

//Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query=$connect->prepare('INSERT INTO depense (motif, montant) VALUES(?,?)');
        $query->bindValue(1,$_POST['motif']);
        $query->bindValue(2,$_POST['montant']); 
        $query->execute();
	    echo '<p>Donnée Inserer...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM depense WHERE id_depense = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['motif'] = $row['motif'];
			$output['montant'] = $row['montant'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE depense 
		SET motif = '".$_POST["motif"]."', 
		montant = '".$_POST["montant"]."'		
		WHERE id_depense = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Depense Mise à jour </p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM depense WHERE id_depense = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Depense Supprimer</p>';
	}
}

?>