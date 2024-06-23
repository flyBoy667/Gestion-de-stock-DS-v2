<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<?php
//Tableau utilisateur
include('includes/db_connexion.php');
$query ="SELECT t.id_transaction, t.num_facture, t.client_fournisseur, t.montant, t.montant_paye, t.type, t.transaction_date, f.ref_fournisseur, f.societe FROM transaction t, fournisseur f WHERE t.type = 2 AND t.client_fournisseur = f.ref_fournisseur";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$total_row = $statement->rowCount();


$output = '
<table id="order" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="10%">Date</th>
		<th width="20%">N°Facture</th>
		<th width="20%">Societé</th>
		<th width="15%">Total Net</th>		
		<!--<th width="20%">Remarque</th>-->
		<th width="15%">Payé</th>
		<th width="20%">Action</th>		
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
			<td>'.$row["transaction_date"].'</td>
			<td>'.$row["num_facture"].'</td>
			<td>'.$row["societe"].'</td>
			<td>'.number_format($row["montant"], 2, ',', ' ')." CFA".'</td>
			<td>'.number_format($row["montant_paye"], 2, ',', ' ')." CFA".'</td>
			<td>
				<a type="button" name="detail" class="btn btn-primary btn-xs detail" href="detail_facture_achat.php?id='.$row["num_facture"].'"><i class="nav-icon fas fa-eye" aria-hidden="true"> Detail</i></a>
				<button type="button" name="detail" class="btn btn-primary btn-xs detail" id="'.$row["id_transaction"].'"><i class="nav-icon fas fa-file" aria-hidden="true"> Facture</i></button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id_transaction"].'"><i class="nav-icon fas fa-trash">Supprimer</i></button>
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

/*$output .='<table width="50%" border="1">
			<tr>
				<th width="50%" align="right">Total</th>
				<td></td>
			</tr>
			<tr>
				<th width="50%" align="right">Total Net</th>
				<td></td>
			</tr>
			<tr>
				<th width="50%" align="right">Prix de revient total</th>
				<td></td>
			</tr>
		</table>';*/
echo $output;
?>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#order').DataTable({
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
