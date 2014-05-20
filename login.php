<?php  

session_start();

require ("classes/connection.class.php");

if(isset($_POST['btnLogIn']))
{
    $username = $_POST['login_username'];
    $userpassword = $_POST['login_password'];

    $username = stripslashes($username);
    $userpassword = stripslashes($userpassword);

    $username = mysql_real_escape_string($username);
    $userpassword = mysql_real_escape_string($userpassword);

    $sql = "select * from tbl_users where user_name='$username' and user_password='$userpassword'";
    $result = $db->query($sql);

    $numRows = mysqli_num_rows($result);

    if($numRows == 1)
    {
        $_SESSION['username'] = $username;
        header("Location:vraag.php");
    }
    else
    {
        $feedback = "Uw inlog gegevens kloppen niet";
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guidance | Log in</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/new_v1.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.topbar.js"></script> <!--script voor foundation-->
    <script src="js/vendor/modernizr.js"></script>

    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
      <script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
    <!--header-->

    <?php include("require/include_header.php"); ?>
    <div class="row row_center">
        <div class="large-6 small-8 large-centered small-centered columns" id="login_form">
            <h2>Log in</h2>
            
            <!--log in form-->

            <form action="" method="post" data-abide>

              <div class="input-wrapper">
                <input type="text" placeholder="gebruikersnaam" name="login_username" required/>
                <small class="error">Geef je gebruikersnaam in</small>
              </div>

              <div class="password-field">
                <input type="password" placeholder="wachtwoord" name="login_password" required/>
                <small class="error">Geef je wachtwoord in</small>
              </div>

              <button type="submit" href="#" class="button [radius round]" id="loginbutton" name="btnLogIn">Log in</button>

            </form>

            <!--feedback form-->

            <?php require ("require/feedback_form.php"); ?>

            <div class="row" id="feedback_login">
                <div data-alert class="alert-box alert radius">
                    <p class="feedback_message"></p>
                    <a class="close" href="#">×</a>
                </div>
            </div>

        </div>
    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
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
