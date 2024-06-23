function recolter()
	{
		document.getElementById("formulaire").request({
			onComplete:function(transport){
				if(document.getElementById('tampon').value==='recup')
				{
					var tab_info = transport.responseText.split('|');
					document.getElementById('des_produit').value = tab_info[0];
					document.getElementById('qte_produit_avt').value = tab_info[1];
					document.getElementById('qte_produit_aps').value = "";
					document.getElementById('qte_produit').value = "";
				}
				else
				{
					if(transport.responseText==="ok")
					{
						document.getElementById('qte_produit_aps').value= parseInt(document.getElementById('qte_produit_avt').value) + parseInt(document.getElementById('qte_produit').value);
						document.getElementById('msg_reponse').innerText = "Le stock a été mis à jour avec succès";
					}
					else
						document.getElementById('msg_reponse').innerText = "Une erreur est survenue, le stock est inchangé";
				}
			}
		});
	}