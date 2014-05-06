<?php  

session_start();

require ("classes/connection.class.php");

$username = $_SESSION['username'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(!empty($username))
{
    $sql = "select * from tbl_users where user_name='$username'";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user_privilege = $row['user_privilege'];
    $userid = $row['user_id'];
    $user_up_v = $row['user_ptn'];

    $_SESSION['userprivilege'] = $user_privilege;
    $_SESSION['userid'] = $userid;
    $_SESSION['user_up_v'] = $user_up_v;
}
else if(empty($username))
{
    header("Location:login.php");
}

?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css"/>
    <link rel="stylesheet" href="css/new.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.topbar.js"></script> <!--script voor foundation-->
    <script src="js/vendor/modernizr.js"></script>
  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--dashboard-->

    <!--<div class="row" id="row_header">
    <br/>
    <br/>
    <div class="large-12 small-12 columns">
        <div class="header">
            <h4 class="left">Recente ervaringen</h4>
            <h4 class="right show-for-xlarge-only">Opkomende evenementen</h4>
        </div>
    </div>
    </div>
       </div>
    </div>-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-8 columns">
                <div class="row" style="margin-bottom: 10px;">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 20px; padding-top: 0px;">Recente ervaringen</h4>
                </div>
                
                <?php

                    $sql = "select * from tbl_ervaringen limit 0,6";
                    $result = $db->query($sql);

                    if(mysqli_num_rows($result) > 0)
                    {
                      while ($row = mysqli_fetch_assoc($result))
                      { ?>
                          <div class="large-6 columns dashboard_container">
                                  <a href="ervaring_details.php?id=<?php echo $row['ervaring_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                          <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                              <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo $row['ervaring_title']; ?></p>
                                              <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo $row['fk_user_name']; ?></p>
                                              <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;"><?php echo htmlspecialchars(substr($row['ervaring_description'], 0, 118))."..."; ?></p>
                                          </li>
                                          <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;"><?php echo $row['ervaring_date']; ?></li>
                                          <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                              <img src="img/icons/like.png" style="padding-right: 10px;"><?php echo $row['ervaring_likes']; ?>
                                              <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;"><?php echo $row['ervaring_reacties']; ?>
                                          </li>
                                      </ul>
                                  </div></a>
                          </div>
                      <?php 
                      } 
                    }
                    else
                    {?>
                      <div class="large-4 columns" style="text-align: left; padding-left: 5px;">
                          <p>er zijn geen relevante ervaringen gevonden</p>
                      </div>
                    <?php 
                    } ?>

                </div>

                <div class="large-4 columns" style="padding: 0px;">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Opkomende evenementen</h4>
                </div>
            </div>
        </div>
    </div>  
            

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <script src="js/foundation/foundation.alert.js"></script> <!--script voor foundation alerts-->
    <script src="js/sticky_footer.js"></script> <!--script voor sticky footer-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/sign_up_select.js"></script> <!--script voor de keuze bij sign up-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.abide.js"></script> <!--script voor form validation abide-->

    <!--footer-->

    <?php include("require/include_footer.php"); ?>

  </body>
</html>
