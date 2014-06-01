<?php  

require ("classes/user.class.php");
require ("classes/connection.class.php");

if(isset($_POST['btnSignup']))
{
  header("Location:signup.php");
}
?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guidance</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/new_v2.css"/>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/vendor/modernizr.js"></script>

    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
      <script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <![endif]-->

    <!--google analytics-->

    <?php include_once("require/analyticstracking.php") ?>
    
  </head>

  <body>

    <div class="row text-center row_v_align">
        <div class="large-12 small-12 columns text-center v_align" id="pre_panel">
            <img src="img/guidance.png" id="platform_img">
            <p id="pre_m_d">Een kennis- en informatie-platform dat zich richt tot het verbeteren van de informatieverspreiding tussen mantelzorgers en zorgorganisaties</p>

            <div class="large-12 small-12 columns">
              <form action="" method="post" data-abide>
                <button id="btnSignup" name="btnSignup" >
                        Maak een account aan
                </button>
              </form>
            </div>

            <a href="login.php" style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 16px;">Heb je al een account? Klik dan hier om in te loggen.</a>
        </div>
    </div>


    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>

    <script type="text/javascript">
      $('#pre_panel').addClass('animated bounceIn');
    </script>

    <script type="text/javascript">
      $(window).on("resize", function () {
        $(".row_v_align").each(function(){
          var rowHeight = $(this).height();
          console.log(rowHeight);
          $(".column_v_align", this).height(rowHeight);
          $(".v_align", this).height(rowHeight);
        });
      }).resize();
    </script>
    
    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.abide.js"></script> <!--script voor form validation abide-->

  </body>
</html>
