<?php  

	include("classes/connection.class.php"); //include config file

	$item_per_page = 3;

	//sanitize post value
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

	//validate page number is really numaric
	if(!is_numeric($page_number)){die('Invalid page number!');}

	//get current starting point of records
	$position = ($page_number * $item_per_page);

	//Limit our results within a specified range. 
	/*$sql = "select * from tbl_ervaringen LIMIT $position, $item_per_page";
    $results = $db->query($sql);*/

    $sql_tags= "select * from tbl_tags where tag_name='".$_POST['tag_name']."' LIMIT $position, $item_per_page";
    $result_tags = $db->query($sql_tags);

    echo $sql_tags;

	//output results from database
	while($row = mysqli_fetch_assoc($result_tags))
	{
        $sql = "select * from tbl_ervaringen where ervaring_id='".$row['fk_ervaring_id']."' order by ervaring_id desc";
        $results = $db->query($sql);
        $row_tags = mysqli_fetch_assoc($results);

		echo '<div class="large-4 columns dashboard_container">
                            <a href="ervaring_details.php?id='.$row_tags["ervaring_id"].'&'.'categorie_name='.$row_tags["fk_categorie_name"].' class="a_ervaring">
                            <div class="panel ervaring_panel" style="border-bottom: 10px solid '.$row_tags["fk_categorie_color"].';">
                                <ul class="small-block-grid-2 profile_info">
                                    <li id="ervaring_profile_img"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                    <li id="ervaring_in">
                                        <p id="ervaring_titel">'.$row_tags["ervaring_title"].'</p>
                                        <p id="ervaring_user">'.$row_tags["fk_user_name"].'</p>
                                        <p id="ervaring_inf">'.htmlspecialchars(substr($row_tags["ervaring_description"], 0, 118))."...".'</p>
                                    </li>
                                    <li class="left" id="ervaring_left">'.$row_tags["ervaring_date"].'</li>
                                    <li class="right" id="ervaring_right">
                                        <img src="img/icons/like.png" style="padding-right: 10px;">'.$row_tags["ervaring_likes"].'
                                        <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">'.$row_tags["ervaring_reacties"].'
                                    </li>
                                </ul>
                            </div></a>
                    </div>';
	}

?>