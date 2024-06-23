<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php
include('includes/db_connexion.php');
$query ="SELECT * FROM depense";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table id="depense" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="20%">Date</th>
		<th width="50%">Motif</th>
		<th width="15%">Montant</th>
		<th width="15%">Action</th>		
	</tr>
</thead><tbody>';

if ($total_row > 0) 
{
	foreach ($result as $row) 
	{
		$output .='
		<tr>
			<td>'.$row["depense_date"].'</td>
			<td>'.$row["motif"].'</td>
			<td>'.number_format($row["montant"], 2, ',', ' ').' CFA</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id_depense"].'">Modifier</button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id_depense"].'">Supprimer</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .='<tr>
		<td colspan="4" align="center">Pas de données</td>
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
    $('#depense').DataTable({
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
