<?php  
    
    include_once("../classes/reactie_vt.class.php");

    try
    {
      $vt = new Reactie_vt();
      $vt->User_id = $_POST['user_id'];
      $vt->Reactie_id = $_POST['reactie_id'];

      $vt->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }

?>