<?php 
include ('includes/header.php');
include('includes/db_connexion.php');
$query ="SELECT * FROM system_group";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
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
</style>
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title categorie-left">Liste des Utilisateurs</h3>
      <h3 class="card-title categorie-right" align="right">
      	<button type="button" name="add" class="btn btn-primary btn-sm add" id="add"><i class="nav-icon fas fa-plus"></i> Ajouter</button>
      </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
	    <div id="user_data" class="table-responsive">
		</div>      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>     
<div id="user_dialog" title="Add Data">
		<form method="post" id="user_form">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Saisissez le Nom</label>
						<input type="text" name="nom" id="nom" class="form-control" />
						<span id="error_nom" class="text-danger"></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Saisissez le Prenom</label>
						<input type="text" name="prenom" id="prenom" class="form-control" />
						<span id="error_prenom" class="text-danger"></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Adresse mail</label>
				<input type="text" name="email" id="email" class="form-control" />
				<span id="error_email" class="text-danger"></span>
			</div>
			<div class="form-group">
				<label>Saisissez le login</label>
				<input type="text" name="login" id="login" class="form-control" />
				<span id="error_login" class="text-danger"></span>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Mot de passe</label>
						<input type="text" name="password" id="password" class="form-control" />
						<span id="password_err" class="text-danger"></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Saisissez a nouveau</label>
						<input type="text" name="confirm_password" id="confirm_password" class="form-control" />
						<span id="confirm_password_err" class="text-danger"></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Selectionner groupe</label>
				<select class="form-control" type="text" id="role" name="role">
					<option value="">Selectionnez</option>
					<?php if ($total_row > 0){
						foreach ($result as $row){?>
					<option value="<?php echo $row["id_group"];?>"><?php echo $row["name"]."-".$row["id_group"];?></option>
					<?php }}?>
				</select>
				<span id="error_role" class="text-danger"></span>
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
<?php include ('includes/footer.php') ?>
<script>
$(document).ready(function(){

	load_data();
	function load_data()
	{
		$.ajax({
			url:"user_fetch.php",
			method:"POST",
			success:function(data){
				$('#user_data').html(data);
			}
		})
	}

	$("#user_dialog").dialog({
		autoOpen: false,
		width:600
	});

	$("#add").click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val("Ajouter");
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$('#user_dialog').dialog('open');
	});

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_nom = '';
		var error_prenom = '';
		var error_login = '';
		var error_role = '';
		
		if ($('#nom').val() == '') 
		{
			error_nom = 'Le nom est obligatoire';
			$('#error_nom').text(error_nom);
			$('#nom').css('border-color', '#cc0000');
		}
		else
		{
			error_nom = '';
			$('#error_nom').text(error_nom);
			$('#nom').css('border-color', '');
		}

		if ($('#prenom').val() == '') 
		{
			error_prenom = 'Le prenom est obligatoire';
			$('#error_prenom').text(error_prenom);
			$('#prenom').css('border-color', '#cc0000');
		}
		else
		{
			error_prenom = '';
			$('#error_prenom').text(error_prenom);
			$('#prenom').css('border-color', '');
		}

		if ($('#login').val() == '') 
		{
			error_login= 'Le login est obligatoire';
			$('#error_login').text(error_login);
			$('#login').css('border-color', '#cc0000');
		}
		else
		{
			error_login = '';
			$('#error_login').text(error_login);
			$('#login').css('border-color', '');
		}
		if ($('#role').val() == '') 
		{
			error_role= 'Le group est obligatoire';
			$('#error_role').text(error_role);
			$('#role').css('border-color', '#cc0000');
		}
		else
		{
			error_role = '';
			$('#error_role').text(error_role);
			$('#role').css('border-color', '');
		}

		if (error_nom != '' || error_prenom !='' || error_login != '' || error_role != '') 
		{
			return false;
		}	
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action/action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
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
			url:"action/action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#nom').val(data.nom);
				$('#prenom').val(data.prenom);
				$('#login').val(data.login);
				$('#role').val(data.role);
				$('#email').val(data.email);
				$('#password').val(data.password);
				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
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
					url:"action/action.php",
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