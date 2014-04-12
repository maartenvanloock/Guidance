<?php  
	    $sql = "select * from tbl_categorie_ervaringen";
	    $result = $db->query($sql);

	    while ($row = mysqli_fetch_assoc($result))
	    { ?>
        	<option value="<?php echo $row['categorie_name'].','.$row['categorie_color']; ?>"><?php echo $row['categorie_name']; ?></option>
<?php 	}

?>