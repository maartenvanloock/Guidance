<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/reactie.class.php");
require ("classes/reactie_vt_vraag.class.php");
require ("classes/vraag_vt.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe reactie----------------------*/

if(isset($_POST['btnSubmitReactie']))
{
    try
    {
      $r = new Reactie();
      $r->Description = mysql_real_escape_string($_POST['reactie_description']);

      $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maart", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Augustus", 9 => "September", 10 => "October", 11 => "November", 12 => "December");

      $date = getdate();
      $month = $date['mon'];
      $day = date('d');
      $current_day = ltrim($day, '0');

      $month_name = $mons[$month];

      $ervaring_date = $current_day.' '.$month_name;
      $r->Date = $ervaring_date;

      $r->Vraag_id = mysql_real_escape_string($_GET['id']);
      $r->Ervaring_id = 0;
      $r->Evenement_id = 0;
      $r->User_id = $userid;
      $r->User = $username;
      $r->User_privilege = $user_privilege;

      $r->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------aanmaken van een nieuwe reactie_vt----------------------*/

if(isset($_POST['btnSubmitReactie_vt_up']))
{
    try
    {
      $reactie_vt_up = new Reactie_vt_vraag();
      $reactie_vt_up->User_id = $userid;
      $reactie_vt_up->Reactie_id = $_POST['reactie_id'];
      $reactie_vt_up->Reactie_st = "up";
      $reactie_vt_up->User_id_m = $_POST['user_id_m'];

      $user_reactie_up_val = ' ';

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

      $reactie_vt_up->User_up_v = $user_reactie_up_val;

      $reactie_vt_up->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}
else if(isset($_POST['btnSubmitReactie_vt_down']))
{
    try
    {
      $reactie_vt_down = new Reactie_vt_vraag();
      $reactie_vt_down->User_id = $userid;
      $reactie_vt_down->Reactie_id = $_POST['reactie_id'];
      $reactie_vt_down->Reactie_st = "down";
      $reactie_vt_down->User_id_m = $_POST['user_id_m'];

      $user_reactie_down_val = ' ';

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
               $user_reactie_down_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_reactie_down_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_reactie_down_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_reactie_down_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_reactie_down_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_reactie_down_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_reactie_down_val = 35;
          break;
      }

      $reactie_vt_down->User_down_v = $user_reactie_down_val;

      $reactie_vt_down->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------aanmaken van een nieuwe vraag_vt----------------------*/

if(isset($_POST['btnSubmitVraag_vt_up']))
{
    try
    {
      $vraag_vt_up = new Vraag_vt();
      $vraag_vt_up->User_id = $userid;
      $vraag_vt_up->Vraag_id = $_GET['id'];
      $vraag_vt_up->Vraag_st = "up";
      $vraag_vt_up->User_id_m = $_POST['user_id_m'];

      $user_vraag_up_val = ' ';

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
               $user_vraag_up_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_vraag_up_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_vraag_up_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_vraag_up_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_vraag_up_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_vraag_up_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_vraag_up_val = 35;
          break;
      }

      $vraag_vt_up->User_up_v = $user_vraag_up_val;

      $vraag_vt_up->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}
else if(isset($_POST['btnSubmitVraag_vt_down']))
{
    try
    {
      $vraag_vt_down = new Vraag_vt();
      $vraag_vt_down->User_id = $userid;
      $vraag_vt_down->Vraag_id = $_GET['id'];
      $vraag_vt_down->Vraag_st = "down";
      $vraag_vt_down->User_id_m = $_POST['user_id_m'];

      $user_vraag_down_val = ' ';

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
               $user_vraag_down_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_vraag_down_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_vraag_down_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_vraag_down_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_vraag_down_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_vraag_down_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_vraag_down_val = 35;
          break;
      }

      $vraag_vt_down->User_down_v = $user_vraag_down_val;

      $vraag_vt_down->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------toevoegen van nieuwe tags aan een vraag----------------------*/

if (isset($_POST['btnSubmitNewTags']) || isset($_POST['btnSubmitNewTagsSmall']))
{
  try
  {
    $tag_string = $_POST['new_added_tags'];
    $tags = preg_split("/[\s,]+/", $tag_string);
    $result_tags = array_unique($tags);
    $tags_lim = count($result_tags);

    for ($x = 0; $x < $tags_lim; $x++)
    {
        $sql_tags = "insert into tbl_tags_vragen(tag_name, fk_vraag_id, fk_user_id) values ('".$tags[$x]."', '".$_GET["id"]."', '".$_SESSION['userid']."')";
        $result_q = $db->query($sql_tags);
    }
  }
  catch (Exception $e)
  {
      $feedback = $e->getMessage();
  } 
}

/*---------------------Vraag markeren als beantwoord----------------------*/

if (isset($_POST['btnMarkeerBeantwoord']) || isset($_POST['btnMarkeerBeantwoordsmall']))
{
  try
  {
      $sql_beantwoord = "update tbl_vragen set vraag_solved=vraag_solved+1 where vraag_id='".$_GET['id']."'";
      $result_beantwoord = $db->query($sql_beantwoord);
  }
  catch (Exception $e)
  {
      $feedback = $e->getMessage();
  } 
}

/*---------------------Vraag markeren als gedupliceerd----------------------*/

if (isset($_POST['btnSubmitDuplicate']))
{
  try
  {   
      $beantwoorde_vraag = $_POST['beantwoorde_vraag'];
      $components = explode('?', $beantwoorde_vraag);
      $beantwoorde_vraag_link = $components[1];

      $timezone = date_default_timezone_get();
      $duplicate_date = date('Y-m-d H:i:s', time() + 86400);

      $sql_duplicate = "update tbl_vragen set vraag_solved=2 where vraag_id='".$_GET['id']."'";
      $result_duplicate = $db->query($sql_duplicate);

      $sql_duplicate_link = "insert into tbl_vraag_duplicate(duplicate_link, duplicate_date, fk_vraag_id, fk_user_id, fk_user_name) values ('".$beantwoorde_vraag_link."', '".$duplicate_date."', '".$_GET['id']."', '".$userid."', '".$username."')";
      $result_duplicate = $db->query($sql_duplicate_link);
  }
  catch (Exception $e)
  {
      $feedback = $e->getMessage();
  } 
}

/*---------------------Vraag markeren als gedupliceerd small----------------------*/

if (isset($_POST['btnSubmitDuplicatesmall']))
{
  try
  {   
      $beantwoorde_vraag = $_POST['beantwoorde_vraag_small'];
      $components = explode('?', $beantwoorde_vraag);
      $beantwoorde_vraag_link = $components[1];

      $timezone = date_default_timezone_get();
      $duplicate_date = date('Y-m-d H:i:s', time() + 86400);

      $sql_duplicate = "update tbl_vragen set vraag_solved=2 where vraag_id='".$_GET['id']."'";
      $result_duplicate = $db->query($sql_duplicate);

      $sql_duplicate_link = "insert into tbl_vraag_duplicate(duplicate_link, duplicate_date, fk_vraag_id, fk_user_id, fk_user_name) values ('".$beantwoorde_vraag_link."', '".$duplicate_date."', '".$_GET['id']."', '".$userid."', '".$username."')";
      $result_duplicate = $db->query($sql_duplicate_link);
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
    <title>Guidance | Vraag details</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css"/>
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

    <!--google analytics-->

    <?php include_once("require/analyticstracking.php") ?>

  </head>

  <body>
    
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--overzicht van vraag details-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-8 columns">
                <?php  
                  $sql = "select * from tbl_vragen where vraag_id='".$_GET['id']."'";
                  $result = $db->query($sql);
                  $row = mysqli_fetch_assoc($result);

                  $sql_user_details = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                  $results_user_details = $db->query($sql_user_details);
                  $row_user_details = mysqli_fetch_assoc($results_user_details);
                ?>

    <!--overzicht van vraag details medium and up-->

                    <div class="panel ervaring_detail_panel show-for-medium-up">
                        <ul class="small-block-grid-2 profile_info">
                            <li class="n_p_r" style="width: 10%; padding-bottom: 0px;">
                            <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>"><img src="<?php echo $row_user_details['user_profile_path']; ?>" style="width: 40px; height: 40px;" class="profile_img_details"></a>
                            <?php  

                                $sql_ervaring_vt = "select * from tbl_vragen_vt where fk_vraag_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                                $result_ervaring_vt = $db->query($sql_ervaring_vt);
                                $row_ervaring_vt = mysqli_fetch_array($result_ervaring_vt);
                                                        
                                if ($row_ervaring_vt != false || $row['fk_user_id'] == $userid)
                                { ?>
                                    <form action="" method="post" class="vote_ervaring_med text-center" data-abide>
                                        <div class="row hide">
                                            <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                   id="user_id_m" name="user_id_m">      
                                        </div>

                                        <span>
                                            <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitVraag_vt_up" style="background-color: #e6e6e6; color: #7b868c;"
                                                    title="Je kan je eigen vraag niet upvoten" disabled><i class="fi-arrow-up size-24"></i></button>
                                            <p id="vt_ervaring"><?php echo $row['vraag_likes']; ?></p>
                                            <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitVraag_vt_down" style="background-color: #e6e6e6; color: #7b868c;" 
                                                    title="Je kan je eigen vraag niet downvoten" disabled><i class="fi-arrow-down size-24"></i></button>
                                        </span>
                                    </form>
                          <?php }
                                else
                                { ?>
                                  <form action="" method="post" class="vote_ervaring_med text-center" data-abide>
                                      <div class="row hide">
                                          <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                 id="user_id_m" name="user_id_m">      
                                      </div>

                                      <span>
                                          <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitVraag_vt_up" style="background-color: #e6e6e6; color: #7b868c;"
                                                  title="upvote deze vraag"><i class="fi-arrow-up size-24"></i></button>
                                          <p id="vt_ervaring"><?php echo $row['vraag_likes']; ?></p>
                                          <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitVraag_vt_down" style="background-color: #e6e6e6; color: #7b868c;"
                                                  title="downvote deze vraag"><i class="fi-arrow-down size-24"></i></button>
                                      </span>
                                  </form>
                          <?php } ?>

                                <form action="" method="post" class="n_m_btm m_tp_tw" style="margin-left: 5px;" data-abide>
                                <?php  
                                      $sql_vraag = "select * from tbl_vragen where vraag_id='".$_GET['id']."'";
                                      $result_vraag = $db->query($sql_vraag);
                                      $row_vraag = mysqli_fetch_assoc($result_vraag);

                                      $sql_reacties_exist = "select * from tbl_reacties where fk_vraag_id='".$_GET['id']."' limit 1";
                                      $result_reacties_exist = $db->query($sql_reacties_exist);
                                      $row_reacties_exist = mysqli_fetch_assoc($result_reacties_exist);

                                      if ($row_vraag['vraag_solved'] == 1)
                                      { ?>
                                          <button style="margin: 0px; padding: 0px; background-color: #ffffff;" disabled>
                                              <img src="img/icons/beantwoord_selected.png" width="30" height="30" alt="Deze vraag is beantwoord" title="Deze vraag is beantwoord">
                                          </button>
                                <?php }
                                      else if ($row_vraag['vraag_solved'] == 0 && $row_vraag['fk_user_id'] == $userid && $row_reacties_exist != false)
                                      { ?>
                                          <button id="btnMarkeerBeantwoord" name="btnMarkeerBeantwoord" style="margin: 0px; padding: 0px; background-color: #ffffff;">
                                              <img src="img/icons/beantwoord.png" id="vraag_beantwoord" width="30" height="30" alt="Markeer deze vraag als beantwoord" title="Markeer deze vraag als beantwoord">
                                          </button>
                                <?php }
                                      else if ($row_vraag['vraag_solved'] == 0 && $row_vraag['fk_user_id'] == $userid && $row_reacties_exist != true)
                                      { ?>
                                          <button style="margin: 0px; padding: 0px; background-color: #ffffff;" disabled>
                                              <img src="img/icons/beantwoord.png" id="vraag_beantwoord" width="30" height="30" alt="Er moet een reactie op je vraag geplaatst zijn voor je deze kunt markeren als beantwoord" 
                                                   title="Er moet een reactie op je vraag geplaatst zijn voor je deze kunt markeren als beantwoord">
                                          </button>
                                <?php }
                                      else if ($user_privilege == 'true' && $row_vraag['vraag_solved'] == 0)
                                      { ?>
                                          <button style="margin: 0px; padding: 0px; background-color: #ffffff;" disabled>
                                              <img src="img/icons/duplicate.png" id="btnMarkeerDuplicate" name="btnMarkeerDuplicate" class="show_hide_duplicate_form" width="30" height="30" alt="Markeer deze vraag als duplicate" title="Markeer deze vraag als duplicate">
                                          </button>
                                <?php }
                                      else if ($row_vraag['vraag_solved'] == 2)
                                      { ?>
                                          <button style="margin: 0px; padding: 0px; background-color: #ffffff;" disabled>
                                              <img src="img/icons/duplicate_selected.png" width="30" height="30" alt="Deze vraag is gemarkeerd als gedupliceerd" title="Deze vraag is gemarkeerd als gedupliceerd">
                                          </button>
                                <?php } ?>
                                </form>
                            </li>
                            <li style="width: 90%; padding-left: 10px; padding-bottom: 0px;">
                                <p class="ervaring_details_title" style="color: #7b868c;"><?php echo htmlspecialchars($row['vraag_title']); ?></p>
                                <p class="ervaring_details_username" style="color: #7b868c;"><?php echo htmlspecialchars('gevraagd door: '.$row['fk_user_name']); ?></p>
                                <p class="ervaring_details_desc" style="color: #a5b1b8;"><?php echo htmlspecialchars($row['vraag_description']); ?></p>
                                  <?php  
                                      $sql_tags = "select * from tbl_tags_vragen where fk_vraag_id='".$_GET['id']."'";
                                      $result_tags = $db->query($sql_tags);

                                      if(mysqli_num_rows($result_tags) > 0)
                                      { ?>
                                        <dl class="sub-nav" style="margin-bottom: 0px; padding-bottom: 5px;">
                                            <dt style="margin-left: 10px;">Tags:</dt>
                                <?php   while ($row_tags = mysqli_fetch_assoc($result_tags))
                                        { ?>
                                            <dd class="active"><a href="vraag_tags.php?tag=<?php echo $row_tags['tag_name'] ?>"><?php echo $row_tags['tag_name'] ?></a></dd>
                                <?php  
                                        } ?>
                                            <dd class="active show_hide_tags_form">
                                                <a type="submit" href="#"><img src="img/icons/add.png" class="add_icon">Voeg nieuwe tags toe</a>
                                            </dd>
                                        </dl>
                                <?php } ?>

                                <div class="row" id="slidingDiv_tagsform">
                                    <div class="large-12 small-12 columns n_pad">
                                        <form action="" method="post" data-abide>
                                            <div class="large-8 small-8 columns n_m_btm">
                                                <input type="text" id="new_added_tags" name="new_added_tags" placeholder="voeg nieuwe tags toe, scheidt ze van elkaar met een komma">
                                            </div>

                                            <div class="large-4 small-4 columns add_btn" style="padding-left: 0px;">
                                                <button type="submit" class="button [radius round] right" id="btnSubmitNewTags" name="btnSubmitNewTags">Voeg tags toe</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="row" id="slidingDiv_duplicateform">
                                    <div class="large-12 small-12 columns n_pad">
                                        <form action="" method="post" data-abide>
                                            <div class="large-8 small-8 columns n_m_btm">
                                                <input type="text" id="beantwoorde_vraag" name="beantwoorde_vraag" placeholder="Geef hier de url link naar de vraag met het antwoord" required>
                                            </div>

                                            <div class="large-4 small-4 columns add_btn" style="padding-left: 0px;">
                                                <button type="submit" class="button [radius round] right" id="btnSubmitDuplicate" name="btnSubmitDuplicate">Markeer als gedupliceerd</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

    <!--overzicht van vraag details small-->

                    <div class="large-12 small-12 columns ervaring_details_small show-for-small hide-for-medium-up">
                        <ul class="profile_info" style="list-style: none; margin-bottom: 0px;">
                            <li class="profile_img_name text-center">
                                <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>"><img src="<?php echo $row_user_details['user_profile_path']; ?>" class="profile_img_details_small" width="60" height="60"></a>
                                <p class="profile_name"><?php echo htmlspecialchars($row['fk_user_name']); ?></p>
                            </li>

                            <li style="width: 100%; padding: 0px;">
                                <p class="ervaring_details_title"><?php echo htmlspecialchars($row['vraag_title']); ?></p>
                                <p class="ervaring_details_desc"><?php echo htmlspecialchars($row['vraag_description']); ?></p>
                                <?php  
                                    $sql_tags = "select * from tbl_tags_vragen where fk_vraag_id='".$_GET['id']."'";
                                    $result_tags = $db->query($sql_tags); 

                                    if(mysqli_num_rows($result_tags) > 0)
                                    { ?>
                                        <div class="row" style="margin-left: 0px; margin-right: 0px; margin-top: 0px; margin-bottom: 0px;">
                                            <div class="large-12 columns" style="padding: 0px; margin-top: 20px; margin-top: 0px; margin-bottom: 0px;">
                                                <div class="large-12 large-centered columns text-center n_pad">
                                                    <h4 class="details_tags_small">Tags</h4>
                                                </div>
                                <?php   while ($row_tags = mysqli_fetch_assoc($result_tags))
                                        { ?>
                                                <div class="large-6 small-6 columns text-center n_pad">
                                                    <div class="panel tag_panel_small">
                                                        <a href="vraag_tags.php?tag=<?php echo $row_tags['tag_name'] ?>" style="color: #ffffff;"><?php echo $row_tags['tag_name'] ?></a>
                                                    </div>
                                                </div>
                                  <?php  
                                        } ?>
                                                <div class="large-12 small-12 columns text-center n_pad m_tp_t">
                                                    <div class="row" style="margin-left: 5px; margin-right: 5px;">
                                                        <button class="show_hide_smalltags_form" type="submit" id="btnSubmitNewTagsSmall" name="btnSubmitNewTagsSmall"><img src="img/icons/add.png" class="add_icon">Voeg nieuwe tags toe</button>
                                                    </div>
                                                </div>
                                          </div>
                                      </div>
                                <?php } ?>
                                      <div class="row" id="slidingDiv_small_tagsform" style="margin-left: 5px; margin-right: 5px;">
                                          <div class="large-12 small-12 columns n_pad">
                                              <form action="" method="post" data-abide style="margin-bottom: 10px;">
                                                      <input type="text" id="new_added_tags_small" name="new_added_tags" placeholder="voeg nieuwe tags toe, scheidt ze van elkaar met een komma">
                                                      <button type="submit" href="#" class="button [radius round] right" id="btnSubmitNewTags" name="btnSubmitNewTags">Voeg tags toe</button>
                                              </form>
                                          </div>
                                      </div>
                            </li>
                        </ul>

                        <?php  

                            $sql_vraag_vt = "select * from tbl_vragen_vt where fk_vraag_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                            $result_vraag_vt = $db->query($sql_vraag_vt);
                            $row_vraag_vt = mysqli_fetch_array($result_vraag_vt);
                                                        
                            if ($row_ervaring_vt != false || $row['fk_user_id'] == $userid)
                            { ?>
                                <div class="row n_marg_lr" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 small-12 columns" style="padding: 0px; margin-top: 0px;">
                                        <form action="" method="post" class="text-center" style="margin: 0px; margin-top: 15px; margin-left: 5px; margin-right: 5px;" data-abide>
                                            <div class="large-12 columns hide">
                                                <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                       id="user_id_m" name="user_id_m">      
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                  <button type="submit" class="btnSubmitVraag_vt_up" name="btnSubmitVraag_vt_up" 
                                                          style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-up size-24"></i></button>
                                            </div>

                                            <div class="large-2 small-2 columns text-center">
                                                <p id="vt_ervaring" style="width: 100%;"><?php echo $row['vraag_likes']; ?></p>
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitVraag_vt_down" name="btnSubmitVraag_vt_down" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-down size-24"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                      <?php }
                            else
                            { ?>
                                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 columns" style="padding: 0px; margin-top: 0px;">
                                        <form action="" method="post" class="text-center" style="margin: 0px; margin-top: 15px; margin-left: 5px; margin-right: 5px;" data-abide>
                                            <div class="row hide">
                                                <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                       id="user_id_m" name="user_id_m">      
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitVraag_vt_up" name="btnSubmitVraag_vt_up" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-up size-24"></i></button>
                                            </div>

                                            <div class="large-2 small-2 columns text-center">
                                                <p id="vt_ervaring" style="width: 100%;"><?php echo $row['vraag_likes']; ?></p>
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitVraag_vt_down" name="btnSubmitVraag_vt_down" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-down size-24"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                      <?php } ?>

                            <form action="" method="post" class="n_m_btm m_tp_tw" style="margin-left: 5px;" data-abide>
                                <?php  
                                      if ($row_vraag['vraag_solved'] == 1)
                                      { ?>

                                <?php }
                                      else if ($row_vraag['vraag_solved'] == 0 && $row_vraag['fk_user_id'] == $userid && $row_reacties_exist != false)
                                      { ?>
                                          <button type="submit" class="button [radius round] right nieuwe_ervaring_s" 
                                                  id="btnMarkeerBeantwoordsmall" name="btnMarkeerBeantwoordsmall" alt="Markeer deze vraag als beantwoord" 
                                                  title="Markeer deze vraag als beantwoord">
                                              <img src="img/icons/beantwoord_w_s.png" width="30" height="30" class="add_icon">Markeer als beantwoord
                                          </button>
                                <?php }
                                      else if ($row_vraag['vraag_solved'] == 0 && $row_vraag['fk_user_id'] == $userid && $row_reacties_exist != true)
                                      { ?>
                                          <button type="submit" class="button [radius round] right btnBeantwoord" 
                                                  alt="Je kan deze ervaring nog niet als beantwoord markeren, want er zijn nog geen reacties geplaatst"
                                                  title="Je kan deze ervaring nog niet als beantwoord markeren, want er zijn nog geen reacties geplaatst" disabled>
                                                  <img src="img/icons/beantwoord.png" width="30" height="30" class="add_icon">Markeer als beantwoord
                                          </button>
                                <?php } ?>
                            </form>
                            <div class="large-12 small-12 columns" style="padding-left: 5px; padding-right: 5px;">
                                <?php if ($user_privilege == 'true' && $row_vraag['vraag_solved'] == 0)
                                      { ?>
                                          <button class="show_hide_small_duplicateform button [radius round] right nieuwe_ervaring_s n_m_btm" 
                                                  id="btnMarkeerDuplicatesmall" name="btnMarkeerDuplicatesmall" alt="Markeer deze vraag als gedupliceerd" 
                                                  title="Markeer deze vraag als gedupliceerd" style="width: 100%;">
                                              <img src="img/icons/duplicate_s_w.png" width="30" height="30" class="add_icon">Markeer als gedupliceerd
                                          </button>
                                <?php }
                                      else if ($user_privilege == 'true' && $row_vraag['vraag_solved'] == 2)
                                      { ?>
                                          
                                <?php } ?>

                                      <div class="row" id="slidingDiv_small_duplicateform" style="margin-left: 5px; margin-right: 5px;">
                                          <div class="large-12 small-12 columns n_pad">
                                              <form action="" method="post" style="margin-bottom: 10px; margin-top: 20px;" data-abide>
                                                  <input type="text" id="beantwoorde_vraag_small" name="beantwoorde_vraag_small" placeholder="Geef hier de url link naar de vraag met het antwoord" required>
                                                  <button type="submit" class="button [radius round] right" id="btnSubmitDuplicatesmall" name="btnSubmitDuplicatesmall">Markeer als gedupliceerd</button>
                                              </form>
                                          </div>
                                      </div>
                            </div>
                    </div>
                
    <!--reactie form-->
                    
                   <div class="row">
                       <div class="large-12 columns">
                           <div class="row">
                                <form action="" method="post" data-abide>
                                    <div class="large-1 columns">
                                        <?php  
                                            $sql_user = "select * from tbl_users where user_id='".$userid."'";
                                            $results_user = $db->query($sql_user);
                                            $row_user = mysqli_fetch_assoc($results_user);
                                        ?>
                                        <img src="<?php echo $row_user['user_profile_path']; ?>" id="profile_img_comment"
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
                                      <?php  
                                            if ($row_vraag['vraag_solved'] == 0 || $row_vraag['vraag_solved'] == 1)
                                            { ?>
                                                <textarea type="text" placeholder="Geef hier je reactie in" 
                                                          style="resize: vertical; height: 38px; border-radius: 3px;" id="reactie_description" name="reactie_description" required></textarea>
                                      <?php }
                                            else if ($row_vraag['vraag_solved'] == 2) 
                                            { ?>
                                                <textarea type="text" placeholder="Geef hier je reactie in" 
                                                          style="resize: vertical; height: 38px; border-radius: 3px;" id="reactie_description" name="reactie_description" disabled></textarea>
                                      <?php } ?>
                                        <small class="error">Geef een reactie in</small>
                                        <ul class="chars_left hide">
                                          <li><p class="description_chars"></p></li>
                                          <li><p>characters left</p></li>
                                        </ul>
                                    </div>

                                    <div class="large-8 columns hide">
                                        <input type='text' id='user_name' name='user_name' value="<?php echo $username; ?>"/>
                                        <input type='text' id='user_id' name='user_id' value="<?php echo $userid; ?>"/>
                                        <input type='text' id='user_profile' name='user_profile' value="<?php echo $row_user['user_profile_path']; ?>"/>
                                        <input type='text' id='user_privilege' name='user_privilege' value="<?php echo $user_privilege; ?>"/>
                                        <input type='text' id='vraag_id' name='vraag_id' value="<?php echo $_GET['id']; ?>"/>
                                    </div>

                                  <?php  
                                        if ($row_vraag['vraag_solved'] == 0 || $row_vraag['vraag_solved'] == 1)
                                        { ?>
                                            <div class="large-3 columns">
                                                <button type="submit" href="#" class="button [radius round] right" id="btnSubmitReactie" name="btnSubmitReactie">Voeg reactie toe</button>
                                            </div>
                                  <?php }
                                        else if ($row_vraag['vraag_solved'] == 2) 
                                        { ?>
                                             <div class="large-3 columns">
                                                <button type="submit" href="#" class="button [radius round] right" id="btnSubmitReactie" name="btnSubmitReactie" disabled>Voeg reactie toe</button>
                                            </div>
                                  <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>

    <!--overzicht van het beste antwoord op de vraag-->

            <?php 

                    if ($row_vraag['vraag_solved'] == 1)
                    { 
                      $sql_beste_antwoord = "select * from tbl_reacties where fk_vraag_id='".$_GET['id']."' order by reactie_likes desc limit 1";
                      $result_beste_antwoord = $db->query($sql_beste_antwoord);
                      $row_beste_antwoord = mysqli_fetch_assoc($result_beste_antwoord); 
                      $beste_antwoord = $row_beste_antwoord['fk_user_name']; 

                      $sql_beste_antwoord_exist = "select * from tbl_reactie_beantwoord where fk_vraag_id='".$_GET['id']."' and fk_user_id='".$row_beste_antwoord['fk_user_id']."' limit 1";
                      $result_beste_antwoord_exist = $db->query($sql_beste_antwoord_exist);
                      $row_beste_antwoord_exist = mysqli_fetch_array($result_beste_antwoord_exist);
                                                        
                      if ($row_beste_antwoord_exist != true)
                      {
                          $sql_s_beste_antwoord = "insert into tbl_reactie_beantwoord (fk_vraag_id, fk_user_id, fk_user_name, fk_reactie_id) 
                                                   values ('".$_GET['id']."', '".$row_beste_antwoord['fk_user_id']."', '".$row_beste_antwoord['fk_user_name']."', '".$row_beste_antwoord['reactie_id']."')";
                          $result_s_beste_antwoord = $db->query($sql_s_beste_antwoord); 
                      }
                      else
                      {

                      } ?>

                        <div class="row text-center">
                            <div class="large-12 columns text-center">
                               <div data-alert="" class="alert-box success radius">
                                   <p id="conf_message" style="font-size: 16px;"><?php echo 'Deze vraag is beantwoord, het beste antwoord werd gegeven door: '.$beste_antwoord; ?></p>
                               </div>
                            </div>
                        </div>
            <?php  
                    } ?>

    <!--overzicht van het gedupliceerde vraag-->

            <?php 

                    if ($row_vraag['vraag_solved'] == 2)
                    { 
                      $sql_duplicate_antwoord = "select * from tbl_vraag_duplicate where fk_vraag_id='".$_GET['id']."'";
                      $result_duplicate_antwoord = $db->query($sql_duplicate_antwoord);
                      $row_duplicate_antwoord = mysqli_fetch_array($result_duplicate_antwoord); ?>

                        <div class="row text-center">
                            <div class="large-12 columns text-center">
                               <div data-alert="" class="alert-box warning radius">
                                   <p id="conf_message" style="font-size: 16px;">
                                      <?php echo 'Deze vraag is gemarkeerd als gedupliceerd en zal verwijderd worden, maar een antwoord kan u <a href="vraag_details.php?'.$row_duplicate_antwoord['duplicate_link'].'" id="duplicate_link">hier</a> terug vinden'; ?>
                                   </p>
                               </div>
                            </div>
                        </div>
            <?php  
                    } ?>

    <!--overzicht van comments-->

                    <div class="large-12 small-12 columns n_pad m_btm_tw">
                        <?php 
                            $sql = "select * from tbl_reacties where fk_vraag_id='".$_GET['id']."' order by reactie_likes desc";
                            $result = $db->query($sql);

                            if(mysqli_num_rows($result) > 0)
                            {
                                while ($row = mysqli_fetch_assoc($result))
                                { 
                                  $sql_user = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                                  $results_user = $db->query($sql_user);
                                  $row_user = mysqli_fetch_assoc($results_user); ?>
                                    <div class="large-12 columns reactie">
                                        <div class="large-1 small-2 columns w_h_auto reactie_img_small_d">

                                            <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>">
                                            <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="reactie_profile_img reactie_profile_img_vsmall"
                                    <?php 
                                            if ($row['fk_user_privilege'] == "true")
                                            { ?>
                                              style="border-radius: 30px; border: 3px solid #5db0c6;"
                                    <?php 
                                            } ?>
                                            ></a>
                                        </div>

                                        <div class="large-10 small-10 columns n_pad_left reactie_desc_d">
                                            <ul class="reactie_desc_ul" style="text-decoration: none; list-style: none;">
                                              <li><?php echo htmlspecialchars($row['fk_user_name']).' ● '.htmlspecialchars($row['reactie_date']); ?></li>
                                              <li class="hide"><?php echo htmlspecialchars($row['fk_user_id']) ?></li>
                                              <li class="reactie_desc"><?php echo htmlspecialchars($row['reactie_description']); ?></li>
                                            </ul>
                                        </div>

                                        <div class="large-12 small-12 columns reactie_like_d">
                                            <form action="" method="post" class="n_m_btm" style="width: 100%;" data-abide>
                                                <ul class="small-block-grid-2" style="margin-bottom: 0px; width: 100%;">
                                                    <li class="left n_pad" style="padding-bottom: 0; padding-right: 0px; height: 30px; text-decoration: none; width: 100%;">
                                                        <div class="row hide">
                                                            <input type="text" placeholder="<?php echo htmlspecialchars($row['reactie_id']); ?>" value="<?php echo htmlspecialchars($row['reactie_id']); ?>" 
                                                                   id="reactie_id" name="reactie_id">
                                                            <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                                   id="user_id_m" name="user_id_m">  
                                                        </div>
                                                        <?php  
                                                        $reactie_id = $row['reactie_id'];

                                                        $sql_vt = "select * from tbl_reacties_vt where fk_reactie_id='".$reactie_id."' and fk_user_id='".$userid."' limit 1";
                                                        $result_vt = $db->query($sql_vt);
                                                        $row_vt = mysqli_fetch_array($result_vt);
                                                        
                                                        if ($row_vt != false || $row['fk_user_id'] == $userid)
                                                        { ?>
                                                            <ul class="inline-list n_m_btm pre_v_small_vt" style="text-decoration: none; list-style: none;">
                                                                <li><p class="n_m_btm"><?php echo htmlspecialchars($row['reactie_likes']).' likes'; ?></p></li>
                                                                <li><button type="submit" class="btnSubmitReactie_vt_up" name="btnSubmitReactie_vt_up" style="color: #7b868c;" disabled><i class="fi-like size-18" style="margin-right: 10px;"></i>like</button></li>
                                                                <li><button type="submit" class="btnSubmitReactie_vt_down" name="btnSubmitReactie_vt_down" style="background-color: none; color: #7b868c;" disabled><i class="fi-dislike size-18" style="margin-right: 10px;"></i>dislike</button></li>
                                                            </ul>    
                                                  <?php 
                                                        }
                                                        else if (empty($row_vt['fk_reactie_id']))
                                                        { ?>
                                                            <ul class="inline-list n_m_btm pre_v_small_vt" style="text-decoration: none; list-style: none;">
                                                                <li><p class="n_m_btm"><?php echo htmlspecialchars($row['reactie_likes']).' likes'; ?></p></li>
                                                                <li><button type="submit" class="btnSubmitReactie_vt_up" name="btnSubmitReactie_vt_up" style="color: #7b868c;"><i class="fi-like size-18" style="margin-right: 10px;"></i>like</button></li>
                                                                <li><button type="submit" class="btnSubmitReactie_vt_down" name="btnSubmitReactie_vt_down" style="background-color: none; color: #7b868c;"><i class="fi-dislike size-18" style="margin-right: 10px;"></i>dislike</button></li>
                                                            </ul>
                                                            
                                                  <?php } ?>          
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
  
                          <?php } 
                            }
                            else
                            { ?>
                                <div class="large-12 small-12 columns" style="text-align: center;">
                                    <p>er zijn nog geen antwoorden gegeven op deze vraag</p>
                                </div>
                          <?php  
                            } ?>
                      </div>

                      <div class="large-12 small-12 columns n_pad" id="reacties_update"></div>
                </div>

    <!--overzicht van gerelateerde vragen large-->

        <div class="large-4 small-12 columns show-for-large-up n_pad">
                <div class="large-12 small-12 columns n_pad">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Gerelateerde vragen</h4>
                </div>

                <?php 
                    $sql_tags = "select * from tbl_tags_vragen where fk_vraag_id='".$_GET['id']."'";
                    $result_tags = $db->query($sql_tags);
                    $row_tags = mysqli_fetch_assoc($result_tags);

                    $sql_find = "select distinct(fk_vraag_id) from tbl_tags_vragen where tag_name='".$row_tags['tag_name']."' limit 3";
                    $result_find = $db->query($sql_find);
                    
                    if(mysqli_num_rows($result_find) > 0)
                    {
                      while ($row_find = mysqli_fetch_assoc($result_find))
                      { 

                          $sql_find_er = "select * from tbl_vragen where vraag_id='".$row_find['fk_vraag_id']."' order by vraag_likes desc";
                          $result_find_er = $db->query($sql_find_er);
                          $row_find_er = mysqli_fetch_assoc($result_find_er);  

                          $sql_user = "select * from tbl_users where user_id='".$row_find_er['fk_user_id']."'";
                          $results_user = $db->query($sql_user);
                          $row_user = mysqli_fetch_assoc($results_user); ?>

                          <div class="large-12 small-12 columns dashboard_container">
                                  <a href="vraag_details.php?id=<?php echo $row_find_er['vraag_id']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="ervaring_profile_pre"></li>
                                          <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                              <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_find_er['vraag_title']; ?></p>
                                              <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo 'gevraagd door: '.$row_find_er['fk_user_name']; ?></p>
                                              <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_find_er['vraag_description'], 0, 118))."..."; ?></p>
                                          </li>
                                          <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_find_er['vraag_date']; ?></li>
                                          <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                              <img src="img/icons/like.png" class="p_r_t"><?php echo $row_find_er['vraag_likes']; ?>
                                              <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_find_er['vraag_reacties']; ?>
                                          </li>
                                      </ul>
                                  </div></a>
                          </div>
                      <?php 
                      } 
                    }
                    else
                    {?>
                      <div class="large-12 small-12 columns" style="text-align: left; padding-left: 6px; padding-right: 0px;">
                          <p>er zijn geen gerelateerde vragen gevonden</p>
                      </div>
                    <?php 
                    } ?>
        </div>

        <!--overzicht van gerelateerde vragen small-->

        <div class="large-4 small-12 columns show-for-small-up hide-for-large-up m_btm_t">
                <div class="large-12 small-12 columns n_pad text-center">
                    <p class="title_small show-for-small-up">Gerelateerde vragen</p>
                </div>

                <?php 
                    $sql_tags = "select * from tbl_tags_vragen where fk_vraag_id='".$_GET['id']."'";
                    $result_tags = $db->query($sql_tags);
                    $row_tags = mysqli_fetch_assoc($result_tags);

                    $sql_find = "select distinct(fk_vraag_id) from tbl_tags_vragen where tag_name='".$row_tags['tag_name']."' limit 3";
                    $result_find = $db->query($sql_find);
                    
                    if(mysqli_num_rows($result_find) > 0)
                    {
                      while ($row_find = mysqli_fetch_assoc($result_find))
                      { 

                          $sql_find_er = "select * from tbl_vragen where vraag_id='".$row_find['fk_vraag_id']."' order by vraag_reacties desc";
                          $result_find_er = $db->query($sql_find_er);
                          $row_find_er = mysqli_fetch_assoc($result_find_er);  

                          $sql_user = "select * from tbl_users where user_id='".$row_find_er['fk_user_id']."'";
                          $results_user = $db->query($sql_user);
                          $row_user = mysqli_fetch_assoc($results_user); ?>

                          <div class="large-12 small-12 columns dashboard_container_small">
                                  <a href="vraag_details.php?id=<?php echo $row_find_er['vraag_id']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="ervaring_profile_pre"></li>
                                          <li class="p_l_t" style="width:88%; padding-bottom: 0;">
                                              <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_find_er['vraag_title']; ?></p>
                                              <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo 'gevraagd door: '.$row_find_er['fk_user_name']; ?></p>
                                              <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_find_er['vraag_description'], 0, 118))."..."; ?></p>
                                          </li>
                                          <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_find_er['vraag_date']; ?></li>
                                          <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                              <img src="img/icons/like.png" class="p_r_t"><?php echo $row_find_er['vraag_likes']; ?>
                                              <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_find_er['vraag_reacties']; ?>
                                          </li>
                                      </ul>
                                  </div></a>
                          </div>
                      <?php 
                      } 
                    }
                    else
                    {?>
                      <div class="large-12 small-12 columns" style="text-align: left; padding-left: 6px; padding-right: 0px;">
                          <p>er zijn geen gerelateerde vragen gevonden</p>
                      </div>
                    <?php 
                    } ?>
        </div>

        <!--overzicht van gerelateerde vragen v_small-->
        
        <?php  

            $sql_tags = "select * from tbl_tags_vragen where fk_vraag_id='".$_GET['id']."'";
            $result_tags = $db->query($sql_tags);
            $row_tags = mysqli_fetch_assoc($result_tags);

            $sql_find = "select distinct(fk_vraag_id) from tbl_tags_vragen where tag_name='".$row_tags['tag_name']."' limit 3";
            $result_find = $db->query($sql_find);

            if(mysqli_num_rows($result_find) > 0)
            {
                while ($row_find = mysqli_fetch_assoc($result_find))
                { 
                    $sql_find_er = "select * from tbl_vragen where vraag_id='".$row_find['fk_vraag_id']."' order by vraag_reacties desc";
                    $result_find_er = $db->query($sql_find_er);
                    $row_find_er = mysqli_fetch_assoc($result_find_er);  

                    $sql_user = "select * from tbl_users where user_id='".$row_find_er['fk_user_id']."'";
                    $results_user = $db->query($sql_user);
                    $row_user = mysqli_fetch_assoc($results_user); ?>
                    
                    <div class="large-12 columns dashboard_container dashboard_container_v_small" style="padding-left: 15px; padding-right: 15px;">
                        <a href="vraag_details.php?id=<?php echo $row_find_er['vraag_id']; ?>&categorie_name=<?php echo $row_find_er['fk_categorie_name']; ?>" class="a_ervaring">
                            <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                <ul class="small-block-grid-2 profile_info">
                                    <li class="pre_img_d n_p_btm text-center" style="width: 100%; padding-right: 0; padding-bottom: 10px;">
                                        <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="vraag_profile_pre">
                                    </li>
                                    <li class="pre_det_d" style="width: 100%; padding-bottom: 0; padding-left: 0px;">
                                        <p class="ervaring_title_pre" style="color: #7b868c;">
                                            <?php 
                                              if (strlen($row_find_er['vraag_title']) > 70)
                                              {
                                                  echo htmlspecialchars(substr($row_find_er['vraag_title'], 0, 70))."...";
                                              }
                                              else
                                              {
                                                  echo htmlspecialchars($row_find_er['vraag_title']);
                                              } ?>
                                        </p>
                                        <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo htmlspecialchars('gevraagd door: '.$row_find_er['fk_user_name']); ?></p>
                                        <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                            <?php 
                                              if (strlen($row_find_er['vraag_description']) > 118)
                                              {
                                                  echo htmlspecialchars(substr($row_find_er['vraag_description'], 0, 118))."...";
                                              }
                                              else
                                              {
                                                  echo htmlspecialchars($row_find_er['vraag_description']);
                                              } ?>
                                        </p>
                                    </li>
                                    <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_find_er['vraag_date']; ?></li>
                                    <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                        <img src="img/icons/like.png" class="p_r_t"><?php echo $row_find_er['vraag_likes']; ?>
                                        <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_find_er['vraag_reacties']; ?>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
      <?php 
                } 
            }
            else
            { ?>
                <div class="large-12 small-12 columns" style="text-align: left; padding-left: 6px; padding-right: 0px;">
                    <p>er zijn geen gerelateerde vragen gevonden</p>
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

    <!--aanmaken van een reactie-->
    
    <script type="text/javascript">
      $(document).ready(function(){

          $("#btnSubmitReactie").on("click", function(e){
          
              e.preventDefault();
              
              var reactie_description = $('#reactie_description').val();
              var user_name = $('#user_name').val();
              var user_id = $('#user_id').val();
              var user_profile = $('#user_profile').val();
              var user_privilege = $('#user_privilege').val();
              var vraag_id = $('#vraag_id').val();

              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "ajax/save_reactie_vraag.php",
                  data: { reactie_description : reactie_description, user_name : user_name, user_id : user_id, user_privilege : user_privilege, vraag_id : vraag_id },
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
                                                      '<li>'+user_name+' - '+data.vraag_date+'</li>'+
                                                      '<li class="hide">'+user_id+'</li>'+
                                                      '<li class="reactie_desc">'+reactie_description+'</li>'+
                                                  '</ul>'+
                                              '</div>'+

                                              '<div class="large-12 small-12 columns">'+
                                                '<ul class="small-block-grid-2" style="margin-bottom: 15px;">'+
                                                  '<li class="left" style="padding-bottom: 0; height: 30px; text-decoration: none;">'+
                                                    '<button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                             style="background-color: #e6e6e6; color: #7b868c;">'+
                                                             '<i class="fi-check size-16"></i>'+
                                                             '<span class="reactie_helpful">'+'Helpful'+'</span>'+
                                                             '<span class="reactie_vt_n">'+'0'+'</span>'+
                                                    '</button>'+       
                                                  '</li>'+
                                                '</ul>'+
                                              '</div>'+
                                           '</div>';

                      $('#reactie_description').html("");
                      $('#reacties_update').prepend(reactie_update).addClass('animated bounceIn');
                  },
                  error: function() {
                      $('#feedback_message').html("Er is en probleem opgetreden, hierdoor is je reactie is niet toegevoegd. Probeer het nog eens.");
                      $('#feedback').slideDown();
                  }
              });

          });
      });
    </script>

    <!--char limit-->

    <script src="js/char_limit.js"></script>

    <script>
        $(document).ready(function(){

          var elem_ervaring_description = $(".description_chars");
          $("#reactie_description").limiter(500, elem_ervaring_description);

        });
    </script>

    <!--vraag als beantwoord of duplicate markeren-->

    <script type="text/javascript">
      $("#btnMarkeerBeantwoord")
      .mouseover(function () {
          $("#vraag_beantwoord").attr("src", "img/icons/beantwoord_selected.png");
      })
      .mouseout(function () {
          $("#vraag_beantwoord").attr("src", "img/icons/beantwoord.png");
      });

      $("#btnMarkeerDuplicate")
      .mouseover(function () {
          $("#btnMarkeerDuplicate").attr("src", "img/icons/duplicate_selected.png");
      })
      .mouseout(function () {
          $("#btnMarkeerDuplicate").attr("src", "img/icons/duplicate.png");
      });
    </script>

    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
    <script src="js/form_animations.js"></script>
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
