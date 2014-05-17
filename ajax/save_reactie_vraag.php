<?php  
    
    include_once("../classes/reactie.class.php");

    $r = new Reactie();
    $r->Description = mysql_real_escape_string($_POST['reactie_description']);

    $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

    $date = getdate();
    $month = $date['mon'];
    $day = date('d');
    $current_day = ltrim($day, '0');

    $month_name = $mons[$month];

    $vraag_date = $current_day.' '.$month_name;
    
    $r->Vraag_id = mysql_real_escape_string($_POST['vraag_id']);
    $r->Ervaring_id = 0;
    $r->Evenements_id = 0;
    $r->Date = $vraag_date;
    $r->User_id = mysql_real_escape_string($_POST['user_id']);
    $r->User = mysql_real_escape_string($_POST['user_name']);
    $r->User_privilege = mysql_real_escape_string($_POST['user_privilege']);

    $r->Save();

    echo json_encode(array("vraag_date" => $vraag_date));
?>