<?php include('includes/header.php');
checkAdmin();
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
      <h3 class="card-title categorie-left"><button type="button" name="add" class="btn btn-primary btn-sm add" id="add"><i class="nav-icon fas fa-plus"></i> Ajouter</button> <button type="button" name="depensejour" class="btn btn-danger btn-sm depensejour" id="depensejour"> Denpense du jour</button></h3>
      <!--<h3 class="card-title categorie-right" align="right">
      	<button type="button" name="reaprovision_stock" class="btn btn-primary btn-sm add_stock new_sale" id="reaprovision_stock"><a href="nouvel_achat.php"><i class="nav-icon fas fa-plus"></i> Reaprovisionnement de stock</a></button>
      </h3>-->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
	    <div id="depense_data" class="table-responsive">
		</div>      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>   
<div id="depense_dialog" title="Add Data">
	<form method="post" id="depense_form">		
		<div class="form-group">
			<label>Motif</label>
			<input type="text" name="motif" id="motif" class="form-control" />
			<span id="error_motif" class="text-danger"></span>
		</div>			
		<div class="form-group">
			<label>Montant</label>
			<input type="text" name="montant" id="montant" class="form-control" />
			<span id="error_montant" class="text-danger"></span>
		</div>
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
<?php include('includes/footer.php');?>

<script>
$(document).ready(function(){

	load_data();
	function load_data()
	{
		$.ajax({
			url:"depense_fetch.php",
			method:"POST",
			success:function(data){
				$('#depense_data').html(data);
			}
		})
	}

	$('#depense_dialog').dialog({
		autoOpen: false,
		width:600
	});

	$('#add').click(function(){
		$('#depense_dialog').attr('title', 'Effectuer une dépense');
		$('#action').val('insert');
		$('#form_action').val("Ajouter");
		$('#depense_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$('#depense_dialog').dialog('open');
	});

	$('#depense_form').on('submit', function(event){
		event.preventDefault();
		var error_motif = '';
		var error_montant = '';
		
		if ($('#motif').val() == '') 
		{
			error_motif = 'Le motif de la depense est obligatoire';
			$('#error_motif').text(error_reference);
			$('#motif').css('border-color', '#cc0000');
		}
		else
		{
			error_motif = '';
			$('#error_motif').text(error_motif);
			$('#motif').css('border-color', '');
		}

		if ($('#montant').val() == '') 
		{
			error_montant = 'Le montant du produit obligatoire';
			$('#error_montant').text(error_montant);
			$('#montant').css('border-color', '#cc0000');
		}
		else
		{
			error_montant = '';
			$('#error_montant').text(error_montant);
			$('#montant').css('border-color', '');
		}

		if (error_motif != '' || error_montant !='') 
		{
			return false;
		}	
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/depense_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#depense_dialog').dialog('close');
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
			url:"action/depense_action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#motif').val(data.motif);
				$('#montant').val(data.montant);
				$('#depense_dialog').attr('title', 'Modifier depense');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#depense_dialog').dialog('open');
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
					url:"action/depense_action.php",
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