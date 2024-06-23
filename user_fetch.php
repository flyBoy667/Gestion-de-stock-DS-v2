<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<?php
//Tableau utilisateur
include('includes/db_connexion.php');

$query ="SELECT * FROM users";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$total_row = $statement->rowCount();

$output = '
<table id="user" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="20%">Nom</th>
		<th width="20%">Prenom</th>
		<th width="20%">Login</th>
		<th width="10%">Rôle</th>
		<th width="25%">Action</th>		
	</tr>
</thead>
<tbody>	
';

if ($total_row > 0) 
{
	foreach ($result as $row) 
	{
		$output .='
		<tr>
			<td>'.$row["nom"].'</td>
			<td>'.$row["prenom"].'</td>
			<td>'.$row["username"].'</td>
			<td>'.$row["role"].'</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row["id_personnel"].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"> Modifier</span></button>
				<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row["id_personnel"].'"><span class="glyphicon glyphicon-trash">Supprimer</span></button>
			</td>			
		</tr>
		';
	}
}
else
{
	$output .='<tr>
		<td colspan="6" align="center">Pas de données</td>
	</tr>
	';
}
$output .='</tbody></table>';
echo $output;
?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#user').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });    
  });
</script>
