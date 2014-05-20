<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/informatie.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe informatieblok edit----------------------*/

if(isset($_POST['btnSubmitEditInformatie']))
{
  try
  {
    $informatieblok_title = $_POST['informatieblok_title'];
    $informatieblok_description = $_POST['informatieblok_description'];

    $sql_ed = "update tbl_informatieblok set informatieblok_title='".$informatieblok_title."', informatieblok_description='".$informatieblok_description."' where informatieblok_id='".$_GET["id"]."'";
    $db->query($sql_ed);
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
    <title>Guidance | Algemene info details</title>
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

    <script src="parser_rules/advanced.js"></script>
    <script src="dist/wysihtml5-0.4.0pre.min.js"></script>

    <!--<script src="js/jquery.wysihtml5_size_matters.js"></script>
    <script src="js/wysihtml5.js"></script>
    
    <script>
      $(function() {
        var editor = new wysihtml5.Editor("informatieblok_description", {
          toolbar:      "informatieblok_toolbar"
        });

        editor.on('load', function() {
          $(editor.composer.iframe).wysihtml5_size_matters();
        });
      });
    </script>-->

    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
      <script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--overzicht van informatieblok-->

    <div class="row p_tw">
    <br/>
    <br/>

        <?php  

            $sql = "select * from tbl_informatieblok where informatieblok_id='".$_GET["id"]."'";
            $result = $db->query($sql); 
            $row = mysqli_fetch_assoc($result);

        ?>
        
        <div class="large-12 small-12 columns" id="info_ov">
            <div class="large-12 columns" style="padding: 0px;">
                <div class="large-11 small-11 columns left" style="padding: 0px;">
                    <p id="info_title"><?php echo $row['informatieblok_title']; ?></p>
                </div>

                <div class="large-2 small-2 columns right" style="padding: 0px; width: auto; height: auto;">
                    <?php  

                    if($user_privilege == 'true') 
                    { ?>
                      <a class="btnEdit" name="btnEdit"><i class="fi-widget size-21 style_1"></i></a> 
              <?php 
                    } ?>
                </div>
            </div>

            <p id="info_description"><?php echo $row['informatieblok_description']; ?></p>
        </div>

    <!--feedback for both forms-->

        <?php require ("require/feedback_form.php"); ?>

        <div class="row" id="conf">
            <div class="large-12 columns">
                <div data-alert="" class="alert-box success radius">
                  <p id="conf_message"></p>
                  <a class="close" href="#">×</a>
                </div>
            </div>
        </div>

        <div class="row" id="feedback">
            <div class="large-12 columns">
                <div data-alert="" class="alert-box alert radius">
                  <p id="feedback_message"></p>
                  <a class="close" href="#">×</a>
                </div>
            </div>
        </div>

        <div class="large-12 small-12 columns hide" id="info_update">

        </div>

    <!--overzicht van edit form-->

        <div class="large-12 small-12 columns hide" id="ed_info_form">
            <form action="" method="post" style="padding: 0px;" class="ed_form" data-abide>
                <div class="large-12 columns" style="padding: 0px;">
                    <div class="large-11 small-11 columns left" style="padding: 0px;">
                        <div id="informatieblok_toolbar">
                            <dl class="sub-nav" style="margin-bottom: 0px; margin: 0px;">
                                <dd style="margin-left: 0px;"><a data-wysihtml5-command="bold"><i class="fi-bold size-21"></i></a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="italic" ><i class="fi-italic size-21"></i></a></dd>
                                <dd style="margin-left: 2px; margin-bottom: 0px; margin-top: 4px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h1</a></dd>
                                <dd style="margin-left: 2px; margin-bottom: 0px; margin-top: 4px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h2</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertUnorderedList"><i class="fi-list-bullet size-21"></i></a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertOrderedList"><i class="fi-list-number size-21"></i></a></dd>
                            </dl>
                        </div>
                    </div>

                    <div class="large-2 small-2 columns right" style="padding: 0px; width: auto; height: auto;">
                        <a class="btnEdit" name="btnEdit"><i class="fi-widget size-21 style_1"></i></a> 
                    </div>
                </div>

                <div class="large-12 columns">
                    <input type="text" id="informatieblok_title" name="informatieblok_title" placeholder="Geef hier alle informatie in" value="<?php echo $row['informatieblok_title']; ?>">
                    <small class="error">Geef de informatie in</small>
                </div>

                <div class="large-12 columns">
                    <textarea id="informatieblok_description" name="informatieblok_description" placeholder="Geef hier alle informatie in"><?php echo $row['informatieblok_description']; ?></textarea>
                </div>

                <div class="large-12 columns hide">
                    <input type="text" id="informatieblok_id" name="informatieblok_id" value="<?php echo $_GET["id"]; ?>">
                </div>

                <div class="large-12 columns" style="height: auto; margin-bottom: 0px;">
                    <button type="submit" class="button [radius round]" id="btnSubmitEditInformatie" name="btnSubmitEditInformatie">Save changes</button>
                </div>
            </form>
        </div>

    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <script>
        var editor = new wysihtml5.Editor("informatieblok_description", { // id of textarea element
          toolbar:      "informatieblok_toolbar", // id of toolbar element
          parserRules:  wysihtml5ParserRules // defined in parser rules set 
        });
    </script>

    <script>
        $( document ).ready(function() {
            $(".wysihtml5-sandbox").css("resize", "vertical");
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){

        $(".btnEdit").click(function(){
            $("#ed_info_form").slideToggle();
            $("#info_ov").slideToggle();
        });

      });
    </script>

    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
    <script src="js/save_informatieblok_ed.js"></script>
    <script src="js/foundation/foundation.alert.js"></script> <!--script voor foundation alerts-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation dropdowns-->
    <script src="js/sticky_footer.js"></script> <!--script voor sticky footer-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/sign_up_select.js"></script> <!--script voor de keuze bij sign up-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.abide.js"></script> <!--script voor form validation abide-->

    <!--footer-->

    <?php include("require/include_footer.php"); ?>

  </body>
</html>
