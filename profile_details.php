<?php  

session_start();

require ("classes/connection.class.php");
require ("classes/user_details.class.php");

$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$user_privilege = $_SESSION['userprivilege'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------nagaan welke gebruiker details er gevraagd worden----------------------*/

if (isset($_GET["user"]))
{
    $userid = $_GET["user"];

    $sql_privilege = "select * from tbl_users where user_id='$userid'";
    $result_privilege = $db->query($sql_privilege);
    $row_privilege = mysqli_fetch_assoc($result_privilege);

    $user_privilege = $row_privilege['user_privilege'];
} 

$sql = "select * from tbl_users where user_id='$userid'";
$result = $db->query($sql);
$row = mysqli_fetch_assoc($result);

/*---------------------aanmaken van pagination----------------------*/

$item_per_page = 9;

if (isset($_GET["filter"]))
{   
    $filter = $_GET["filter"];

    if($filter == "ervaringen")
    {
        $sql = "select count(*) from tbl_ervaringen where fk_user_id='".$userid."'";
        $result = $db->query($sql);
    }
    else if($filter == "reacties")
    {
        $sql = "select count(*) from tbl_reacties where fk_user_id='".$userid."'";
        $result = $db->query($sql);
    }
}
else
{
    $sql = "select count(*) from tbl_ervaringen where fk_user_id='".$userid."'";
    $result = $db->query($sql);
}

$get_all_rows = mysqli_fetch_array($result);

$pages = ceil($get_all_rows[0]/$item_per_page);

$pagination = '';

if($pages > 1)
{
    $pagination .= '<div class="row">
                        <div class="large-12 columns n_pad">
                            <div class="pagination-centered">
                                <ul class="pagination">';
    for($i = 1; $i<=$pages; $i++)
    {
        if (isset($_GET["filter"]))
        { 
            $pagination .= '<li><a href="profile_details.php?filter='.$filter.'&page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
        }
        else
        {
            $pagination .= '<li><a href="profile_details.php?page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
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

/*---------------------aanpassen van profile details---------------------*/

$sql_user_details = "select * from tbl_user_details where fk_user_id = $userid limit 1";
$results_user_details = $db->query($sql_user_details);
$row_user_details = mysqli_fetch_assoc($results_user_details);

if(isset($_POST['btnSubmitProfile']))
{
   try
   {   
       $profile_img_r = $_POST['image_hr'];
       $profile_img = preg_replace('#^data:image/[^;]+;base64,#', '', $profile_img_r);
       $profile_img_st = file_put_contents('profile_imgs/user_img_'.$userid.'.png', base64_decode($profile_img));

       /*echo '<img src="user_img.png" id="profile_imgsmall_'.$userid.'.png" name="profile_imgsmall_'.$userid.'.png" width="40" height="40">';
       echo '<img src="user_img.png" id="profile_imgsmall_'.$userid.'.png" name="profile_imgsmall_'.$userid.'r.png" width="80" height="80">';
       echo '<img src="user_img.png" id="profile_imgsmall_'.$userid.'.png" name="profile_img_'.$userid.'r.png" width="400" height="400">';*/

       if ($profile_img_st !== 3951)
       {
           $href_cropped_image = $_POST['image_hr'];
           $img = preg_replace('#^data:image/[^;]+;base64,#', '', $href_cropped_image);
           $movecroppedimage = file_put_contents('profile_imgs/profile_img_'.$userid.'.png', base64_decode($img));

           $sql = "update tbl_users set user_profile_path = 'profile_imgs/profile_img_$userid.png' where user_id = $userid";
           $db->query($sql);
       }

       $ud = new User_details();

       $profile_zorg_voor = mysql_real_escape_string($_POST['profile_zorg_voor']);
       $ud->Userzorgvoor = htmlspecialchars($profile_zorg_voor);

       $profile_description = mysql_real_escape_string($_POST['profile_description']);
       $ud->Userdesc = htmlspecialchars($profile_description);

       $profile_location = mysql_real_escape_string($_POST['profile_location']);
       $ud->Userwoonplaats = htmlspecialchars($profile_location);

       $ud->Userid = htmlspecialchars($_SESSION['userid']);

       if ($row_user_details != false)
       {
            $ud->Update();
       }
       else
       {
            $ud->Save();
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

    <link rel="stylesheet" href="css/jquery.cropbox.css"/>
    <!--<script src=​"http:​/​/​ajax.googleapis.com/​ajax/​libs/​jquery/​2.1.0/​jquery.min.js">​</script>​-->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.10/hammer.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.11/jquery.mousewheel.js"></script>
    <script src="js/jquery.cropbox.js"></script>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.cropimage').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script type="text/javascript" defer>
        $( function () {
          $( '.cropimage' ).each( function () {
            var image = $(this),
                cropwidth = image.attr('cropwidth'),
                cropheight = image.attr('cropheight'),
                results = image.next('.results' ),
                x       = $('.cropX', results),
                y       = $('.cropY', results),
                w       = $('.cropW', results),
                h       = $('.cropH', results),
                download = results.next('.download').find('a');

              image.cropbox( {width: cropwidth, height: cropheight, showControls: 'always' } )
                .on('cropbox', function( event, results, img ) {
                  x.text( results.cropX );
                  y.text( results.cropY );
                  w.text( results.cropW );
                  h.text( results.cropH );
                  download.attr('href', img.getDataURL());
                  var href = $('#profile_image_cropped').attr('href');
                  $('#image_hr').val(href);
                  $('#img_small').attr("src", href);
                });
          });

          $('#select').on('change', function () {
              var size = parseInt(this.value);
              $('.cropimage').each(function () {
                $(this).cropbox({width: size, height: size})
              });
          });
        });
    </script>

  </head>

  <body>
  
    <!--navigation-->

    <?php include("require/include_header_norm.php"); ?>

    <!--profile details voor gebruiker-->

    <div class="large-12 small-12 columns" style="background-color: #074e68;">
    <br/>
    <br/>
            <div class="large-12 small-12 columns text-center">
                <?php
                if (isset($_GET["user"]))
                {
                    $sql_user = "select * from tbl_users where user_id='".$userid."'";
                }
                else
                {
                    $sql_user = "select * from tbl_users where user_id='".$_SESSION['userid']."'";
                }

                $results_user = $db->query($sql_user);
                $row_user = mysqli_fetch_assoc($results_user); ?>
                <img src="<?php echo $row_user['user_profile_path']; ?>" id="profile_details_med_img" style="width: 100px; height: 100px; border-radius: 100px;">
            </div>

            <div class="large-12 small-12 columns text-center">
                <h2 id="profile_details_username"><?php echo $row['user_name']; ?></h2>
            </div>
            
            <div class="large-12 small-12 columns text-center n_pad">
                <a href="#" class="edit_profile" data-reveal-id="edit_profile">
            <?php  
                    if (!isset($_GET["user"]))
                    { ?>
                        <p class="btn_edit_profile">edit profile</p>
            <?php   }
                    else if ($_GET['user'] == $_SESSION['userid'])
                    { ?>
                        <p class="btn_edit_profile">edit profile</p>
            <?php   } ?>
                </a>
            </div>

            <div class="large-12 small-12 columns text-center m_tp_t">
                    <i class="fi-star size-36" style="color: #ffffff;"></i>
                    <span id="profile_details_ptn" style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 28px; font-style: inherit; font-weight: 700; margin-top: 10px; margin-left: 10px; margin-right: 10px;">
                    <?php echo $row['user_ptn']; ?></span>
                    <i class="fi-star size-36" style="color: #ffffff;"></i>
            </div>
    </div>

    <div class="large-12 small-12 columns p_btm_tw" style="background-color: #074e68;">
        <div class="row">
            <div class="large-12 small-12 small-centered large-centered columns n_pad text-center m_tp_th">
                <ul class="inline-list text-center" style="display: inline-block;">
                    <li id="n_posts">
                        <h2 class="profile_details_smallinf">
                            <?php  
                                $sql_posts = "select count(*) as posts from tbl_ervaringen where fk_user_id='".$userid."'";
                                $result_posts = $db->query($sql_posts);
                                $row_posts = mysqli_fetch_assoc($result_posts);

                                echo $row_posts['posts'];
                            ?>
                        </h2>
                        <h2 class="profile_details_smallinftext">ervaringen</h2>
                    </li>
                    
                    <li id="n_reacties">
                        <h2 class="profile_details_smallinf">
                            <?php  
                                $sql_reacties = "select count(*) as reacties from tbl_reacties where fk_user_id='".$userid."'";
                                $result_reacties = $db->query($sql_reacties);
                                $row_reacties = mysqli_fetch_assoc($result_reacties);

                                echo $row_reacties['reacties'];
                            ?>
                        </h2>
                        <h2 class="profile_details_smallinftext">antwoorden</h2>
                    </li>
                        
                    <li id="n_likes">
                        <h2 class="profile_details_smallinf">
                            <?php  
                                $sql_reactielikes = "select count(reactie_likes) as reactielikes from tbl_reacties where fk_user_id='".$userid."'";
                                $result_reactielikes = $db->query($sql_reactielikes);
                                $row_reactielikes = mysqli_fetch_assoc($result_reactielikes);

                                echo $row_reactielikes['reactielikes'];
                            ?>
                        </h2>
                        <h2 class="profile_details_smallinftext">likes</h2>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--aanpassen van profile details-->
    
        <div id="edit_profile" class="reveal-modal large" data-reveal>
            <div class="large-12 small-12 columns n_pad">
                <h4>Edit profile</h4>
            </div>

            <form action="" method="post" data-abide>
                <div class="large-12 small-12 columns n_pad m_btm_t">
                    <label style="margin-bottom: 10px;">CHANGE PROFILE PHOTO:</label>
                    <input type="file" name="image" onchange="readURL(this);">
                    <!--<img class="cropimage" alt="" src="img/user.png" cropwidth="200" cropheight="200"/>-->
                    <img class="cropimage" alt="" 
                         src="<?php  
                                $sql_user = "select * from tbl_users where user_id='".$_SESSION['userid']."'";
                                $results_user = $db->query($sql_user);
                                $row_user = mysqli_fetch_assoc($results_user);
                                if ($row_user["user_profile_path"] !== 'img/user.png')
                                {
                                    echo $row_user['user_profile_path'];
                                }
                                else
                                {
                                    echo 'img/user.png';
                                } ?>" cropwidth="200" cropheight="200"/>

                    <div class="results hide"> 
                        <b>X</b>: <span class="cropX"></span> 
                        <b>Y</b>: <span class="cropY"></span> 
                        <b>W</b>: <span class="cropW"></span> 
                        <b>H</b>: <span class="cropH"></span> 
                    </div>

                    <div class="download hide"> 
                        <a href="" id="profile_image_cropped" name="profile_image_cropped" download="<?php echo 'profile_img_'.$userid; ?>">Download</a>
                    </div>
                </div>    

                <div class="large-12 small-12 columns n_pad">
                    <input type="text" id="image_hr" name="image_hr">
                    <img src="#" id="img_small" width="40" height="40">
                </div>

                <div class="large-12 small-12 columns n_pad">
                    <label class="m_btm_t">IK ZORG VOOR:</label>
                    <input type="text" id="profile_zorg_voor" name="profile_zorg_voor" 
                           <?php

                            if ($row_user_details["user_detail_zorgvoor"])
                            {
                                echo 'value="'.$row_user_details["user_detail_zorgvoor"].'"';
                            }
                            else
                            {
                                echo 'placeholder="Ex: mijn dementerende vader"';
                            }

                            ?> >
                </div>

                <div class="large-12 small-12 columns n_pad">
                    <label class="m_btm_t">OVER MIJ:</label>
                    <textarea type="text" id="profile_description" name="profile_description"><?php echo trim($row_user_details["user_detail_desc"]); ?></textarea>
                    <ul class="chars_left">
                        <li><p class="profile_description_chars"></p></li>
                        <li><p>characters left</p></li>
                    </ul>
                </div>

                <div class="large-12 small-12 columns n_pad">
                    <label class="m_btm_t">WOONPLAATS:</label>
                    <input type="text" id="profile_location" name="profile_location" placeholder="Naam gemeente, Naam stad"
                           <?php

                                if ($row_user_details["user_detail_woonplaats"])
                                {
                                    echo 'value="'.$row_user_details["user_detail_woonplaats"].'"';
                                }
                                else
                                {
                                    echo 'placeholder="Naam gemeente, Naam stad"';
                                }

                                ?> >
                    <ul class="chars_left">
                        <li><p class="profile_location_chars"></p></li>
                        <li><p>characters left</p></li>
                    </ul>
                </div>

                <div class="large-12 small-12 columns n_pad">
                    <button type="submit" href="#" class="button [radius round]" id="btnSubmitProfile" name="btnSubmitProfile">Voeg aanpassingen toe</button>
                </div>
            </form>

            <a class="close-reveal-modal">&#215;</a>
        </div>
    
    <!--filters large and up-->

    <div class="row">
    <br/>
        <div class="small-6 large-centered columns text-center show-for-large-up">
            <dl class="sub-nav" style="display: inline-block;">
                <dd <?php if (isset($_GET["filter"]))
                          { 
                                $categorie_filter_large = $_GET["filter"];

                                if($categorie_filter_large == 'ervaringen')
                                {
                                    echo 'class="active"';
                                } 
                          } ?> >
                    <a href="profile_details.php?user=<?php echo $userid; ?>&filter=ervaringen" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                       onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                       class="filter_ervaring_fi">ervaringen</a>
                </dd>
                <dd <?php if (isset($_GET["filter"]))
                          { 
                                $filter_large = $_GET["filter"];

                                if($filter_large == 'reacties')
                                {
                                    echo 'class="active"';
                                } 
                          } ?> >
                    <a href="profile_details.php?user=<?php echo $userid; ?>&filter=reacties" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                       onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                       class="filter_ervaring_fi">reacties</a>
                </dd>
            </dl>
        </div>

    <!--filters small-->

    <div class="large-4 columns show-for-small-up hide-for-large-up">
            <div class="large-12 columns n_pad" style="padding-left: 5px; padding-right: 5px;">
                <form action="" method="get" Onchange="this.form.submit()" style="margin-bottom: 0px;" data-abide>
                    <select id="filter" name="filter" Onchange="this.form.submit()" style="margin-bottom: 10px;" required>
                        <option value="" disabled selected>Filter op categorie:</option>
                        <option value="ervaringen" 
                            <?php if (isset($_GET["filter"]))
                                  { 
                                        $filter_small = $_GET["filter"];

                                        if($filter_small == 'ervaringen')
                                        {
                                            echo 'selected';
                                        } 
                                  } ?> >ervaringen</option>
                        <option value="reacties" 
                            <?php if (isset($_GET["filter"]))
                                  { 
                                        $filter_small = $_GET["filter"];

                                        if($filter_small == 'reacties')
                                        {
                                            echo 'selected';
                                        } 
                                  } ?> >reacties</option>
                    </select>
                </form>
            </div>
    </div>

    <!--pagination-->

    <?php echo $pagination; ?>

    <!--overzicht van ervaringen voor deze gebruiker-->

        <div class="large-12 small-12 columns ervaringen" id="results_ervaringen">
            <?php

                if (isset($_GET["filter"]))
                { 
                        $filter = $_GET["filter"];

                        if($filter == 'ervaringen')
                        {
                            $sql_e = "select * from tbl_ervaringen where fk_user_id='".$userid."' order by ervaring_id desc LIMIT $start_from, $item_per_page";
                            $result_e = $db->query($sql_e);

                            if(mysqli_num_rows($result_e) > 0)
                            {
                                while ($row_e = mysqli_fetch_assoc($result_e))
                                { 
                                    $sql_user = "select * from tbl_users where user_id='".$row_e['fk_user_id']."'";
                                    $results_user = $db->query($sql_user);
                                    $row_user = mysqli_fetch_assoc($results_user); ?>
                                    <div class="large-4 columns dashboard_container">
                                        <a href="ervaring_details.php?id=<?php echo $row_e['ervaring_id']; ?>&categorie_name=<?php echo $row_e['fk_categorie_name']; ?>" class="a_ervaring">
                                        <div class="panel ervaring_panel m_btm_t" style="border-bottom: 10px solid <?php echo $row_e['fk_categorie_color']; ?>;">
                                            <ul class="small-block-grid-2 profile_info">
                                                <li class="n_p_btm n_p_r" style="width: 12%;">
                                                    <img src="<?php echo $row_user['user_profile_path']; ?>" class="profile_details_img">
                                                </li>
                                                <li class="p_l_t n_p_btm" style="width:88%; padding-bottom: 0px;">
                                                    <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_e['ervaring_title']; ?></p>
                                                    <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_e['fk_user_name']; ?></p>
                                                    <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_e['ervaring_description'], 0, 118))."..."; ?></p>
                                                </li>
                                                <li class="left ervaring_date_pre n_p_btm" style="width: 100px;"><?php echo $row_e['ervaring_date']; ?></li>
                                                <li class="right ervaring_likes_pre n_p_btm" style="width: auto;">
                                                    <img src="img/icons/like.png" class="p_r_t"><?php echo $row_e['ervaring_likes']; ?>
                                                    <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_e['ervaring_reacties']; ?>
                                                </li>
                                            </ul>
                                        </div></a>
                                    </div>
                <?php           }
                            }
                            else
                            { ?>
                                <div class="small-12 large-centered columns" style="margin-top: 25%; text-align: center;">
                                    <p>er zijn geen ervaringen</p>
                                </div>
                <?php       } 
                        }
                        else if($filter == 'reacties')
                        {
                            $sql_r = "select * from tbl_reacties where fk_user_id='".$userid."' order by reactie_likes desc LIMIT $start_from, $item_per_page";
                            $result_r = $db->query($sql_r);

                            if(mysqli_num_rows($result_r) > 0)
                            {
                                while ($row_r = mysqli_fetch_assoc($result_r))
                                { 
                                    $sql_user = "select * from tbl_users where user_id='".$row_r['fk_user_id']."'";
                                    $results_user = $db->query($sql_user);
                                    $row_user = mysqli_fetch_assoc($results_user); ?>
                                    <div class="large-6 small-12 columns" style="padding-left: 5px; padding-right: 5px;">
                                         <div class="panel profile_reactie_panel">
                                            <div class="large-2 columns w_h_auto">
                                                <img src="<?php echo $row_user['user_profile_path']; ?>" class="reactie_profile_img"
                                        <?php 
                                                if ($row_r['fk_user_privilege'] == "true")
                                                { ?>
                                                  style="border-radius: 20px; border: 2px solid #5db0c6;"
                                        <?php 
                                                } ?>
                                                >
                                            </div>

                                            <div class="large-10 small-10 columns n_p_l">
                                                <ul style="text-decoration: none; list-style: none;">
                                                  <li><?php echo htmlspecialchars($row_r['fk_user_name']).' '.htmlspecialchars($row_r['reactie_date']); ?></li>
                                                  <li class="reactie_desc"><?php echo htmlspecialchars($row_r['reactie_description']); ?>
                                                  </li>
                                                </ul>
                                            </div>

                                            <div class="large-12 columns">
                                                    <ul class="small-block-grid-2" style="margin-bottom: 15px;">
                                                        <li class="left n_p_btm" style="height: 30px; text-decoration: none;">
                                                            <div class="row hide">
                                                                <input type="text" placeholder="<?php echo htmlspecialchars($row_r['reactie_id']); ?>" value="<?php echo htmlspecialchars($row_r['reactie_id']); ?>" 
                                                                       id="reactie_id" name="reactie_id">
                                                            </div>
                                                            <?php  
                                                            $reactie_id = $row_r['reactie_id'];

                                                            $sql_vt = "select * from tbl_reacties_vt where fk_reactie_id='".$reactie_id."' and fk_user_id='".$userid."' limit 1";
                                                            $result_vt = $db->query($sql_vt);
                                                            $row_vt = mysqli_fetch_array($result_vt); ?>

                                                            <button type="submit" href="#" class="button [radius round] btnSubmitReactie_vt left" name="btnSubmitReactie_vt"
                                                                    style="background-color: #e6e6e6; color: #7b868c;" disabled>
                                                                    <i class="fi-check size-16"></i>
                                                                    <span class="reactie_helpful">Helpful</span>
                                                                    <span class="reactie_vt_n">
                                                                    <?php echo htmlspecialchars($row_r['reactie_likes']); ?></span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                            </div>
                                        </div>
                                    </div>
                <?php           }
                            } 
                        }
                } 
                else
                {
                    $sql_e = "select * from tbl_ervaringen where fk_user_id='".$userid."' order by ervaring_id desc LIMIT $start_from, $item_per_page";
                    $result_e = $db->query($sql_e);

                    if(mysqli_num_rows($result_e) > 0)
                    {
                        while ($row_e = mysqli_fetch_assoc($result_e))
                        { 
                            $sql_user = "select * from tbl_users where user_id='".$row_e['fk_user_id']."'";
                            $results_user = $db->query($sql_user);
                            $row_user = mysqli_fetch_assoc($results_user); ?>
                            <div class="large-4 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row_e['ervaring_id']; ?>&categorie_name=<?php echo $row_e['fk_categorie_name']; ?>" class="a_ervaring">
                                <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_e['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                    <ul class="small-block-grid-2 profile_info">
                                        <li class="n_p_btm n_p_r" style="width: 12%; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" class="profile_details_img"></li>
                                        <li class="p_l_t n_p_btm" style="width:88%; padding-bottom: 0px;">
                                            <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_e['ervaring_title']; ?></p>
                                            <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_e['fk_user_name']; ?></p>
                                            <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_e['ervaring_description'], 0, 118))."..."; ?></p>
                                        </li>
                                        <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_e['ervaring_date']; ?></li>
                                        <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                            <img src="img/icons/like.png" class="p_r_t"><?php echo $row_e['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;"><?php echo $row_e['ervaring_reacties']; ?>
                                        </li>
                                    </ul>
                                </div></a>
                            </div>
        <?php           }
                    }
                    else
                    { ?>
                        <div class="small-12 large-centered columns" style="margin-top: 25%; text-align: center;">
                            <p>er zijn geen ervaringen</p>
                        </div>
        <?php       } 
                } ?>
        </div>       
    </div>
    <br/>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>

    <!--char limit-->

    <script src="js/char_limit.js"></script>
    <script src="js/form_animations.js"></script>

    <script>
        $(document).ready(function(){

          var elem_profile_description = $(".profile_description_chars");
          $("#profile_description").limiter(500, elem_profile_description);

          var elem_profile_location = $(".profile_location_chars");
          $("#profile_location").limiter(100, elem_profile_location);

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
