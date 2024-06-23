<?php
include('includes/db_connexion.php');
$id = $_GET['id'];//echo $id;
$query ="SELECT t.num_facture, t.client_fournisseur, t.montant, t.remise,t.montant_paye, t.transaction_date, d.Detail_com, d.Detail_ref, d.Detail_qte, p.id_produit, p.nom_produit, p.code_produit, p.prix_vente,c.IdClient, c.Nom, c.Prenom FROM transaction t, clients c, detail d, produit p WHERE t.client_fournisseur = c.IdClient AND t.num_facture = d.Detail_com AND d.Detail_ref = p.id_produit AND t.num_facture= '".$id."'";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();


$query2 ="SELECT t.id_transaction, t.num_facture, t.client_fournisseur, t.montant, t.montant_paye, t.type, t.transaction_date, c.IdClient, c.Nom, c.Prenom, c.Adresse, c.Tel FROM transaction t, clients c WHERE t.client_fournisseur = c.IdClient AND t.num_facture= '".$id."'";

$statement2 = $connect->prepare($query2);

$statement2->execute();

$result2 = $statement2->fetchAll();

$total_row2 = $statement2->rowCount();

$totalht = 0.00;
//var_dump($total_row);
include('includes/header.php');	
?>
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <?php if ($total_row2 > 0){ foreach ($result2 as $row2){?>
                
              <div class="row">
                <div class="col-12">
                  <h4>
                    <!--<i class="fas fa-globe"></i>--><img src="dist/img/icon_stock.png" alt="AdminLTE Logo" class="brand-image elevation-3"> D&S Inventeur.
                    <small class="float-right">Date: <?php echo $row2['transaction_date'];?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>D&S, Inventeur.</strong><br>
                    Bamako, ACI 2000 <br>
                    Phone: (223) 91-93-60-13 / 78-62-85-87<br>
                    Email: info@ds-mali.com
                  </address>
                </div>
                <!-- /.col -->
                
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $row2['Nom']." ". $row2['Prenom'];?></strong><br>
                    <?php echo $row2['Adresse'];?><br>
                    Phone: <?php echo $row2['Tel'];?><br>
                    <!--Email: john.doe@example.com-->
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Facture #<?php echo $row2['num_facture']?></b><br>
                  <br>
                  <b>Commande ID:</b> <?php echo $row2['num_facture']?><br>
                  <b>Date de paiement:</b> <?php echo $row2['transaction_date']?><br>
                  <!--<b>Account:</b> 968-34567-->
                </div>
                <?php }}?>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>#Code produit</th>                     
                      <th>Produit</th>
                      <th>Qty</th>
                      <th>Prix UHT</th>
                      <th>Montant HT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($total_row > 0){ foreach ($result as $row){ ?>	
                    <tr>
                      <td><?php echo $row['code_produit']?></td>
                      <td><?php echo $row['nom_produit']?></td>                      
                      <td><?php echo $row['Detail_qte']?></td>
                      <td><?php echo number_format($row['prix_vente'], 2, ',', ' ')?></td>
                      <td><?php $mth = $row['Detail_qte'] * $row['prix_vente']; echo number_format($mth, 2, ',', ' ');?></td>
                    </tr>
               		<?php $totalht = $totalht + $mth; $remise = $row['remise'];}}?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <!--<p class="lead">Payment Methods:</p>                 

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Cash
                  </p>-->
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <!--<p class="lead">Amount Due 2/22/2014</p>-->

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:54%">Montant HT:</th>
                        <td><?php echo number_format($totalht, 2, ',', ' ');?></td>
                      </tr>
                      <tr>
                        <th>Remise:</th>
                        <td><?php echo number_format($remise, 2, ',', ' ');?></td>
                      </tr>
                      <tr>
                        <th>Total(Montant HT - Remise):</th>
                        <td><?php $mtotalht = $totalht - $remise; echo number_format($mtotalht, 2, ',', ' ')?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a type="button" id="printInvoice" class="btn btn-default"><i class="fas fa-print"></i> Imprimer</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Envoie paiement
                  </button>
                  <!--<button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-arrow-left"></i> Generate PDF
                  </button>-->
                  <button type="button" id="retour" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-arrow-left"></i> Arrière
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
        </div><!-- /.col -->

<?php include('includes/footer.php');?>
<script>
$(document).ready(function() {	
	$('#retour').click(function(){
		//alert("retour");
		document.location.href="http://localhost/stock_final/liste_vente.php";	
	});

	$('#printInvoice').click(function(){
    Popup($('.invoice')[0].outerHTML);
    function Popup(data) 
    {
        window.print();
        return true;
    }
	});
});
</script>