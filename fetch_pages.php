<?php  

	include("classes/connection.class.php"); //include config file

	$item_per_page = 9;

	//sanitize post value
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

	//validate page number is really numaric
	if(!is_numeric($page_number)){die('Invalid page number!');}

	//get current starting point of records
	$position = ($page_number * $item_per_page);

	//Limit our results within a specified range. 
	$sql = "select * from tbl_ervaringen LIMIT $position, $item_per_page";
    $results = $db->query($sql);

	//output results from database
	while($row = mysqli_fetch_assoc($results))
	{
		echo '<div class="large-4 columns dashboard_container">
                            <a href="ervaring_details.php?id='.$row["ervaring_id"].'&'.'categorie_name='.$row["fk_categorie_name"].'" style="border-bottom: 10px solid '.$row["fk_categorie_color"].';"
                               class="a_ervaring">
                            <div class="panel ervaring_panel">
                                <ul class="small-block-grid-2 profile_info">
                                    <li id="ervaring_profile_img"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                    <li id="ervaring_in">
                                        <p id="ervaring_titel">'.$row["ervaring_title"].'</p>
                                        <p id="ervaring_user">'.$row["fk_user_name"].'</p>
                                        <p id="ervaring_inf">'.htmlspecialchars(substr($row["ervaring_description"], 0, 118))."...".'</p>
                                    </li>
                                    <li class="left" id="ervaring_left">'.$row["ervaring_date"].'</li>
                                    <li class="right" id="ervaring_right">
                                        <img src="img/icons/like.png" style="padding-right: 10px;">'.$row["ervaring_likes"].'
                                        <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">'.$row["ervaring_reacties"].'
                                    </li>
                                </ul>
                            </div></a>
                    </div>';
	}

?>