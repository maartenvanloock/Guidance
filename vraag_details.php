<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/reactie.class.php");
require ("classes/reactie_vt.class.php");
require ("classes/ervaring_vt.class.php");

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

/*---------------------aanmaken van een nieuwe ervaring_vt----------------------*/

if(isset($_POST['btnSubmitErvaring_vt_up']))
{
    try
    {
      $ervaring_vt_up = new Ervaring_vt();
      $ervaring_vt_up->User_id = $userid;
      $ervaring_vt_up->Ervaring_id = $_GET['id'];
      $ervaring_vt_up->Ervaring_st = "up";
      $ervaring_vt_up->User_id_m = $_POST['user_id_m'];

      $user_ervaring_up_val = ' ';

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
               $user_ervaring_up_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_ervaring_up_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_ervaring_up_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_ervaring_up_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_ervaring_up_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_ervaring_up_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_ervaring_up_val = 35;
          break;
      }

      $ervaring_vt_up->User_up_v = $user_ervaring_up_val;

      $ervaring_vt_up->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}
else if(isset($_POST['btnSubmitErvaring_vt_down']))
{
    try
    {
      $ervaring_vt_down = new Ervaring_vt();
      $ervaring_vt_down->User_id = $userid;
      $ervaring_vt_down->Ervaring_id = $_GET['id'];
      $ervaring_vt_down->Ervaring_st = "down";
      $ervaring_vt_down->User_id_m = $_POST['user_id_m'];

      $user_ervaring_down_val = ' ';

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
               $user_ervaring_down_val = 5;
          break;

          case in_array($user_up_v, $r2) :
               $user_ervaring_down_val = 10;
          break;

          case in_array($user_up_v, $r3) :
               $user_ervaring_down_val = 15;
          break;

          case in_array($user_up_v, $r4) :
               $user_ervaring_down_val = 20;
          break;

          case in_array($user_up_v, $r5) :
               $user_ervaring_down_val = 25;
          break;

          case in_array($user_up_v, $r6) :
               $user_ervaring_down_val = 30;
          break;

          case in_array($user_up_v, $r7) :
               $user_ervaring_down_val = 35;
          break;
      }

      $ervaring_vt_down->User_down_v = $user_ervaring_down_val;

      $ervaring_vt_down->Save();
    }
    catch (Exception $e)
    {
      $feedback = $e->getMessage();
    }
}

/*---------------------toevoegen van nieuwe tags aan een ervaring----------------------*/

