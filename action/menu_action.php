<?php 

//Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query=$connect->prepare('INSERT INTO system_menu (name, link) VALUES(?,?)');
        $query->bindValue(1,$_POST['menu']);
        $query->bindValue(2,$_POST['link']);      
        $query->execute();
	    echo '<p>Menu Inserer avec succès...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM system_menu WHERE id = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['name'] = $row['name'];
			$output['link'] = $row['link'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE system_menu 
		SET name = '".$_POST["menu"]."', 
		link = '".$_POST["link"]."'
		WHERE id = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Mise à jour </p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM system_menu WHERE id = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Supprimer</p>';
	}
}

?>