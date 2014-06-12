<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/evenement.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuw evenement----------------------*/

if(isset($_POST['btnSubmitEvenement']))
{
    try
    {
        $evenement_title = htmlspecialchars($_POST['evenement_title']);
        $evenement_description = htmlspecialchars($_POST['evenement_description']);
        $evenement_start_tijd = htmlspecialchars($_POST['evenement_start']);
        $evenement_stop_tijd = htmlspecialchars($_POST['evenement_stop']);

        $evenement_datum = $_POST['evenement_date'];
        $evenement_date = strtotime($_POST['evenement_date']);
        $evenement_date_fi = date('Y-m-d H:i:s', $evenement_date);

        $evenement_adress = htmlspecialchars($_POST['evenement_adress']);

        $ev = new Evenement();

        $ev->Title = htmlspecialchars($evenement_title);
        $ev->Description = htmlspecialchars($evenement_description);
        $ev->Address = htmlspecialchars($evenement_adress);

        $ev->User = $username;
        $ev->User_id = $userid;

        $ev->Date = $evenement_date_fi;
        $ev->Time_start = $evenement_start_tijd;
        $ev->Time_stop = $evenement_stop_tijd;

        $last_vraag_id = $ev->Save();
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
    $sql = "select count(*) from tbl_evenementen order by evenement_id desc";
    $result = $db->query($sql);   
}
else 
{ 
    $sql = "select count(*) from tbl_evenementen order by evenement_id desc";
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.topbar.js"></script> <!--script voor foundation-->
    <script src="js/vendor/modernizr.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/DateTimePicker.css">
    <script src="js/DateTimePicker.js"></script>

    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="css/DateTimePicker-ltie9.css"/>
        <script type="text/javascript" src="js/DateTimePicker-ltie9.js"></script>
    <![endif]-->

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
    
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--filters en add evenement-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns show-for-large-up">
            <div class="row">
                <div class="large-9 columns">
                        <dl class="sub-nav">
                          <dt>Filter:</dt>
                              <dd 
                              <?php if (isset($_GET["filter"]))
                                    { 
                                          $categorie_filter_large = $_GET["filter"];

                                        if($categorie_filter_large == "datum")
                                        {
                                            echo 'class="active"';
                                        } 
                                    } ?> >
                                  <a href="evenement.php?filter=datum" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                                     onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                                     class="filter_ervaring_fi">Datum</a>
                              </dd>
                              <dd
                              <?php if (isset($_GET["filter"]))
                                    { 
                                          $categorie_filter_large = $_GET["filter"];

                                        if($categorie_filter_large == "aantal_aanwezigen")
                                        {
                                            echo 'class="active"';
                                        } 
                                    } ?> >
                                  <a href="evenement.php?filter=aantal_aanwezigen" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                                     onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                                     class="filter_ervaring_fi">Aantal aanwezigen</a>
                              </dd>
                              <dd 
                              <?php if (isset($_GET["filter"]))
                                    { 
                                          $categorie_filter_large = $_GET["filter"];

                                        if($categorie_filter_large == "aantal_reacties")
                                        {
                                            echo 'class="active"';
                                        } 
                                    } ?> >
                                  <a href="evenement.php?filter=aantal_reacties" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                                     onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                                     class="filter_ervaring_fi">Aantal reacties</a>
                              </dd>
                        </dl>
                </div>

          <?php if($user_privilege == 'true')
                { ?>
                    <div class="large-3 columns btn_add">
                        <button type="submit" href="#" class="show_hide_evenement_form button [radius round] right nieuwe_ervaring"><img src="img/icons/add.png" class="add_icon">Nieuw evenement</button>
                    </div>
          <?php } ?>
              </div>
        </div>
    </div>
    <br/>

    <!--filters en add evenement small-->

    <div class="large-4 columns show-for-small-up hide-for-large-up">
            <div class="large-12 columns s_pad">
                <form action="" method="get" Onchange="this.form.submit()" class="n_m_btm" data-abide>
                    <select id="filter" name="filter" onchange='this.form.submit()' class="m_btm_t" required>
                        <option value="" disabled selected>Filter op:</option>
                        <option value="datum">Datum</option>
                        <option value="aantal_aanwezigen">Aantal aanwezigen</option>
                        <option value="aantal_reacties">Aantal reacties</option>
                    </select>
                </form>
            </div>

            <div class="large-12 columns s_pad">
          <?php if($user_privilege == 'true')
                {?>
                  <button type="submit" href="#" class="show_hide_evenement_form button [radius round] right nieuwe_ervaring_s"><img src="img/icons/add.png" class="add_icon">Nieuw evenement</button>
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

    <!--nieuw evenement toevoegen-->

    <div class="row" id="slidingDiv_evenementform">
        <div class="large-12 small-12 columns ervaring_form">
                <form action="" method="post" id="ervaring_form" data-abide>
                    <div class="large-12 small-12 columns">
                        <h4>Een nieuw evenement toevoegen</h4>
                    </div>

                      <div class="large-8 columns">
                        <input type="text" placeholder="Geef hier de naam van je evenement in" id="evenement_title" name="evenement_title" required>
                        <small class="error">Geef de naam van je evenement in</small>
                        <ul class="chars_left p_btm_tw">
                          <li><p class="title_chars"></p></li>
                          <li><p>overige karakters</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                          <div class="large-6 small-12 columns n_pad p_r_t">
                            <input type="text" id="evenement_start" name="evenement_start" placeholder="begin tijd evenement" data-field="time" data-view="Popup" required readonly>
                          </div>

                          <div class="large-6 small-12 columns n_pad p_l_t">
                            <input type="text" id="evenement_stop" name="evenement_stop" data-field="time" placeholder="eind tijd evenement" data-view="Popup" required readonly>
                          </div>
                      </div>

                      <div class="large-8 columns">
                        <textarea type="text" placeholder="Geef hier wat meer informatie over het evenement" id="evenement_description" name="evenement_description" required></textarea>
                        <small class="error">Geef wat informatie over je vraag, zo kan ze sneller beantwoord worden</small>
                        <ul class="chars_left n_p_btm">
                          <li><p class="description_chars"></p></li>
                          <li><p>overige karakters</p></li>
                        </ul>
                      </div>

                      <div class="large-4 columns">
                            <input type="text" id="evenement_date" name="evenement_date" placeholder="datum van het evenement" data-field="date" data-view="Popup" required readonly>
                            <input type="text" id="evenement_adress" name="evenement_adress" placeholder="adres van het evenement, vb: kruisstraat 55, Putte">
                      </div>

                      <div class="large-4 columns hide">
                          <input type="text" id="user_name" name="user_name" value="<?php echo $username; ?>">
                          <input type="text" id="user_id" name="user_id" value="<?php echo $userid; ?>">
                      </div>

                      <div class="large-4 columns">
                            <button type="submit" href="#" class="button [radius round]" id="btnSubmitEvenement" name="btnSubmitEvenement">Voeg evenement toe</button>
                      </div>
                </form>
                <div id="dtBox"></div>
        </div>
    </div>

    <!--overzicht van evenementen-->

    <div class="row">
        <div class="large-12 small-12 columns ervaringen" id="results">

            <?php 

              if (isset($_GET["filter"]))
              { 
                $filter  = $_GET["filter"];

                if($filter == "datum")
                {
                  $sql = "select * from tbl_evenementen order by evenement_date asc";
                  $results = $db->query($sql);
                }
                else if($filter == "aantal_aanwezigen")
                {
                  $sql = "select * from tbl_evenementen order by evenement_n_visit desc";
                  $results = $db->query($sql);
                }
                else if($filter == "aantal_reacties")
                {
                  $sql = "select * from tbl_evenementen order by evenement_reacties desc";
                  $results = $db->query($sql);
                }
              }
              else 
              { 
                $sql = "select * from tbl_evenementen order by evenement_id desc";
                $results = $db->query($sql);
              }
              
              if(mysqli_num_rows($results) > 0)
              {
                while ($row = mysqli_fetch_assoc($results))
                { 
                  $timenow_date_fi = date('Y-m-d', time());

                  if ($row['evenement_date'] < $timenow_date_fi)
                  {
                      $sql_del_evenement = "delete * from tbl_evenementen where evenement_id='".$row['evenement_id']."'";
                      $result_del_evenement = $db->query($sql_del_evenement);
                  }
                  else
                  {
                      $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "Mei", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
                      $date = $row['evenement_date'];
                      $date_st = explode("-", $date);
                      $month = ltrim($date_st[1], '0');
                      $month_name = $mons[$month];
                      $day = $date_st[2];
                      $year = $date_st[0];  

                      $sql_user = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                      $results_user = $db->query($sql_user);
                      $row_user = mysqli_fetch_assoc($results_user); ?>
                        <div class="large-4 columns evenement_container m_btm_tw">
                            <a href="evenement_details.php?id=<?php echo $row['evenement_id']; ?>" class="a_ervaring">
                                <div class="panel evenement_panel n_pad n_marg">
                                    <div class="large-12 columns">
                                        <!--<input type="text" id="address" name="address" value="<?php /*echo $row['evenement_adress'];*/ ?>">-->
                                        <!--<input type="submit" onclick="mapAddress('<?php echo 'map_canvas_'.$row['evenement_id']; ?>', '<?php echo $row['evenement_adress']; ?>')">-->
                                    </div>

                                    <!--<div id="map-canvas" style="width: 100%; height: 200px; overflow: hidden; border-top-left-radius: 3px; border-top-right-radius: 3px;"></div>-->
                                    <!--<div id="<?php /*echo 'map_canvas_'.$row['evenement_id'];*/ ?>" class="google_map"></div>-->

                                    <div class="large-12 small-12 columns n_pad n_marg evenement_pre_panel">
                                    <div class="large-2 small-2 columns text-center n_pad p_t evenement_pre_date_panel">
                                        <p class="evenement_pre_date_day n_m_btm text-center" style="color: #ffffff;"><?php echo $day; ?></p>
                                        <p class="evenement_pre_date_month n_m_btm text-center" style="color: #ffffff;"><?php echo $month_name; ?></p>
                                    </div>

                                    <div class="large-8 small-8 columns evenement_pre_title_panel">
                                        <p class="evenement_pre_title">
                                        <?php 
                                            if (strlen($row['evenement_title']) > 30)
                                            {
                                                echo htmlspecialchars(substr($row['evenement_title'], 0, 30))."...";
                                            }
                                            else
                                            {
                                                echo htmlspecialchars($row['evenement_title']);
                                            } ?>
                                        </p>
                                        <p class="evenement_pre_adress" style="color: #7b868c;">
                                        <?php 
                                            if (strlen($row['evenement_adress']) > 30)
                                            {
                                                echo htmlspecialchars(substr($row['evenement_adress'], 0, 30))."...";
                                            }
                                            else
                                            {
                                                echo htmlspecialchars($row['evenement_adress']);
                                            } ?>
                                            </p>
                                    </div>

                                    <div class="large-2 small-2 columns text-center n_pad evenement_pre_aanwezigen_panel">
                                        <p class="evenement_pre_nvisit n_pad n_marg" style="color: #7b868c;"><?php echo $row['evenement_n_visit']; ?></p>
                                        <p class="evenement_pre_aanw n_pad n_marg" style="color: #7b868c;">aanw.</p>
                                    </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="large-12 small-12 columns evenement_container_v_small m_btm_tw">
                            <a href="evenement_details.php?id=<?php echo $row['evenement_id']; ?>" class="a_ervaring">
                                <div class="panel evenement_panel n_pad n_marg">
                                    <div class="large-12 small-12 columns n_pad n_marg evenement_pre_panel">
                                        <div class="large-12 small-12 columns evenement_pre_title_panel">
                                            <p class="evenement_pre_title">
                                            <?php 
                                                if (strlen($row['evenement_title']) > 50)
                                                {
                                                    echo htmlspecialchars(substr($row['evenement_title'], 0, 50))."...";
                                                }
                                                else
                                                {
                                                    echo htmlspecialchars($row['evenement_title']);
                                                } ?>
                                            </p>
                                            <p class="evenement_pre_adress" style="color: #7b868c;">
                                            <?php 
                                                if (strlen($row['evenement_adress']) > 40)
                                                {
                                                    echo htmlspecialchars(substr($row['evenement_adress'], 0, 40))."...";
                                                }
                                                else
                                                {
                                                    echo htmlspecialchars($row['evenement_adress']);
                                                } ?>
                                                </p>
                                        </div>

                                        <div class="large-6 small-6 columns text-center n_pad p_t evenement_pre_date_panel">
                                            <p class="evenement_pre_date_day n_m_btm text-center" style="color: #ffffff;"><?php echo $day; ?></p>
                                            <p class="evenement_pre_date_month n_m_btm text-center" style="color: #ffffff;"><?php echo $month_name; ?></p>
                                        </div>

                                        <div class="large-6 small-6 columns text-center n_pad evenement_pre_aanwezigen_panel">
                                            <p class="evenement_pre_nvisit n_pad n_marg" style="color: #7b868c;"><?php echo $row['evenement_n_visit']; ?></p>
                                            <p class="evenement_pre_aanw n_pad n_marg" style="color: #7b868c;">aanw.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
          <?php   }
                } 
              }
              else
              {?>
                <div class="small-12 large-centered columns" style="margin-top: 15%; text-align: center;">
                    <p>er zijn momenteel nog geen evenementen aangemaakt op het platform</p>
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

    <!--DateTimePicker-->

    <script type="text/javascript">
      $(document).ready(function()
      {
       
        $("#dtBox").DateTimePicker({
          shortMonthNames: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          fullMonthNames: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "October", "November", "December"],
          shortDayNames: ["Zo", "Ma", "Di", "Wo", "Do", "Vrij", "Za"],
          fullDayNames: ["Zondag", "Maandag", "Disndag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag"],
          titleContentDate: "Kies de evenement datum",
          titleContentTime: "Kies de tijd"
        });
       
      });
    </script>

    <!--google maps-->

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>

    <script type="text/javascript">
      function mapAddress(mapElement, address) {
      var geocoder = new google.maps.Geocoder();

      geocoder.geocode({ 'address': address }, function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
              var mapOptions = {
                  zoom: 15,
                  center: results[0].geometry.location,
                  disableDefaultUI: true,
                  scrollwheel: false,
                  navigationControl: false,
                  mapTypeControl: false,
                  scaleControl: false,
                  draggable: false,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              var map = new google.maps.Map(document.getElementById(mapElement), mapOptions);
              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
          } else {
              alert("Geocode was not successful for the following reason: " + status);
          }
      });
      }
    </script>

    <!--<script>     
      var geocoder;
      var map;

      function initialize() {
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(-34.397, 150.644);
          var mapOptions = {
              zoom: 15,
              center: latlng,
              disableDefaultUI: true,
              scrollwheel: false,
              navigationControl: false,
              mapTypeControl: false,
              scaleControl: false,
              draggable: false,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          }
          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      }

      function codeAddress() {
          var address = document.getElementById('address').value;
          geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                  map.setCenter(results[0].geometry.location);
                  var marker = new google.maps.Marker({
                      map: map,
                      position: results[0].geometry.location
                  });
              } 
              else 
              {
                alert('Geocode was not successful for the following reason: ' + status);
              }
          });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
      google.maps.event.addDomListener(window, 'load', codeAddress);
    </script>-->

    <!--char limit-->

    <script src="js/char_limit.js"></script>
    <script src="js/form_animations.js"></script>

    <script>
        $(document).ready(function(){

          var elem_evenement_title = $(".title_chars");
          $("#evenement_title").limiter(150, elem_evenement_title);

          var elem_evenement_description = $(".description_chars");
          $("#evenement_description").limiter(1000, elem_evenement_description);

        });
    </script>

    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
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
