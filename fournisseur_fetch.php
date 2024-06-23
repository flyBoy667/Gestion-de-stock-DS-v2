<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php
include('includes/db_connexion.php');
$query = "SELECT * FROM fournisseur";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table id="fournisseur" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="5%">#</th>
		<th width="10%">Nom</th>
		<th width="10%">Prénom</th>
		<th width="20%">Société</th>
		<th width="15%">Adresse</th>
		<th width="10%">Téléphone</th>
		<th width="15%">Action</th>
	</tr>
</thead><tbody>';

if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
		<tr>
			<td>' . $row["ref_fournisseur"] . '</td>
			<td>' . $row["nom_fournisseur"] . '</td>
			<td>' . $row["prenom_fournisseur"] . '</td>
			<td>' . $row["societe"] . '</td>
			<td>' . $row["adresse"] . '</td>
			<td>' . $row["telephone"] . '</td>
			<td>
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="' . $row["ref_fournisseur"] . '">Modifier</button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["ref_fournisseur"] . '">Supprimer</button>
			</td>
		</tr>
		';
    }
} else {
    $output .= '<tr>
		<td colspan="7" align="center">Pas de données</td>
	</tr>
	';
}

$output .= '</tbody></table>';

echo $output;
?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $('#fournisseur').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 7,
        });
    });
</script>