if (isset($_POST['btnSubmitNewTags']))
{
  try
  {
    $tag_string = $_POST['new_added_tags'];
    $tags = preg_split("/[\s,]+/", $tag_string);
    $result_tags = array_unique($tags);
    $tags_lim = count($result_tags);

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
    {
       for ($x = 0; $x < $tags_lim; $x++)
        {
            $sql_tags = "insert into tbl_tags_vragen(tag_name, fk_vraag_id, fk_user_id) values ('".$tags[$x]."', '".$_GET["id"]."', '".$_SESSION['userid']."')";
            $result_q = $db->query($sql_tags);
        }
    }
  }
  catch (Exception $e)
  {
      $feedback = $e->getMessage();
  } 
}
else if (isset($_POST['btnSubmitNewTagsSmall']))
{
  try
  {
    $tag_string = $_POST['new_added_tags'];
    $tags = preg_split("/[\s,]+/", $tag_string);
    $result_tags = array_unique($tags);
    $tags_lim = count($result_tags);

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
    {
       for ($x = 0; $x < $tags_lim; $x++)
        {
            $sql_tags = "insert into tbl_tags_vragen (tag_name, fk_vraag_id, fk_user_id) values ('".$tags[$x]."', '".$_GET["id"]."', '".$_SESSION['userid']."')";
            $result_q = $db->query($sql_tags);
        }
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
    <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css"/>
    <link rel="stylesheet" href="css/new.css"/>
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

    <?php include("require/include_header_norm.php"); ?>

    <!--overzicht van ervaring details-->

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

    <!--overzicht van ervaring details medium and up-->

                    <div class="panel ervaring_detail_panel show-for-medium-up">
                        <ul class="small-block-grid-2 profile_info">
                            <li class="n_p_r" style="width: 10%; padding-bottom: 0px;">
                            <img src="<?php echo $row_user_details['user_profile_path']; ?>" style="width: 40px; height: 40px;" class="profile_img_details">
                            <?php  

                                $sql_ervaring_vt = "select * from tbl_vragen_vt where fk_vraag_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                                $result_ervaring_vt = $db->query($sql_ervaring_vt);
                                $row_ervaring_vt = mysqli_fetch_array($result_ervaring_vt);
                                                        
                                if ($row_ervaring_vt != false)
                                { ?>
                                    <form action="" method="post" class="vote_ervaring_med text-center" data-abide>
                                        <div class="row hide">
                                            <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                   id="user_id_m" name="user_id_m">      
                                        </div>

                                        <span>
                                            <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" style="background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-up size-24"></i></button>
                                            <p id="vt_ervaring"><?php echo $row['vraag_likes']; ?></p>
                                            <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" style="background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-down size-24"></i></button>
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
                                          <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" style="background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-up size-24"></i></button>
                                          <p id="vt_ervaring"><?php echo $row['vraag_likes']; ?></p>
                                          <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" style="background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-down size-24"></i></button>
                                      </span>
                                  </form>
                          <?php } ?>
                            </li>
                            <li style="width: 90%; padding-left: 10px; padding-bottom: 0px;">
                                <p class="ervaring_details_title" style="color: #7b868c;"><?php echo htmlspecialchars($row['vraag_title']); ?></p>
                                <p class="ervaring_details_username" style="color: #7b868c;"><?php echo htmlspecialchars($row['fk_user_name']); ?></p>
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
                                            <dd class="active"><a href="ervaring_tags.php?tag=<?php echo $row_tags['tag_name'] ?>"><?php echo $row_tags['tag_name'] ?></a></dd>
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
                                            <div class="large-8 small-8 columns">
                                                <input type="text" id="new_added_tags" name="new_added_tags" placeholder="voeg nieuwe tags toe, scheidt ze van elkaar met een komma">
                                            </div>

                                            <div class="large-4 small-4 columns add_btn" style="padding-left: 0px;">
                                                <button type="submit" href="#" class="button [radius round] right" id="btnSubmitNewTags" name="btnSubmitNewTags">Voeg tags toe</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>

    <!--overzicht van ervaring details small-->

                    <div class="large-12 small-12 columns ervaring_details_small show-for-small hide-for-medium-up">
                        <ul class="profile_info" style="list-style: none; margin-bottom: 0px;">
                            <li class="profile_img_name text-center">
                                <img src="<?php echo $row_user_details['user_profile_path']; ?>" class="profile_img_details_small" width="60" height="60">
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
                                                        <a href="ervaring_tags.php?tag=<?php echo $row_tags['tag_name'] ?>" style="color: #ffffff;"><?php echo $row_tags['tag_name'] ?></a>
                                                    </div>
                                                </div>
                                  <?php  
                                        } ?>
                                                <div class="large-12 small-12 columns text-center n_pad m_tp_t">
                                                    <div class="row" style="margin-left: 5px; margin-right: 5px;">
                                                        <button class="show_hide_smalltags_form" type="submit" href="#" id="btnSubmitNewTagsSmall" name="btnSubmitNewTagsSmall"><img src="img/icons/add.png" class="add_icon">Voeg nieuwe tags toe</button>
                                                    </div>
                                                </div>
                                          </div>
                                      </div>
                                <?php } ?>
                                      <div class="row" id="slidingDiv_small_tagsform" style="margin-left: 5px; margin-right: 5px;">
                                          <div class="large-12 small-12 columns n_pad">
                                              <form action="" method="post" data-abide style="margin-bottom: 10px;">
                                                      <input type="text" id="new_added_tags" name="new_added_tags" placeholder="voeg nieuwe tags toe, scheidt ze van elkaar met een komma">
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
                                                        
                            if ($row_ervaring_vt != false)
                            { ?>
                                <div class="row n_marg_lr" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 small-12 columns" style="padding: 0px; margin-top: 20px; margin-top: 0px;">
                                        <form action="" method="post" class="text-center" style="margin: 0px; margin-top: 15px; margin-left: 5px; margin-right: 5px;" data-abide>
                                            <div class="large-12 columns hide">
                                                <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                       id="user_id_m" name="user_id_m">      
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                  <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" 
                                                          style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-up size-24"></i></button>
                                            </div>

                                            <div class="large-2 small-2 columns text-center">
                                                <p id="vt_ervaring" style="width: 100%;"><?php echo $row['vraag_likes']; ?></p>
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-down size-24"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                      <?php }
                            else
                            { ?>
                                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 columns" style="padding: 0px; margin-top: 20px;">
                                        <form action="" method="post" class="text-center" style="margin: 0px; margin-top: 15px; margin-left: 5px; margin-right: 5px;" data-abide>
                                            <div class="row hide">
                                                <input type="text" placeholder="<?php echo htmlspecialchars($row['fk_user_id']); ?>" value="<?php echo htmlspecialchars($row['fk_user_id']); ?>" 
                                                       id="user_id_m" name="user_id_m">      
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-up size-24"></i></button>
                                            </div>

                                            <div class="large-2 small-2 columns text-center">
                                                <p id="vt_ervaring" style="width: 100%;"><?php echo $row['vraag_likes']; ?></p>
                                            </div>

                                            <div class="large-5 small-5 columns" style="padding: 0px;">
                                                <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" 
                                                        style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-down size-24"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                      <?php } ?>
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
                                        <textarea type="text" placeholder="Geef hier een reactie in" 
                                                  style="resize: vertical; height: 38px; border-radius: 3px;" id="reactie_description" name="reactie_description" required></textarea>
                                        <small class="error">Geef een reactie in</small>
                                    </div>

                                    <div class="large-8 columns hide">
                                        <input type='text' id='user_name' name='user_name' value="<?php echo $username; ?>"/>
                                        <input type='text' id='user_id' name='user_id' value="<?php echo $userid; ?>"/>
                                        <input type='text' id='user_privilege' name='user_privilege' value="<?php echo $user_privilege; ?>"/>
                                        <input type='text' id='ervaring_id' name='ervaring_id' value="<?php echo $_GET['id']; ?>"/>
                                    </div>

                                    <div class="large-3 columns">
                                        <button type="submit" href="#" class="button [radius round] right" id="btnSubmitReactie" name="btnSubmitReactie">Voeg reactie toe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

    <!--overzicht van comments-->
    
                    <div class="large-12 small-12 columns" style="padding: 0px;" id="reacties_update">
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
                                        <div class="large-1 small-2 columns w_h_auto">

                                            <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>">
                                            <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="reactie_profile_img"
                                    <?php 
                                            if ($row['fk_user_privilege'] == "true")
                                            { ?>
                                              style="border-radius: 30px; border: 3px solid #5db0c6;"
                                    <?php 
                                            } ?>
                                            ></a>
                                        </div>

                                        <div class="large-10 small-10 columns n_pad_left">
                                            <ul style="text-decoration: none; list-style: none;">
                                              <li><?php echo htmlspecialchars($row['fk_user_name']).' '.htmlspecialchars($row['reactie_date']); ?></li>
                                              <li class="hide"><?php echo htmlspecialchars($row['fk_user_id']) ?></li>
                                              <li class="reactie_desc"><?php echo htmlspecialchars($row['reactie_description']); ?></li>
                                            </ul>
                                        </div>

                                        <div class="large-12 columns">
                                            <form action="" method="post" data-abide>
                                                <ul class="small-block-grid-2" style="margin-bottom: 15px;">
                                                    <li class="left" style="padding-bottom: 0; height: 30px; text-decoration: none;">
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
                                                        
                                                        if ($row_vt != false)
                                                        { ?>
                                                            <button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                                    style="background-color: #e6e6e6; color: #7b868c;" disabled>
                                                                    <i class="fi-check size-16"></i>
                                                                    <span class="reactie_helpful">Helpful</span>
                                                                    <span class="reactie_vt_n">
                                                                    <?php echo htmlspecialchars($row['reactie_likes']); ?></span>
                                                            </button>
                                                  <?php 
                                                        }
                                                        else if (empty($row_vt['fk_reactie_id']))
                                                        { ?>
                                                            <button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                                    style="background-color: #e6e6e6; color: #7b868c;">
                                                                    <i class="fi-check size-16"></i>
                                                                    <span class="reactie_helpful">Helpful</span>
                                                                    <span class="reactie_vt_n">
                                                                    <?php echo htmlspecialchars($row['reactie_likes']); ?></span>
                                                            </button>
                                                  <?php } ?>          
                                                    </li>

                                                    <li class="right" style="padding-bottom:0; width: auto; text-decoration: none; padding-top: 3px;">
                                                        <a href="#" style="color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                                        <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">reply</a>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
  
                          <?php } 
                            }
                            else
                            { ?>
                                <div class="row" style="text-align: center;">
                                    <p>er zijn nog geen antwoorden geplaatst op deze vraag</p>
                                </div>
                          <?php  
                            } ?>
                      </div>
                </div>

    <!--overzicht van relevante ervaringen large-->

        <div class="large-4 small-12 columns show-for-medium-up n_pad">
                <div class="large-12 small-12 columns n_pad">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Relevante Vragen</h4>
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

                          <div class="large-12 small-12 columns dashboard_container">
                                  <a href="ervaring_details.php?id=<?php echo $row_find_er['ervaring_id']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                          <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                              <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_find_er['vraag_title']; ?></p>
                                              <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_find_er['fk_user_name']; ?></p>
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
                          <p>er zijn geen relevante vragen gevonden</p>
                      </div>
                    <?php 
                    } ?>
        </div>

        <!--overzicht van relevante ervaringen small-->

        <div class="large-4 small-12 columns show-for-small-up hide-for-large-up">
                <div class="large-12 small-12 columns n_pad text-center">
                    <p style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px; font-size: 20px; font-style: inherit; font-weight: 600;" 
                       class="show-for-small-only">Relevante Vragen</p>
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

                          <div class="large-12 small-12 columns dashboard_container">
                                  <a href="ervaring_details.php?id=<?php echo $row_find_er['vraag_id']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                          <li class="p_l_t" style="width:88%; padding-bottom: 0;">
                                              <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_find_er['vraag_title']; ?></p>
                                              <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_find_er['fk_user_name']; ?></p>
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
                          <p>er zijn geen relevante vragen gevonden</p>
                      </div>
                    <?php 
                    } ?>
        </div>

            </div>
        </div>
    </div>
    

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>

    <script src="js/form_animations.js"></script>
    <script src="js/save_reactie.js"></script>
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
