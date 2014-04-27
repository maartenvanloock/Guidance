<?php  

session_start();

require ("classes/connection.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------nagaan welke gebruiker details er gevraagd worden----------------------*/

if (isset($_GET["user"]))
{
    $userid = $_GET["user"];
} 
else
{

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
    else if($filter == "reactie")
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
                        <div class="large-12 columns">
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

    <div class="large-12 small-12 columns hide">
        <form method="post" action="" Onchange="this.form.submit()" enctype="multipart/form-data"> 
              <div class="large-4 columns">
                <input type="file" Onchange="this.form.submit()" id="image" name="image">
              </div>
        </form>
    </div>

    <!--profile details-->

    <div class="large-12 small-12 columns" style="background-color: #074e68;">
    <br/>
    <br/>
            <div class="large-12 small-12 columns text-center">
                <img src="img/user.png" style="width: 100px; height: 100px; border-radius: 100px;">
            </div>

            <div class="large-12 small-12 columns text-center">
                <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 28px; font-style: inherit; font-weight: 700; margin-top: 10px;"><?php echo $row['user_name']; ?></h2>
            </div>

            <div class="large-12 small-12 columns text-center" style="margin-top: 10px;">
                    <i class="fi-star size-36" style="color: #ffffff;"></i>
                    <span style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 28px; font-style: inherit; font-weight: 700; margin-top: 10px; margin-left: 10px; margin-right: 10px;">
                    <?php echo $row['user_ptn']; ?></span>
                    <i class="fi-star size-36" style="color: #ffffff;"></i>
            </div>
    </div>

    <div class="large-12 small-12 columns" style="background-color: #074e68; padding-bottom: 20px;">
        <div class="row">
            <div class="large-6 small-12 small-centered large-centered columns text-center" style="margin-top: 30px;">
                <ul class="inline-list text-center" style="display: inline-block;">
                    <li style="padding-right: 20px; border-right: 3px solid #ffffff;">
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 24px; font-style: inherit; font-weight: 600; margin-top: 0px;">
                            <?php  
                                $sql_posts = "select count(*) as posts from tbl_ervaringen where fk_user_id='".$userid."'";
                                $result_posts = $db->query($sql_posts);
                                $row_posts = mysqli_fetch_assoc($result_posts);

                                echo $row_posts['posts'];
                            ?>
                        </h2>
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600; margin-top: 10px; margin-bottom: 0px;">posts</h2>
                    </li>
                        
                    <li style="padding-right: 20px; border-right: 3px solid #ffffff;">
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 24px; font-style: inherit; font-weight: 600; margin-top: 0px;">
                            <?php  
                                $sql_reacties = "select count(*) as reacties from tbl_reacties where fk_user_id='".$userid."'";
                                $result_reacties = $db->query($sql_reacties);
                                $row_reacties = mysqli_fetch_assoc($result_reacties);

                                echo $row_reacties['reacties'];
                            ?>
                        </h2>
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600; margin-top: 10px; margin-bottom: 0px;">answers</h2>
                    </li>
                        
                    <li style="margin-right: 10px;">
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 24px; font-style: inherit; font-weight: 600; margin-top: 0px;">
                            <?php  
                                $sql_reactielikes = "select count(reactie_likes) as reactielikes from tbl_reacties where fk_user_id='".$userid."'";
                                $result_reactielikes = $db->query($sql_reactielikes);
                                $row_reactielikes = mysqli_fetch_assoc($result_reactielikes);

                                echo $row_reactielikes['reactielikes'];
                            ?>
                        </h2>
                        <h2 style="color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600; margin-top: 10px; margin-bottom: 0px;">likes</h2>
                    </li>
                </ul>
            </div>
        </div>
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
                    <a href="profile_details.php?filter=ervaringen" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                       onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                       style="color: #7b868c; border-radius: 3px; padding-top: 5px; padding-bottom: 5px;">ervaringen</a>
                </dd>
                <dd <?php if (isset($_GET["filter"]))
                          { 
                                $filter_large = $_GET["filter"];

                                if($filter_large == 'reacties')
                                {
                                    echo 'class="active"';
                                } 
                          } ?> >
                    <a href="profile_details.php?filter=reacties" onMouseOver="this.style.backgroundColor='#5db0c6', this.style.color='#ffffff'"
                       onMouseOut="this.style.backgroundColor='#f9f9f9', this.style.color='#7b868c'" 
                       style="color: #7b868c; border-radius: 3px; padding-top: 5px; padding-bottom: 5px;">reacties</a>
                </dd>
            </dl>
        </div>

    <!--filters small-->

    <div class="large-4 columns show-for-small-up hide-for-large-up">
            <div class="large-12 columns" style="padding: 0px;">
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

    <div class="row">
        <div class="large-12 small-12 columns ervaringen" id="results">
            <?php

                if (isset($_GET["filter"]))
                { 
                        $filter = $_GET["filter"];

                        if($filter_small == 'ervaringen')
                        {
                            $sql_e = "select * from tbl_ervaringen where fk_user_id='".$userid."' order by ervaring_id desc LIMIT $start_from, $item_per_page";
                            $result_e = $db->query($sql_e);

                            if(mysqli_num_rows($result_e) > 0)
                            {
                                while ($row_e = mysqli_fetch_assoc($result_e))
                                { ?>

                                    <div class="large-4 columns dashboard_container">
                                        <a href="ervaring_details.php?id=<?php echo $row_e['ervaring_id']; ?>&categorie_name=<?php echo $row_e['fk_categorie_name']; ?>" class="a_ervaring">
                                        <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_e['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                            <ul class="small-block-grid-2 profile_info">
                                                <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                                <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                                    <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo $row_e['ervaring_title']; ?></p>
                                                    <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo $row_e['fk_user_name']; ?></p>
                                                    <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;"><?php echo htmlspecialchars(substr($row_e['ervaring_description'], 0, 118))."..."; ?></p>
                                                </li>
                                                <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;"><?php echo $row_e['ervaring_date']; ?></li>
                                                <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                                    <img src="img/icons/like.png" style="padding-right: 10px;"><?php echo $row_e['ervaring_likes']; ?>
                                                    <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;"><?php echo $row_e['ervaring_reacties']; ?>
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
                        else if($filter_small == 'reacties')
                        {
                            $sql_r = "select * from tbl_reacties where fk_user_id='".$userid."' order by reactie_likes desc LIMIT $start_from, $item_per_page";
                            $result_r = $db->query($sql_r);

                            if(mysqli_num_rows($result_r) > 0)
                            {
                                while ($row_r = mysqli_fetch_assoc($result_r))
                                { ?>
                                    <div class="large-6 small-12 columns" style="padding-left: 5px; padding-right: 5px;">
                                         <div class="panel" style="height: 150px; background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8; margin-bottom: 10px; padding: 20px;">
                                            <div class="large-2 columns" style="width: auto; height: auto;">
                                                <img src="img/profile_img.png" class="reactie_profile_img"
                                        <?php 
                                                if ($row_r['fk_user_privilege'] == "true")
                                                { ?>
                                                  style="border-radius: 20px; border: 2px solid #5db0c6;"
                                        <?php 
                                                } ?>
                                                >
                                            </div>

                                            <div class="large-10 small-10 columns" style="padding-left: 0px;">
                                                <ul style="text-decoration: none; list-style: none;">
                                                  <li><?php echo htmlspecialchars($row_r['fk_user_name']).' '.htmlspecialchars($row_r['reactie_date']); ?></li>
                                                  <li style="margin-bottom: 5; 
                                                             color: #a5b1b8; 
                                                             font-family: 'Open Sans', sans-serif; 
                                                             font-size: 16px; 
                                                             font-style: italic;"><?php echo htmlspecialchars($row_r['reactie_description']); ?>
                                                  </li>
                                                </ul>
                                            </div>

                                            <div class="large-12 columns">
                                                    <ul class="small-block-grid-2" style="margin-bottom: 15px;">
                                                        <li class="left" style="padding-bottom: 0; height: 30px; text-decoration: none;">
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
                        { ?>

                            <div class="large-4 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row_e['ervaring_id']; ?>&categorie_name=<?php echo $row_e['fk_categorie_name']; ?>" class="a_ervaring">
                                <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_e['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                    <ul class="small-block-grid-2 profile_info">
                                        <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="img/profile_img.png" style="border-radius: 20px;"></li>
                                        <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                            <p style="padding-bottom: 0px; margin-bottom: 5px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600;"><?php echo $row_e['ervaring_title']; ?></p>
                                            <p style="padding-bottom: 10px; margin-bottom:0; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 14px;"><?php echo $row_e['fk_user_name']; ?></p>
                                            <p style="margin-bottom: 5; color: #a5b1b8; font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic;"><?php echo htmlspecialchars(substr($row_e['ervaring_description'], 0, 118))."..."; ?></p>
                                        </li>
                                        <li class="left" style="padding-bottom: 0; width: 100px; height: 25px; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;"><?php echo $row_e['ervaring_date']; ?></li>
                                        <li class="right" style="padding-bottom:0; width: auto; color: #7b868c; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600;">
                                            <img src="img/icons/like.png" style="padding-right: 10px;"><?php echo $row_e['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;"><?php echo $row_e['ervaring_reacties']; ?>
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
