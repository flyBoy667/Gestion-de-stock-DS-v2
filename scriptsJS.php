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
