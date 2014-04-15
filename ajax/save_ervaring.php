<?php  
    
    include_once("../classes/ervaring.class.php");

    $e = new Ervaring();
    $ervaring_title = mysql_real_escape_string($_POST['ervaring_title']);
    $e->Title = htmlspecialchars($ervaring_title);

    $ervaring_description = mysql_real_escape_string($_POST['ervaring_description']);
    $e->Description = htmlspecialchars($ervaring_description);

    $e->User = mysql_real_escape_string($_POST['user_name']);
    $e->User_id = mysql_real_escape_string($_POST['user_id']);
      
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

    $e->Save();

?>