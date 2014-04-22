<?php  
    
    require ("../classes/connection.class.php");
    
    $informatieblok_title = $_POST['informatie_title'];
    $informatieblok_description = $_POST['informatie_description'];
    $informatieblok_id = $_POST['informatie_id'];

    $sql_ed = "update tbl_informatieblok set informatieblok_title='".$informatieblok_title."', informatieblok_description='".$informatieblok_description."' where informatieblok_id='".$informatieblok_id."'";
    $db->query($sql_ed);

?>