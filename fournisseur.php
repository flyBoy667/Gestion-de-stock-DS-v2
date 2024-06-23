<?php
// Connexion à la base de données
include('includes/db_connexion.php');

// Sélection de la liste des fournisseurs
$fournisseurs = "SELECT * FROM fournisseur";
$fournisseur_statement = $connect->prepare($fournisseurs);
$fournisseur_statement->execute();
$result_fournisseur = $fournisseur_statement->fetchAll();
$total_fournisseur = $fournisseur_statement->rowCount();

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
                <button type="button" name="add" class="btn btn-primary btn-sm add" id="add">
                    <i class="nav-icon fas fa-plus"></i> Ajouter
                </button>
            </h3>
        </div>
        <div class="card-body">
            <div id="fournisseur_data" class="table-responsive"></div>
        </div>
    </div>
</div>

<div id="fournisseur_dialog" title="Ajouter des données">
    <form method="post" id="fournisseur_form" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom_fournisseur" id="nom_fournisseur" class="form-control" />
                    <span id="error_nom_fournisseur" class="text-danger"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom_fournisseur" id="prenom_fournisseur" class="form-control" />
                    <span id="error_prenom_fournisseur" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Société</label>
                    <input type="text" name="societe" id="societe" class="form-control" />
                    <span id="error_societe" class="text-danger"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Adresse</label>
                    <textarea name="adresse" id="adresse" class="form-control"></textarea>
                    <span id="error_adresse" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" />
                    <span id="error_telephone" class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="hidden" name="action" id="action" value="insert" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Ajouter" />
        </div>
    </form>
</div>

<div id="action_alert" title="Action"></div>
<div id="delete_confirmation" title="Confirmation">
    <p>Êtes-vous sûr de vouloir supprimer ces données?</p>
</div>

<?php include('includes/footer.php'); ?>

<script>
    $(document).ready(function () {
        load_data();

        function load_data() {
            $.ajax({
                url: "fournisseur_fetch.php",
                method: "POST",
                success: function (data) {
                    $('#fournisseur_data').html(data);
                }
            });
        }

        $('#fournisseur_dialog').dialog({
            autoOpen: false,
            width: 600
        });

        $('#add').click(function () {
            $('#fournisseur_dialog').attr('title', 'Ajouter des données');
            $('#action').val('insert');
            $('#form_action').val("Ajouter");
            $('#fournisseur_form')[0].reset();
            $('#form_action').attr('disabled', false);
            $('#fournisseur_dialog').dialog('open');
        });

        $('#fournisseur_form').on('submit', function (event) {
            event.preventDefault();
            let error_nom_fournisseur = '';
            let error_prenom_fournisseur = '';
            let error_societe = '';
            let error_adresse = '';
            let error_telephone = '';

            if ($('#nom_fournisseur').val() === '') {
                error_nom_fournisseur = 'Le nom est obligatoire';
                $('#error_nom_fournisseur').text(error_nom_fournisseur);
                $('#nom_fournisseur').css('border-color', '#cc0000');
            } else {
                error_nom_fournisseur = '';
                $('#error_nom_fournisseur').text(error_nom_fournisseur);
                $('#nom_fournisseur').css('border-color', '');
            }

            if ($('#prenom_fournisseur').val() === '') {
                error_prenom_fournisseur = 'Le prénom est obligatoire';
                $('#error_prenom_fournisseur').text(error_prenom_fournisseur);
                $('#prenom_fournisseur').css('border-color', '#cc0000');
            } else {
                error_prenom_fournisseur = '';
                $('#error_prenom_fournisseur').text(error_prenom_fournisseur);
                $('#prenom_fournisseur').css('border-color', '');
            }

            if ($('#societe').val() === '') {
                error_societe = 'La société est obligatoire';
                $('#error_societe').text(error_societe);
                $('#societe').css('border-color', '#cc0000');
            } else {
                error_societe = '';
                $('#error_societe').text(error_societe);
                $('#societe').css('border-color', '');
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

            if ($('#telephone').val() === '') {
                error_telephone = 'Le numéro de téléphone est obligatoire';
                $('#error_telephone').text(error_telephone);
                $('#telephone').css('border-color', '#cc0000');
            } else {
                error_telephone = '';
                $('#error_telephone').text(error_telephone);
                $('#telephone').css('border-color', '');
            }

            if (error_nom_fournisseur !== '' || error_prenom_fournisseur !== '' || error_societe !== '' || error_adresse !== '' || error_telephone !== '') {
                return false;
            } else {
                $('#form_action').attr('disabled', 'disabled');
                var form_data = $(this).serialize();
                $.ajax({
                    url: "action/fournisseur_action.php",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        $('#fournisseur_dialog').dialog('close');
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
                url: "action/fournisseur_action.php",
                method: "POST",
                data: {id: id, action: action},
                dataType: "json",
                success: function (data) {
                    $('#nom_fournisseur').val(data.nom_fournisseur);
                    $('#prenom_fournisseur').val(data.prenom_fournisseur);
                    $('#societe').val(data.societe);
                    $('#adresse').val(data.adresse);
                    $('#telephone').val(data.telephone);

                    $('#fournisseur_dialog').attr('title', 'Modifier des données');
                    $('#action').val('update');
                    $('#hidden_id').val(id);
                    $('#form_action').val('Modifier');
                    $('#fournisseur_dialog').dialog('open');
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
                        url: "action/fournisseur_action.php",
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
            var id = $(this).attr('id');
            $('#delete_confirmation').data('id', id).dialog('open');
        });
    });
</script>
