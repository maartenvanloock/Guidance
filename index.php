<?php  

require ("classes/user.class.php");
require ("classes/connection.class.php");

if(isset($_POST['btnSignUp']))
{
  try
  {
    $u = new User();

    $username = mysql_real_escape_string($_POST['username']);
    $u->Username = htmlspecialchars($username);

    $userpassword = mysql_real_escape_string($_POST['password']);
    $u->Userpassword = htmlspecialchars($userpassword);
          
    if(isset($_POST['user_privilege']))
    {

      $userprivilege = mysql_real_escape_string($_POST['user_privilege']);
      $u->Userprivilege = htmlspecialchars($userprivilege);

      if($_POST['user_privilege'] == "false")
      {
        if($u->UserAvailable())
        {
          $u->Save();
          header("Location:login.php");
        }
        else
        {
          $feedback = "Er is al een account aangemaakt met deze gebruikersnaam";  
        }
      }
      else if($_POST['user_privilege'] == "true") 
      {
        if($_POST['secret_password'] == "zorgorganisatiebe")
        {
          if($u->UserAvailable())
          {
            $u->Save();
            header("Location:login.php");
          }
          else
          {
            $feedback = "Er is al een account aangemaakt met deze gebruikersnaam";
          }
        }
        else
        {
          $feedback = "Het geheime wachtwoord is niet juist";
        }
      }
    }
    else
    {
      
    }
  }
  catch (Exception $e)
  {
    $feedback = $e->getMessage();
  }
}
?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/new_v1.css"/>
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

    <?php include("require/include_header.php"); ?>
   
    <div class="row row_center">
      <div class="small-6 large-centered columns" id="signup_form">
        <h2>Sign up</h2>
        <h3>Kies uw account type</h3>

         <!--sign up form-->

        <div class="small-3 columns options" id="mantelzorger_optie">
          <img class="sign_up_image" src="img/mantelzorger_unselected.png" id="mantelzorger_profile" width="110" height="110">
          <a class="signup_options" id="mantelzorger" href="#">mantelzorger</a>
        </div>

        <div class="small-3 columns options" id="zorgorganisatie_optie">
          <img class="sign_up_image" src="img/zorgorganisatie_unselected.png" id="zorgorganisatie_profile"width="110" height="110">
          <a class="signup_options" id="zorgorganisatie" href="#">zorgorganisatie</a>
        </div>

        <p><a href="#">Niet zeker wat kiezen?</a></p>

        <form action="" method="post" data-abide>

          <div class="input-wrapper">
            <input type="text" placeholder="gebruikersnaam" name="username" required/>
            <small class="error">Geef een gebruikersnaam in</small>
          </div>

          <div class="password-field">
            <input type="password" placeholder="wachtwoord" name="password" id="wachtwoord" required/>
            <small class="error">Geef een wachtwoord in</small>
          </div>

          <div class="password-confirmation-field">
            <input type="password" placeholder="herhaal wachtwoord" name="password_repeat" required pattern="password" data-equalto="wachtwoord"/>
            <small class="error">Het wachtwoord komt niet overeen</small>
          </div>

          <div id="geheim_wachtwoord"><input type="text" placeholder="geheim wachtwoord" name="secret_password"/></div>
          <div><input type="text" placeholder="1" id="user_privilege" name="user_privilege"/></div>

          <button type="submit" href="#" class="button [radius round]" id="signupbutton" name="btnSignUp">Maak account aan</button>

        </form>

        <!--feedback sign up form-->

        <?php require ("require/feedback_form.php"); ?>

        <div class="row" id="feedback_signup">
            <div data-alert="" class="alert-box alert radius">
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
