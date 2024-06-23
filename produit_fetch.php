<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php
include('includes/db_connexion.php');
$query ="SELECT p.id_produit, p.code_produit, p.nom_produit, p.categorie, p.marque, p.stock, p.stock_encours, c.id_categorie, c.categorie, m.id_marque, m.marque FROM produit p, categorie c, marque m WHERE p.categorie = c.id_categorie AND p.marque = m.id_marque";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table id="produit" class="table table-bordered table-hover">
<thead>
	<tr>
		<th width="5%">#</th>
		<th width="55%">Nom produit</th>
		<th width="10%">En stock</th>
		<th width="30%">Action</th>		
	</tr>
</thead><tbody>';

if ($total_row > 0) 
{
	foreach ($result as $row) 
	{
		$stock_encour = 0 + $row['stock_encours'];
		$output .='
		<tr>
			<td>'.$row["code_produit"].'</td>
			<td>'.$row["nom_produit"].'</td>
			<td>'.$stock_encour.'</td>
			<td>
				<a type="button" name="detail" class="btn btn-primary btn-xs" href="produit_detail.php?id='.$row["id_produit"].'"><i class="nav-icon fas fa-eye" aria-hidden="true">Detail</i></a>
				<button type="button" name="actu_prix" class="btn btn-primary btn-xs actu_prix" id="'.$row["id_produit"].'">Actualiser prix</button>
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id_produit"].'">Modifier</button>
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id_produit"].'">Supprimer</button>
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
