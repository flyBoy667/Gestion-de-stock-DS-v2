<?php include ('includes/header.php');

$id = $_GET['id'];//echo $id;
include('includes/db_connexion.php');
//$query ='SELECT * FROM  produit WHERE id_produit='.$id;
$query ='SELECT p.id_produit, p.code_produit, p.nom_produit, p.categorie, p.marque,p.prix_achat, p.prix_vente, p.stock,p.stock_encours, p.statut, p.created_at, c.id_categorie, c.categorie, m.id_marque, m.marque FROM produit p, categorie c, marque m WHERE p.categorie = c.id_categorie AND p.marque = m.id_marque AND id_produit='.$id;
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();   

$query_vente ="SELECT `Detail_ref`,SUM(`Detail_qte`) AS q_vendue,`type` FROM detail WHERE type=1 AND Detail_ref='".$id."' GROUP BY Detail_ref";
$statement_vente = $connect->prepare($query_vente);
$statement_vente->execute();
$result_vente = $statement_vente->fetchAll(PDO::FETCH_OBJ);

$quantite_vendue = 0;
foreach ($result_vente as $row_vente) 
  {
    $quantite_vendue = $row_vente->q_vendue;
  }

 // echo($sum_achat);exit;

 $query_achat="SELECT `Detail_ref`,SUM(`Detail_qte`) AS q_achete,`type` FROM detail WHERE type=2 AND Detail_ref='".$id."' GROUP BY Detail_ref";
$statement_achat = $connect->prepare($query_achat);
$statement_achat->execute();
$result_achat = $statement_achat->fetchAll(PDO::FETCH_OBJ);

$quantite_achete = 0;
foreach ($result_achat as $row_achat) 
  {
    $quantite_achete = $row_achat->q_achete;
  } 

//total des achats
$total_achat ='SELECT f.ref_fournisseur, f.societe, d.Detail_com, d.Detail_ref, d.Detail_qte, d.type, t.num_facture,t.client_fournisseur, t.transaction_date FROM fournisseur f, detail d, transaction t WHERE d.Detail_com = t.num_facture AND f.ref_fournisseur = t.client_fournisseur AND d.type=2 AND  d.Detail_ref='.$id;
$achat_statement = $connect->prepare($total_achat);
$achat_statement->execute();
$result_total_achat = $achat_statement->fetchAll();
$total_row_achat = $achat_statement->rowCount();  

//total des ventes
$total_vente ='SELECT c.IdClient, c.Nom, c.Prenom, d.Detail_com, d.Detail_ref, d.Detail_qte, d.type, t.num_facture,t.client_fournisseur, t.transaction_date FROM clients c, detail d, transaction t WHERE d.Detail_com = t.num_facture AND c.IdClient = t.client_fournisseur AND d.type=1 AND  d.Detail_ref='.$id;
$vente_statement = $connect->prepare($total_vente);
$vente_statement->execute();
$result_total_vente = $vente_statement->fetchAll();
$total_row_vente = $vente_statement->rowCount();  
?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

          <div class="col-md-3">

            <?php if ($total_row > 0){ foreach ($result as $row){  /*$stock_encour = $row["stock"] + $row['stock_encours'];*/?>

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="dist/img/produit.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['nom_produit']?></h3>

                <p class="text-muted text-center"><?php echo $row['categorie']?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Ajouter le</b> <a class="float-right"><?php echo $row['created_at']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Statut</b> <a class="float-right"><?php if($row['statut']==1) echo "Actif"; else echo "Inactif"?></a>
                  </li>                  
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#detail" data-toggle="tab">Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Historique des achat</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Historique des ventes</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <div class="active tab-pane" id="detail">                   
                    <div class="col-md-9">
                      <div class="card card-warning" style="box-shadow: none!important;">
                            <!-- /.card-header -->
                            <div class="card-body">
                              <!-- input states -->
                              <div class="form-group">
                                  <label class="col-form-label"> Code produit</label>
                                  <input type="text" class="form-control" value="<?php echo $row['code_produit']?>" readonly="">
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label">Benefice</label>
                                  <input type="text" class="form-control" value="<?php echo $row['prix_vente'] - $row['prix_achat']."  FCFA"?>" readonly="">
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label class="col-form-label">Prix d'achat</label>
                                          <input type="text" name="" class="form-control" value="<?php echo $row['prix_achat']." "?>FCFA" readonly="">
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label class="col-form-label">Prix de vente</label>
                                          <input type="text" name="" class="form-control" value="<?php echo $row['prix_vente']." "?>FCFA" readonly="">
                                      </div>
                                  </div>
                              </div>              
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-warning">
                          <table class="table table-striped">              
                          <tbody>
                           <!-- <tr>
                              <th>Stock a l'ouverture</th>
                              <td><?php echo $row['stock']?></td>
                            </tr>-->
                            <tr>
                              <th>Total des achat(+)</th>
                              <td><?php echo $quantite_achete;?></td>
                            </tr>
                            <tr>
                              <th>Total des ventes(-)</th>
                              <td><?php echo $quantite_vendue;?></td>
                            </tr>
                            <tr style="background: yellow;">
                              <th>En stock</th>
                              <td><?php echo $row['stock_encours']?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>  
                  </div>
                <?php }}?>   
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <table id="achat_total" class="table table-bordered table-hover">
                      <thead>
                        <tr style="background-color: #007bff; color: #FFF;">
                          <th width="30%">Date</th>
                          <th width="50%">Fournisseur</th>
                          <th width="10%">Quantite</th>   
                        </tr>
                      </thead>
                      <tbody>
                         <?php if ($total_row_achat > 0){ foreach ($result_total_achat as $row_total_achat){ ?>
                            <tr>
                             <td><?php echo $row_total_achat["transaction_date"]?></td>
                             <td><?php echo $row_total_achat["societe"]?></td>
                             <td><?php echo $row_total_achat["Detail_qte"]?></td>
                            </tr> 
                         <?php }}?> 
                      </tbody>
                    </table>

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <table id="vente_total" class="table table-bordered table-hover">
                      <thead>
                        <tr style="background-color: #007bff; color: #FFF;">
                          <th width="30%">Date</th>
                          <th width="50%">Client</th>
                          <th width="10%">Quantite</th>   
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($total_row_vente > 0){ foreach ($result_total_vente as $row_total_vente){ ?>
                            <tr>
                             <td><?php echo $row_total_vente["transaction_date"]?></td>
                             <td><?php echo $row_total_vente["Nom"]." ". $row_total_vente["Prenom"]?></td>
                             <td><?php echo $row_total_vente["Detail_qte"]?></td>
                            </tr> 
                         <?php }}?> 
                      </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
          <script src="plugins/jquery/jquery.min.js"></script>          

<?php include ('includes/footer.php')?>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#achat_total').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "pageLength" : 5,
  });    

 $('#vente_total').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "pageLength" : 5,
  });       
});
</script>