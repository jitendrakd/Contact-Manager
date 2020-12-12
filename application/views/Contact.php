<html>
<head>

 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"  >
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"  ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"  ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script> 
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
		 
} );

/* function stateFilter($state)
	{ 
		$.ajax({
	url: '<?php echo base_url('index.php/stateFilter');?>',
	type:"POST",
	data:{ "state": $state},
	dataType : 'json',
	success: function(result){
	 {
                $.each(result, function(index, val) {
                    $("#table").find('tbody').append("<tr><td>"+val.id+"</td><td>"+val.state_name+"</td><td>"+val.city_name+"</td><td><button></td></tr>");
                });
            }
	}});
	} */
	
function deleteState(id){
	var result = confirm("Are you sure to delete?");
    if(result){ 
$.ajax({
	url: '<?php echo base_url('index.php/deleteState');?>',
	type:"POST",
	data:{ "id": id},
	success: function(result){
	location.reload();
    
	}});}
}
function deleteCity(id){
	var result = confirm("Are you sure to delete?");
    if(result){ 
$.ajax({
	url: '<?php echo base_url('index.php/deleteCity');?>',
	type:"POST",
	data:{ "id": id},
	success: function(result){
	location.reload();
    
	}});}
}
</script>
<style>
#example_wrapper{width:100%;}
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>
<div class="container">
<div class="row">
<!--<button class="btn btn-primary " name="State Management" value="" onClick="stateM();">State Management</button> 
<button class="btn btn-primary  ml-2" name="Add City" value="">Add City</button> 
<button class="btn btn-primary ml-2" name="City Management" value="">City Management</button> -->
</div>
<h3 align="center">State Management</h3>
<div class="row">   
<table id="example" class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th>S.no</th>
                <th>State Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
			<?php $count=1; foreach($data as $resultRow) {?>
			<tr>
                <td><?php echo $count;?></td> 
                <td><?php echo $resultRow['state_name'];?></td> 
                <td><button type="button" class="btn btn-success ml-4"  data-toggle="modal" data-target="#exampleModal<?php echo $resultRow['id'];?>">Edit</button>
				<button type="button" class="btn btn-success" value="<?php echo $resultRow['id'];?>" onClick="deleteState(this.value)">Delete</button></td>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal<?php echo $resultRow['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
					  <form method="post" action="<?php echo base_url('index.php/editState');?>">
						<input type="hidden" value="<?php echo $resultRow['id'];?>" name="id">
						<input type="text" value="<?php echo $resultRow['state_name'];?>" name="state">
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					  </div>
					</form>  
					</div>
				  </div>
				</div>
				<!--model for edit state -->
			</tr>
			<?php $count++;}?>
             
        </tbody> 
</table>
<p></p>  
</div>	
<div class="row">
<h3 align="center">Add City</h3>
<table class="table">
  <thead>
    <tr>
      <th colspan="2" scope="col">Add City</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Select State</th>
      <td>
		<form method="post" action="<?php echo base_url('index.php/addCity');?>">
	    <select class="form-control form-control-sm" name="state_name">
	    <?php foreach($data as $resultRow) {?>
	     <option value="<?php echo $resultRow['state_name'];?>"><?php echo $resultRow['state_name'];?></option>
		<?php }?>
		</select> 
	  </td> 
    </tr>
    <tr>
      <th scope="row">Enter city Name</th>
      <td>
	  <input type="text" name="city_name" ></td>
       
    </tr>
    <tr>
      <th scope="row"><button type="submit" align="right" class="btn btn-primary">Submit</button></th>
	  </form>
      <td><button type="button" class="btn btn-primary">Cancel</button></td>
      
    </tr>
  </tbody>
</table>
</div>
<div class="row">
<h3 align="center">City Management</h3>
<table class="table" id="table">
 <thead>
    <tr>
      <th colspan="2" scope="col">City Management</th>
      <th colspan="2" scope="col">Select State
	  <form method="post" action="<?php echo base_url('index.php/stateFilter');?>">
	  <select class="form-control form-control-sm" name="state_name" id="selectedState">
	    <option>--Select State--</option>
	    <?php foreach($data as $resultRow) {?>
	     <option value="<?php echo $resultRow['state_name'];?>"><?php echo $resultRow['state_name'];?></option>
		<?php }?>
		</select> 
	  <button type="submit" align="right" class="btn btn-primary">Submit</button>
	  </form>
	  </th>
    </tr>
  </thead>
  <tbody>
 <tr>
  <th>S.No</th>
  <th>State Name</th>
  <th>City Name</th>
  <th>Action</th>
 </tr>
 	<?php 
	 
	   if(isset($cityInfo)){
		  
		$cityCount = 1;	
	    foreach($cityInfo as $cityRow) {?>
	     <tr>
		 <td><?php echo $cityCount;?></td>
		 <td><?php echo $cityRow['state_name'];?></td>
		 <td><?php echo $cityRow['city_name'];?></td>
		<td><button type="button" class="btn btn-success ml-4"  data-toggle="modal" data-target="#exampleModal<?php echo $cityRow['id'];?>">Edit</button>
				<button type="button" class="btn btn-success" value="<?php echo $cityRow['id'];?>" onClick="deleteCity(this.value)">Delete</button></td>
				<!-- Modal -->
				<div class="modal fade" id="exampleModal<?php echo $cityRow['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
					  <form method="post" action="<?php echo base_url('index.php/editCity');?>">
						<input type="hidden" value="<?php echo $cityRow['id'];?>" name="id">
						<input type="text" value="<?php echo $cityRow['city_name'];?>" name="city_name">
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					  </div>
					</form>  
					</div>
				  </div>
				</div>
				<!--model for edit state -->
		 </tr>
		 
	   <?php $cityCount++;}}?>
</tbody>
</table>
</div>
</body>

</html>