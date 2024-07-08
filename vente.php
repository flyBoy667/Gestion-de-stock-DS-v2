<?php

$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');


include('includes/header.php');

?>
    <!--    <style type="text/css">-->
    <!--        .titre_h1 {-->
    <!--            width: auto;-->
    <!--            display: block;-->
    <!--            height: auto;-->
    <!--            text-align: center;-->
    <!--            background-color: #EDEEEE;-->
    <!--            border: #666666 1px solid;-->
    <!--            padding-top: 20px;-->
    <!--            padding-bottom: 8px;-->
    <!--            padding-left: 10px;-->
    <!--            border: #3868e2 1px solid;-->
    <!--            -moz-border-radius: 5px;-->
    <!--            -webkit-border-radius: 5px;-->
    <!--        }-->
    <!---->
    <!--        .div_saut_ligne {-->
    <!--            width: 100%;-->
    <!--            height: 5px;-->
    <!--            display: inline-block;-->
    <!--        }-->
    <!---->
    <!--        .titre_h1 {-->
    <!--            width: auto;-->
    <!--            display: block;-->
    <!--            height: auto;-->
    <!--            text-align: center;-->
    <!--            background-color: #EDEEEE;-->
    <!--            border: #666666 1px solid;-->
    <!--            padding-top: 20px;-->
    <!--            padding-bottom: 8px;-->
    <!--            border: #3868e2 5px inset;-->
    <!--            -moz-border-radius: 5px;-->
    <!--            -webkit-border-radius: 5px;-->
    <!--        }-->
    <!---->
    <!--        .suite {-->
    <!--            width: 15%;-->
    <!--            height: 25px;-->
    <!--            float: left;-->
    <!--            font-size: 16px;-->
    <!--            font-weight: normal;-->
    <!--            text-align: left;-->
    <!--        }-->
    <!---->
    <!--        .bord {-->
    <!--            float: left;-->
    <!--            width: 5%;-->
    <!--            height: 25px;-->
    <!--        }-->
    <!---->
    <!--        .des {-->
    <!--            width: 30%;-->
    <!--            height: 25px;-->
    <!--            float: left;-->
    <!--            font-size: 16px;-->
    <!--            font-weight: normal;-->
    <!--            text-align: left;-->
    <!--            overflow: hidden;-->
    <!--        }-->
    <!---->
    <!--        .prix {-->
    <!--            width: 15%;-->
    <!--            height: 25px;-->
    <!--            float: left;-->
    <!--            font-size: 16px;-->
    <!--            font-weight: normal;-->
    <!--            text-align: right;-->
    <!--        }-->
    <!---->
    <!--        input,-->
    <!--        select {-->
    <!--            border-radius: 10px;-->
    <!--            text-align: center;-->
    <!--            padding-right: 10px;-->
    <!--        }-->
    <!--    </style>-->
    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered th {
            background-color: #007bff;
            color: #fff;
        }

        .table-bordered td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table-bordered .action-column {
            text-align: center;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 10px 20px;
        }

        .card-title {
            margin: 0;
        }

        .client-info-section, .product-info-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .btn-action {
            margin-left: 10px;
        }

        .btn-action.disabled_after_valid:disabled {
            cursor: not-allowed;
        }

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
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Créer un nouveau client</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
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

                                            if (reponse === "somme_error") {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Erreur',
                                                    text: 'La Somme à payer est incorrecte'
                                                });
                                                return;
                                            }

                                            if (paye < total_commande) {
                                                const dette = total_commande - paye
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Succès',
                                                    text: `La facture a été validée avec une dette de ${dette} FCFA`
                                                });
                                            }
                                            let validateText = "La facture a été validée"
                                            if (paye < total_commande) {
                                                let dette = total_commande - paye
                                                validateText += ` avec une dette de ${dette} FCFA`
                                                console.log(dette)
                                            }
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Succès',
                                                text: validateText
                                            });

                                            // Affichage des boutons stylisés et centrés après validation
                                            document.getElementById("editer").innerHTML = "<div class='text-center'><input type='button' class='btn btn-facture mx-auto' value='Voir la facture' onclick='window.open(\"ticket.php?id=" + reponse + "\")' /></div>";
                                            document.getElementById("actualiser").innerHTML = "<div class='text-center'><input type='button' class='btn btn-nouvelle-vente mx-auto' value='Nouvelle vente' onclick='window.location.reload();' /></div>";

                                            // Désactivation des éléments après validation
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
                    <!-- Section pour les informations du client -->
                    <div class="mb-4">
                        <h4 class="text-secondary"><u>Informations du client</u></h4>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ref_client" class="form-label">Réf. Client :</label>
                            <select id="ref_client" name="ref_client" class="form-select"
                                    onchange="document.getElementById('param').value='recup_client';recolter();">
                                <option value="0">Choisir un client</option>
                                <?php
                                $requete = "SELECT IdClient, Prenom, Nom FROM clients ORDER BY IdClient;";
                                $retours = mysqli_query($liaison, $requete);
                                while ($retour = mysqli_fetch_array($retours)) {
                                    echo "<option value='" . $retour["IdClient"] . "'>" . $retour["IdClient"] . " - " . $retour["Prenom"] . " " . $retour["Nom"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="civilite" class="form-label">Civilité :</label>
                            <select id="civilite" name="civilite" class="form-select">
                                <option value="0">Sélectionner la civilité</option>
                                <option value="Mr">Mr</option>
                                <option value="Mme">Mme</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom_client" class="form-label">Nom du client :</label>
                            <input type="text" id="nom_client" name="nom_client" class="form-control"
                                   placeholder="Entrez le nom du client">
                        </div>
                        <div class="col-md-6">
                            <label for="prenom_client" class="form-label">Prénom du client :</label>
                            <input type="text" id="prenom_client" name="prenom_client" class="form-control"
                                   placeholder="Entrez le prénom du client">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="creer_client" name="creer_client"
                                class="btn btn-outline-primary btn-action" disabled
                                onclick="document.getElementById('param').value='creer_client';recolter();">
                            Créer le client
                        </button>
                    </div>

                    <!-- Section pour les informations du produit -->
                    <div class="mb-4">
                        <h4 class="text-secondary"><u>Informations du produit</u></h4>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="ref_produit" class="form-label">Réf. Produit :</label>
                            <select id="ref_produit" name="ref_produit" class="form-select"
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
                        <div class="col-md-2">
                            <label for="qte" class="form-label">Qté en stock :</label>
                            <input type="text" id="qte" name="qte" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="designation" class="form-label">Désignation du produit :</label>
                            <input type="text" id="designation" name="designation" class="form-control" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="puht" class="form-label">Prix unitaire HT :</label>
                            <input type="text" id="puht" name="puht" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="qte_commande" class="form-label">Quantité :</label>
                            <input type="number" id="qte_commande" name="qte_commande" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="total_commande" class="form-label">Total commande :</label>
                            <input type="text" id="total_commande" name="total_commande" class="form-control"
                                   disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="remise" class="form-label">Remise :</label>
                            <input type="text" id="remise" name="remise" value="0" class="form-control"
                                   onchange="montant_a_payer()">
                        </div>
                        <div class="col-md-2">
                            <label for="paye" class="form-label">Payé :</label>
                            <input type="number" id="paye" name="paye" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" id="ajouter" name="ajouter"
                                    class="btn btn-outline-success btn-action disabled_after_valid"
                                    onclick="plus_com()">Ajouter
                            </button>
                            <button type="button" id="valider" name="valider"
                                    class="btn btn-outline-primary btn-action disabled_after_valid" disabled
                                    onclick="document.getElementById('param').value='facturer';recolter();">Valider
                            </button>
                            <input type="hidden" id="param" name="param" value="">
                            <input type="hidden" id="chaine_com" name="chaine_com">
                            <input type="hidden" id="total_com" name="total_com">
                        </div>
                    </div>

                    <input type="hidden" id="Adresse" name="Adresse">
                    <input type="hidden" id="Tel" name="Tel">
                    <input type="hidden" id="qr" name="qr">
                    <input type="button" id="qr_btn" name="qr_btn" value="Scanner code barre"
                           class="btn btn-primary">

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="text-center mb-3">
                                <h4>Récapitulatif de la commande</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-info text-white">
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
                                    <!-- Dynamically populated content -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <div id="editer"></div>
                                <div id="actualiser"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

            document.getElementById("ref_produit").value = tab_detail[0]
            articles[tab_detail[0]][2] = articles[tab_detail[0]][2] + tab_detail[1] * 1
            qte.value = articles[tab_detail[0]][2]

            facture();
        }
    </script>

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