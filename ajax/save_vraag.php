<?php  
    
    include_once("../classes/vraag.class.php");
    include_once("../classes/connection.class.php");

    $vr = new Vraag();
    $vraag_title = mysql_real_escape_string($_POST['vraag_title']);
    $vr->Title = htmlspecialchars($vraag_title);

    $vraag_description = mysql_real_escape_string($_POST['vraag_description']);
    $vr->Description = htmlspecialchars($vraag_description);

    $vr->User = $_POST['user_name'];
    $vr->User_id = $_POST['user_id'];

    $tag_string = $_POST['vraag_tags'];
    $vr->Tags = $tag_string;
        
    $category_color = $_POST['categorie_name'];
    $categorie_arr = explode(",", $category_color, 2);
    $categorie_name = $categorie_arr[0];
    $categorie_color = $categorie_arr[1];
    $vr->Categorie_name = mysql_real_escape_string($categorie_name);
    $vr->Categorie_color = $categorie_color;

    $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

    $date = getdate();
    $month = $date['mon'];
    $day = date('d');
    $current_day = ltrim($day, '0');

    $month_name = $mons[$month];

    $vraag_date = $current_day.' '.$month_name;
    $vr->Date = $vraag_date;

    $sql = "select * from tbl_vragen order by vraag_id desc limit 1";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);

    $vr->Save();

    $last_vraag_id = $row['vraag_id']+1;

    echo json_encode(array("vraag_date" => $vraag_date, "last_vraag_id" => $last_vraag_id, "categorie_color" => $categorie_color, "categorie_name_upd" => $categorie_name));

?>