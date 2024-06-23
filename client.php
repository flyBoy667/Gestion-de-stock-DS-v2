<?php
//connexion a la base de donnée
include('includes/db_connexion.php');

//Selction de la liste des categorie
$clients = "SELECT * FROM clients";
$client_statement = $connect->prepare($clients);
$client_statement->execute();
$result_client = $client_statement->fetchAll();
$total_client = $client_statement->rowCount();

include('includes/header.php');
?>
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
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title categorie-left">
                <button type="button" name="add" class="btn btn-primary btn-sm add" id="add"><i
                            class="nav-icon fas fa-plus"></i> Ajouter
                </button>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="produit_data" class="table-responsive">
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<div id="produit_dialog" title="Add Data">
    <form method="post" id="article_form" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Civilite</label>
                    <select class="form-control" type="text" id="civilite" name="civilite">
                        <option>Mr</option>
                        <option>Mme</option>
                    </select>
                    <span id="error_civilite" class="text-danger"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control"/>
                    <span id="error_nom" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Prenom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control"/>
                    <span id="error_prenom" class="text-danger"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="form-control"/>
                    <span id="error_adresse" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Tel</label>
                    <input type="text" name="tel" id="tel" class="form-control"/>
                    <span id="error_tel" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="hidden" name="action" id="action" value="insert"/>
            <input type="hidden" name="hidden_id" id="hidden_id"/>
            <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Ajouter"/>
        </div>
    </form>
</div>

<div id="action_alert" title="Action">

</div>

<div id="delete_confirmation" title="Confirmation">
    <p>Êtes-vous sûr de vouloir supprimer ces données?</p>
</div>

<?php include('includes/footer.php'); ?>

<script>
    $(document).ready(function () {

        load_data();

        function load_data() {
            $.ajax({
                url: "client_fetch.php",
                method: "POST",
                success: function (data) {
                    $('#produit_data').html(data);
                }
            })
        }

        $('#produit_dialog').dialog({
            autoOpen: false,
            width: 600
        });

        $('#add').click(function () {
            $('#produit_dialog').attr('title', 'Add Data');
            $('#action').val('insert');
            $('#form_action').val("Ajouter");
            $('#article_form')[0].reset();
            $('#form_action').attr('disabled', false);
            $('#produit_dialog').dialog('open');
        });

        $('#article_form').on('submit', function (event) {
            event.preventDefault();
            let error_civilite = '';
            let error_nom = '';
            let error_prenom = '';
            let error_adresse = '';
            let error_tel = '';

            if ($('#civilite').val() === '') {
                error_civilite = 'La civilite est obligatoire';
                $('#error_civilite').text(error_civilite);
                $('#civilite').css('border-color', '#cc0000');
            } else {
                error_civilite = '';
                $('#error_civilite').text(error_civilite);
                $('#civilite').css('border-color', '');
            }

            if ($('#nom').val() === '') {
                error_nom = 'Le nom du client est obligatoire';
                $('#error_nom').text(error_nom);
                $('#nom').css('border-color', '#cc0000');
            } else {
                error_nom = '';
                $('#error_nom').text(error_nom);
                $('#nom').css('border-color', '');
            }

            if ($('#prenom').val() === '') {
                error_prenom = 'Le prenom du client est obligatoire';
                $('#error_prenom').text(error_prenom);
                $('#prenom').css('border-color', '#cc0000');
            } else {
                error_prenom = '';
                $('#error_prenom').text(error_prenom);
                $('#prenom').css('border-color', '');
            }

            if ($('#adresse').val() === '') {
                error_adresse = 'L\'adresse est obligatoire';
                $('#error_adresse').text(error_adresse);
                $('#adresse').css('border-color', '#cc0000');
            } else {
                error_adresse = '';
                $('#error_adresse').text(error_adresse);
                $('#adresse').css('border-color', '');
            }

            if ($('#tel').val() === '') {
                error_tel = 'Le numero de tel est obligatoire';
                $('#error_tel').text(error_tel);
                $('#tel').css('border-color', '#cc0000');
            } else {
                error_tel = '';
                $('#error_tel').text(error_tel);
                $('#tel').css('border-color', '');
            }

            if (error_civilite !== '' || error_nom !== '' || error_tel !== '' || error_prenom !== '' || error_adresse !== '') {
                return false;
            } else {
                $('#form_action').attr('disabled', 'disabled');
                var form_data = $(this).serialize();
                $.ajax({
                    url: "action/client_action.php",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        $('#produit_dialog').dialog('close');
                        $('#action_alert').html(data);
                        $('#action_alert').dialog('open');
                        load_data();
                        $('#form_action').attr('disabled', false);
                    }
                });
            }

        });

        $('#action_alert').dialog({
            autoOpen: false
        });

        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            var action = 'fetch_single';
            $.ajax({
                url: "action/client_action.php",
                method: "POST",
                data: {id: id, action: action},
                dataType: "json",
                success: function (data) {
                    $('#civilite').val(data.civilite);
                    $('#nom').val(data.nom);
                    $('#prenom').val(data.prenom);
                    $('#adresse').val(data.adresse);
                    $('#tel').val(data.tel);

                    $('#produit_dialog').attr('title', 'Edit Data');
                    $('#action').val('update');
                    $('#hidden_id').val(id);
                    $('#form_action').val('Update');
                    $('#produit_dialog').dialog('open');
                }
            });
        });

        $('#delete_confirmation').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                Ok: function () {
                    var id = $(this).data('id');
                    var action = 'delete';
                    $.ajax({
                        url: "action/client_action.php",
                        method: "POST",
                        data: {id: id, action: action},
                        success: function (data) {
                            $('#delete_confirmation').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            load_data();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            $('#delete_confirmation').data('id', id).dialog('open');
        });

    });
</script>
