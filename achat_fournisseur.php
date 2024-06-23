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

        input, select {
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
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Ajout nouvelle stock</h3>

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
                                            if (document.getElementById("paye").value == "" || (document.getElementById("paye").value < (document.getElementById("total_commande").value - document.getElementById("remise").value)) || (document.getElementById("paye").value > (document.getElementById("total_commande").value - document.getElementById("remise").value))) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Erreur',
                                                    text: 'La Somme a payé incorrect'
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success',
                                                    text: 'La facture a été validée'
                                                });
                                                document.getElementById("editer").innerHTML = "<input type='button' value='Voir la facture' onclick='window.open(\"ticket.php?id=" + reponse + "\")' />";
                                                document.getElementById("actualiser").innerHTML = "<input type='button' value='Nouvel achat' onclick='window.location.reload();' />";
                                                document.querySelectorAll(".disabled_after_valid").forEach((element) => {
                                                    element.disabled = true;
                                                });

                                            }
                                        }

                                        break;

                                }
                            }
                        });
                    }
                </script>
                <form id="formulaire" name="formulaire" method="post" action="action/add_achat_fournisseur.php">
                    <div class="titre_h1" style="height:350px;">
                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:35%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                            <u>Informations du fournisseur</u><br/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:35%;height:50px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            <input type="button" id="creer_fournisseur" name="creer_fournisseur" disabled
                                   value="Créer le fournisseur"
                                   onclick="document.getElementById('param').value='creer_fournisseur';recolter();"/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>

                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Réf. fournisseur :<br/>
                            <select id="ref_fournisseur" name="ref_fournisseur"
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
                        <div style="width:10%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Société :<br/>
                            <input type="text" id="societe" name="societe"/>
                        </div>

                        <div style="width:10%;height:55px;float:left;"></div>
                        <div style="width:6%;height:55px;float:left;"></div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Nom du fournisseur :<br/>
                            <input type="text" id="nom_fournisseur" name="nom_fournisseur"/>
                        </div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Prénom du fournisseur :<br/>
                            <input type="text" id="prenom_fournisseur" name="prenom_fournisseur"/>
                        </div>


                        <div style="width:10%;height:50px;float:left;"></div>
                        <div style="width:80%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
                            <u>Ajout des produits commandés</u><br/>
                        </div>
                        <div style="width:10%;height:50px;float:left;"></div>

                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Réf. Produit :<br/>
                            <select id="ref_produit" name="ref_produit"
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
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Qté en stock :<br/>
                            <input type="text" id="qte" name="qte" disabled style="text-align:right;"/>
                        </div>
                        <div style="width:10%;height:55px;float:left;"></div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Désignation du produit :<br/>
                            <input type="text" id="designation" name="designation" disabled/>
                        </div>
                        <div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Prix unitaire HT :<br/>
                            <input type="text" id="puht" name="puht" disabled style="text-align:right;"/>
                        </div>
                        <div style="width:10%;height:55px;float:left;"></div>

                        <div class="div_saut_ligne" style="height:2%;">
                        </div>

                        <div style="width:0;height:55px;float:left;"></div>
                        <div style="width:10%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                            Quantité:<br/>
                            <input type="text" id="qte_commande" name="qte_commande"/>
                        </div>
                        <div style="width:7%;height:55px;float:left;"></div>
                        <div style="width:20%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            Total commande :<br/>
                            <h4>
                                <input type="text" id="total_commande" name="total_commande" disabled
                                       style="color:#7f0c06;width:100%;font-family: Arial Black;"/>
                            </h4>
                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            Remise :<br/>
                            <input type="text" id="remise" name="remise" value="0" onchange="montan_a_payer();"/>
                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
                            Payé :<br/>
                            <input type="text" id="paye" name="paye"/>
                        </div>
                        <div style="width:3%;height:55px;float:left;"></div>
                        <div style="width:7%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">
                            <input type="button" id="ajouter" name="ajouter" class="disabled_after_valid" value="Ajouter" style="margin-top:10px;"
                                   onclick="plus_com();"/><br/>
                            <input type="text" id="param" name="param" style="visibility:hidden;"/>
                        </div>
                        <div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">
                            <input type="button" id="valider" name="valider" value="Valider" style="margin-top:10px;"
                                   onclick="document.getElementById('param').value='facturer';recolter();"/><br/>
                            <input type="text" id="chaine_com" name="chaine_com" style="visibility:hidden;"/>
                            <input type="text" id="total_com" name="total_com" style="visibility:hidden;"/>
                        </div>
                    </div>
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
                            document.getElementById("det_com").innerHTML += "<div class='bord'><input type='button' value='X' title='Supprimer le produit' class='disabled_after_valid' style='height:20px;font-size:12px;' onclick='suppr(\"" + tab_com[ligne] + "\");' /></div>";
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
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

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