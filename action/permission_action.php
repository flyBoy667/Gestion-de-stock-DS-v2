<?php 

//Traitement des informations

include('../includes/db_connexion.php');

if (isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query=$connect->prepare('INSERT INTO system_privileges (id_group, id_menu, access) VALUES(?,?,?)');
        $query->bindValue(1,$_POST['role']);
        $query->bindValue(2,$_POST['menu']);
        $query->bindValue(3,$_POST['permission']);    
        $query->execute();
	    echo '<p>Donnée Inserer...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM system_privileges WHERE id_privilege = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['id_group'] = $row['id_group'];
			$output['id_menu'] = $row['id_menu'];
			$output['access'] = $row['access'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE system_privileges 
		SET id_group = '".$_POST["role"]."', 
		id_menu = '".$_POST["menu"]."',
		access = '".$_POST["permission"]."'
		WHERE id_privilege = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Mise à jour </p>';
	}

	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM system_privileges WHERE id_privilege = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Donnée Supprimer</p>';
	}
}

?>