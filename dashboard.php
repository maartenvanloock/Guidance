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

/*---------------------nagaan of de gebruiker al vragen heeft aangemaakt of gezocht op tags----------------------*/

$sql_user_vragen = "select count(*) as posts from tbl_vragen where fk_user_id='".$userid."'";
$result_user_vragen = $db->query($sql_user_vragen);
$row_user_vragen = mysqli_fetch_assoc($result_user_vragen);

if ($row_user_vragen > 0)
{
    $sql_tags_used_v = "select distinct(tag_name) from tbl_tags where fk_user_id=$userid";
}
else if ($row_user_searched > 0)
{
    $sql_tags_used_v = "select distinct(tag_name) from tbl_search_tags where fk_user_id=$userid";
}

if (isset($sql_tags_used_v))
{
    $result_tags_used_v = $db->query($sql_tags_used_v);

    $tags_v = '';

    if(mysqli_num_rows($result_tags_used_v) > 0)
    {
        while ($row_tags_used_v = mysqli_fetch_array($result_tags_used_v))
        { 
            $tags_v .= $row_tags_used_v["tag_name"].' ';
        } 
    } 

    $tags_used_v = mysql_real_escape_string($tags_v);
    $tags_used_result_v = htmlspecialchars($tags_used_v);

    $zoek_words_v = explode(' ', $tags_used_result_v);
    $zoek_words_result_v = array();

    foreach ($zoek_words_v as $zoek_word_v) 
    {
        $zoek_word_v = trim($zoek_word_v);

        if (!empty($zoek_word_v)) 
        {
            $zoek_words_result_v[] = "tag_name='$zoek_word'";
        }
    }

    $zoek_words_s_v = implode(' or ', $zoek_words_result_v);
}

?>

