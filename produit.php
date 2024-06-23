<?php 
//connexion a la base de donnée
include('includes/db_connexion.php');

//Selction de la liste des categorie
$categorie ="SELECT * FROM categorie";
$categorie_statement = $connect->prepare($categorie);
$categorie_statement->execute();
$result_categorie = $categorie_statement->fetchAll();
$total_categorie = $categorie_statement->rowCount();

//Selection de la liste des marques
$marque ="SELECT * FROM marque";
$marque_result = $connect->prepare($marque);
$marque_result->execute();
$result_marque = $marque_result->fetchAll();
$total_marque = $marque_result->rowCount();

include('includes/header.php');
?>
<style type="text/css">
  .categorie-left{
    width: 50%;
    float: left;
  }
  .categorie-right{
    width: 50%;
    float: right;
  }
  .panel-h{
    color: #fff!important;
      background-color: green!important;
      border-color: #ddd;
      height: 41px;
  }
  .new_sale a{
    color: #FFF;
  }
  .new_sale a:hover{
    color: #FFF;
  }
</style>
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title categorie-left"><button type="button" name="add" class="btn btn-primary btn-sm add" id="add"><i class="nav-icon fas fa-plus"></i> Ajouter</button></h3>
      <h3 class="card-title categorie-right" align="right">
      	<button type="button" name="reaprovision_stock" class="btn btn-primary btn-sm add_stock new_sale" id="reaprovision_stock"><a href="nouvel_achat.php"><i class="nav-icon fas fa-plus"></i> Reaprovisionnement de stock</a></button>
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
					<label>Categorie</label>
					<select class="form-control" type="text" id="categorie" name="categorie">
						<option>Selectionnez</option>
						<?php if ($total_categorie > 0){
							foreach ($result_categorie as $row_categorie){?>
						<option value="<?php echo $row_categorie["id_categorie"];?>"><?php echo $row_categorie["categorie"]?></option>
						<?php }}?>
					</select>
					<span id="error_categorie" class="text-danger"></span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Marque</label>
					<select class="form-control" type="text" id="marque" name="marque">
						<option>Selectionnez</option>
						<?php if ($total_marque > 0){
							foreach ($result_marque as $row_marque){?>
						<option value="<?php echo $row_marque["id_marque"];?>"><?php echo $row_marque["marque"];?></option>
						<?php }}?>
					</select>
					<span id="error_marque" class="text-danger"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Code produit</label>
					<input type="text" name="code" id="code" class="form-control" />
					<span id="error_code" class="text-danger"></span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Nom produit</label>
					<input type="text" name="nom" id="nom" class="form-control" />
					<span id="error_nom" class="text-danger"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Prix d'achat</label>
					<input type="text" name="pa" id="pa" class="form-control" />
					<span id="error_pa" class="text-danger"></span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Prix de vente</label>
					<input type="text" name="pv" id="pv" class="form-control" />
					<span id="error_pv" class="text-danger"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Stock</label>
					<input type="text" name="stock" id="stock" class="form-control" />
					<span id="error_stock" class="text-danger"></span>
				</div>	
			</div>	
			<div class="col-sm-6">	
				<div class="form-group">
					<label>Statut</label>
					<select class="form-control" type="text" id="statut" name="statut">
						<option value="">Selectionnez</option>				
						<option value="1">Actif</option>
						<option value="2">Inactif</option>
						<span id="error_statut" class="text-danger"></span>
					</select>
				</div>	
			</div>
		</div>

		<!--<div class="row">	
			<div class="col-sm-6">	
				<div class="form-group">
					<label>Image</label>
					<input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpeg"/>
				</div>	
			</div>
		</div>-->
		<div class="form-group">				
			<input type="hidden" name="action" id="action" value="insert" />		
			<input type="hidden" name="hidden_id" id="hidden_id" />	
			<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Ajouter" />	
		</div>
	</form>
</div>

<div id="action_alert" title="Action">

</div>

<div id="delete_confirmation" title="Confirmation">
	<p>Êtes-vous sûr de vouloir supprimer ces données?</p>
</div>

<div id="actuprix_dialog" title="Mise à jour des prix">
	<form method="post" id="actuliser_prix">		
		<div class="form-group">
			<label>Nom produit</label>
			<input type="text" name="actu_nom" id="actu_nom" class="form-control" />
			<span id="error_actu_nom" class="text-danger"></span>
		</div>
		<div class="form-group">
			<label>Prix d'achat</label>
			<input type="text" name="actu_pa" id="actu_pa" class="form-control" />
			<span id="error_actu_pa" class="text-danger"></span>
		</div>
		<div class="form-group">
			<label>Prix de vente</label>
			<input type="text" name="actu_pv" id="actu_pv" class="form-control" />
			<span id="error_actu_pv" class="text-danger"></span>
		</div>			
		<div class="form-group">				
			<input type="hidden" name="action" id="action" value="maj" />		
			<input type="hidden" name="hidden_id_maj" id="hidden_id_maj" />	
			<input type="submit" name="form_action_maj" id="form_action_maj" class="btn btn-info" value="Ajouter" />	
		</div>
	</form>
</div>

<?php include('includes/footer.php');?>

