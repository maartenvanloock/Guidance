<?php  
	$db = new mysqli('localhost','root','', 'guidance');

	if (mysqli_connect_errno()) 
	{
  		exit('Connect failed: '. mysqli_connect_error());
	}
?>