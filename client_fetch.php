<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php
include('includes/db_connexion.php');
$query ="SELECT * FROM clients";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table id="produit" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="5%">#</th>
		<th width="5%">Civilite</th>
		<th width="20%">Nom</th>
		<th width="20%">Prenom</th>		
		<th width="20%">Adresse</th>		
		<th width="20%">Tel</th>	
		<th width="20%">Action</th>			
	</tr>
</thead><tbody>';

if ($total_row > 0)
{
    foreach ($result as $row)
    {
        $stock_encour = 0 + $row['stock_encours'];
        $output .='
		<tr>
			<td>'.$row["IdClient"].'</td>
			<td>'.$row["Client_civilite"].'</td>
			<td>'.$row["Nom"].'</td>
			<td>'.$row["Prenom"].'</td>
			<td>'.$row["Adresse"].'</td>
			<td>'.$row["Tel"].'</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["IdClient"].'">Modifier</button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["IdClient"].'">Supprimer</button>
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
        $('#produit').DataTable({
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
