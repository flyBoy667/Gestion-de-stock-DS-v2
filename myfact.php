<?php 
$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');
?>

<style type="text/css">
	.titre_h1
	{
		width:auto;
		display:block;
		height:auto;
		text-align:center;
		background-color:#EDEEEE;
		border:#666666 1px solid;
		padding-top:20px;
		padding-bottom:8px;
		padding-left: 10px;
		border:#3868e2 1px solid;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;		
	}
	.div_saut_ligne
	{
		width:100%;
		height:5px;
		display:inline-block;
	}
	.titre_h1
	{
		width:auto;
		display:block;
		height:auto;
		text-align:center;
		background-color:#EDEEEE;
		border:#666666 1px solid;
		padding-top:20px;
		padding-bottom:8px;
		border:#3868e2 5px inset;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;		
	}
	.suite
	{
		width:15%;
		height:25px;
		float:left;
		font-size:16px;
		font-weight:normal;
		text-align:left;
	}
	.bord
	{
		float:left;
		width:5%;
		height:25px;
	}
	.des
	{
		width:30%;
		height:25px;
		float:left;
		font-size:16px;
		font-weight:normal;
		text-align:left;
		overflow:hidden;
	}

	.prix
	{
		width:15%;
		height:25px;
		float:left;
		font-size:16px;
		font-weight:normal;
		text-align:right;
	}
	input,select{
		border-radius: 10px;
		text-align:center;
		padding-right: 10px; 
	}
