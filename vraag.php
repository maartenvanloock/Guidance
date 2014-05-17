<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/vraag.class.php");
require ("classes/ervaring_categorie.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe ervaring----------------------*/

if(isset($_POST['btnSubmitVraag']))
{
    try
    {
    /*$tag_string = $_POST['vraag_tags'];
    $tags = preg_split("/[\s,]+/", $tag_string);
    $result = array_unique($tags);
    $tags_lim = count($result);

      if ($tags_lim > 5)
      {
        echo '<div class="row" id="feedback" style="margin-top: 0; padding: 0; text-align: center; display: none;">
                  <div class="large-12 columns">
                      <div data-alert="" class="alert-box alert radius">
                          <p id="feedback_message" style="font-size: 16px; font-style: inherit; font-weight: 600;">je mag maar 5 tags toevoegen</p>
                          <a class="close" href="#">×</a>
                      </div>
                  </div>
              </div>';
      }
      else
      {*/
        $vr = new Vraag();
        $vraag_title = mysql_real_escape_string($_POST['vraag_title']);
        $vr->Title = htmlspecialchars($vraag_title);

        $vraag_description = mysql_real_escape_string($_POST['vraag_description']);
        $vr->Description = htmlspecialchars($vraag_description);

        $vr->User = $username;
        $vr->User_id = $userid;

        $tag_string = $_POST['vraag_tags'];
        $vr->Tags = $tag_string;
        
        $category_color = $_POST['categorie_name'];
        $categorie_arr = explode(",", $category_color, 2);
        $categorie_name = $categorie_arr[0];
        $categorie_color = $categorie_arr[1];
        $vr->Categorie_name = mysql_real_escape_string($categorie_name);
        $vr->Categorie_color = $categorie_color;

        $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

        $date = getdate();
        $month = $date['mon'];
        $day = date('d');
        $current_day = ltrim($day, '0');

        $month_name = $mons[$month];

        $vraag_date = $current_day.' '.$month_name;
        $vr->Date = $vraag_date;

        $last_vraag_id = $vr->Save();

        /*for ($x = 0; $x < $tags_lim; $x++)
        {
            $sql = "insert into tbl_tags_vragen(tag_name, fk_vraag_id, fk_user_id) values ('".$tags[$x]."', '".$last_vraag_id."', '".$userid."')";
            $result_q = $db->query($sql);
        }
      }*/
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
    $ec = new Ervaring_categorie();

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

/*---------------------aanmaken van pagination----------------------*/

$item_per_page = 9;

if (isset($_GET["filter"]))
{ 
    $filter  = $_GET["filter"]; 

    $sql = "select count(*) from tbl_vragen where fk_categorie_name = '$filter'";
    $result = $db->query($sql);
}
else if (isset($_GET["filter_e"]))
{
    $filter_e = $_GET["filter_e"];

    if($filter_e == "eigen_vragen")
    {
      $sql = "select count(*) from tbl_vragen where fk_user_id=$userid";
      $result = $db->query($sql);
    }
    else if($filter_e == "beantwoord")
    {
      $sql = "select count(*) from tbl_vragen where vraag_solved=1";
      $result = $db->query($sql);
    }
    else if($filter_e == "onbeantwoord")
    {
      $sql = "select count(*) from tbl_vragen where vraag_solved=0";
      $result = $db->query($sql);
    } 
}
else
{
    $sql = "select count(*) from tbl_vragen";
    $result = $db->query($sql);
}

$get_all_rows = mysqli_fetch_array($result);

$pages = ceil($get_all_rows[0]/$item_per_page);

$pagination = '';

if($pages > 1)
{
    $pagination .= '<div class="row">
                        <div class="large-12 columns">
                            <div class="pagination-centered">
                                <ul class="pagination">';
    for($i = 1; $i<=$pages; $i++)
    {
        if (isset($_GET["filter"]))
        { 
            $pagination .= '<li><a href="vraag.php?filter='.$filter.'&page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
        }
        else if (isset($_GET["filter_e"]))
        {
            $pagination .= '<li><a href="vraag.php?filter_e='.$filter_e.'&page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
        }
        else
        {
            $pagination .= '<li><a href="vraag.php?page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
        }
    }

    $pagination .= '</ul>
                </div>
            </div>
        </div>';
  }

if (isset($_GET["page"]))
{ 
    $page  = $_GET["page"]; 
} 
else 
{ 
    $page = 1; 
}

$start_from = ($page-1) * $item_per_page;

?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/new.css"/>
    <link rel="stylesheet" type="text/css" href="spectrum.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.topbar.js"></script> <!--script voor foundation-->
    <script src="js/vendor/modernizr.js"></script>
    <script type="text/javascript" src="spectrum.js"></script>
  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--filters en add nieuwe vraag-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns show-for-large-up">
            <div class="row">
                <div class="large-9 columns">
                    <dl class="sub-nav">
                      <dt>Filter:</dt>
                      <?php if($user_privilege == 'false')
                      {?>
                      <dd><a href="vraag.php?filter_e=eigen_vragen" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                             onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                             class="filter_ervaring_fi">Eigen vragen</a></dd>
                      <?php } ?>
                      <dd><a href="vraag.php?filter_e=beantwoord" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                             onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                             class="filter_ervaring_fi">Beantwoord</a></dd>
                      <dd><a href="vraag.php?filter_e=onbeantwoord" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                             onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                             class="filter_ervaring_fi">Onbeantwoord</a></dd>
                      <?php  
                          $sql = "select * from tbl_categorie_vragen";
                          $result = $db->query($sql);

                          if(mysqli_num_rows($result) > 0)
                          {
                            while ($row = mysqli_fetch_assoc($result))
                            { ?>
            
                              <dd <?php if (isset($_GET["filter"]))
                                        { 
                                            $categorie_filter_large = $_GET["filter"];

                                            if($categorie_filter_large == $row['categorie_name'])
                                            {
                                                echo 'class="active"';
                                            } 
                                        } ?>>
                              <a href="vraag.php?filter=<?php echo $row['categorie_name']; ?>"
                                 onMouseOver="this.style.backgroundColor='<?php echo $row['categorie_color'] ?>', this.style.color='#ffffff'" 
                                 onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='<?php echo $row['categorie_color'] ?>'"
                                 <?php  
                                        if (isset($_GET["filter"]))
                                        { 
                                            $categorie_filter_large = $_GET["filter"];

                                            if($categorie_filter_large == $row['categorie_name'])
                                            {
                                                echo 'style="border-radius: 3px; padding-top: 5px; padding-bottom: 5px; color: #ffffff; background-color:'.$row['categorie_color'].';"';
                                            } 
                                        }
                                     ?>
                                 style="color: <?php echo $row['categorie_color']; ?>; border-radius: 3px; padding-top: 5px; padding-bottom: 5px;"> 
                              <?php echo $row['categorie_name']; ?></a></dd>
                      <?php  
                            }
                          }?>
                    </dl>
                </div>

          <?php if($user_privilege == 'false')
                { ?>
                    <div class="large-3 columns btn_add">
                        <button type="submit" href="#" class="show_hide_vraag_form button [radius round] right nieuwe_ervaring"><img src="img/icons/add.png" class="add_icon">Nieuwe vraag</button>
                    </div>
          <?php } 
                else
                { ?>
                    <div class="large-3 columns btn_add">
                        <button type="submit" href="#" class="show_hide_categorie_form button [radius round] right nieuwe_ervaring"><img src="img/icons/add.png" class="add_icon">Nieuwe categorie</button>
                    </div>
          <?php } ?>
            </div>
        </div>

    <!--filters en add vraag small-->

    <div class="large-4 columns show-for-small-up hide-for-large-up">
            <div class="large-12 columns s_pad">
                <form action="" method="get" Onchange="this.form.submit()" style="margin-bottom: 0px;" data-abide>
                    <select id="filter" name="filter" onchange='this.form.submit()' style="margin-bottom: 10px;" required>
                        <option value="" disabled selected>Filter op categorie:</option>
                        <option value="eigen_vragen">Eigen ervaringen</option>
                        <option value="beantwoord">Beantwoord</option>
                        <option value="onbeantwoord">Onbeantwoord</option>

                        <?php 

                              $sql = "select * from tbl_categorie_vragen";
                              $result = $db->query($sql);

                              if(mysqli_num_rows($result) > 0)
                              {
                                while ($row = mysqli_fetch_assoc($result))
                                { ?>
                                  <option value="<?php echo $row['categorie_name']; ?>" 

                                          <?php if (isset($_GET["filter"]))
                                                { 
                                                   $categorie_filter_small = $_GET["filter"];

                                                   if($categorie_filter_small == $row['categorie_name'])
                                                   {
                                                      echo 'selected';
                                                   } 
                                                } ?> ><?php echo $row['categorie_name']; ?></option>
                      <?php     }
                              } ?>
                    </select>
                </form>
            </div>

            <div class="large-12 columns s_pad">
          <?php if($user_privilege == 'false')
                {?>
                  <button type="submit" href="#" class="show_hide_vraag_form button [radius round] right nieuwe_ervaring_s"><img src="img/icons/add.png" class="add_icon">Nieuwe ervaring</button>
          <?php } 
                else
                { ?>
                  <button type="submit" href="#" class="show_hide_categorie_form button [radius round] right nieuwe_ervaring_s"><img src="img/icons/add.png" class="add_icon">Nieuwe categorie</button>
          <?php } ?>
            </div>
        </div>

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

    <!--nieuwe vraag toevoegen-->

    <div class="row" id="slidingDiv_vraagform">
        <div class="large-12 small-12 columns ervaring_form">
                <form action="" method="post" id="vraag_form" data-abide>
                    <div class="large-12 small-12 columns">
                        <h4>Stel een nieuwe vraag</h4>
                    </div>

                      <div class="large-8 columns">
                        <input type="text" placeholder="Stel hier je hoofdvraag waar je graag een antwoord op wilt" id="vraag_title" name="vraag_title" required>
                        <small class="error">Geef de hoofdvraag in waar je graag een antwoord op wil krijgen</small>
                        <ul class="chars_left">
                          <li><p class="title_chars"></p></li>
                          <li><p>characters left</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                          <select id="categorie_name" name="categorie_name" required>
                              <option value="" disabled selected>Plaats vraag in categorie:</option>
                              <?php require ("require/ervaring_categories_dropdown.php"); ?>
                          </select>
                      </div>

                      <div class="large-4 columns hide">
                          <input type="text" id="user_name" name="user_name" value="<?php echo $username; ?>">
                          <input type="text" id="user_id" name="user_id" value="<?php echo $userid; ?>">
                          <input type="text" id="user_profile" name="user_profile" value="<?php echo $row_user['user_profile_path']; ?>">
                      </div>

                      <div class="large-8 columns">
                        <textarea type="text" placeholder="Geef hier wat meer informatie over je vraag" id="vraag_description" name="vraag_description" required></textarea>
                        <small class="error">Geef wat informatie over je vraag, zo kan ze sneller beantwoord worden</small>
                        <ul class="chars_left">
                          <li><p class="description_chars"></p></li>
                          <li><p>characters left</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                        <input type="text" placeholder="Geef hier max. 5 tags in, scheidt ze van elkaar met een komma" id="vraag_tags" name="vraag_tags" required>
                        <small class="error">Je mag maar 5 tags ingeven</small>
                            <button type="submit" href="#" class="button [radius round]" id="btnSubmitVraag" name="btnSubmitVraag">Voeg vraag toe
                            </button>
                      </div>
                </form>
        </div>
    </div>

    <!--nieuwe categorie toevoegen-->

    <div class="row" id="slidingDiv_categorieform">
        <div class="large-12 columns categorie_form">
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
                          <span class='label color_label'>kies een kleur</span>
                          <input class="hide" id="categorie_chose" value="" name="categorie_chose">
                    </div>

                      <div class="large-4 columns">
                          <button type="submit" href="#" class="button [radius round]" id="btnSubmitCategorie" name="btnSubmitCategorie">Voeg categorie toe</button>
                      </div>
                </form>
                </div>
        </div>
    </div>

    <!--pagination-->

    <?php echo $pagination; ?>

    <!--overzicht van vragen-->

    <div class="row">
        <div class="large-12 small-12 columns ervaringen" id="results">

            <?php 

              if (isset($_GET["filter"]))
              { 
                $filter  = $_GET["filter"];
                $sql = "select * from tbl_vragen where fk_categorie_name = '$filter' order by vraag_id desc LIMIT $start_from, $item_per_page";
                $results = $db->query($sql); 
              } 
              else if (isset($_GET["filter_e"]))
              { 
                $filter_e  = $_GET["filter_e"];

                if($filter_e == "eigen_vragen")
                {
                  $sql = "select * from tbl_vragen where fk_user_id=$userid order by vraag_id desc LIMIT $start_from, $item_per_page";
                  $results = $db->query($sql);
                }
                else if($filter_e == "beantwoord")
                {
                  $sql = "select * from tbl_vragen where vraag_solved=1 order by vraag_id desc LIMIT $start_from, $item_per_page";
                  $results = $db->query($sql);
                }
                else if($filter_e == "onbeantwoord")
                {
                  $sql = "select * from tbl_vragen where vraag_solved=0 order by vraag_id desc LIMIT $start_from, $item_per_page";
                  $results = $db->query($sql);
                }
              }
              else 
              { 
                $sql = "select * from tbl_vragen order by vraag_id desc LIMIT $start_from, $item_per_page";
                $results = $db->query($sql);
              }
              
              if(mysqli_num_rows($results) > 0)
              {
                while ($row = mysqli_fetch_assoc($results))
                { 
                  $sql_user = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                  $results_user = $db->query($sql_user);
                  $row_user = mysqli_fetch_assoc($results_user); ?>
                    <div class="large-4 columns dashboard_container">
                            <a href="vraag_details.php?id=<?php echo $row['vraag_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring">
                            <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                <ul class="small-block-grid-2 profile_info">
                                    <li class="n_p_btm" style="width: 12%; padding-right: 0;">
                                      <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="vraag_profile_pre">
                                    </li>
                                    <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                        <p class="ervaring_title_pre" style="color: #7b868c;">
                                            <?php 
                                            if (strlen($row['vraag_title']) > 70)
                                            {
                                              echo htmlspecialchars(substr($row['vraag_title'], 0, 70))."...";
                                            }
                                            else
                                            {
                                              echo htmlspecialchars($row['vraag_title']);
                                            } ?>
                                        </p>
                                        <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo htmlspecialchars('gepost door: '.$row['fk_user_name']); ?></p>
                                        <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                            <?php 
                                            if (strlen($row['vraag_description']) > 118)
                                            {
                                              echo htmlspecialchars(substr($row['vraag_description'], 0, 118))."...";
                                            }
                                            else
                                            {
                                              echo htmlspecialchars($row['vraag_description']);
                                            } ?>
                                        </p>
                                    </li>
                                    <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['vraag_date']; ?></li>
                                    <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                        <img src="img/icons/like.png" class="p_r_t"><?php echo $row['vraag_likes']; ?>
                                        <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['vraag_reacties']; ?>
                                    </li>
                                </ul>
                            </div></a>
                    </div>
                <?php 
                } 
              }
              else
              {?>
                <div class="small-12 large-centered columns" style="margin-top: 25%; text-align: center;">
                    <p>er zijn nog geen vragen gesteld op het platform</p>
                </div>
              <?php
              } ?>
        </div>
    </div>
    <br/>

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
          $("#vraag_title").limiter(150, elem_ervaring_title);

          var elem_ervaring_description = $(".description_chars");
          $("#vraag_description").limiter(500, elem_ervaring_description);

          var elem_categorie_title = $(".categorie_title_chars");
          $("#categorie_title").limiter(50, elem_categorie_title);

        });
    </script>

    <script type="text/javascript">
      $(document).ajaxStart(function() {
          $('#ajax_load').show(); // show the gif image when ajax starts
      }).ajaxStop(function() {
          $('#ajax_load').hide(); // hide the gif image when ajax completes
      });
    </script>

    <script src="js/save_vraag.js"></script>
    <script src="js/save_categorie_ervaring.js"></script>
    <script src="js/foundation/foundation.alert.js"></script> <!--script voor foundation alerts-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation dropdowns-->
    <script src="js/sticky_footer.js"></script> <!--script voor sticky footer-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.abide.js"></script> <!--script voor form validation abide-->

    <!--footer-->

    <?php include("require/include_footer.php"); ?>

  </body>
</html>