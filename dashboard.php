<?php  

session_start();

require ("classes/connection.class.php");

$username = $_SESSION['username'];

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

    <div class="row">
        <div class="header">
            <h4>Recente ervaringen</h4>
        </div>
    </div>

    <div class="row">
        <div class="large-12 small-12 columns">
            <div class="large-4 columns dashboard_container">
                <div class="panel">
                    <ul class="inline-list profile_info">
                        <li><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                        <li>
                            <h6>Waar kan ik een lijst terug zorgdiensten?</h6>
                            <p>Maarten Van Loock</p>
                        </li>
                    </ul>
                    <p>onlangs had ik een probleem met het verzorgen van mijn dementerende vader. Ik kan de zorg niet langer alleen meer aan en heb dus heb hulp nodig bij dagelijse taken.
                    Weet iemand waar ik een lijst met alle beschikbare zorgdiensten kan terug vinden?</p>
                </div>
            </div>

            <div class="large-4 columns dashboard_container"><?php  echo $row['user_privilege'];?></div>

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
