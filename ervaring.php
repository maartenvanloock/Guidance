<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/ervaring.class.php");
require ("classes/ervaring_categorie.class.php");

$username = $_SESSION['username'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(!empty($username))
{
    $sql = "select * from tbl_users where user_name='$username'";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);
    $user_privilege = $row['user_privilege'];
    $userid = $row['user_id'];
}
else if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe ervaring----------------------*/

if(isset($_POST['btnSubmitErvaring']))
{
    try
    {
      $e = new Ervaring();
      $ervaring_title = mysql_real_escape_string($_POST['ervaring_title']);
      $e->Title = htmlspecialchars($ervaring_title);

      $ervaring_description = mysql_real_escape_string($_POST['ervaring_description']);
      $e->Description = htmlspecialchars($ervaring_description);

      $e->User = $username;
      $e->User_id = $userid;
      
      $category_color = $_POST['categorie_name'];
      $categorie_arr = explode(",", $category_color, 2);
      $categorie_name = $categorie_arr[0];
      $categorie_color = $categorie_arr[1];
      $e->Categorie_name = mysql_real_escape_string($categorie_name);
      $e->Categorie_color = $categorie_color;

      $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

      $date = getdate();
      $month = $date['mon'];
      $day = date('d');
      $current_day = ltrim($day, '0');

      $month_name = $mons[$month];

      $ervaring_date = $current_day.' '.$month_name;
      $e->Date = $ervaring_date;

      $e->Save();

    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------aanmaken van een nieuwe categorie----------------------*/

function rgb2hex($rgb) {
   $hex = "#";
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

   return $hex; // returns the hex value including the number sign (#)
}

if(isset($_POST['btnSubmitCategorie']))
{
  try
  {
    $ec = new Ervaring_categorie;

    $categorie_title = mysql_real_escape_string($_POST['categorie_title']);
    $ec->Title = htmlspecialchars($categorie_title);

    $categorie_color = mysql_real_escape_string($_POST['categorie_chose']);
    $ec->Color = htmlspecialchars($categorie_color);

    $ec->Save();
  }
  catch (Exception $e)
  {
    $feedback = $e->getMessage();
  }
}


/*$sql_color = "select categorie_color from tbl_categorie_ervaringen where categorie_name = $row['fk_categorie_name']";
$result_color = $db->query($sql_color);
echo $result_color;*/
                                  

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

    <link rel="stylesheet" type="text/css" href="spectrum.css">
    <script type="text/javascript" src="spectrum.js"></script>
  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--filters en add ervaring-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-8 columns">
                    <dl class="sub-nav">
                      <dt>Filter:</dt>
                      <?php if($user_privilege == 'false')
                      {?>
                      <dd><a href="#">Eigen ervaringen</a></dd>
                      <?php } ?>
                      <dd><a href="#">Beantwoord</a></dd>
                      <dd><a href="#">Onbeantwoord</a></dd>
                      <?php  
                          $sql = "select * from tbl_categorie_ervaringen";
                          $result = $db->query($sql);

                          if(mysqli_num_rows($result) > 0)
                          {
                            while ($row = mysqli_fetch_assoc($result))
                            { ?>
                              <dd><a href="#" style="color: <?php echo $row['categorie_color']; ?>;"><?php echo $row['categorie_name']; ?></a></dd>
                      <?php  
                            }
                          }?>
                    </dl>
                </div>

                <?php if($user_privilege == 'false')
                {?>
                <div class="large-4 columns">
                    <button type="submit" href="#" class="show_hide_ervaring_form button [radius round] right nieuwe_ervaring"><img src="img/icons/add.png" class="add_icon">Nieuwe ervaring</button>
                </div>
                <?php } 
                else
                {?>
                <div class="large-4 columns">
                    <button type="submit" href="#" class="show_hide_categorie_form button [radius round] right nieuwe_ervaring"><img src="img/icons/add.png" class="add_icon">Nieuwe categorie</button>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!--nieuwe ervaring toevoegen-->

    <div class="row" id="slidingDiv_ervaringform">
        <div class="large-12 small-12 columns" style="border-radius: 3px; background-color: #ffffff; padding: 10px; margin-bottom: 10px; border: 1px solid #d8d8d8;">
                <form action="" method="post" id="ervaring_form" data-abide>
                    <div class="large-12 small-12 columns">
                        <h4>Voeg een nieuwe ervaring toe</h4>
                    </div>

                      <div class="large-8 columns">
                        <input type="text" placeholder="Stel hier je hoofdvraag waar je graag een antwoord op wilt" id="ervaring_title" name="ervaring_title" required>
                        <small class="error">Geef je hoofdvraag in</small>
                        <ul class="chars_left">
                          <li><p class="title_chars"></p></li>
                          <li><p>characters left</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                          <select id="categorie_name" name="categorie_name" required>
                              <option value="" disabled selected>Plaats ervaring in categorie:</option>
                              <?php require ("require/ervaring_categories_dropdown.php"); ?>
                          </select>
                      </div>

                      <div class="large-8 columns">
                        <textarea type="text" placeholder="Geef hier wat meer informatie over je ervaring en je bijbehorende vraag" id="ervaring_description" name="ervaring_description" 
                        style="resize: vertical; height: 100px; border-radius: 3px;" required></textarea>
                        <small class="error">Geef wat informatie over je ervaring en bijbehorende vraag</small>
                        <ul class="chars_left">
                          <li><p class="description_chars"></p></li>
                          <li><p>characters left</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                        <input type="text" placeholder="Geef hier een aantal tags in die je ervaring en vragen beschrijven, scheidt ze van elkaar met een komma" id="ervaring_tags" name="ervaring_tags" required>
                        <small class="error">Geef een aantal tags in die je ervaring of vraag beschrijven</small>
                            <button type="submit" href="#" class="button [radius round]" id="btnSubmitErvaring" name="btnSubmitErvaring" 
                                    style="height: 47px;
                                           width: 100%;
                                           border-radius: 3px;
                                           background-color: #5db0c6;
                                           color: white;
                                           font-family: 'Open Sans', sans-serif;
                                           font-size: 16px;
                                           font-style: inherit;
                                           font-weight: 600;
                                           padding: 5px;">Voeg ervaring toe
                            </button>
                      </div>
                </form>
        </div>
    </div>

    <!--nieuwe categorie toevoegen-->

    <div class="row" id="slidingDiv_categorieform">
        <div class="large-12 small-12 columns" style="border-radius: 3px; background-color: #ffffff; padding: 10px; margin-bottom: 10px; border: 1px solid #d8d8d8;">
        <div class="row">
                <form action="" method="post" id="categorie_form" style="padding: 10px;" data-abide>
                    <div class="large-12 small-12 columns">
                        <h4>Voeg een nieuwe categorie toe</h4>
                    </div>

                    <div class="large-6 columns">
                      <input type="text" placeholder="Geef hier de titel van de categorie in" id="categorie_title" name="categorie_title" required>
                      <small class="error">Geef de nieuwe categorie een titel</small>
                      <ul class="chars_left">
                          <li><p class="categorie_title_chars"></p></li>
                          <li><p>characters left</p></li>
                      </ul>
                    </div>

                    <div class="large-2 columns" style="margin-bottom: 10px;">
                          <input type='text' id='showPaletteOnly' name='showPaletteOnly'/>
                          <span class='label'
                                style="border-radius: 3px;
                                       height: 35px;
                                       width: 120px;
                                       background-color: #5db0c6;
                                       padding: 10px;
                                       font-family: 'Open Sans', sans-serif;
                                       font-size: 14px;
                                       font-style: inherit;
                                       font-weight: 600;">kies een kleur</span>
                          <input class="hide" id="categorie_chose" value="" name="categorie_chose">
                    </div>

                      <div class="large-4 columns">
                            <button type="submit" href="#" class="button [radius round]" id="btnSubmitCategorie" name="btnSubmitCategorie" 
                                    style="height: 38px;
                                           width: 100%;
                                           border-radius: 3px;
                                           background-color: #5db0c6;
                                           color: white;
                                           font-family: 'Open Sans', sans-serif;
                                           font-size: 16px;
                                           font-style: inherit;
                                           font-weight: 600;
                                           padding: 5px;">Voeg categorie toe
                            </button>
                      </div>
                </form>
                </div>
        </div>
    </div>

    <!--overzicht van ervaringen-->

    <div class="row">
        <div class="large-12 small-12 columns ervaringen">

            <?php 
              $sql = "select * from tbl_ervaringen";
              $result = $db->query($sql);

              if(mysqli_num_rows($result) > 0)
              {
                while ($row = mysqli_fetch_assoc($result))
                { ?>
                    <div class="large-4 columns dashboard_container">
                            <div class="panel ervaring_panel" 
                                 style="border-bottom: 12px solid <?php echo $row['fk_categorie_color']; ?>;">
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
                            </div>
                    </div>
                <?php 
                } 
              }
              else
              {?>
                <div class="small-6 large-centered columns" style="margin-top: 25%;">
                    <p>er zijn geen ervaringen</p>
                </div>
              <?php 
              } ?>

        <!--<div class="large-4 columns dashboard_container">
                    <div class="panel ervaring_panel">
                        <ul class="small-block-grid-2 profile_info">
                            <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                            <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;">Waar kan ik een lijst terug vinden met alle beschikbare zorgdiensten?</p>
                                <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;">Maarten Van Loock</p>
                                <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;">
                                Onlangs had ik een probleem met het verzorgen van mijn dementerende vader. Ik kan de zorg niet langer alleen meer aan en heb dus heb hulp nodig bij dagelijse taken. Weet iemand waar ik een lijst met alle beschikbare zorgdiensten kan terug vinden?</p>
                            </li>
                            <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">12 maart</li>
                            <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                <img src="img/icons/like.png" style="padding-right: 10px;">8
                                <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">15
                            </li>
                        </ul>
                    </div>
            </div>-->
        </div>
    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>

    <!--color picker-->

    <script type="text/javascript">
          function printColor(color) {
             var text = color.toHexString();    
             $(".label").text(text);
             $("#categorie_chose").val(text);
          }

          $("#showPaletteOnly").spectrum({
              color: "rgb(26, 188, 156)",    
              showPaletteOnly: true,
              change: function(color) {
                  printColor(color);
              },
              palette: 
              [
                  ["rgb(26, 188, 156)", "rgb(46, 204, 113)",
                  "rgb(52, 152, 219)", "rgb(155, 89, 182)","rgb(52, 73, 94)"],
                  ["rgb(6, 160, 133)", "rgb(41, 128, 185)", "rgb(241, 196, 15)", "rgb(230, 126, 34)",
                  "rgb(248, 155, 72)"] 
              ]
          });
    </script>
    
    <!--char limit-->

    <script src="js/char_limit.js"></script>
    <script src="js/form_animations.js"></script>

    <script>
        $(document).ready(function(){

          var elem_ervaring_title = $(".title_chars");
          $("#ervaring_title").limiter(150, elem_ervaring_title);

          var elem_ervaring_description = $(".description_chars");
          $("#ervaring_description").limiter(500, elem_ervaring_description);

          var elem_categorie_title = $(".categorie_title_chars");
          $("#categorie_title").limiter(50, elem_categorie_title);

        });
    </script>

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
