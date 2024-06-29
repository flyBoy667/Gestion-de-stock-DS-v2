<?php include('includes/header.php');
checkAdmin();
?>
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<div class="col-12">
	<!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Ajout nouvelle stock</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          	<form id="formulaire" name="formulaire" method="post" action="action/add_stock.php">
          		<script src="js/prototype.js" type="text/javascript"></script>
				<script src="js/recolter.js" type="text/javascript"></script>
	          	<div class="row">
	              <div class="col-md-6">
	                <div class="form-group">
	                  <label>Selectionnez le produit</label>
	            
	                  <select class="form-control select2bs4" style="width: 100%;" id="ref_produit" name="ref_produit" onchange="document.getElementById('tampon').value='recup';recolter();">
							<option value="0" selected="selected">Choisir une référence</option>
							<?php 
	                    	$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
							mysqli_select_db($liaison, 'stock_v3');
							$requete = "SELECT id_produit, nom_produit FROM produit ORDER BY id_produit;";
							$retours = mysqli_query($liaison, $requete);
							while($retour = mysqli_fetch_array($retours))
							{
							echo "<option value='".$retour["id_produit"]."'>".$retour["id_produit"]."-".$retour["nom_produit"]."</option>";
							}         
								?>-->
						</select>
	                  <input type="text" id="tampon" name="tampon" style="visibility:hidden;" />
	                </div>
	                <!-- /.form-group -->
	               	<div class="form-group">
	                  <label>Nom du produit</label>
	                  <input type="text" id="des_produit" name="des_produit" class="form-control" readonly="">
	                </div>
	                <!-- /.form-group -->
	              </div>
	              <!-- /.col -->
	              <div class="col-md-6">
	                <div class="form-group">
	                  <label>Stock encours</label>
	                  <input type="text" id="qte_produit_avt" name="qte_produit_avt" class="form-control" readonly="">
	                </div>
	                <!-- /.form-group -->
	                <div class="form-group">
	                  <label>Nouvelle quantité</label>
	                  <input type="text" id="qte_produit" name="qte_produit" class="form-control">
	                </div>
	                <!-- /.form-group -->
	                <div class="form-group">
	                  <label>Stock après mise à jour</label>
	                  <input type="text" id="qte_produit_aps" name="qte_produit_aps" class="form-control" readonly="">
	                </div>
	                <!-- /.form-group -->
	              </div>
	              <!-- /.col -->              
	            </div>
	            <input type="button" class="btn btn-outline-primary form-rounded" id="valider" name="valider" value="Valider la mise à jour" onclick="document.getElementById('tampon').value='maj';recolter();" />
				<div id="msg_reponse" style="width:35%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
					<?php 
					echo "Réponse serveur";
					?>
				</div>
          	</form>
            
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

</div>

<!-- jQuery -->
<!<script src="js/jquery.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({

    })

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

<?php include('includes/footer.php');?>