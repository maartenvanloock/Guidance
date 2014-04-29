<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/reactie.class.php");
require ("classes/reactie_vt.class.php");
require ("classes/ervaring_vt.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];

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

      $r->Ervaring_id = mysql_real_escape_string($_GET['id']);
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
      $ervaring_vt = new Ervaring_vt();
      $ervaring_vt->User_id = $userid;
      $ervaring_vt->Ervaring_id = $_GET['id'];
      $ervaring_vt->Ervaring_st = "up";

      $ervaring_vt->Save();
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
      $ervaring_vt = new Ervaring_vt();
      $ervaring_vt->User_id = $userid;
      $ervaring_vt->Ervaring_id = $_GET['id'];
      $ervaring_vt->Ervaring_st = "down";

      $ervaring_vt->Save();
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

    <link rel="stylesheet" type="text/css" href="spectrum.css">
    <script type="text/javascript" src="spectrum.js"></script>
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
                  $sql = "select * from tbl_ervaringen where ervaring_id='".$_GET['id']."'";
                  $result = $db->query($sql);
                  $row = mysqli_fetch_assoc($result);
                ?>

    <!--overzicht van ervaring details medium and up-->

                    <div class="panel show-for-medium-up" style="background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8;">
                        <ul class="small-block-grid-2 profile_info">
                            <li style="width: 10%; padding-bottom: 0px; padding-right: 0px;">
                            <img src="img/profile_img.png" style="border-radius: 20px;">
                            <?php  

                                $sql_ervaring_vt = "select * from tbl_ervaringen_vt where fk_ervaring_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                                $result_ervaring_vt = $db->query($sql_ervaring_vt);
                                $row_ervaring_vt = mysqli_fetch_array($result_ervaring_vt);
                                                        
                                if ($row_ervaring_vt != false)
                                { ?>
                                    <form action="" method="post" class="text-center" style="width: 20px; margin: 0px; margin-left: 6px; margin-top: 15px;" data-abide>
                                        <span>
                                            <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" style="background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-up size-24"></i></button>
                                            <p id="vt_ervaring"><?php echo $row['ervaring_likes']; ?></p>
                                            <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" style="background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-down size-24"></i></button>
                                        </span>
                                    </form>
                          <?php }
                                else
                                { ?>
                                  <form action="" method="post" class="text-center" style="width: 20px; margin: 0px; margin-left: 6px; margin-top: 15px;" data-abide>
                                      <span>
                                          <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" style="background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-up size-24"></i></button>
                                          <p id="vt_ervaring"><?php echo $row['ervaring_likes']; ?></p>
                                          <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" style="background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-down size-24"></i></button>
                                      </span>
                                  </form>
                          <?php } ?>
                            </li>
                            <li style="width: 90%; padding-left: 10px; padding-bottom: 0px;">
                                <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo htmlspecialchars($row['ervaring_title']); ?></p>
                                <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo htmlspecialchars($row['fk_user_name']); ?></p>
                                <p style="margin-bottom: 10px; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;">
                                <?php echo htmlspecialchars($row['ervaring_description']); ?></p>
                                
                                  <?php  
                                      $sql_tags = "select * from tbl_tags where fk_ervaring_id='".$_GET['id']."'";
                                      $result_tags = $db->query($sql_tags);

                                      if(mysqli_num_rows($result_tags) > 0)
                                      { ?>
                                        <dl class="sub-nav" style="margin-bottom: 0px; padding-bottom: 10px;">
                                            <dt style="margin-left: 10px;">Tags:</dt>
                                <?php   while ($row_tags = mysqli_fetch_assoc($result_tags))
                                        { ?>
                                            <dd class="active"><a href="ervaring_tags.php?tag=<?php echo $row_tags['tag_name'] ?>"><?php echo $row_tags['tag_name'] ?></a></dd>
                                <?php  
                                        } ?>
                                        </dl>
                                <?php } ?>
                                
                            </li>
                        </ul>
                    </div>

    <!--overzicht van ervaring details small-->

                    <div class="large-12 small-12 show-for-small hide-for-medium-up" style="background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8; padding: 20px;">
                        <ul class="profile_info" style="list-style: none; margin-bottom: 0px;">
                            <li class="text-center" style="width: 100%; padding-bottom: 0px; padding-right: 0px;">
                                <img src="img/profile_img.png" style="border-radius: 20px;">
                                <p style="padding-top: 10px; padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo htmlspecialchars($row['fk_user_name']); ?></p>
                            </li>

                            <li style="width: 100%; padding: 0px;">
                                <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo htmlspecialchars($row['ervaring_title']); ?></p>
                                <p style="margin-bottom: 10px; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;">
                                <?php echo htmlspecialchars($row['ervaring_description']); ?></p>
                                
                                  <?php  
                                      $sql_tags = "select * from tbl_tags where fk_ervaring_id='".$_GET['id']."'";
                                      $result_tags = $db->query($sql_tags);

                                      if(mysqli_num_rows($result_tags) > 0)
                                      { ?>
                                        <dl class="sub-nav" style="margin-bottom: 0px; padding-bottom: 0px;">
                                            <dt style="margin-left: 10px;">Tags:</dt>
                                <?php   while ($row_tags = mysqli_fetch_assoc($result_tags))
                                        { ?>
                                            <dd class="active"><a href="ervaring_tags.php?tag=<?php echo $row_tags['tag_name'] ?>"><?php echo $row_tags['tag_name'] ?></a></dd>
                                <?php  
                                        } ?>
                                        </dl>
                                <?php } ?>
                            </li>
                        </ul>

                        <?php  

                            $sql_ervaring_vt = "select * from tbl_ervaringen_vt where fk_ervaring_id='".$_GET['id']."' and fk_user_id='".$userid."' limit 1";
                            $result_ervaring_vt = $db->query($sql_ervaring_vt);
                            $row_ervaring_vt = mysqli_fetch_array($result_ervaring_vt);
                                                        
                            if ($row_ervaring_vt != false)
                            { ?>
                                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 columns" style="padding: 0px; margin-top: 20px;">
                                        <div class="large-5 small-5 columns" style="padding: 0px;">
                                            <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" 
                                                    style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-up size-24"></i></button>
                                        </div>

                                        <div class="large-2 small-2 columns text-center">
                                            <p id="vt_ervaring" style="width: 100%;"><?php echo $row['ervaring_likes']; ?></p>
                                        </div>

                                        <div class="large-5 small-5 columns" style="padding: 0px;">
                                            <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" 
                                                    style="width: 100%; background-color: #e6e6e6; color: #7b868c;" disabled><i class="fi-arrow-down size-24"></i></button>
                                        </div>
                                    </div>
                                </div>
                      <?php }
                            else
                            { ?>
                                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                                    <div class="large-12 columns" style="padding: 0px; margin-top: 20px;">
                                        <div class="large-5 small-5 columns" style="padding: 0px;">
                                            <button type="submit" class="btnSubmitErvaring_vt_up" name="btnSubmitErvaring_vt_up" 
                                                    style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-up size-24"></i></button>
                                        </div>

                                        <div class="large-2 small-2 columns text-center">
                                            <p id="vt_ervaring" style="width: 100%;"><?php echo $row['ervaring_likes']; ?></p>
                                        </div>

                                        <div class="large-5 small-5 columns" style="padding: 0px;">
                                            <button type="submit" class="btnSubmitErvaring_vt_down" name="btnSubmitErvaring_vt_down" 
                                                    style="width: 100%; background-color: #e6e6e6; color: #7b868c;"><i class="fi-arrow-down size-24"></i></button>
                                        </div>
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
                                        <img src="img/profile_img.png" id="profile_img_comment"
                                        <?php 
                                        if ($user_privilege == 'true')
                                        { ?>
                                            style="border: 3px solid #5db0c6;"
                                        <?php 
                                        } 
                                        else
                                        {
                                                  
                                        } ?>
                                        >
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
                                        <button type="submit" href="#" class="button [radius round] right" id="btnSubmitReactie" name="btnSubmitReactie" 
                                                style="height: 50px;
                                                       width: 100%;
                                                       -webkit-border-radius: 3px;
                                                       background-color: #5db0c6;
                                                       color: white;
                                                       font-family: 'Open Sans', sans-serif;
                                                       font-size: 16px;
                                                       font-style: inherit;
                                                       font-weight: 600;
                                                       padding: 5px;">Voeg reactie toe
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

    <!--overzicht van comments-->
    
                    <div class="large-12 small-12 columns" style="padding: 0px;" id="reacties_update">
                        <?php 
                            $sql = "select * from tbl_reacties where fk_ervaring_id='".$_GET['id']."' order by reactie_likes desc";
                            $result = $db->query($sql);

                            if(mysqli_num_rows($result) > 0)
                            {
                                while ($row = mysqli_fetch_assoc($result))
                                { ?>
                                    <div class="large-12 columns reactie" style="padding: 10px; background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8; margin-bottom: 10px;">
                                        <div class="large-1 small-2 columns" style="width: auto; height: auto;">

                                            <a href="profile_details.php?user=<?php echo $row['fk_user_id']; ?>"><img src="img/profile_img.png" class="reactie_profile_img"
                                    <?php 
                                            if ($row['fk_user_privilege'] == "true")
                                            { ?>
                                              style="border-radius: 30px; border: 3px solid #5db0c6;"
                                    <?php 
                                            } ?>
                                            ></a>
                                        </div>

                                        <div class="large-10 small-10 columns" style="padding-left: 0px;">
                                            <ul style="text-decoration: none; list-style: none;">
                                              <li><?php echo htmlspecialchars($row['fk_user_name']).' '.htmlspecialchars($row['reactie_date']); ?></li>
                                              <li style="margin-bottom: 5; 
                                                         color: #a5b1b8; 
                                                         font-family: 'Open Sans', sans-serif; 
                                                         font-size: 16px; 
                                                         font-style: italic;"><?php echo htmlspecialchars($row['reactie_description']); ?>
                                              </li>
                                            </ul>
                                        </div>

                                        <div class="large-12 columns">
                                            <form action="" method="post" data-abide>
                                                <ul class="small-block-grid-2" style="margin-bottom: 15px;">
                                                    <li class="left" style="padding-bottom: 0; height: 30px; text-decoration: none;">
                                                        <div class="row hide">
                                                            <input type="text" placeholder="<?php echo htmlspecialchars($row['reactie_id']); ?>" value="<?php echo htmlspecialchars($row['reactie_id']); ?>" 
                                                                   id="reactie_id" name="reactie_id">
                                                        </div>
                                                        <?php  
                                                        $reactie_id = $row['reactie_id'];

                                                        $sql_vt = "select * from tbl_reacties_vt where fk_reactie_id='".$reactie_id."' and fk_user_id='".$userid."' limit 1";
                                                        $result_vt = $db->query($sql_vt);
                                                        $row_vt = mysqli_fetch_array($result_vt);
                                                        
                                                        if ($row_vt != false)
                                                        { ?>
                                                                <button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                                        style="height: auto;
                                                                               width: auto;
                                                                               -webkit-border-radius: 3px;
                                                                               background-color: #e6e6e6;
                                                                               color: #7b868c;
                                                                               font-family: 'Open Sans', sans-serif;
                                                                               font-size: 14px;
                                                                               font-style: inherit;
                                                                               padding: 6px;" disabled>
                                                                               <i class="fi-check size-16"></i>
                                                                               <span style="margin-left: 5px; margin-right: 5px;">Helpful</span>
                                                                               <span style="-webkit-border-radius: 3px; background-color: #fafafa; padding: 3px; padding-top: 0px; padding-bottom: 0px;">
                                                                               <?php echo htmlspecialchars($row['reactie_likes']); ?></span>
                                                                </button>
                                                  <?php 
                                                        }
                                                        else if (empty($row_vt['fk_reactie_id']))
                                                        { ?>
                                                            <button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                                    style="height: auto;
                                                                           width: auto;
                                                                           -webkit-border-radius: 3px;
                                                                           background-color: #e6e6e6;
                                                                           color: #7b868c;
                                                                           font-family: 'Open Sans', sans-serif;
                                                                           font-size: 14px;
                                                                           font-style: inherit;
                                                                           padding: 6px;">
                                                                           <i class="fi-check size-16"></i>
                                                                           <span style="margin-left: 5px; margin-right: 5px;">Helpful</span>
                                                                           <span style="-webkit-border-radius: 3px; background-color: #fafafa; padding: 3px; padding-top: 0px; padding-bottom: 0px;">
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
                                    <p>er zijn nog geen antwoorden geplaatst op deze ervaring</p>
                                </div>
                          <?php  
                            } ?>
                      </div>
                </div>

    <!--overzicht van relevante ervaringen-->

        <div class="large-4 small-12 columns" style="padding: 0px;">
                <div class="large-12 small-12 columns" style="padding: 0px;">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Relevante ervaringen</h4>
                </div>
                <?php 
                    /*$sql = "select * from tbl_ervaringen where fk_categorie_name='".$_GET['categorie_name']."' and not ervaring_id='".$_GET['id']."' limit 3";
                    $result = $db->query($sql);*/

                    $sql_tags = "select * from tbl_tags where fk_ervaring_id='".$_GET['id']."'";
                    $result_tags = $db->query($sql_tags);
                    $row_tags = mysqli_fetch_assoc($result_tags);

                    $sql_find = "select distinct(fk_ervaring_id) from tbl_tags where tag_name='".$row_tags['tag_name']."' limit 3";
                    $result_find = $db->query($sql_find);
                    
                    if(mysqli_num_rows($result_find) > 0)
                    {
                      while ($row_find = mysqli_fetch_assoc($result_find))
                      { 

                          $sql_find_er = "select * from tbl_ervaringen where ervaring_id='".$row_find['fk_ervaring_id']."' order by ervaring_reacties desc";
                          $result_find_er = $db->query($sql_find_er);
                          $row_find_er = mysqli_fetch_assoc($result_find_er);  ?>

                          <div class="large-12 small-12 columns dashboard_container">
                                  <a href="ervaring_details.php?id=<?php echo $row_find_er['ervaring_id']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                       style="border-bottom: 10px solid <?php echo $row_find_er['fk_categorie_color']; ?>;">
                                      <ul class="small-block-grid-2 profile_info">
                                          <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                          <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                              <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo $row_find_er['ervaring_title']; ?></p>
                                              <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo $row_find_er['fk_user_name']; ?></p>
                                              <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;"><?php echo htmlspecialchars(substr($row_find_er['ervaring_description'], 0, 118))."..."; ?></p>
                                          </li>
                                          <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;"><?php echo $row_find_er['ervaring_date']; ?></li>
                                          <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                              <img src="img/icons/like.png" style="padding-right: 10px;"><?php echo $row_find_er['ervaring_likes']; ?>
                                              <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;"><?php echo $row_find_er['ervaring_reacties']; ?>
                                          </li>
                                      </ul>
                                  </div></a>
                          </div>
                      <?php 
                      } 
                    }
                    else
                    {?>
                      <div class="large-4 columns" style="text-align: left; padding-left: 5px;">
                          <p>er zijn geen relevante ervaringen gevonden</p>
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

    <script src="js/save_reactie.js"></script>
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
