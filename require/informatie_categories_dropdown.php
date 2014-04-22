<?php  
	    $sql = "select * from tbl_categorie_informatieblok";
	    $result = $db->query($sql);

	    while ($row = mysqli_fetch_assoc($result))
	    { ?>
        	<option value="<?php echo $row['categorie_name']; ?>"><?php echo $row['categorie_name']; ?></option>
<?php 	}

?>