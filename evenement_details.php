<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/evenement.class.php");
require ("classes/evenement_deelnemen.class.php");
require ("classes/reactie_evenement.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe gebruiker deelname----------------------*/

if (isset($_POST['btnSubmitDeelnemen']))
{
    try
    {
      $evd = new Evenement_deelnemen();
      $evd->User_id = $userid;
      $evd->User_name = $username;
      $evd->Evenement_id = $_GET["id"];

      $evd->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------aanmaken van een nieuwe reactie----------------------*/

if(isset($_POST['btnSubmitReactie']))
{
    try
    {
      $re = new Reactie_evenement();
      $re->Description = mysql_real_escape_string($_POST['reactie_description']);

      $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

      $date = getdate();
      $month = $date['mon'];
      $day = date('d');
      $current_day = ltrim($day, '0');

      $month_name = $mons[$month];

      $evenement_date = $current_day.' '.$month_name;
      $re->Date = $evenement_date;

      $re->Evenement_id = mysql_real_escape_string($_GET['id']);
      $re->User_id = $userid;
      $re->User = $_POST['user_name'];
      $re->User_privilege = $user_privilege;

      $re->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------aanmaken van een nieuwe reactie_vt----------------------*/

if(isset($_POST['btnSubmitReactie_vt']))
{
    try
    {
      $reactie_vt = new Reactie_vt();
      $reactie_vt->User_id = $userid;
      $reactie_vt->Reactie_id = $_POST['reactie_id'];
      $reactie_vt->User_id_m = $_POST['user_id_m'];

      $user_reactie_up_val = '';

      $r1 = range(0, 249);
      $r2 = range(250, 499);
      $r3 = range(500, 749);
      $r4 = range(750, 999);
      $r5 = range(1000, 1249);
      $r6 = range(1250, 1499);
      $r7 = range(1500, 5000);
      
      switch (true) 
      {
          case in_array($user_up_v, $r1) :
               $user_reactie_up_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_reactie_up_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_reactie_up_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_reactie_up_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_reactie_up_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_reactie_up_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_reactie_up_val = 35;
          break;
      }

      $reactie_vt->User_up_v = $user_reactie_up_val;

      $reactie_vt->Save();
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
    <link rel="stylesheet" href="css/new.css"/>
    <link rel="stylesheet" href="css/animate.min.css">
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
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--overzicht van evenement details-->

    <br/>
    <br/>
    <div class="row">
        <div class="large-12 small-12 columns ervaringen">
            <?php  
                $sql_evenement_details = "select * from tbl_evenementen where evenement_id='".$_GET["id"]."'";
                $results_evenement_details = $db->query($sql_evenement_details);
                $row_evenement_details = mysqli_fetch_assoc($results_evenement_details);

                $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "Mei", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
                $date = $row_evenement_details['evenement_date'];
                $date_st = explode("-", $date);
                $month = ltrim($date_st[1], '0');
                $month_name = $mons[$month];
                $day = $date_st[2];
                $year = $date_st[0];
            ?>
            <div class="panel n_pad n_marg m_btm_t" style="border: none;">
                <div class="large-12 columns hide">
                    <input type="text" id="address" name="address" value="<?php echo $row_evenement_details['evenement_adress']; ?>">
                    <input type="button" value="Geocode" onclick="codeAddress()">
                </div>

                <div id="map-canvas"></div>

                <div class="large-12 small-12 columns show-for-large-up evenement_details_panel">
                    <div class="large-1 small-1 columns text-center p_t evenement_details_date_panel">
                        <p class="evenement_details_day n_m_btm text-center" style="color: #ffffff;"><?php echo $day; ?></p>
                        <p class="evenement_details_month n_m_btm text-center" style="color: #ffffff;"><?php echo $month_name; ?></p>
                    </div>

                    <div class="large-9 small-11 columns n_pad evenement_details_title_panel">
                        <p class="evenement_details_title" style="color: #7b868c;"><?php echo $row_evenement_details['evenement_title']; ?></p>
                        <ul class="inline-list m_btm_t">
                          <li><img src="img/icons/location.png" width="20" height="20" class="n_m_r n_p_r"></li>
                          <li><?php echo $row_evenement_details['evenement_adress']; ?></li>

                          <li><img src="img/icons/time_f.png" width="20" height="20" class="n_m_r n_p_r"></li>
                          <li><?php echo $row_evenement_details['evenement_time_start'].' - '.$row_evenement_details['evenement_time_stop']; ?></li>

                          <li><img src="img/icons/n_visit.png" width="20" height="20" class="n_m_r n_p_r"></li>
                          <li><?php echo $row_evenement_details['evenement_n_visit'].' aanwezigen'; ?></li>
                        </ul>
                    </div>

                    <?php  

                        $sql_evenement_evd = "select * from tbl_evenement_deelnames where fk_evenement_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                        $result_evenement_evd = $db->query($sql_evenement_evd);
                        $row_evenement_evd = mysqli_fetch_array($result_evenement_evd);
                                                        
                        if ($row_evenement_evd != false)
                        { ?>
                            <div class="large-2 small-12 columns n_pad btn_add_deelnemen show-for-large-up">
                                <form action="" method="post" data-abide>
                                    <button type="submit" href="#" class="button [radius round] right deelnemen_btn_di" class="btnSubmitDeelnemen_di" name="btnSubmitDeelnemen_di" disabled>
                                        <img src="img/icons/deelnemen.png" class="evenement_icon">Deelnemen
                                    </button>
                                </form>
                            </div>
                  <?php }
                        else
                        { ?>
                            <div class="large-2 small-12 columns n_pad btn_add_deelnemen show-for-large-up">
                                <form action="" method="post" data-abide>
                                    <button type="submit" href="#" class="button [radius round] right deelnemen_btn" class="btnSubmitDeelnemen" name="btnSubmitDeelnemen">
                                        <img src="img/icons/deelnemen.png" class="evenement_icon">Deelnemen
                                    </button>
                                </form>
                            </div>
                  <?php } ?>
                    <div class="large-12 small-12 columns n_pad n_m_btm">
                        <p class="evenement_details_desc" style="color: #a5b1b8;"><?php echo $row_evenement_details['evenement_description']; ?></p>
                    </div>
                </div>

  <!--overzicht van evenement details small-->

                <div class="large-12 small-12 columns evenement_details_panel_small show-for-small-up hide-for-large-up">
                    <div class="large-12 small-12 columns text-center p_t evenement_details_title_smallpanel">
                        <p class="evenement_details_title_smallday n_m_btm text-center" style="color: #ffffff;"><?php echo $day; ?></p>
                        <p class="evenement_details_title_smallmonth n_m_btm text-center" style="color: #ffffff;"><?php echo $month_name; ?></p>
                    </div>

                    <div class="large-12 small-12 columns n_pad text-center m_btm_tw">
                        <p id="evenement_details_title_small" style="color: #7b868c;"><?php echo $row_evenement_details['evenement_title']; ?></p>
                    </div>

                    <div class="large-12 small-12 columns n_pad m_btm_tw">
                        <ul class="inline-list text-center n_marg">
                            <div class="large-12 small-4 columns">
                                <li><img src="img/icons/location.png" width="20" height="20" class="n_m_r n_p_r"></li>
                                <li><?php echo $row_evenement_details['evenement_adress']; ?></li>
                            </div>

                            <div class="large-12 small-4 columns">
                                <li><img src="img/icons/time_f.png" width="20" height="20" class="n_m_r n_p_r"></li>
                                <li><?php echo $row_evenement_details['evenement_time_start'].' - '.$row_evenement_details['evenement_time_stop']; ?></li>
                            </div>

                            <div class="large-12 small-4 columns">
                                <li><img src="img/icons/n_visit.png" width="20" height="20" class="n_m_r n_p_r"></li>
                                <li><?php echo $row_evenement_details['evenement_n_visit'].' aanwezigen'; ?></li>
                            </div>
                        </ul>
                    </div>

                    <?php  

                        $sql_evenement_evd = "select * from tbl_evenement_deelnames where fk_evenement_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                        $result_evenement_evd = $db->query($sql_evenement_evd);
                        $row_evenement_evd = mysqli_fetch_array($result_evenement_evd);
                                                        
                        if ($row_evenement_evd != false)
                        { ?>
                            <div class="large-12 columns n_pad show-for-small-up hide-for-large-up">
                                <form action="" method="post" data-abide>
                                    <button type="submit" href="#" class="button [radius round] right deelnemen_btn_small_di" class="btnSubmitDeelnemen_di" name="btnSubmitDeelnemen_di" disabled>
                                        <img src="img/icons/deelnemen.png" class="evenement_icon">Deelnemen
                                    </button>
                                </form>
                            </div>
                  <?php }
                        else
                        { ?>
                            <div class="large-12 columns n_pad p_t show-for-small-up hide-for-large-up">
                                <form action="" method="post" data-abide>
                                    <button type="submit" href="#" class="button [radius round] right deelnemen_btn_small" class="btnSubmitDeelnemen" name="btnSubmitDeelnemen">
                                        <img src="img/icons/deelnemen.png" class="evenement_icon">Deelnemen
                                    </button>
                                </form>
                            </div>
                  <?php } ?>
                    <div class="large-12 small-12 columns n_pad">
                        <p id="evenement_details_description_small" style="color: #a5b1b8;"><?php echo $row_evenement_details['evenement_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <!--reactie form-->
                    
    <div class="row">
        <div class="large-12 small-12 columns">
            <div class="row">
                <form action="" method="post" id="reactie_form" data-abide>
                    <div class="large-1 columns">
                        <?php  
                            $sql_user = "select * from tbl_users where user_id='".$userid."'";
                            $results_user = $db->query($sql_user);
                            $row_user = mysqli_fetch_assoc($results_user);
                        ?>
                        <img src="<?php echo $row_user['user_profile_path']; ?>" id="profile_reactie_evcomment"
                        <?php 
                            if ($user_privilege == 'true')
                            { ?>
                                style="border: 3px solid #5db0c6;"
                        <?php 
                            } 
                            else
                            {
                                                  
                            } ?>
                                class="show-for-large-up">
                    </div>

                    <div class="large-8 columns">
                        <textarea type="text" placeholder="Geef hier een reactie in" id="reactie_description" name="reactie_description" required></textarea>
                        <small class="error">Geef een reactie in</small>
                    </div>

                    <div class="large-8 columns hide">
                        <input type='text' id='user_name' name='user_name' value="<?php echo $username; ?>"/>
                        <input type='text' id='user_id' name='user_id' value="<?php echo $userid; ?>"/>
                        <input type='text' id='user_profile' name='user_profile' value="<?php echo $row_user['user_profile_path']; ?>"/>
                        <input type='text' id='user_privilege' name='user_privilege' value="<?php echo $user_privilege; ?>"/>
                        <input type='text' id='evenement_id' name='evenement_id' value="<?php echo $_GET['id']; ?>"/>
                    </div>

                    <div class="large-3 columns">
                        <button type="submit" href="#" class="button [radius round] right" id="btnSubmitReactie" name="btnSubmitReactie">Voeg reactie toe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--overzicht van comments-->
    
    <div class="row" style="padding: 15px;">
    <div class="large-12 small-12 columns n_pad">
    <div class="large-12 small-12 columns n_pad" id="reacties_update">
    </div>
        <?php 
            $sql = "select * from tbl_reacties_evenementen where fk_evenement_id='".$_GET['id']."' order by reactie_id desc";
            $result = $db->query($sql);

            if(mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                { 

                    $sql_user = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                    $results_user = $db->query($sql_user);
                    $row_user = mysqli_fetch_assoc($results_user); ?>

                    <div class="large-12 columns reactie">
                        <div class="large-1 small-2 columns w_h_auto evenement_reactie_img">
                            <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>">
                            <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="reactie_profile_img"
                            <?php 
                                if ($row['fk_user_privilege'] == "true")
                                { ?>
                                    style="border-radius: 30px; border: 3px solid #5db0c6;"
                            <?php 
                                } ?> ></a>
                        </div>

                        <div class="large-11 small-10 columns n_pad_left">
                            <ul class="ul_reacties_evenementen">
                                <li><?php echo htmlspecialchars($row['fk_user_name']).' '.htmlspecialchars($row['reactie_date']); ?></li>
                                <li class="hide"><?php echo htmlspecialchars($row['fk_user_id']) ?></li>
                                <li class="reactie_desc"><?php echo htmlspecialchars($row['reactie_description']); ?></li>
                            </ul>
                        </div>
                    </div>
          <?php } 
            }
            else
            { ?>
                <div class="row" style="text-align: center;">
                    <p>er zijn nog geen reacties geplaatst op dit evenement</p>
                </div>
      <?php  
            } ?>
        </div>
    </div>
    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>

    <!--google maps-->

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>

    <script>   
      var geocoder;
      var map;

      function initialize() {
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(-34.397, 150.644);
          var mapOptions = {
              zoom: 15,
              center: latlng,
              disableDefaultUI: true,
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
    </script>

    <!--aanmaken van een reactie-->
    
    <!--<script type="text/javascript">
      $(document).ready(function(){

          $("#btnSubmitReactie").on("click", function(e){
          
              e.preventDefault();
              
              var reactie_description = $('#reactie_description').val();
              var user_name = $('#user_name').val();
              var user_id = $('#user_id').val();
              var user_profile = $('#user_profile').val();
              var user_privilege = $('#user_privilege').val();
              var evenement_id = $('#evenement_id').val();

              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "ajax/save_reactie_evenement.php",
                  data: { reactie_description : reactie_description, user_name : user_name, user_id : user_id, user_privilege : user_privilege, evenement_id : evenement_id },
                  cache: false,
                  success: function(data) {

                      var reactie_update = '<div class="large-12 columns reactie">'+
                                              '<div class="large-1 small-2 columns w_h_auto">'+
                                                  '<a href="profile_details.php?user='+user_id+'">'+
                                                      '<img src="'+user_profile+'" width="40" height="40" class="reactie_profile_img">'+
                                                  '</a>'+
                                              '</div>'+

                                              '<div class="large-11 small-10 columns n_pad_left">'+
                                                  '<ul class="ul_reacties_evenementen">'+
                                                      '<li>'+user_name+' - '+data.evenement_date+'</li>'+
                                                      '<li class="hide">'+user_id+'</li>'+
                                                      '<li class="reactie_desc">'+reactie_description+'</li>'+
                                                  '</ul>'+
                                              '</div>'+
                                           '</div>';

                      $('#reactie_description').html("");
                      $('#reacties_update').prepend(reactie_update).addClass('animated bounceIn');
                  },
                  error: function() {
                      $('#feedback_message').html("Er is en probleem en je reactie is niet toegevoegd, probeer het nog eens");
                      $('#feedback').slideDown();
                  }
              });

          });
      });
    </script>-->

    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
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
