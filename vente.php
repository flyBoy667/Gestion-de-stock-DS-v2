<?php

$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');


include('includes/header.php');

?>
    <style type="text/css">
        .titre_h1 {
            width: auto;
            display: block;
            height: auto;
            text-align: center;
            background-color: #EDEEEE;
            border: #666666 1px solid;
            padding-top: 20px;
            padding-bottom: 8px;
            padding-left: 10px;
            border: #3868e2 1px solid;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        .div_saut_ligne {
            width: 100%;
            height: 5px;
            display: inline-block;
        }

        .titre_h1 {
            width: auto;
            display: block;
            height: auto;
            text-align: center;
            background-color: #EDEEEE;
            border: #666666 1px solid;
            padding-top: 20px;
            padding-bottom: 8px;
            border: #3868e2 5px inset;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        .suite {
            width: 15%;
            height: 25px;
            float: left;
            font-size: 16px;
            font-weight: normal;
            text-align: left;
        }

        .bord {
            float: left;
            width: 5%;
            height: 25px;
        }

        .des {
            width: 30%;
            height: 25px;
            float: left;
            font-size: 16px;
            font-weight: normal;
            text-align: left;
            overflow: hidden;
        }

        .prix {
            width: 15%;
            height: 25px;
            float: left;
            font-size: 16px;
            font-weight: normal;
            text-align: right;
        }

        input,
        select {
            border-radius: 10px;
            text-align: center;
            padding-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <!--        <div id="produit_dialog" title="Add Data">-->
        <!--            <form method="post" id="article_form" action="" enctype="multipart/form-data">-->
        <!--                <div class="row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Categorie</label>-->
        <!--                            <select class="form-control" type="text" id="categorie" name="categorie">-->
        <!--                                <option>Selectionnez</option>-->
        <!--                                --><?php //if ($total_categorie > 0) {
        //                                    foreach ($result_categorie as $row_categorie) {
        //                                        ?>
        <!--                                        <option value="-->
        <?php //echo $row_categorie["id_categorie"]; ?><!--">-->
        <?php //echo $row_categorie["categorie"] ?><!--</option>-->
        <!--                                    --><?php //}
        //                                } ?>
        <!--                            </select>-->
        <!--                            <span id="error_categorie" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Marque</label>-->
        <!--                            <select class="form-control" type="text" id="marque" name="marque">-->
        <!--                                <option>Selectionnez</option>-->
        <!--                                --><?php //if ($total_marque > 0) {
        //                                    foreach ($result_marque as $row_marque) {
        //                                        ?>
        <!--                                        <option value="--><?php //echo $row_marque["id_marque"]; ?><!--">-->
        <?php //echo $row_marque["marque"]; ?><!--</option>-->
        <!--                                    --><?php //}
        //                                } ?>
        <!--                            </select>-->
        <!--                            <span id="error_marque" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Code produit</label>-->
        <!--                            <input type="text" name="code" id="code" class="form-control"/>-->
        <!--                            <span id="error_code" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Nom produit</label>-->
        <!--                            <input type="text" name="nom" id="nom" class="form-control"/>-->
        <!--                            <span id="error_nom" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Prix d'achat</label>-->
        <!--                            <input type="text" name="pa" id="pa" class="form-control"/>-->
        <!--                            <span id="error_pa" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Prix de vente</label>-->
        <!--                            <input type="text" name="pv" id="pv" class="form-control"/>-->
        <!--                            <span id="error_pv" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Stock</label>-->
        <!--                            <input type="text" name="stock" id="stock" class="form-control"/>-->
        <!--                            <span id="error_stock" class="text-danger"></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Statut</label>-->
        <!--                            <select class="form-control" type="text" id="statut" name="statut">-->
        <!--                                <option value="">Selectionnez</option>-->
        <!--                                <option value="1">Actif</option>-->
        <!--                                <option value="2">Inactif</option>-->
        <!--                                <span id="error_statut" class="text-danger"></span>-->
        <!--                            </select>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!---->
        <!--                <!--<div class="row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <div class="form-group">-->
        <!--                            <label>Image</label>-->
        <!--                            <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpeg"/>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->-->
        <!--                <div class="form-group">-->
        <!--                    <input type="hidden" name="action" id="action" value="insert"/>-->
        <!--                    <input type="hidden" name="hidden_id" id="hidden_id"/>-->
        <!--                    <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Ajouter"/>-->
        <!--                </div>-->
        <!--            </form>-->
        <!--        </div>-->

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Creer un nouveau client</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <script src="js/prototype.js" type="text/javascript"></script>
                <script language='javascript' type="text/javascript">
                    var articles = {}; // Objet pour stocker les informations des articles
                    var article = 0
                    var produits_panier = [];

                    function recolter() {
                        document.getElementById("formulaire").request({
                            onComplete: function (transport) {
                                let idClient = document.getElementById("ref_client").value;

                                document.getElementById("valider").disabled = idClient <= 0;

                                switch (document.getElementById('param').value) {
                                    case 'recup_client':
                                        var tab_info = transport.responseText.split('|');
                                        document.getElementById('civilite').value = tab_info[0];
                                        document.getElementById('nom_client').value = tab_info[1];
                                        document.getElementById('prenom_client').value = tab_info[2];
                                        break;

                                    case 'recup_article':
                                        var tab_info = transport.responseText.split('|');
                                        var refProduit = tab_info[3];

                                        if (articles[refProduit]) {
                                            // Si les informations de l'article sont déjà stockées, les charger
                                            var tab_infos = articles[refProduit];
                                            document.getElementById('designation').value = tab_infos[0];
                                            document.getElementById('puht').value = tab_infos[1];
                                            document.getElementById('qte').value = tab_infos[2];
                                        } else {
                                            // Sinon, faire une requête et stocker les informations
                                            document.getElementById('designation').value = tab_info[0];
                                            document.getElementById('puht').value = tab_info[1];
                                            document.getElementById('qte').value = tab_info[2];

                                            // Stocker les informations de l'article
                                            articles[refProduit] = tab_info;
                                        }
                                        break;

                                    case 'creer_client':
                                        var civilite = document.getElementById('civilite').value;
                                        var nom_client = document.getElementById('nom_client').value;
                                        var prenom_client = document.getElementById('prenom_client').value;
                                        var rep = transport.responseText;

                                        if (rep === "nok") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'Le client existe déjà',

                                            });
                                            return;
                                        } else if (rep === "info") {
                                            showAlert();
                                        } else {
                                            var data = transport.responseText.split('|');
                                            var liste = document.getElementById("ref_client");
                                            var option = document.createElement("option");
                                            console.log(rep)
                                            option.value = data[0];
                                            option.text = data[0] + " - " + data[1] + " " + data[2];
                                            liste.add(option);
                                            liste.selectedIndex = liste.length - 1;

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: 'Le client a ete ajoute',
                                            });

                                            document.getElementById("valider").disabled = false;
                                        }
                                        break;

                                    case 'facturer':
                                        var reponse = transport.responseText;
                                        if (reponse === "nok") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'Une erreur est survenue'
                                            });
                                            return;
                                        } else if (reponse === "remise_error") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'La remise accordée est incorrecte'
                                            });
                                            return;
                                        } else {
                                            let paye = document.getElementById("paye").value;
                                            let total_commande = document.getElementById("total_commande").value - document.getElementById("remise").value;

                                            if (paye === "" || paye < total_commande || paye > total_commande || paye < document.getElementById("remise").value) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Erreur',
                                                    text: 'La Somme à payer est incorrecte'
                                                });
                                                return;
                                            }

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Succès',
                                                text: 'La facture a été validée'
                                            });

                                            document.getElementById("editer").innerHTML = "<input type='button' value='Voir la facture' onclick='window.open(\"ticket.php?id=" + reponse + "\")' />";
                                            document.getElementById("actualiser").innerHTML = "<input type='button' value='Nouvelle vente' onclick='window.location.reload();' />";
                                            document.querySelectorAll(".disabled_after_valid").forEach((element) => {
                                                element.disabled = true;
                                            });
                                            document.getElementById("valider").disabled = true;
                                        }
                                        break;
                                }
                            }
                        });
                    }
                </script>
                <form id="formulaire" name="formulaire" method="post" action="action/add_facture.php">
                    <div class="titre_h1" style="height:350px;">
                        <!-- Informations du client -->
                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:35%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                            <u>Informations du client</u><br/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:35%;height:50px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <input type="button" id="creer_client" name="creer_client" value="Créer le client" disabled
                                   onclick="document.getElementById('param').value='creer_client';recolter();"/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>

                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">

                            <label for="ref_client"> Réf. Client :</label><br/>
                            <select id="ref_client" name="ref_client"
                                    onchange="document.getElementById('param').value='recup_client';recolter();">
                                <option value="0">Choisir client</option>
                                <?php
                                $requete = "SELECT IdClient, Prenom, Nom FROM clients ORDER BY IdClient;";
                                $retours = mysqli_query($liaison, $requete);
                                while ($retour = mysqli_fetch_array($retours)) {
                                    echo "<option value='" . $retour["IdClient"] . "'>" . $retour["IdClient"] . " - " . $retour["Prenom"] . " " . $retour["Nom"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div style="width:10%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="civilite"> Civilité :</label>
                            <select id="civilite" name="civilite">
                                <option value="0">Selectionner civilite</option>
                                <option value="Mr">Mr</option>
                                <option value="Mme">Mme</option>
                            </select>
                        </div>

                        <div style="width:10%;height:55px;float:left;"></div>
                        <div style="width:6%;height:55px;float:left;"></div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="nom_client">Nom du client :</label> <br>
                            <input type="text" id="nom_client" name="nom_client"/>
                        </div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="prenom_client">Prénom du client :</label> <br/>

                            <input type="text" id="prenom_client" name="prenom_client"/>
                        </div>

                        <!-- Ajout des produits commandés -->
                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:80%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                            <u>Ajout des produits commandés</u><br/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>

                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="ref_produit">Réf. Produit :</label> <br>
                            <select id="ref_produit" name="ref_produit"
                                    onchange="document.getElementById('param').value='recup_article';recolter();">
                                <option value="0">Réf. produit</option>
                                <?php
                                $requete = "SELECT id_produit, nom_produit FROM produit ORDER BY id_produit;";
                                $retours = mysqli_query($liaison, $requete);
                                while ($retour = mysqli_fetch_array($retours)) {
                                    echo "<option value='" . $retour["id_produit"] . "'>" . $retour["id_produit"] . ' - ' . $retour['nom_produit'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="qte"> Qté en stock :</label>
                            <input type="text" id="qte" name="qte" disabled style="text-align:right;"/>
                        </div>
                        <div style="width:10%;height:55px;float:left;"></div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="designation">Désignation du produit :</label>
                            <input type="text" id="designation" name="designation" disabled/>
                        </div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="puht"> Prix unitaire HT :</label> <br>
                            <input type="text" id="puht" name="puht" disabled style="text-align:right;"/>
                        </div>
                        <div style="width:10%;height:55px;float:left;"></div>

                        <div class="div_saut_ligne" style="height:2%;"></div>

                        <div style="width:0;height:55px;float:left;"></div>
                        <div style="width:10%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <label for="qte_commande"> Quantité:</label>
                            <input type="number" id="qte_commande" name="qte_commande"/>
                        </div>
                        <div style="width:7%;height:55px;float:left;"></div>
                        <div style="width:20%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            <h5>
                                <label for="total_commande">Total commande :</label>
                                <input type="text" id="total_commande" name="total_commande" disabled
                                       style="color:#7f0c06;width:100%;font-family: Arial Black;"/>
                            </h5>
                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            <label for="remise">Remise :</label>
                            <input type="text" id="remise" name="remise" value="0" onchange="montan_a_payer();"/>
                            <input type="text" id="total_remise" name="total_remise" style="visibility:hidden;"/>

                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            <label for="paye">Payé :</label>
                            <input type="number" id="paye" name="paye"/>
                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:7%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">
                            <input type="button" id="ajouter" name="ajouter" class="disabled_after_valid"
                                   value="Ajouter" style="margin-top:10px;"
                                   onclick="plus_com();"/><br/>
                            <input type="text" id="param" name="param" style="visibility:hidden;"/>
                        </div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">

                            <input type="button" id="valider" name="valider" value="Valider" disabled
                                   style="margin-top:10px;"
                                   onclick="document.getElementById('param').value='facturer';recolter();"/>

                            <input type="text" id="chaine_com" name="chaine_com" style="visibility:hidden;"/>
                            <input type="text" id="total_com" name="total_com" style="visibility:hidden;"/>
                        </div>
                    </div>
                    <input type="hidden" id="Adresse" name="Adresse">
                    <input type="hidden" id="Tel" name="Tel">
                    <input type="text" id="qr" name="qr">
                    <input type="button" id="qr_btn" name="qr_btn">
                </form>

                <div class="div_saut_ligne" style="height:50px;">
                </div>

                <div style="float:left;width:10%;height:25px;"></div>
                <div style="float:left;width:80%;height:auto;text-align:center;">
                    <div class="titre_h1" style="float:left;height:auto;width:100%;">
                        <div style="float:left;width:5%;height:25px;"></div>
                        <div style="width:15%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Réference
                        </div>
                        <div style="width:15%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Quantité
                        </div>
                        <div style="width:30%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:left;overflow:hidden;">
                            Désignation du produit
                        </div>
                        <div style="width:15%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:right;">
                            PUHT
                        </div>
                        <div style="width:15%;height:25px;float:left;font-size:16px;font-weight:bold;text-align:right;">
                            PTHT
                        </div>
                        <div style="float:left;width:5%;height:25px;"></div>

                        <div style="float:left;width:100%;height:auto;" id="det_com">
                            <div class="bord"></div>
                            <div class="suite">

                            </div>
                            <div class="suite">

                            </div>
                            <div class="des">

                            </div>
                            <div class="prix">

                            </div>
                            <div class="prix" style="font-weight:bold;">

                            </div>
                            <div class="bord"></div>

                        </div>

                        <div style="float:left;width: 5%;height:25px;"></div>
                        <div style="float:left;width: 100%;height:auto; margin-bottom: 10px" id="editer"></div>
                        <div style="float:left;width: 100%;height:auto;" id="actualiser"></div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <script language='javascript' type="text/javascript">
                var tot_com = 0;
                /*
                * Generation du code barre
                * id_produit devient la valeur du code barre
                * un fichier pour la generation de code barre pour tous les produits
                * */
                // document.getElementById("qr").addEventListener('input', (e) => {
                //     document.getElementById("ref_produit").value = e.currentTarget.value;
                //     document.getElementById("param").value = "recup_article";
                //     recolter();
                // })
                // document.getElementById("qr_btn").addEventListener('click', (e) => {
                //     document.getElementById("qr").focus();
                // })

                function showAlert() {
                    Swal.fire({
                        title: 'Ajouter les informations du client',
                        html: `<input type="text" id="swal-input1" class="swal2-input" placeholder="Adresse" required>
                       <input type="text" id="swal-input2" class="swal2-input" placeholder="Téléphone" required>`,
                        showCancelButton: true,
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annuler',
                        preConfirm: () => {
                            const address = document.getElementById('swal-input1').value;
                            const phone = document.getElementById('swal-input2').value;

                            if (!address || !phone) {
                                Swal.showValidationMessage('Tous les champs doivent être remplis');
                                return false;
                            }

                            return {
                                address: address,
                                phone: phone
                            };

                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Récupérer les valeurs saisies dans l'alerte
                            const address = result.value.address;
                            const phone = result.value.phone;

                            // Remplir les champs cachés du formulaire
                            document.getElementById('Adresse').value = address;
                            document.getElementById('Tel').value = phone;

                            // Soumettre le formulaire
                            document.getElementById('param').value = 'creer_client';
                            recolter();
                        }
                    });
                }

                document.getElementById("formulaire").addEventListener("input", (ev) => {
                    if (document.getElementById("nom_client").value.length >= 2 && document.getElementById("prenom_client").value.length >= 2 && document.getElementById("civilite").value !== "0") {
                        document.getElementById("creer_client").disabled = false;
                    } else {
                        document.getElementById("creer_client").disabled = true;
                    }
                })

                function somme_a_retouner() {
                    return document.getElementById('paye').value - document.getElementById('total_commande').value
                }

                function plus_com() {
                    var ref_p = ref_produit.value;

                    if (ref_client.value !== 0 && ref_p !== 0 && qte_commande.value !== "0" && qte_commande.value !== "") {
                        if (parseInt(qte_commande.value) > parseInt(qte.value)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: "La quantité en stock n'est pas suffisante pour honorer la commande"
                            });
                        } else {
                            // Utiliser les données du tableau articles
                            if (articles[ref_p]) {
                                article = articles[ref_p];
                                var des_p = article[0];
                                var pht_p = article[1];
                                var qte_p = qte_commande.value;

                                article[2] = article[2] - parseInt(qte_p);

                                qte.value = article[2]

                                tot_com = tot_com + qte_p * pht_p;
                                total_commande.value = tot_com.toFixed(2);
                                total_com.value = total_commande.value;
                                chaine_com.value += "|" + ref_p + ";" + qte_p + ";" + des_p + ";" + pht_p;
                                facture();
                            } else {
                                alert("Les informations du produit ne sont pas disponibles.");
                            }
                        }
                    }
                }

                function montan_a_payer() {
                    //alert("test");
                    document.getElementById('paye').value = document.getElementById('total_commande').value - document.getElementById('remise').value;
                }

                function facture() {

                    var tab_com = chaine_com.value.split('|');
                    var nb_lignes = tab_com.length;
                    document.getElementById("det_com").innerHTML = "";
                    for (ligne = 0; ligne < nb_lignes; ligne++) {
                        if (tab_com[ligne] != "") {
                            var ligne_com = tab_com[ligne].split(';');
                            document.getElementById("det_com").innerHTML += "<div class='bord'></div>";
                            document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[0] + "</div>";
                            document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[1] + "</div>";
                            document.getElementById("det_com").innerHTML += "<div class='des'>" + ligne_com[2] + "</div>";
                            document.getElementById("det_com").innerHTML += "<div class='prix'>" + ligne_com[3] + "</div>";
                            document.getElementById("det_com").innerHTML += "<div class='prix'>" + (ligne_com[1] * ligne_com[3]).toFixed(2) + "</div>";
                            document.getElementById("det_com").innerHTML += "<div class='bord'><input type='button' class='disabled_after_valid' value='X' title='Supprimer le produit' style='height:20px;font-size:12px;' onclick='suppr(\"" + tab_com[ligne] + "\");' /></div>";
                        }
                    }
                }

                function suppr(ligne_s) {
                    chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
                    var tab_detail = ligne_s.split(';');

                    total_commande.value = (total_commande.value - tab_detail[1] * tab_detail[3]).toFixed(2);
                    total_com.value = total_commande.value;
                    tot_com = total_com.value * 1;

                    document.getElementById("ref_produit").value = tab_detail[0]
                    articles[tab_detail[0]][2] = articles[tab_detail[0]][2] + tab_detail[1] * 1
                    qte.value = articles[tab_detail[0]][2]

                    facture();
                }
            </script>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- jQuery -->
    <!
    <script src="js/jquery.min.js">
    </script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Page script -->
    <!--<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({

    })

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    })
  })
</script>-->


<?php include('includes/footer.php'); ?>