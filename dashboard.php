<?php 

session_start();

require ("classes/connection.class.php");

$username = $_SESSION['username'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(!empty($username))
{
    $sql = "select * from tbl_users where user_name='$username'";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user_privilege = $row['user_privilege'];
    $userid = $row['user_id'];
    $user_up_v = $row['user_ptn'];

    $_SESSION['userprivilege'] = $user_privilege;
    $_SESSION['userid'] = $userid;
    $_SESSION['user_up_v'] = $user_up_v;
}
else if(empty($username))
{
    header("Location:login.php");
}

/*---------------------nagaan of de gebruiker al ervaringen heeft aangemaakt of gezocht op tags----------------------*/

$sql_user_posts = "select count(*) as posts from tbl_ervaringen where fk_user_id='".$userid."'";
$result_user_posts = $db->query($sql_user_posts);
$row_user_posts = mysqli_fetch_assoc($result_user_posts);

$sql_user_searched = "select count(*) as searchtags from tbl_search_tags where fk_user_id='".$userid."'";
$result_user_searched = $db->query($sql_user_searched);
$row_user_searched = mysqli_fetch_assoc($result_user_searched);

if ($row_user_posts > 0)
{
    $sql_tags_used = "select distinct(tag_name) from tbl_tags where fk_user_id=$userid";
}
else if ($row_user_searched > 0)
{
    $sql_tags_used = "select distinct(tag_name) from tbl_search_tags where fk_user_id=$userid";
}
else
{
  
}

if (isset($sql_tags_used))
{
    $result_tags_used = $db->query($sql_tags_used);

    $tags = '';

    if(mysqli_num_rows($result_tags_used) > 0)
    {
        while ($row_tags_used = mysqli_fetch_array($result_tags_used))
        { 
            $tags .= $row_tags_used["tag_name"].' ';
        } 
    } 

    $tags_used = mysql_real_escape_string($tags);
    $tags_used_result = htmlspecialchars($tags_used);

    $zoek_words = explode(' ', $tags_used_result);
    $zoek_words_result = array();

    foreach ($zoek_words as $zoek_word) 
    {
        $zoek_word = trim($zoek_word);

        if (!empty($zoek_word)) 
        {
            $zoek_words_result[] = "tag_name='$zoek_word'";
        }
    }

    $zoek_words_s = implode(' or ', $zoek_words_result);
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

    <!--dashboard-->

    <!--<div class="row" id="row_header">
    <br/>
    <br/>
    <div class="large-12 small-12 columns">
        <div class="header">
            <h4 class="left">Recente ervaringen</h4>
            <h4 class="right show-for-xlarge-only">Opkomende evenementen</h4>
        </div>
    </div>
    </div>
       </div>
    </div>-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-8 columns">
                <div class="row p_btm_t">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 20px; padding-top: 0px;">Recente ervaringen</h4>
                </div>
                
                <?php

                    if ($user_privilege == 'false')
                    {
                        $sql_p = "select distinct (fk_ervaring_id) from tbl_tags where ".$zoek_words_s." order by fk_ervaring_id desc limit 0,6";
                        $result_p = $db->query($sql_p);

                        $sql_n = "select * from tbl_ervaringen";
                        $result_n = $db->query($sql_n);

                        if(mysqli_num_rows($result_p) > 0)
                        {
                          while ($rows_p = mysqli_fetch_array($result_p))
                          { 
                             $sql_s = "select * from tbl_ervaringen where ervaring_id='".$rows_p['fk_ervaring_id']."'";
                             $results = $db->query($sql_s);
                             $row_s = mysqli_fetch_assoc($results); 

                             $sql_user = "select * from tbl_users where user_id='".$row_s['fk_user_id']."'";
                             $results_user = $db->query($sql_user);
                             $row_user = mysqli_fetch_assoc($results_user); ?>
                              <div class="large-6 columns dashboard_container">
                                      <a href="ervaring_details.php?id=<?php echo $row_s['ervaring_id']; ?>&categorie_name=<?php echo $row_s['fk_categorie_name']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                           style="border-bottom: 10px solid <?php echo $row_s['fk_categorie_color']; ?>;">
                                          <ul class="small-block-grid-2 profile_info">
                                              <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                              <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                                  <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_s['ervaring_title']; ?></p>
                                                  <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_s['fk_user_name']; ?></p>
                                                  <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_s['ervaring_description'], 0, 115))."..."; ?></p>
                                              </li>
                                              <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_s['ervaring_date']; ?></li>
                                              <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                                  <img src="img/icons/like.png" class="p_r_t"><?php echo $row_s['ervaring_likes']; ?>
                                                  <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_s['ervaring_reacties']; ?>
                                              </li>
                                          </ul>
                                      </div></a>
                              </div>
                          <?php 
                          } 
                        }
                        else if ($rows_n = mysqli_fetch_array($result_n))
                        { 

                          $sql = "select * from tbl_ervaringen order by ervaring_id desc limit 0,6";
                          $result = $db->query($sql);

                          if(mysqli_num_rows($result) > 0)
                          {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                                  <div class="large-6 columns dashboard_container">
                                        <a href="ervaring_details.php?id=<?php echo $row['ervaring_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                             style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>;">
                                            <ul class="small-block-grid-2 profile_info">
                                                <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user_n['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                                <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                                    <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row['ervaring_title']; ?></p>
                                                    <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row['fk_user_name']; ?></p>
                                                    <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row['ervaring_description'], 0, 115))."..."; ?></p>
                                                </li>
                                                <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['ervaring_date']; ?></li>
                                                <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                                    <img src="img/icons/like.png" class="p_r_t"><?php echo $row['ervaring_likes']; ?>
                                                    <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['ervaring_reacties']; ?>
                                                </li>
                                            </ul>
                                        </div></a>
                                  </div>
                <?php       }
                          }
                        }
                        else
                        { ?>
                            <div class="large-8 small-8 columns" style="text-align: left; padding-left: 5px;">
                                <p>er zijn geen relevante ervaringen gevonden</p>
                            </div>
                <?php   }
                    }
                    else
                    { 
                        $sql = "select * from tbl_ervaringen order by ervaring_id desc limit 0,6";
                        $result = $db->query($sql);

                        if(mysqli_num_rows($result) > 0)
                        {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                                  <div class="large-6 columns dashboard_container">
                                        <a href="ervaring_details.php?id=<?php echo $row['ervaring_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                             style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>;">
                                            <ul class="small-block-grid-2 profile_info">
                                                <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user_n['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                                <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                                    <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row['ervaring_title']; ?></p>
                                                    <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row['fk_user_name']; ?></p>
                                                    <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row['ervaring_description'], 0, 115))."..."; ?></p>
                                                </li>
                                                <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['ervaring_date']; ?></li>
                                                <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                                    <img src="img/icons/like.png" class="p_r_t"><?php echo $row['ervaring_likes']; ?>
                                                    <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['ervaring_reacties']; ?>
                                                </li>
                                            </ul>
                                        </div></a>
                                  </div>
                <?php       }
                        }
                        else
                        { ?>
                            <div class="large-8 small-8 columns" style="text-align: left; padding-left: 5px;">
                                <p>er zijn nog geen ervaringen toevoegd aan het platform</p>
                            </div>
                <?php   }
                     } ?>
                </div>

                <div class="large-4 columns n_pad">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Opkomende evenementen</h4>
                </div>
            </div>
        </div>
    </div>  
            

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <script src="js/foundation/foundation.alert.js"></script> <!--script voor foundation alerts-->
    <script src="js/sticky_footer.js"></script> <!--script voor sticky footer-->
    <script src="js/foundation.min.js"></script> <!--script voor foundation-->
    <script src="js/sign_up_select.js"></script> <!--script voor de keuze bij sign up-->
    <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
    <script src="js/foundation/foundation.abide.js"></script> <!--script voor form validation abide-->

    <!--footer-->

    <?php include("require/include_footer.php"); ?>

  </body>
</html>
