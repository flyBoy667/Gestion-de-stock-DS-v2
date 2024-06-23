<?php include ('includes/header.php');?>
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
</style>
<div class="col-md-6">
  <div class="card">
    <div class="card-header ">
      <h3 class="card-title categorie-left">Catégorie</h3>
      <h3 class="card-title categorie-right" align="right"><button type="button" name="new_categorie" class="btn btn-primary btn-sm add" id="new_categorie"><i class="nav-icon fas fa-plus" aria-hidden="true"></i> Ajouter</button></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    	<!-- Donnée table categorie -->
    	<div id="categorie_data">					
		</div>
    </div>
    <!-- /.card-body -->
   </div>
  <!-- /.card -->
</div>      
<div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title categorie-left">Marque</h3>
      <h3 class="card-title categorie-right" align="right"><button type="button" name="new_marque" class="btn btn-primary btn-sm add" id="new_marque"><i class="nav-icon fas fa-plus" aria-hidden="true"></i> Ajouter</button></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    	<div id="marque_data">
		</div>
    </div>
    <!-- /.card-body -->
   </div>
  <!-- /.card -->
</div>
<div id="categorie_dialog" title="Nouvelle categorie">
	<form method="post" id="categorie_form">
		<div class="form-group">
			<label>Catégorie</label>
			<input type="text" name="categorie" id="categorie" class="form-control" />
			<span id="error_categorie" class="text-danger"></span>
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
<div id="marque_dialog" title="Nouvelle marque">
		<form method="post" id="marque_form">
			<div class="form-group">
				<label>Marque</label>
				<input type="text" name="marque" id="marque" class="form-control" />
				<span id="error_marque" class="text-danger"></span>
			</div>
			<div class="form-group">				
				<input type="hidden" name="action_marque" id="action_marque" value="insert_marque" />		
				<input type="hidden" name="hidden_id_marque" id="hidden_id_marque" />	
				<input type="submit" name="form_action_marque" id="form_action_marque" class="btn btn-info" value="Ajouter marque" />	
			</div>
		</form>
</div>
<div id="alert_marque" title="Action"></div>
<div id="marque_delete_confirmation" title="Confirmation">
	<p>Êtes-vous sûr de vouloir supprimer ce marque?</p>
</div>
<?php include ('includes/footer.php') ?>
<!-- page script -->


<!-- Script categorie -->
<script>
$(document).ready(function(){
	load_data();
	function load_data()
	{
		$.ajax({
			url:"categorie_fetch.php",
			method:"POST",
			success:function(data){
				$('#categorie_data').html(data);
			}
		})
	}

	$('#categorie_dialog').dialog({
		autoOpen: false,
		width:500
	});

	$('#new_categorie').click(function(){
		$('#categorie_dialog').attr('title', 'Nouvelle categorie');
		$('#action').val('insert');
		$('#form_action').val("Ajouter");
		$('#categorie_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$('#categorie_dialog').dialog('open');
	});
	$('#categorie_form').on('submit', function(event){
		event.preventDefault();
		var error_categorie = '';
		if ($('#categorie').val() == '') 
		{
			error_categorie = 'Le categorie est obligatoire';
			$('#error_categorie').text(error_categorie);
			$('#categorie').css('border-color', '#cc0000');
		}
		else
		{
			error_categorie = '';
			$('#error_categorie').text(error_categorie);
			$('#categorie').css('border-color', '');
		}

		if (error_categorie != '') 
		{
			return false;
		}	
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/categorie_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#categorie_dialog').dialog('close');
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
			url:"action/categorie_action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#categorie').val(data.categorie);
				$('#categorie_dialog').attr('title', 'Mise à jour');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#categorie_dialog').dialog('open');
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
					url:"action/categorie_action.php",
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

<!-- Script marque -->
<script>
$(document).ready(function(){
	load_data();
	function load_data()
	{
		$.ajax({
			url:"marque_fetch.php",
			method:"POST",
			success:function(data){
				$('#marque_data').html(data);
			}
		})
	}

	$('#marque_dialog').dialog({
		autoOpen: false,
		widht:500
	});

	$('#new_marque').click(function(){
		$('#marque_dialog').attr('title', 'Nouvelle marque');
		$('#action_marque').val('insert_marque');
		$('#form_action_marque').val("Ajouter");
		$('#marque_form')[0].reset();
		$('#form_action_marque').attr('disabled', false);
		$('#marque_dialog').dialog('open');
	});
	$('#marque_form').on('submit', function(event){
		event.preventDefault();
		var error_marque = '';
		if ($('#marque').val() == '') 
		{
			error_marque = 'Le marque est obligatoire';
			$('#error_marque').text(error_marque);
			$('#marque').css('border-color', '#cc0000');
		}
		else
		{
			error_marque = '';
			$('#error_marque').text(error_marque);
			$('#marque').css('border-color', '');
		}

		if (error_marque != '') 
		{
			return false;
		}	
		else
		{
			$('#form_action_marque').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/marque_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#marque_dialog').dialog('close');
					$('#alert_marque').html(data);
					$('#alert_marque').dialog('open');
					load_data();
					$('#form_action_marque').attr('disabled', false);
				}
			});
		}	

	});

	$('#alert_marque').dialog({
		autoOpen:false
	});

	$(document).on('click', '.edit_marque', function(){
		var id = $(this).attr('id');
		var action_marque = 'fetch_marque';
		$.ajax({
			url:"action/marque_action.php",
			method:"POST",
			data:{id:id, action_marque:action_marque},
			dataType:"json",
			success:function(data)
			{
				$('#marque').val(data.marque);
				$('#marque_dialog').attr('title', 'Mise à jour');
				$('#action_marque').val('update_marque');
				$('#hidden_id_marque').val(id);
				$('#form_action_marque').val('Update');
				$('#marque_dialog').dialog('open');
			}
		});
	});

	$('#marque_delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action_marque = 'delete';
				$.ajax({
					url:"action/marque_action.php",
					method:"POST",
					data:{id:id, action_marque:action_marque},
					success:function(data)
					{
						$('#marque_delete_confirmation').dialog('close');
						$('#alert_marque').html(data);
						$('#alert_marque').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete_marque', function(){
		var id = $(this).attr("id");
		$('#marque_delete_confirmation').data('id', id).dialog('open');
	});	
});	
</script>


