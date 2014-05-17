<?php  
    
    include_once("../classes/ervaring.class.php");
    include_once("../classes/connection.class.php");

    $e = new Ervaring();
    $ervaring_title = mysql_real_escape_string($_POST['ervaring_title']);
    $e->Title = htmlspecialchars($ervaring_title);

    $ervaring_description = mysql_real_escape_string($_POST['ervaring_description']);
    $e->Description = htmlspecialchars($ervaring_description);

    $e->User = $_POST['user_name']);
    $e->User_id = $_POST['user_id']);

    $tag_string = $_POST['ervaring_tags'];
    $e->Tags = $tag_string;
      
    $category_color = $_POST['categorie_name'];
    $categorie_arr = explode(",", $category_color, 2);
    $categorie_name = $categorie_arr[0];
    $categorie_color = $categorie_arr[1];
    $e->Categorie_name = mysql_real_escape_string($categorie_name);
    $e->Categorie_color = $categorie_color;

    $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

    $date = getdate();
    $month = $date['mon'];
    $day = date('d');
    $current_day = ltrim($day, '0');

    $month_name = $mons[$month];

    $ervaring_date = $current_day.' '.$month_name;
    $e->Date = $ervaring_date;

    $sql = "select * from tbl_ervaringen order by ervaring_id desc limit 1";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);

    $e->Save();

    $last_ervaring_id = $row['ervaring_id']+1;

    echo json_encode(array("ervaring_date" => $ervaring_date, "last_ervaring_id" => $last_ervaring_id, "categorie_color" => $categorie_color, "categorie_name_upd" => $categorie_name));

?>