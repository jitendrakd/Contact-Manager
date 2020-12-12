<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"  >
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"  ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"  ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script> 
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<style>
body {font-family: Arial;}
#example_wrapper{width:100%;}
table, th, td {
  border: 1px solid #402c2c5c;
}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.mt-2{
  margin-top:2%;
  margin-bottom:2%;
}
</style>
</head>
<body>
<div class="container">
<a href="<?php echo base_url('index.php/user_logout');?>" >  <button type="button" class="btn btn-primary mt-2">Logout</button></a>

<?php echo $this->session->userdata('user_name');
             $success_msg= $this->session->flashdata('success_msg');
              $error_msg= $this->session->flashdata('error_msg');

                  if($success_msg){
                    ?>
                    <div class="alert alert-success">
                      <?php echo $success_msg; ?>
                    </div>
                  <?php
                  }
                  if($error_msg){
                    ?>
                    <div class="alert alert-danger">
                      <?php echo $error_msg; ?>
                    </div>
                    <?php
                  }
                  ?>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Contact')">Create Contact</button>
  <button class="tablinks" onclick="openCity(event, 'ContactList')">Contact List</button>
  <button class="tablinks" onclick="openCity(event, 'ShareContact')">Share Contact</button>
</div>

<div id="Contact" class="tabcontent">
   
 <form role="form" method="post" action="<?php echo base_url('index.php/crudContact'); ?>">
	<fieldset>
		<div class="form-group"  >
			<input class="form-control" placeholder="First Name" name="contact_first_name" type="text" autofocus required="required">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Middle Name" name="contact_middle_name" type="text" value="">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Last Name" name="contact_last_name" type="text" value="" required="required">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Primary Phone" name="contact_primary_phone" title="Please enter only 10 digit" type="tel" pattern="[789][0-9]{9}" value="" required="required">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Secondary Phone" name="contact_secondary_phone" title="Please enter only 10 digit" type="tel" pattern="[789][0-9]{9}" value="" >
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Email" name="contact_email" type="email" value="" required="required">
		</div>
		<div class="form-group">
			<input class="form-control" placeholder="Profic Picture" name="contact_image" type="file" value="" >
		</div>


			<input class="btn btn-lg btn-success btn-block" type="submit" value="login" name="login" >

	</fieldset>
	</form>
</div>

<div id="ContactList" class="tabcontent">
  
  <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Primary Phone</th>
                <th>Secondary Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
		<?php  foreach($contacts as $row){ ?>
            <tr>
                <td><?php echo $row['contact_first_name']?></td>
                <td><?php echo $row['contact_middle_name']?></td>
                <td><?php echo $row['contact_last_name']?></td>
                <td><?php echo $row['contact_primary_phone']?></td>
                <td><?php echo $row['contact_secondary_phone']?></td>
                <td><?php echo $row['contact_email']?></td>
                <td><button type="button" class="btn btn-success ml-4"  data-toggle="modal" data-target="#exampleModal<?php echo $row['contact_id'];?>">Edit</button> 
                <button type="button" class="btn btn-success ml-4"  data-toggle="modal" data-target="#exampleModal1<?php echo $row['contact_id'];?>">Share</button> 
				<button class="btn btn-success ml-4" id="<?php echo $row['contact_id'];?>" onClick="exportContact(this.id)">Export</button> 
				<!-- Modal -->
				<div class="modal fade" id='exampleModal<?php echo $row['contact_id'];?>' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit Contact</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
					  <form method="post" action="<?php echo base_url('index.php/crudContact');?>">
						<input type="hidden" value="<?php echo $row['contact_id'];?>" name="contact_id"> 
						<fieldset>
							<div class="form-group"  >
								<input class="form-control" placeholder="First Name" value="<?php echo $row['contact_first_name'];?>" name="contact_first_name" type="text" autofocus required="required">
							</div>
							<div class="form-group">
								<input class="form-control" value="<?php echo $row['contact_middle_name'];?>" placeholder="Middle Name" name="contact_middle_name" type="text" value="">
							</div>
							<div class="form-group">
								<input class="form-control" value="<?php echo $row['contact_last_name'];?>"  placeholder="Last Name" name="contact_last_name" type="text" value="" required="required">
							</div>
							<div class="form-group">
								<input class="form-control" value="<?php echo $row['contact_primary_phone'];?>"  placeholder="Primary Phone" name="contact_primary_phone" title="Please enter only 10 digit" type="tel" pattern="[789][0-9]{9}" value="" required="required">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Secondary Phone" name="contact_secondary_phone" title="Please enter only 10 digit" value="<?php echo $row['contact_secondary_phone'];?>"  type="tel" pattern="[789][0-9]{9}" value="" >
							</div>
							<div class="form-group">
								<input class="form-control" value="<?php echo $row['contact_email'];?>"  placeholder="Email" name="contact_email" type="email" value="" required="required">
							</div>
							 
							<input class="btn btn-lg btn-success btn-block" type="submit" value="login" name="login" >

						</fieldset>
						</form> 
					</div>
				  </div>
				</div>
				<!--model for edit -->
				
				</div>
				<!-- Modal -->
				<div class="modal fade" id='exampleModal1<?php echo $row['contact_id'];?>' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Share Contact</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<table id="example" class="display" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($allUsers as $row1){ ?>
								<tr>
								   <?php if($this->session->userdata('user_id') != $row1['user_id']){?>
									<td><?php echo $row1['user_name'];?></td> 
									<td><button class="btn btn-info" id="<?php echo $row1['user_id'];?>" name="<?php echo $row['contact_id'];?>" onClick="shareContact(this.id,this.name)">Share</button></td>
								</tr>
								   <?php }}?>			
							</tbody> 
						</table>
					</div>
				  </div>
				</div>
				</div>
				<!--model for edit-->
            </tr> 
		<?php }?>	
        </tbody> 
    </table>
</div>

<div id="ShareContact" class="tabcontent">
  <h3>Share Contact</h3>
  <table id="example" class="display" style="width:100%">
	<thead>
		<tr>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Last Name</th>
			<th>Primary Phone</th>
			<th>Secondary Phone</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
		<?php  foreach($shareContact as $rowShare){ ?>
            <tr>
                <td><?php echo $rowShare['contact_first_name']?></td>
                <td><?php echo $rowShare['contact_middle_name']?></td>
                <td><?php echo $rowShare['contact_last_name']?></td>
                <td><?php echo $rowShare['contact_primary_phone']?></td>
                <td><?php echo $rowShare['contact_secondary_phone']?></td>
                <td><?php echo $rowShare['contact_email']?></td>
			</tr>
		<?php }?>	
	</tbody> 
</table>
</div>
</div>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
 <script>  
 function shareContact(id,name){ 
$.ajax({
	url: '<?php echo base_url('index.php/shareContact');?>',
	type:"POST",
	data:{ "share_id_to": id,"shared_contact":name},
	success: function(result){
	//location.reload();
    
	}});
}
 function exportContact(id){ 
$.ajax({
	url: '<?php echo base_url('index.php/linkvcard');?>',
	type:"POST",
	data:{ "contact_id": id},
	success: function(result){
	//location.reload();
    
	}});
}
 </script>  
</body>
</html> 