<script>
$(document).ready(function(){

	load_data();
	function load_data()
	{
		$.ajax({
			url:"produit_fetch.php",
			method:"POST",
			success:function(data){
				$('#produit_data').html(data);
			}
		})
	}

	$('#produit_dialog').dialog({
		autoOpen: false,
		width:600
	});

	$('#add').click(function(){
		$('#produit_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val("Ajouter");
		$('#article_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$('#produit_dialog').dialog('open');
	});

	$('#article_form').on('submit', function(event){
		event.preventDefault();
        let error_code = '';
        let error_nom = '';
        let error_categorie = '';
        let error_marque = '';
        let error_pv = '';
        let error_pa = '';
        let error_statut = '';
        if ($('#code').val() === '')
		{
			error_code = 'Le code produit obligatoire';
			$('#error_code').text(error_reference);
			$('#code').css('border-color', '#cc0000');
		}
		else
		{
			error_code = '';
			$('#error_code').text(error_code);
			$('#code').css('border-color', '');
		}

		if ($('#nom').val() === '')
		{
			error_nom = 'Le nom du produit obligatoire';
			$('#error_nom').text(error_nom);
			$('#nom').css('border-color', '#cc0000');
		}
		else
		{
			error_nom = '';
			$('#error_nom').text(error_nom);
			$('#nom').css('border-color', '');
		}

		if ($('#categorie').val() === '')
		{
			error_categorie= 'Le categorie est obligatoire';
			$('#error_categorie').text(error_categorie);
			$('#categorie').css('border-color', '#cc0000');
		}
		else
		{
			error_categorie = '';
			$('#error_categorie').text(error_categorie);
			$('#categorie').css('border-color', '');
		}

		if ($('#pa').val() == '') 
		{
			error_pa= 'Le prix d achat obligatoire';
			$('#error_pa').text(error_pa);
			$('#pa').css('border-color', '#cc0000');
		}
		else
		{
			error_pa = '';
			$('#error_pa').text(error_pa);
			$('#pa').css('border-color', '');
		}

		if ($('#marque').val() == '') 
		{
			error_marque= 'Le marque est obligatoire';
			$('#error_marque').text(error_marque);
			$('#marque').css('border-color', '#cc0000');
		}
		else
		{
			error_marque = '';
			$('#error_marque').text(error_marque);
			$('#marque').css('border-color', '');
		}

		if ($('#pv').val() == '') 
		{
			error_pv= 'Le prix de vente obligatoire';
			$('#error_pv').text(error_pv);
			$('#pv').css('border-color', '#cc0000');
		}
		else
		{
			error_pv = '';
			$('#error_pv').text(error_pv);
			$('#pv').css('border-color', '');
		}

		if ($('#statut').val() == '') 
		{
			error_statut= 'Le statut est obligatoire';
			$('#error_statut').text(error_statut);
			$('#statut').css('border-color', '#cc0000');
		}
		else
		{
			error_statut= '';
			$('#error_statut').text(error_statut);
			$('#statut').css('border-color', '');
		}

		if (error_code != '' || error_nom !='' || error_marque != '' || error_pv != '' || error_categorie != '' || error_pa != '' || error_statut !='') 
		{
			return false;
		}	
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/produit_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
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
		autoOpen:false
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action/produit_action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#code').val(data.code_produit);
				$('#nom').val(data.nom_produit);
				$('#categorie').val(data.categorie);
				$('#marque').val(data.marque);
				$('#pa').val(data.prix_achat);
				$('#pv').val(data.prix_vente);
				$('#stock').val(data.stock);
				$('#statut').val(data.statut);
				$('#produit_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#produit_dialog').dialog('open');
			}
		});
	});


	$('#actuprix_dialog').dialog({
		autoOpen: false,
		width:600
	});

	$('#actuliser_prix').on('submit', function(event){
		event.preventDefault();
		
		var error_actu_nom = '';		
		var error_actu_pv = '';
		var error_actu_pa = '';				

		if ($('#actu_nom').val() == '') 
		{
			error_actu_nom = 'Le nom du produit obligatoire';
			$('#error_actu_nom').text(error_actu_nom);
			$('#actu_nom').css('border-color', '#cc0000');
		}
		else
		{
			error_actu_nom = '';
			$('#error_actu_nom').text(error_actu_nom);
			$('#actu_nom').css('border-color', '');
		}

		if ($('#actu_pa').val() == '') 
		{
			error_actu_pa= 'Le prix d achat obligatoire';
			$('#error_actu_pa').text(error_actu_pa);
			$('#actu_pa').css('border-color', '#cc0000');
		}
		else
		{
			error_actu_pa = '';
			$('#error_actu_pa').text(error_actu_pa);
			$('#actu_pa').css('border-color', '');
		}

		if ($('#actu_pv').val() == '') 
		{
			error_actu_pv= 'Le prix de vente obligatoire';
			$('#error_actu_pv').text(error_actu_pv);
			$('#actu_pv').css('border-color', '#cc0000');
		}
		else
		{
			error_actu_pv = '';
			$('#error_actu_pv').text(error_actu_pv);
			$('#actu_pv').css('border-color', '');
		}
		if ( error_actu_nom !='' || error_actu_pv != '' || error_actu_pa != '') 
		{
			return false;
		}	
		else
		{
			$('#form_action_maj').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/produit_action.php",
				method:"POST",
				mimeType:"multipart/form-data",
				data:form_data,
				success:function(data)
				{
					$('#actuprix_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action_maj').attr('disabled', false);
				}
			});
		}	

	});

	$(document).on('click', '.actu_prix', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single_maj';
		$.ajax({
			url:"action/produit_action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#actu_nom').val(data.nom_produit);
				$('#actu_pa').val(data.prix_achat);
				$('#actu_pv').val(data.prix_vente);
				$('#actuprix_dialog').attr('title', 'Mise à jour des prix');
				$('#action').val('maj');
				$('#hidden_id_maj').val(id);
				$('#form_action_maj').val('Mise à jour');
				$('#actuprix_dialog').dialog('open');
			}
		});
	});

	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url:"action/produit_action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});
	
});	
</script>