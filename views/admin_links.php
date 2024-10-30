<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Links <?php 
	$add = add_query_arg(
	    array_merge(
	        $queryArgs,
	        array(
	            'action' => 'addLinks'
	        )
	    ),
	    $baseUrl
	);
 ?>
<a class="add-new-h2" href="<?php echo $add; ?>">Add New</a></h2>


<table class="wp-list-table widefat" style="width:100%">
<thead>
	<tr>
		<th>Sno</th>
		<th>Links</th>
		<th>Target</th>
		<th>Case Sensitive</th>
		<th>Actions</th>
	</tr>
</thead>	
<?php
$count = 0;
 foreach($results as $key=>$result): 

 	$edit = add_query_arg(
 	    array_merge(
 	        $queryArgs,
 	        array(
 	            'action' => 'edit',
 	            'id' => $key
 	        )
 	    ),
 	    $baseUrl
 	);

 	$delete = add_query_arg(
 	    array_merge(
 	        $queryArgs,
 	        array(
 	            'action' => 'delete',
 	            'id' => $key
 	        )
 	    ),
 	    $baseUrl
 	);

 	?>
	<tr>
		<td><?php echo ++$count; ?></td>
		<td><?php echo $result['link']; ?></td>
		<td><?php echo $result['target']; ?></td>
		<td><?php echo $result['casesensitive']; ?></td>
		<td><a href="<?php echo $edit; ?>"><button class="button action">Edit</button></a> &nbsp;<a href="<?php echo $delete; ?>" onclick="return deleteLink();"><button class="button action">Delete</button></a>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<script>
function deleteLink(){
	if(confirm('Are you sure you want to delete this link?')){
		return true;
	}else{
		return false;
	}		
}
</script>