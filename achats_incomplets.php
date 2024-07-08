<?php include('includes/header.php'); ?>
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

<style type="text/css">
    .categorie-left {
        width: 50%;
        float: left;
    }

    .categorie-right {
        width: 50%;
        float: right;
    }

    .panel-h {
        color: #fff !important;
        background-color: green !important;
        border-color: #ddd;
        height: 41px;
    }

    .new_sale a {
        color: #FFF;
    }

    .new_sale a:hover {
        color: #FFF;
    }
</style>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Mettre à jour la transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="errorMessage" class="alert alert-danger d-none" role="alert"></div>
                <form id="updateForm">
                    <div class="form-group">
                        <label for="transactionId">ID de la transaction</label>
                        <input type="text" class="form-control" id="transactionId" readonly>
                    </div>
                    <!-- Ajoutez ici d'autres champs de formulaire pour la mise à jour de la transaction -->
                    <div class="form-group">
                        <label for="somme_payee">Montant paye</label>
                        <input type="text" class="form-control" id="montantPaye" name="montantPaye" readonly>
                    </div>
                    <div class="form-group">
                        <label for="restant">Restant</label>
                        <input type="text" class="form-control" id="restant" readonly>
                    </div>
                    <div class="form-group">
                        <label for="somme_payee">Remboursser</label>
                        <input type="number" class="form-control" id="remboursser" name="remboursser">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Enregistrer les modifications</button>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title categorie-left">
                <button type="button" name="new_sale" class="btn btn-primary btn-sm new_sale" id="new_sale"><a
                            href="vente.php"><i class="nav-icon fas fa-plus"></i> Nouvelle vente</a></button>
            </h3>
            <h3 class="card-title categorie-right" align="right">
                <button type="button" name="recherche" class="btn btn-primary btn-sm recherche" id="recherche">Recherche
                    <i class="nav-icon fas fa-search"></i></button>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="sales_data" class="table-responsive">
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!--<div id="recherche_dialog" title="Nouvelle Recherche">
    <form method="post" id="recherche_form">
      <div class="form-group">
        <label>N°Facture</label>
        <input type="text" name="facture_num" id="facture_num" class="form-control" />
        <span id="error_facture" class="text-danger"></span>
      </div>
      <div class="form-group">
      <label>Intervalle de Date:</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="far fa-calendar-alt"></i>
          </span>
        </div>
        <input type="text" class="form-control float-right" id="reservation" name="intervalle">
      </div>
      <!-- /.input group -->
<!--</div>-->
<!-- /.form group -->
<!--<div class="form-group">
  <input type="hidden" name="action_recherche" id="action_recherche" value="insert_marque" />
  <input type="hidden" name="hidden_id_marque" id="hidden_id_marque" />
  <input type="submit" name="form_action_recherche" id="form_action_recherche" class="btn btn-info" value="recherche" />
</div>
</form>-->
<!--</div>-->
<div id="alert_marque" title="Action"></div>

<!-- jQuery -->
<!
<script src="js/jquery.min.js"></script>
<!-- Select2 -->
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
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
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
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

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
</script>

<?php include('includes/footer.php'); ?>

<script>
    $(document).ready(function () {
        load_data();

        function load_data() {
            $.ajax({
                url: "achats_incomplets_fetch.php",
                method: "POST",
                success: function (data) {
                    $('#sales_data').html(data);
                }
            })
        }

        // Gérer l'ouverture de la boîte modale pour la mise à jour
        $(document).on('click', '.update', function () {
            var transactionId = $(this).attr('id');
            $.ajax({
                url: 'get_transaction_details.php',
                method: 'POST',
                data: {id_transaction: transactionId},
                dataType: 'json',
                success: function (data) {
                    $('#transactionId').val(data.id_transaction);
                    $('#numFacture').val(data.num_facture);
                    $('#clientFournisseur').val(data.client_fournisseur);
                    $('#montant').val(data.montant);
                    $('#montantPaye').val(data.montant_paye);
                    $('#restant').val(data.restant);
                    $('#updateModal').modal('show');
                }
            });
        });

        // Gérer l'enregistrement des modifications
        $('#saveChanges').click(function () {
            var transactionId = $('#transactionId').val();
            var montant = $('#montant').val();
            var montantPaye = $('#montantPaye').val();
            var restant = $('#restant').val();
            var remboursser = $('#remboursser').val();

            $.ajax({
                url: 'update_transaction_achat.php',
                method: 'POST',
                data: {
                    id_transaction: transactionId,
                    montant: montant,
                    montantPaye: montantPaye,
                    restant: restant,
                    remboursser: remboursser
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        load_data();
                        $('#updateModal').modal('hide');
                        $('#errorMessage').addClass('d-none').text('');
                    } else {
                        $('#errorMessage').removeClass('d-none').text(response.message);
                    }
                }
            });
        });
    });

</script>