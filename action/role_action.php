<?php 

//Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query=$connect->prepare('INSERT INTO system_group (name, description) VALUES(?,?)');
        $query->bindValue(1,$_POST['name']);
        $query->bindValue(2,$_POST['description']);      
        $query->execute();
	    echo '<p>Groupe Inserer avec succès...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM system_group WHERE id_group = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['name'] = $row['name'];
			$output['description'] = $row['description'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE system_group 
		SET name = '".$_POST["name"]."', 
		description = '".$_POST["description"]."'
		WHERE id_group = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Mise à jour </p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM system_group WHERE id_group = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Supprimer</p>';
	}
}

?>