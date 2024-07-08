<?php
session_start();
include('includes/db_connexion.php');

if (!isset($_SESSION['user_id'])) {
    // Redirection si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php
$admin_query = "SELECT
    t.id_transaction,
    t.num_facture,
    t.client_fournisseur,
    t.montant,
    t.montant_paye,
    t.type,
    t.transaction_date,
    t.restant,
    c.IdClient,
    c.Nom,
    c.Prenom,
    u.nom as ajoute_par_nom,
    u.prenom as ajoute_par_prenom
FROM
    transaction t
        JOIN
    clients c ON t.client_fournisseur = c.IdClient
        JOIN
    users u ON u.id_personnel = t.ajouter_par
WHERE
    t.type = 1 AND t.restant > 0";

$caissier_query = "SELECT 
                        t.id_transaction, 
                        t.num_facture, 
                        t.client_fournisseur, 
                        t.montant, 
                        t.montant_paye, 
                        t.type, 
                        t.transaction_date, 
                        c.IdClient, 
                        c.Nom, 
                        c.Prenom, 
                        u.nom as ajoute_par_nom, 
                        u.prenom as ajoute_par_prenom 
                    FROM 
                        transaction t
                    JOIN 
                        clients c ON t.client_fournisseur = c.IdClient 
                    JOIN 
                        users u ON u.id_personnel = t.ajouter_par 
                    WHERE 
                        t.type = 1 AND t.ajouter_par = :user_id";

$statement = $connect->prepare($admin_query);
$statement->execute();
$admin_result = $statement->fetchAll();

$caissier_statement = $connect->prepare($caissier_query);
$caissier_statement->execute([':user_id' => $user_id]);
$caissier_result = $caissier_statement->fetchAll();

if ($_SESSION['role'] >= 5) {
    $final_result = $admin_result;
} else {
    $final_result = $caissier_result;
}

$output = '
<table id="sales" class="table table-bordered table-hover">
<thead>
    <tr>
        <th width="10%">Date</th>
        <th width="10%">N°Facture</th>
        <th width="10%">Nom / Prenom</th>
        <th width="10%">Total Net</th>        
        <th width="10%">Payé</th>
        <th width="10%">Ajouté par</th>
        <th width="8%">Restant</th>
        <th width="20%">Action</th>        
    </tr>
</thead>
<tbody>';

if (count($final_result) > 0) {
    foreach ($final_result as $row) {
        $output .= '
        <tr>
            <td>' . $row["transaction_date"] . '</td>
            <td>' . $row["num_facture"] . '</td>
            <td>' . $row["Nom"] . " " . $row["Prenom"] . '</td>
            <td>' . number_format($row["montant"], 2, ',', ' ') . " CFA" . '</td>
            <td>' . number_format($row["montant_paye"], 2, ',', ' ') . " CFA" . '</td>
            <td>' . $row["ajoute_par_prenom"] . " " . $row["ajoute_par_nom"] . '</td>
            <td>' . $row["restant"] . '</td>
            <td>
                <a type="button" name="detail" class="btn btn-primary btn-xs detail" href="detail_facture.php?id=' . $row["num_facture"] . '"><i class="nav-icon fas fa-eye" aria-hidden="true"> Detail</i></a>
                <a type="button" name="ticket" class="btn btn-primary btn-xs detail" href="ticket.php?id=' . $row["num_facture"] . '""><i class="nav-icon fas fa-file" aria-hidden="true"> Facture</i></a>';
        if ($_SESSION["role"] >= 5) {
            $output .= ' <button type="button" name="delete" class="btn btn-primary btn-xs update" id="' . $row["id_transaction"] . '"><i class="nav-icon fas fa-sync">Mettre à jour</i></button>';
            $output .= ' <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id_transaction"] . '"><i class="nav-icon fas fa-trash"> Supprimer</i></button>';
        }
        $output .= '
            </td>
        </tr>';
    }
} else {
    $output .= '<tr>
        <td colspan="7" align="center">Pas de données</td>
    </tr>';
}

$output .= '</tbody></table>';

echo $output;
?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function () {
        $('#sales').DataTable({
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