<!doctype html>
<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guidance | Dashboard</title>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/new.css"/>
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

    <!--dashboard-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns">
            <div class="row">
                <div class="large-8 columns m_btm_tw">

    <!--recente ervaringen-->

                <div class="large-12 small-12 columns n_pad">

                <div class="row p_btm_t show-for-large-up">
                    <h4 style="color: #7b868c; margin-top: 0px; margin-left: 20px; padding-top: 0px;">Recente ervaringen</h4>
                </div>

                <div class="large-12 small-12 columns n_pad text-center show-for-small-up hide-for-large-up">
                    <p class="title_small show-for-small-up">Recente ervaringen</p>
                </div>
                
                <?php

                    if ($user_privilege == 'false')
                    {   
                        
                        $sql_n = "select * from tbl_ervaringen";
                        $result_n = $db->query($sql_n);

                        $sql_user_search = "select count(*) from tbl_ervaringen where user_id='".$userid."' limit 1";
                        $results_user_search = $db->query($sql_user);
                        $row_user_search = mysqli_fetch_assoc($results_user);

                        if($row_user_search != false)
                        {
                          $sql_p = "select distinct (fk_ervaring_id) from tbl_tags where ".$zoek_words_s." order by fk_ervaring_id desc limit 0,4";
                          $result_p = $db->query($sql_p);

                          while ($rows_p = mysqli_fetch_array($result_p))
                          { 
                             $sql_s = "select * from tbl_ervaringen where ervaring_id='".$rows_p['fk_ervaring_id']."'";
                             $results = $db->query($sql_s);
                             $row_s = mysqli_fetch_assoc($results); 

                             $sql_user = "select * from tbl_users where user_id='".$row_s['fk_user_id']."'";
                             $results_user = $db->query($sql_user);
                             $row_user = mysqli_fetch_assoc($results_user); ?>
                             <div class="large-6 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row_s['ervaring_id']; ?>&categorie_name=<?php echo $row_s['fk_categorie_name']; ?>" class="a_ervaring">
                                    <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_s['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                        <ul class="small-block-grid-2 profile_info">
                                            <li class="n_p_btm" style="width: 12%; padding-right: 0;">
                                            <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="ervaring_profile_pre">
                                            </li>
                                            <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                            <p class="ervaring_title_pre" style="color: #7b868c;">
                                                <?php 
                                                if (strlen($row_s['ervaring_title']) > 70)
                                                {
                                                  echo htmlspecialchars(substr($row_s['ervaring_title'], 0, 70))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row_s['ervaring_title']);
                                                } ?>
                                            </p>
                                            <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo 'gepost door: '.$row_s['fk_user_name']; ?></p>
                                            <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                                <?php
                                                if (strlen($row_s['ervaring_description']) > 115)
                                                {
                                                  echo htmlspecialchars(substr($row_s['ervaring_description'], 0, 115))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row_s['ervaring_description']);
                                                } ?>
                                            </p>
                                        </li>

                                        <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_s['ervaring_date']; ?></li>

                                        <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                            <img src="img/icons/like.png" class="p_r_t"><?php echo $row_s['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_s['ervaring_reacties']; ?>
                                        </li>
                                    </ul>
                                  </div>
                                </a>
                            </div>
                          <?php 
                          } 
                        }
                        else if ($rows_n = mysqli_fetch_array($result_n))
                        { 

                          $sql = "select * from tbl_ervaringen order by ervaring_id desc limit 0,4";
                          $result = $db->query($sql);

                          if(mysqli_num_rows($result) > 0)
                          {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                              <div class="large-6 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row['ervaring_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring">
                                    <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                        <ul class="small-block-grid-2 profile_info">
                                            <li class="n_p_btm" style="width: 12%; padding-right: 0;">
                                            <img src="<?php echo $row_user_n['user_profile_path']; ?>" width="40" height="40" class="ervaring_profile_pre">
                                            </li>
                                            <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                            <p class="ervaring_title_pre" style="color: #7b868c;">
                                                <?php 
                                                if (strlen($row['ervaring_title']) > 70)
                                                {
                                                  echo htmlspecialchars(substr($row['ervaring_title'], 0, 70))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row['ervaring_title']);
                                                } ?>
                                            </p>
                                            <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo 'gepost door: '.$row['fk_user_name']; ?></p>
                                            <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                                <?php
                                                if (strlen($row['ervaring_description']) > 115)
                                                {
                                                  echo htmlspecialchars(substr($row['ervaring_description'], 0, 115))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row['ervaring_description']);
                                                } ?>
                                            </p>
                                        </li>

                                        <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['ervaring_date']; ?></li>

                                        <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                            <img src="img/icons/like.png" class="p_r_t"><?php echo $row['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['ervaring_reacties']; ?>
                                        </li>
                                    </ul>
                                  </div>
                                </a>
                            </div>
                <?php       }
                          }
                        }
                        else
                        { ?>
                            <div class="large-8 small-8 columns" style="text-align: left; padding-left: 5px;">
                                <p>er zijn geen recente ervaringen gevonden</p>
                            </div>
                <?php   }
                    }
                    else
                    { 
                        $sql = "select * from tbl_ervaringen order by ervaring_id desc limit 0,4";
                        $result = $db->query($sql);

                        if(mysqli_num_rows($result) > 0)
                        {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                              <div class="large-6 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row['ervaring_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring">
                                    <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                        <ul class="small-block-grid-2 profile_info">
                                            <li class="n_p_btm" style="width: 12%; padding-right: 0;">
                                            <img src="<?php echo $row_user_n['user_profile_path']; ?>" width="40" height="40" class="ervaring_profile_pre">
                                            </li>
                                            <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                            <p class="ervaring_title_pre" style="color: #7b868c;">
                                                <?php 
                                                if (strlen($row['ervaring_title']) > 70)
                                                {
                                                  echo htmlspecialchars(substr($row['ervaring_title'], 0, 70))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row['ervaring_title']);
                                                } ?>
                                            </p>
                                            <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo 'gepost door: '.$row['fk_user_name']; ?></p>
                                            <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                                <?php
                                                if (strlen($row['ervaring_description']) > 115)
                                                {
                                                  echo htmlspecialchars(substr($row['ervaring_description'], 0, 115))."...";
                                                }
                                                else
                                                {
                                                   echo htmlspecialchars($row['ervaring_description']);
                                                } ?>
                                            </p>
                                        </li>

                                        <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['ervaring_date']; ?></li>

                                        <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                            <img src="img/icons/like.png" class="p_r_t"><?php echo $row['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['ervaring_reacties']; ?>
                                        </li>
                                    </ul>
                                  </div>
                                </a>
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

    <!--recente vragen-->

                    <div class="large-12 small-12 columns n_pad">
                    <div class="row p_btm_t m_tp_tw m_btm_tw show-for-large-up">
                        <br/>
                        <h4 style="color: #7b868c; margin-top: 0px; margin-left: 20px; padding-top: 0px;">Recente vragen</h4>
                    </div>

                    <div class="large-12 small-12 columns n_pad text-center show-for-small-up hide-for-large-up">
                        <br/>
                        <p class="title_small show-for-small-up">Recente vragen</p>
                    </div>
            <?php 

                    if ($user_privilege == 'false')
                    {
                        $sql_p = "select distinct (fk_vraag_id) from tbl_tags_vragen where ".$zoek_words_s." order by fk_vraag_id desc limit 0,4";
                        $result_p = $db->query($sql_p);

                        $sql_n = "select * from tbl_vragen";
                        $result_n = $db->query($sql_n);

                        if(mysqli_num_rows($result_p) > 0)
                        {
                          while ($rows_p = mysqli_fetch_array($result_p))
                          { 
                             $sql_s = "select * from tbl_vragen where vraag_id='".$rows_p['fk_vraag_id']."'";
                             $results = $db->query($sql_s);
                             $row_s = mysqli_fetch_assoc($results); 

                             $sql_user = "select * from tbl_users where user_id='".$row_s['fk_user_id']."'";
                             $results_user = $db->query($sql_user);
                             $row_user = mysqli_fetch_assoc($results_user); ?>
                             <div class="large-6 columns dashboard_container">
                                <a href="vraag_details.php?id=<?php echo $row_s['vraag_id']; ?>&categorie_name=<?php echo $row_s['fk_categorie_name']; ?>" class="a_ervaring">
                                    <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_s['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                        <ul class="small-block-grid-2 profile_info">
                                            <li class="n_p_btm" style="width: 12%; padding-right: 0;">
                                                <img src="<?php echo $row_user['user_profile_path']; ?>" width="40" height="40" class="vraag_profile_pre">
                                            </li>
                                            <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                                <p class="ervaring_title_pre" style="color: #7b868c;">
                                                    <?php 
                                                    if (strlen($row_s['vraag_title']) > 70)
                                                    {
                                                      echo htmlspecialchars(substr($row_s['vraag_title'], 0, 70))."...";
                                                    }
                                                    else
                                                    {
                                                      echo htmlspecialchars($row_s['vraag_title']);
                                                    } ?>
                                                </p>
                                                <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo htmlspecialchars('gepost door: '.$row_s['fk_user_name']); ?></p>
                                                <p class="ervaring_desc_pre" style="color: #a5b1b8;">
                                                    <?php 
                                                    if (strlen($row_s['vraag_description']) > 115)
                                                    {
                                                      echo htmlspecialchars(substr($row_s['vraag_description'], 0, 115))."...";
                                                    }
                                                    else
                                                    {
                                                      echo htmlspecialchars($row_s['vraag_description']);
                                                    } ?>
                                                </p>
                                            </li>
                                            <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_s['vraag_date']; ?></li>
                                            <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                                <img src="img/icons/like.png" class="p_r_t"><?php echo $row_s['vraag_likes']; ?>
                                                <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_s['vraag_reacties']; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                             </div>
              <?php 
                          } 
                        }
                        else if ($rows_n = mysqli_fetch_array($result_n))
                        { 

                          $sql = "select * from tbl_vragen order by ervaring_id desc limit 0,4";
                          $result = $db->query($sql);

                          if(mysqli_num_rows($result) > 0)
                          {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                              <div class="large-6 columns dashboard_container">
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
                                                    if (strlen($row['vraag_description']) > 115)
                                                    {
                                                      echo htmlspecialchars(substr($row['vraag_description'], 0, 115))."...";
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
                                    </div>
                                </a>
                             </div>
                <?php       }
                          }
                        }
                        else
                        { ?>
                            <div class="large-8 small-8 columns" style="text-align: left; padding-left: 5px;">
                                <p>er zijn geen recente ervaringen gevonden</p>
                            </div>
                <?php   }
                    }
                    else
                    { 
                        $sql = "select * from tbl_vragen order by vraag_id desc limit 0,4";
                        $result = $db->query($sql);

                        if(mysqli_num_rows($result) > 0)
                        {
                            while ($row = mysqli_fetch_array($result))
                            { 
                              $sql_user_n = "select * from tbl_users where user_id='".$row['fk_user_id']."'";
                              $results_user_n = $db->query($sql_user_n);
                              $row_user_n = mysqli_fetch_assoc($results_user_n); ?>
                                  <div class="large-6 columns dashboard_container">
                                        <a href="vraag_details.php?id=<?php echo $row['vraag_id']; ?>&categorie_name=<?php echo $row['fk_categorie_name']; ?>" class="a_ervaring"><div class="panel ervaring_panel" 
                                             style="border-bottom: 10px solid <?php echo $row['fk_categorie_color']; ?>;">
                                            <ul class="small-block-grid-2 profile_info">
                                                <li class="n_p_btm" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user_n['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                                <li class="p_l_t" style="width: 88%; padding-bottom: 0;">
                                                    <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row['vraag_title']; ?></p>
                                                    <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row['fk_user_name']; ?></p>
                                                    <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row['vraag_description'], 0, 115))."..."; ?></p>
                                                </li>
                                                <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row['vraag_date']; ?></li>
                                                <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                                    <img src="img/icons/like.png" class="p_r_t"><?php echo $row['vraag_likes']; ?>
                                                    <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row['vraag_reacties']; ?>
                                                </li>
                                            </ul>
                                        </div></a>
                                  </div>
                <?php       }
                        }
                        else
                        { ?>
                            <div class="large-8 small-8 columns" style="text-align: left; padding-left: 5px;">
                                <p>er zijn nog geen vragen toevoegd aan het platform</p>
                            </div>
                <?php   } 
                    } ?>
                </div>
                </div>

    <!--opkomende evenementen large-->

                <div class="large-4 columns n_pad" style="padding-right: 20px;">
                    <div class="large-12 small-12 columns n_pad" style="min-height: 586px;">
                    <h4 class="show-for-large-up" style="color: #7b868c; margin-top: 0px; margin-left: 5px; padding-top: 0px;">Opkomende evenementen</h4>

                    <div class="large-12 small-12 columns n_pad text-center show-for-small-up hide-for-large-up">
                        <br/>
                        <p class="title_small show-for-small-up">Opkomende evenementen</p>
                    </div>

                    <?php
                        $sql = "select * from tbl_evenementen order by evenement_id desc limit 0,6";
                        $results = $db->query($sql);
              
                        if(mysqli_num_rows($results) > 0)
                        {
                          while ($row = mysqli_fetch_assoc($results))
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
                              <div class="large-12 small-12 columns evenement_container" style="margin-bottom: 14px;">
                                  <a href="evenement_details.php?id=<?php echo $row['evenement_id']; ?>" class="a_ervaring">
                                      <div class="panel evenement_panel n_pad n_marg">
                                          <div class="large-12 small-12 columns n_pad n_marg evenement_pre_panel">
                                              <div class="large-2 small-2 columns text-center n_pad p_t evenement_pre_date_panel" style="border-top-left-radius: 3px;">
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

                                              <div class="large-2 small-2 columns text-center n_pad evenement_pre_aanwezigen_panel" style="border-top-right-radius: 3px;">
                                                  <p class="evenement_pre_nvisit n_pad n_marg" style="color: #7b868c;"><?php echo $row['evenement_n_visit']; ?></p>
                                                  <p class="evenement_pre_aanw n_pad n_marg" style="color: #7b868c;">aanw.</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                          <?php 
                          } 
                        }
                        else
                        {?>
                          <div class="small-12 large-centered columns" style="margin-top: 25%; text-align: center;">
                              <p>er zijn momenteel nog geen evenementen aangemaakt op het platform</p>
                          </div>
                        <?php
                        } ?>
                </div>

    <!--Recente algemene info-->

                <div class="large-12 small-12 columns n_pad">
                <div class="row p_btm_t m_tp_tw m_btm_tw show-for-large-up">
                        <br/>
                        <h4 style="color: #7b868c; margin-top: 0px; margin-left: 20px; padding-top: 0px;">Algemene info</h4>
                </div>

                    <div class="large-12 small-12 columns n_pad text-center show-for-small-up hide-for-large-up">
                        <br/>
                        <p class="title_small show-for-small-up">Algemene info</p>
                    </div>
                <?php 

                    $sql_info = "select * from tbl_informatieblok order by informatieblok_id desc limit 0,3";
                    $results_info = $db->query($sql_info);
                
                    if(mysqli_num_rows($results_info) > 0)
                    {
                      while ($row_info = mysqli_fetch_assoc($results_info))
                      { ?>
                          <div class="large-12 small-12 columns dashboard_container">
                                  <a href="algemene_info_details.php?id=<?php echo $row['informatieblok_id']; ?>" class="a_ervaring">
                                      <div class="panel ervaring_panel m_btm_t">
                                          <p class="informatieblok_title" style="color: #7b868c;"><?php echo $row_info['informatieblok_title']; ?></p>
                                          <p class="informatieblok_desc" style="color: #a5b1b8;"><?php echo strip_tags(substr($row_info['informatieblok_description'], 0, 370))."..."; ?></p>      
                                      </div>
                                  </a>
                          </div>
                      <?php 
                      } 
                    }
                    else
                    {?>
                      <div class="large-12 small-12 large-centered columns" style="margin-top: 15%; text-align: center;">
                          <p>er is geen informatie</p>
                      </div>
                    <?php
                    } ?>
                </div>
                </div>
            </div>
        </div>
    </div>  
            

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
    <script src="js/rem.min.js"></script>
    <script src="js/rem.js"></script>
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
