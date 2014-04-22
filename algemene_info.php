<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/informatie.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe informatieblok----------------------*/

if(isset($_POST['btnSubmitInformatie']))
{
  try
  {
    $inf = new Informatie();

    $informatie_title = mysql_real_escape_string($_POST['informatieblok_title']);
    $inf->Title = htmlspecialchars($informatie_title);

    $informatie_description = mysql_real_escape_string($_POST['informatieblok_description']);
    $inf->Description = $informatie_description;

    $inf->User = $username;
    $inf->User_id = $userid;

    $categorie_name = mysql_real_escape_string($_POST['categorie_name']);
    $inf->Categorie_name = $categorie_name;

    $inf->Save();
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

    $sql = "select count(*) from tbl_informatieblok where fk_categorie_name = '$filter'";
    $result = $db->query($sql);
}
else
{
    $sql = "select count(*) from tbl_informatieblok";
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
            $pagination .= '<li><a href="algemene_info.php?filter='.$filter.'&page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
        }
        else
        {
            $pagination .= '<li><a href="algemene_info.php?page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
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
  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--filters en add informatieblok-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-9 columns">
                    <dl class="sub-nav">
                      <dt>Filter:</dt>
                      <?php  

                      $sql = "select * from tbl_categorie_informatieblok";
                      $result = $db->query($sql);

                      if(mysqli_num_rows($result) > 0)
                      {
                        while ($row = mysqli_fetch_assoc($result))
                        { ?>
                            <dd><a href="algemene_info.php?filter=<?php echo $row['categorie_name']; ?>" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                                   onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                                   style="color: #7b868c; border-radius: 3px; padding-top: 5px; padding-bottom: 5px;"><?php echo $row['categorie_name']; ?></a></dd>
                <?php  
                        }
                      } ?>
                    </dl>
                </div>

      <?php     if ($user_privilege == 'true')
                { ?>
                    <div class="large-3 columns" style="width: auto; height: auto;">
                        <button type="submit" href="#" class="show_hide_informatie_form button [radius round] right nieuwe_informatieblok"><img src="img/icons/add.png" class="add_icon">Nieuwe informatieblok</button>
                    </div>
                <?php  

                } ?>
            </div>
        </div>

    <!--nieuwe informatieblok toevoegen-->

        <div class="row" id="slidingDiv_informatieform">
            <div class="large-12 small-12 columns" style="border-radius: 3px; background-color: #ffffff; padding: 10px; margin-bottom: 10px; border: 1px solid #d8d8d8;">
                <form action="" method="post" id="categorie_form" style="padding: 10px;" data-abide>
                    <div class="large-12 small-12 columns">
                        <h4>Voeg een nieuwe informatieblok toe</h4>
                    </div>

                    <div class="large-8 columns">
                        <input type="text" placeholder="Geef hier de titel van de informatieblok in" id="informatieblok_title" name="informatieblok_title" required>
                        <small class="error">Geef de nieuwe informatieblok een titel</small>
                        <ul class="chars_left">
                            <li><p class="informatie_title_chars"></p></li>
                            <li><p>characters left</p></li>
                        </ul>
                    </div>

                    <div class="large-4 columns">
                        <select id="categorie_name" name="categorie_name" required>
                            <option value="" disabled selected>Plaats informatieblok in categorie:</option>
                            <?php require ("require/informatie_categories_dropdown.php"); ?>
                        </select>
                    </div>

                    <div class="large-12 columns" style="padding-left: 0px;">
                        <div id="informatieblok_toolbar" style="display: none; padding-bottom: 0px;">
                          <dl class="sub-nav edit_text" style="margin-bottom: 0px; margin: 0px;">
                            <dd style="margin-left: 0px;"><a data-wysihtml5-command="bold"><i class="fi-bold size-21"></i></a></dd>
                            <dd style="margin-left: 2px;"><a data-wysihtml5-command="italic" ><i class="fi-italic size-21"></i></a></dd>
                            <dd style="margin-left: 2px; margin-bottom: 0px; margin-top: 4px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h1</a></dd>
                            <dd style="margin-left: 2px; margin-bottom: 0px; margin-top: 4px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h2</a></dd>
                            <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertUnorderedList"><i class="fi-list-bullet size-21"></i></a></dd>
                            <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertOrderedList"><i class="fi-list-number size-21"></i></a></dd>
                          </dl>
                        </div>
                    </div>

                    <div class="large-8 columns left" style="margin-bottom: 20px;">
                        <textarea id="informatieblok_description" name="informatieblok_description" placeholder="Geef hier alle informatie in" style="height: 100px; border-radius: 3px;"></textarea>
                        <small class="error">Geef de informatie in</small>
                    </div>

                    <div class="large-4 columns" style="height: 100px; margin-bottom: 0px;">
                        <button type="submit" href="#" class="button [radius round]" id="btnSubmitInformatie" name="btnSubmitInformatie" 
                                style="height: 100px;
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

    <!--overzicht van informatieblok-->

    <div class="row">
        <div class="large-12 small-12 columns ervaringen" id="results">

            <?php 

              if (isset($_GET["filter"]))
              { 
                $filter  = $_GET["filter"];
                $sql = "select * from tbl_informatieblok where fk_categorie_name = '$filter' order by informatieblok_id desc LIMIT $start_from, $item_per_page";
                $results = $db->query($sql); 
              } 
              else 
              { 
                $sql = "select * from tbl_informatieblok order by informatieblok_id desc LIMIT $start_from, $item_per_page";
                $results = $db->query($sql);
              }
              
              if(mysqli_num_rows($results) > 0)
              {
                while ($row = mysqli_fetch_assoc($results))
                { ?>
                    <div class="large-4 columns dashboard_container">
                            <a href="algemene_info_details.php?id=<?php echo $row['informatieblok_id']; ?>" class="a_ervaring">
                                <div class="panel ervaring_panel" style="margin-bottom: 10px;">
                                    <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo $row['informatieblok_title']; ?></p>
                                    <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;"><?php echo strip_tags(substr($row['informatieblok_description'], 0, 250))."..."; ?></p>      
                                </div>
                            </a>
                    </div>
                <?php 
                } 
              }
              else
              {?>
                <div class="small-6 large-centered columns" style="margin-top: 25%; text-align: center;">
                    <p>er is geen informatie</p>
                </div>
              <?php
              } ?>
        </div>
    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <!--wysihtml5 editor-->

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

    <!--char limit-->

    <script src="js/char_limit.js"></script>
    <script src="js/form_animations.js"></script>

    <script>
        $(document).ready(function(){

          var elem_informatieblok_title = $(".informatie_title_chars");
          $("#informatieblok_title").limiter(150, elem_informatieblok_title);

        });
    </script>

    <!--<script type="text/javascript" src="js/pagination.js"></script>-->
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