</style>
<div class="app-main__outer">
	<div class="app-main__inner">
		<div class="main-card mb-3 card form-rounded">
			<div class="card-body">
			<script src="js/prototype.js" type="text/javascript"></script>	
			<script language='javascript' type="text/javascript">
				function recolter()
				{
					document.getElementById("formulaire").request({
						onComplete:function(transport){
							switch(document.getElementById('param').value)
							{
								case 'recup_client':
									var tab_info = transport.responseText.split('|');
									document.getElementById('civilite').value = tab_info[0];
									document.getElementById('nom_client').value = tab_info[1];
									document.getElementById('prenom_client').value = tab_info[2];			
								break;
								
								case 'recup_article':
									var tab_info = transport.responseText.split('|');
									document.getElementById('designation').value = tab_info[0];
									document.getElementById('puht').value = tab_info[1];
									document.getElementById('qte').value = tab_info[2];					
								break;
								
								case 'creer_client':
									var rep = transport.responseText;
									if(rep=="nok")
										alert("Le client existe déjà");
									else
									{
										var liste = document.getElementById("ref_client");
										var option = document.createElement("option");
										option.value = rep;
										option.text = rep;
										liste.add(option);
										liste.selectedIndex = liste.length-1;						
									}
								break;	

								case 'facturer':
									var reponse = transport.responseText;
									if(transport.responseText=="nok")
										alert("Une erreur est survenue");
									else
									{
										alert("La facture a été validée");
										document.getElementById("editer").innerHTML = "<input type='button' value='Editer la facture' onclick='window.open(\"edition.php?info=" + reponse + "\")' />";
									}	
										
								break;					
								
							}	
						}
					});
				}
			</script>
			<form id="formulaire" name="formulaire" method="post" action="action/add_facture.php">
				<div class="titre_h1" style="height:350px;">
					<div style="width:10%;height:50px;float:left;"></div>
					<div style="width:35%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
						<u>Informations du client</u><br />
					</div>
					<div style="width:10%;height:50px;float:left;"></div>
					<div style="width:35%;height:50px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						<input type="button" id="creer_client" name="creer_client" value="Créer le client" onclick="document.getElementById('param').value='creer_client';recolter();" />
					</div>
					<div style="width:10%;height:50px;float:left;"></div>

					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Réf. Client :<br />
						<select id="ref_client" name="ref_client" onchange="document.getElementById('param').value='recup_client';recolter();">
							<option value="0">Choisir client</option>
							<?php 
								$requete = "SELECT IdClient FROM clients ORDER BY IdClient;";
								$retours = mysqli_query($liaison, $requete);
								while($retour = mysqli_fetch_array($retours))
								{
									echo "<option value='".$retour["IdClient"]."'>".$retour["IdClient"]."</option>";
								}
							?>
						</select>
					</div>
					<div style="width:10%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Civilité :<br />
						<input type="text" id="civilite" name="civilite" />
					</div>
					
					<div style="width:10%;height:55px;float:left;"></div>
					<div style="width:6%;height:55px;float:left;"></div>
					<div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Nom du client :<br />
						<input type="text" id="nom_client" name="nom_client" />
					</div>
					<div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Prénom du client :<br />
						<input type="text" id="prenom_client" name="prenom_client" />
					</div>					
					

			<div class="div_saut_ligne" style="height:5px;">
			</div>

					<div style="width:10%;height:50px;float:left;"></div>
					<div style="width:80%;height:50px;float:left;font-size:20px;font-weight:bold;text-align:left;color:#a13638;">
						<u>Ajout des produits commandés</u><br />
					</div>
					<div style="width:10%;height:50px;float:left;"></div>	

					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Réf. Produit :<br />
						<select id="ref_produit" name="ref_produit" onchange="document.getElementById('param').value='recup_article';recolter();">
							<option value="0">Réf. produit</option>
							<?php 
								$requete = "SELECT id_produit FROM produit ORDER BY id_produit;";
								$retours = mysqli_query($liaison, $requete);
								while($retour = mysqli_fetch_array($retours))
								{
									echo "<option value='".$retour["id_produit"]."'>".$retour["id_produit"]."</option>";
								}							
							?>
						</select>
					</div>
					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Qté en stock :<br />
						<input type="text" id="qte" name="qte" disabled style="text-align:right;" />
					</div>
					<div style="width:10%;height:55px;float:left;"></div>
					<div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Désignation du produit :<br />
						<input type="text" id="designation" name="designation" disabled />
					</div>
					<div style="width:25%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Prix unitaire HT :<br />
						<input type="text" id="puht" name="puht" disabled style="text-align:right;" />
					</div>		
					<div style="width:10%;height:55px;float:left;"></div>				
	
			<div class="div_saut_ligne" style="height:30px;">
			</div>

					<div style="width:10%;height:55px;float:left;"></div>
					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;">
						Qté commandée :<br />
						<input type="text" id="qte_commande" name="qte_commande" />
					</div>
					<div style="width:10%;height:55px;float:left;"></div>	
					<div style="width:20%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;margin-top: -5px;">
						Total commande :<br />
					<h4>
						<input type="text" id="total_commande" name="total_commande" disabled style="color:#7f0c06;width:100%;font-family: Arial Black;"/>
					</h4>
					</div>
					<div style="width:10%;height:55px;float:left;"></div>
					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">
						<input type="button" id="ajouter" name="ajouter" value="Ajouter" style="margin-top:10px;" onclick="plus_com();" /><br />
						<input type="text" id="param" name="param" style="visibility:hidden;" />
					</div>
					<div style="width:15%;height:55px;float:left;font-size:16px;font-weight:bold;text-align:left;padding-top: 10px;">
						<input type="button" id="valider" name="valider" value="Valider" style="margin-top:10px;" onclick="document.getElementById('param').value='facturer';recolter();"/><br />
						<input type="text" id="chaine_com" name="chaine_com" style="visibility:hidden;" />
						<input type="text" id="total_com" name="total_com" style="visibility:hidden;" />						
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
							CH001
						</div>
						<div class="suite">
							125
						</div>
						<div class="des">
							Chemise
						</div>
						<div class="prix">
							125.25
						</div>
						<div class="prix" style="font-weight:bold;">
							1243.75
						</div>
						<div class="bord"></div>						
						
					</div>

					<div style="float:left;width: 5%;height:25px;"></div>
					<div style="float:left;width: 100%;height:auto;" id="editer"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script language='javascript' type="text/javascript">
	
	var tot_com = 0;
	
	function plus_com()
	{
		if(ref_client.value != 0 && ref_produit.value != 0 && qte_commande.value != "0" && qte_commande.value != "")
		{
			if(parseInt(qte_commande.value) > parseInt(qte.value))
				alert("La quantité en stock n'est pas suffisante pour honorer la commande");
			else
			{
				var ref_p = ref_produit.value;
				var qte_p = qte_commande.value;
				var des_p = designation.value;
				var pht_p = puht.value;
				
				tot_com = tot_com + qte_p*pht_p;
				total_commande.value = tot_com.toFixed(2);
				total_com.value = total_commande.value;
				chaine_com.value += "|" + ref_p + ";" + qte_p + ";" + des_p + ";" + pht_p;				
				facture();
			}
		}
	}
	
	function facture()
	{		
		var tab_com = chaine_com.value.split('|');
		var nb_lignes = tab_com.length;
		document.getElementById("det_com").innerHTML = "";
		for (ligne=0; ligne<nb_lignes; ligne++)
		{
			if(tab_com[ligne]!="")
			{
				var ligne_com = tab_com[ligne].split(';');
				document.getElementById("det_com").innerHTML += "<div class='bord'></div>";
				document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[0] + "</div>";
				document.getElementById("det_com").innerHTML += "<div class='suite'>" + ligne_com[1] + "</div>";
				document.getElementById("det_com").innerHTML += "<div class='des'>" + ligne_com[2] + "</div>";
				document.getElementById("det_com").innerHTML += "<div class='prix'>" + ligne_com[3] + "</div>";
				document.getElementById("det_com").innerHTML += "<div class='prix'>" + (ligne_com[1]*ligne_com[3]).toFixed(2) + "</div>";
				document.getElementById("det_com").innerHTML += "<div class='bord'><input type='button' value='X' title='Supprimer le produit' style='height:20px;font-size:12px;' onclick='suppr(\"" + tab_com[ligne] + "\");' /></div>";											
			}
		}		
	}
	
	function suppr(ligne_s)
	{
		chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
		var tab_detail = ligne_s.split(';');
		
		total_commande.value = (total_commande.value -tab_detail[1]*tab_detail[3]).toFixed(2);
		total_com.value = total_commande.value;
		tot_com = total_com.value*1;
		
		facture();
	}
	
</script>			
<?php 
	mysqli_close($liaison);
?>