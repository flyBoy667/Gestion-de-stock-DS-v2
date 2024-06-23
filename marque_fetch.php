<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<?php
include('includes/db_connexion.php');

$query ="SELECT * FROM marque";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$total_row = $statement->rowCount();

$output = '
<table id="mymarque" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th width="">ID</th>
			<th width="60%">marque</th>
			<th width="40%">Action</th>
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
			<td>'.$row["id_marque"].'</td>
			<td>'.$row["marque"].'</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-sm edit_marque" id="'.$row["id_marque"].'"><span class="glyphicon glyphicon-edit" aria-hidden="true"> Modifier</span></button>
			
				<button type="button" name="delete" class="btn btn-danger btn-sm delete_marque" id="'.$row["id_marque"].'"><span class="glyphicon glyphicon-trash">Supprimer</span></button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .='<tr>
		<td colspan="3" align="center">Pas de données</td>
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
    $('#mymarque').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "pageLength" : 7,
    });    
  });
</script>