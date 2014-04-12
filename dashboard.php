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

    <div class="row" id="row_header">
    <br/>
    <br/>
    <div class="large-12 small-12 columns">
        <div class="header">
            <h4 class="left">Recente ervaringen</h4>
            <h4 class="right show-for-xlarge-only">Opkomende evenementen</h4>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="large-12 small-12 columns">
            <div class="large-8 columns">
                <div class="row">

                    <div class="large-4 columns dashboard_container">
                        <div class="row">
                            <div class="panel ervaring_panel">
                                <ul class="small-block-grid-2 profile_info">
                                    <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                    <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                        <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;">Waar kan ik een lijst terug vinden met alle beschikbare zorgdiensten?</p>
                                        <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;">Maarten Van Loock</p>
                                        <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;">Onlangs had ik een probleem met het verzorgen van mijn dementerende vader. Ik kan de zorg niet langer alleen meer aan en heb dus heb hulp nodig bij dagelijse taken. Weet iemand waar ik een lijst met alle beschikbare zorgdiensten kan terug vinden?</p>
                                    </li>
                                    <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">12 maart</li>
                                    <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                        <img src="img/icons/like.png" style="padding-right: 10px;">8
                                        <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">15
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="large-4 columns dashboard_container">
                        <div class="row">
                            <div class="panel ervaring_panel">
                                <ul class="small-block-grid-2 profile_info">
                                    <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                    <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                        <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;">Waar kan ik een lijst terug vinden met alle beschikbare zorgdiensten?</p>
                                        <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;">Maarten Van Loock</p>
                                        <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;">Onlangs had ik een probleem met het verzorgen van mijn dementerende vader. Ik kan de zorg niet langer alleen meer aan en heb dus heb hulp nodig bij dagelijse taken. Weet iemand waar ik een lijst met alle beschikbare zorgdiensten kan terug vinden?</p>
                                    </li>
                                    <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">12 maart</li>
                                    <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                        <img src="img/icons/like.png" style="padding-right: 10px;">8
                                        <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">15
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--<div class="large-4 columns dashboard_container"><?php  echo $row['user_privilege'];?></div>-->

            <div class="large-4 columns dashboard_container">Opkomende evenementen</div>
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
