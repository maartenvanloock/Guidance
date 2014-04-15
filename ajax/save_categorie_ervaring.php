<?php  
    
    include_once("../classes/ervaring_categorie.class.php");

    function rgb2hex($rgb) {
       $hex = "#";
       $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

       return $hex; // returns the hex value including the number sign (#)
    }

    $ec = new Ervaring_categorie;

    $categorie_title = mysql_real_escape_string($_POST['categorie_title']);
    $ec->Title = htmlspecialchars($categorie_title);

    $categorie_color = mysql_real_escape_string($_POST['categorie_chose']);
    $ec->Color = htmlspecialchars($categorie_color);

    $ec->Save();
      

?>