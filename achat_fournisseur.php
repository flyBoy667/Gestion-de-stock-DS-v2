<?php
$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');
include('includes/header.php');
checkAdmin();
?>
    <style type="text/css">
        .table {
            margin-top: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
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

        input, select {
            border-radius: 10px;
            text-align: center;
            padding-right: 10px;
        }

        .btn-facture {
            background-color: #28a745; /* Couleur de fond verte */
            color: #fff; /* Couleur du texte blanche */
            border: none; /* Pas de bordure */
            padding: 8px 16px; /* Espacement interne */
            font-size: 14px; /* Taille de police */
            cursor: pointer; /* Curseur pointer au survol */
            margin-right: 10px; /* Marge à droite */
            margin-bottom: 10px; /* Marge en bas */
        }

        .btn-nouvelle-vente {
            background-color: #007bff; /* Couleur de fond bleue */
            color: #fff; /* Couleur du texte blanche */
            border: none; /* Pas de bordure */
            padding: 8px 16px; /* Espacement interne */
            font-size: 14px; /* Taille de police */
            cursor: pointer; /* Curseur pointer au survol */
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
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h3>Ajout nouvelle stock</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <script src="js/prototype.js" type="text/javascript"></script>
                <script language='javascript' type="text/javascript">
                    function recolter() {
                        document.getElementById("formulaire").request({
                            onComplete: function (transport) {
                                switch (document.getElementById('param').value) {
                                    case 'recup_fournisseur':
                                        var tab_info = transport.responseText.split('|');
                                        document.getElementById('societe').value = tab_info[2];
                                        document.getElementById('nom_fournisseur').value = tab_info[0];
                                        document.getElementById('prenom_fournisseur').value = tab_info[1];
                                        break;

                                    case 'recup_article':
                                        var tab_info = transport.responseText.split('|');
                                        document.getElementById('designation').value = tab_info[0];
                                        document.getElementById('puht').value = tab_info[1];
                                        document.getElementById('qte').value = tab_info[2];
                                        break;

                                    case 'creer_fournisseur':
                                        var rep = transport.responseText;
                                        if (rep == "nok") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'Le fournisseur existe déjà'
                                            });
                                            return
                                        } else {
                                            var liste = document.getElementById("ref_fournisseur");
                                            var option = document.createElement("option");
                                            option.value = rep;
                                            option.text = rep;
                                            liste.add(option);
                                            liste.selectedIndex = liste.length - 1;
                                        }
                                        break;

                                    case 'facturer':
                                        var reponse = transport.responseText;
                                        if (transport.responseText == "nok") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'Une erreur est survenue'
                                            });
                                            return

                                        } else if (reponse === "remise_error") {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Erreur',
                                                text: 'La remise payée est incorrecte'
                                            });
                                            return; // Arrête le script
                                        } else {
                                            // if (document.getElementById("paye").value == "" || (document.getElementById("paye").value < (document.getElementById("total_commande").value - document.getElementById("remise").value)) || (document.getElementById("paye").value > (document.getElementById("total_commande").value - document.getElementById("remise").value))) {
                                            //     Swal.fire({
                                            //         icon: 'error',
                                            //         title: 'Erreur',
                                            //         text: 'La Somme a payé incorrect'
                                            //     });
                                            if (reponse === "somme_error") {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Erreur',
                                                    text: 'La Somme à payer est incorrecte'
                                                });
                                                return;
                                            }
                                            {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success',
                                                    text: 'La facture a été validée'
                                                });
                                                // Affichage des boutons stylisés et centrés après validation
                                                document.getElementById("editer").innerHTML = "<div class='text-center'><input type='button' class='btn btn-facture mx-auto' value='Voir la facture' onclick='window.open(\"ticket.php?id=" + reponse + "\")' /></div>";
                                                document.getElementById("actualiser").innerHTML = "<div class='text-center'><input type='button' class='btn btn-nouvelle-vente mx-auto' value='Nouvelle vente' onclick='window.location.reload();' /></div>";

                                                document.querySelectorAll(".disabled_after_valid").forEach((element) => {
                                                    element.disabled = true;
                                                });
                                                document.getElementById("valider").disabled = true;

                                            }
                                        }

                                        break;

                                }
                            }
                        });
                    }
                </script>
                <form id="formulaire" name="formulaire" method="post" action="action/add_achat_fournisseur.php">
                    <div class="mb-4">
                        <h4 class="text-secondary"><u>Informations du fournisseur</u></h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="ref_fournisseur" class="font-weight-bold">Réf. fournisseur :</label>
                            <select id="ref_fournisseur" name="ref_fournisseur" class="form-control"
                                    onchange="document.getElementById('param').value='recup_fournisseur';recolter();">
                                <option value="0">Choisir fournisseur</option>
                                <?php
                                $requete = "SELECT ref_fournisseur, nom_fournisseur, prenom_fournisseur FROM fournisseur ORDER BY ref_fournisseur;";
                                $retours = mysqli_query($liaison, $requete);
                                while ($retour = mysqli_fetch_array($retours)) {
                                    echo "<option value='" . $retour["ref_fournisseur"] . "'>" . $retour["ref_fournisseur"] . " - " . $retour["prenom_fournisseur"] . " " . $retour["nom_fournisseur"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="societe" class="font-weight-bold">Société :</label>
                            <input type="text" id="societe" name="societe" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="nom_fournisseur" class="font-weight-bold">Nom du fournisseur :</label>
                            <input type="text" id="nom_fournisseur" name="nom_fournisseur" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom_fournisseur" class="font-weight-bold">Prénom du fournisseur :</label>
                            <input type="text" id="prenom_fournisseur" name="prenom_fournisseur" class="form-control"/>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <button type="button" id="creer_fournisseur" name="creer_fournisseur" class="btn btn-secondary"
                                disabled
                                onclick="document.getElementById('param').value='creer_fournisseur';recolter();">
                            Créer le fournisseur
                        </button>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-secondary"><u>Ajout des produits commandés</u></h4>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="ref_produit" class="font-weight-bold">Réf. Produit :</label>
                            <select id="ref_produit" name="ref_produit" class="form-control"
                                    onchange="document.getElementById('param').value='recup_article';recolter();">
                                <option value="0">Réf. produit</option>
                                <?php
                                $requete = "SELECT id_produit, nom_produit FROM produit ORDER BY id_produit;";
                                $retours = mysqli_query($liaison, $requete);
                                while ($retour = mysqli_fetch_array($retours)) {
                                    echo "<option value='" . $retour["id_produit"] . "'>" . $retour["id_produit"] . " - " . $retour["nom_produit"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="qte" class="font-weight-bold">Qté en stock :</label>
                            <input type="text" id="qte" name="qte" class="form-control" disabled/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="designation" class="font-weight-bold">Désignation du produit :</label>
                            <input type="text" id="designation" name="designation" class="form-control" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label for="puht" class="font-weight-bold">Prix unitaire HT :</label>
                            <input type="text" id="puht" name="puht" class="form-control" disabled/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="qte_commande" class="font-weight-bold">Quantité :</label>
                            <input type="text" id="qte_commande" name="qte_commande" class="form-control"/>
                        </div>
                        <div class="col-md-4">
                            <label for="total_commande" class="font-weight-bold">Total commande :</label>
                            <input type="text" id="total_commande" name="total_commande" class="form-control text-right"
                                   disabled/>
                        </div>
                        <div class="col-md-4">
                            <label for="remise" class="font-weight-bold">Remise :</label>
                            <input type="text" id="remise" name="remise" class="form-control" value="0"
                                   onchange="montant_a_payer();"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="paye" class="font-weight-bold">Payé :</label>
                            <input type="text" id="paye" name="paye" class="form-control"/>
                        </div>
                        <div class="col-md-4 text-center">
                            <button type="button" id="ajouter" name="ajouter"
                                    class="btn btn-secondary mt-4 disabled_after_valid"
                                    onclick="plus_com();">
                                Ajouter
                            </button>
                        </div>
                        <div class="col-md-4 text-center">
                            <button type="button" id="valider" name="valider" class="btn btn-primary mt-4"
                                    onclick="document.getElementById('param').value='facturer';recolter();">
                                Valider
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="param" name="param"/>
                    <input type="hidden" id="chaine_com" name="chaine_com"/>
                    <input type="hidden" id="total_com" name="total_com"/>
                </form>

                <!-- Tableau des commandes -->
                <div class="mt-4">
                    <div class="text-center mb-3">
                        <h4>Récapitulatif des commandes</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="text-white">
                            <tr>
                                <th scope="col">Référence</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Désignation du produit</th>
                                <th scope="col" class="text-end">PUHT</th>
                                <th scope="col" class="text-end">PTHT</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="det_com">
                            <!-- Contenu dynamique -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <div id="editer"></div>
                        <div id="actualiser"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language='javascript' type="text/javascript">

        var tot_com = 0;

        document.getElementById("formulaire").addEventListener("input", (ev) => {
            if (document.getElementById("nom_fournisseur").value.length >= 2 && document.getElementById("prenom_fournisseur").value.length >= 2 && document.getElementById("societe").value.length >= 2) {
                document.getElementById("creer_fournisseur").disabled = false;
            } else {
                document.getElementById("creer_fournisseur").disabled = true;

            }

        })

        function plus_com() {
            if (ref_fournisseur.value != 0 && ref_produit.value != 0 && qte_commande.value != "0" && qte_commande.value != "") {
                //if(parseInt(qte_commande.value) > parseInt(qte.value))
                //	alert("La quantité en stock n'est pas suffisante pour honorer la commande");
                //else
                //{
                var ref_p = ref_produit.value;
                var qte_p = qte_commande.value;
                var des_p = designation.value;
                var pht_p = puht.value;

                tot_com = tot_com + qte_p * pht_p;
                total_commande.value = tot_com.toFixed(2);
                total_com.value = total_commande.value;
                chaine_com.value += "|" + ref_p + ";" + qte_p + ";" + des_p + ";" + pht_p;
                facture();
                //}
            }
        }

        function montan_a_payer() {
            //alert("test");
            document.getElementById('paye').value = document.getElementById('total_commande').value - document.getElementById('remise').value;
        }


        function facture() {
            var tab_com = chaine_com.value.split('|');
            var tbody = document.getElementById("det_com");

            tbody.innerHTML = ""; // Vide le contenu actuel du tableau

            for (var i = 0; i < tab_com.length; i++) {
                if (tab_com[i] !== "") {
                    var ligne_com = tab_com[i].split(';');

                    // Création d'une nouvelle ligne <tr>
                    var tr = document.createElement("tr");

                    // Ajout des cellules <td>
                    tr.innerHTML = `
                <td>${ligne_com[0]}</td>
                <td>${ligne_com[1]}</td>
                <td>${ligne_com[2]}</td>
                <td class="text-end">${ligne_com[3]}</td>
                <td class="text-end">${(ligne_com[1] * ligne_com[3]).toFixed(2)}</td>
                <td class="action-column">
                    <button class="btn btn-sm btn-danger disabled_after_valid" onclick="suppr('${tab_com[i]}')">Supprimer</button>
                </td>
            `;

                    // Ajout de la ligne au tableau
                    tbody.appendChild(tr);
                }
            }
        }

        function suppr(ligne_s) {
            chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
            var tab_detail = ligne_s.split(';');

            total_commande.value = (total_commande.value - tab_detail[1] * tab_detail[3]).toFixed(2);
            total_com.value = total_commande.value;
            tot_com = total_com.value * 1;

            facture();
        }

    </script>


    <!-- jQuery -->
    <!
    <script src="js/jquery.min.js"></script>
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