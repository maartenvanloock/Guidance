<?php  

session_start();

require ("classes/connection.class.php");

$username = $_SESSION['username'];
$user_privilege = $_SESSION['userprivilege'];
$userid = $_SESSION['userid'];
$user_up_v = $_SESSION['user_up_v'];

/*---------------------nagaan of de gebruiker bestaat en is ingelogd----------------------*/

if(empty($username))
{
    header("Location:login.php");
}

/*---------------------aanmaken van een nieuwe zoek filter----------------------*/

if (isset($_GET["zoek_filter"]))
{
    $zoek_filter = mysql_real_escape_string($_GET["zoek_filter"]);
    $zoek_filter_result = htmlspecialchars($zoek_filter);

    $zoek_words = explode(' ', $zoek_filter_result);
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

/*---------------------aanmaken van pagination----------------------*/

    $item_per_page = 9;

    $pagination = '';

    if (isset($_GET["zoek_filter"]))
    { 
        $sql_p = "select count(distinct fk_ervaring_id) from tbl_tags where ".$zoek_words_s."";
        $result_p = $db->query($sql_p);

        $get_all_rows = mysqli_fetch_array($result_p);

        $pages = ceil($get_all_rows[0]/$item_per_page);

    if($pages > 1)
    {
        $pagination .= '<div class="row">
                            <div class="large-12 columns">
                                <div class="pagination-centered">
                                    <ul class="pagination">';
        for($i = 1; $i<=$pages; $i++)
        {
            if (isset($_GET["zoek_filter"]))
            { 
                $pagination .= '<li><a href="ervaring_search.php?zoek_filter='.$_GET["zoek_filter"].'&page='.$i.'" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
            }
        }

        $pagination .= '</ul>
                    </div>
                </div>
            </div>';
      }

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

    <!--overzicht van ervaringen met gekozen zoek filter-->

    <div class="row">
    <br/>
    <br/>
        <div class="large-12 small-12 columns ervaringen" id="results">
            <form action="" method="get" Onchange="this.form.submit()" data-abide>
                <input type="text" placeholder="zoeken naar" id="zoek_filter" name="zoek_filter" required>
            </form>
        </div>

    <!--pagination-->

    <?php echo $pagination; ?>

        <div class="large-12 columns">
        <?php  

                if (isset($_GET["zoek_filter"]))
                {
                    $sql = "select distinct fk_ervaring_id from tbl_tags where ".$zoek_words_s." LIMIT $start_from, $item_per_page";
                    $result = $db->query($sql);

                    if(mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result))
                        { 
                            $sql_s = "select * from tbl_ervaringen where ervaring_id='".$row['fk_ervaring_id']."'";
                            $results = $db->query($sql_s);
                            $row_s = mysqli_fetch_assoc($results); 

                            $sql_user = "select * from tbl_users where user_id='".$row_s['fk_user_id']."'";
                            $results_user = $db->query($sql_user);
                            $row_user = mysqli_fetch_assoc($results_user);?>

                            <div class="large-4 columns dashboard_container">
                                <a href="ervaring_details.php?id=<?php echo $row_s['ervaring_id']; ?>&categorie_name=<?php echo $row_s['fk_categorie_name']; ?>" class="a_ervaring">
                                <div class="panel ervaring_panel" style="border-bottom: 10px solid <?php echo $row_s['fk_categorie_color']; ?>; margin-bottom: 10px;">
                                    <ul class="small-block-grid-2 profile_info">
                                        <li style="width: 12%; padding-bottom: 0; padding-right: 0;"><img src="<?php echo $row_user['user_profile_path']; ?>" class="ervaring_profile_pre"></li>
                                        <li style="width:88%; padding-left: 10; padding-bottom: 0;">
                                            <p class="ervaring_title_pre" style="color: #7b868c;"><?php echo $row_s['ervaring_title']; ?></p>
                                            <p class="ervaring_username_pre" style="color: #7b868c;"><?php echo $row_s['fk_user_name']; ?></p>
                                            <p class="ervaring_desc_pre" style="color: #a5b1b8;"><?php echo htmlspecialchars(substr($row_s['ervaring_description'], 0, 118))."..."; ?></p>
                                        </li>
                                        <li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;"><?php echo $row_s['ervaring_date']; ?></li>
                                        <li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">
                                            <img src="img/icons/like.png" style="padding-right: 10px;"><?php echo $row_s['ervaring_likes']; ?>
                                            <img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;"><?php echo $row_s['ervaring_reacties']; ?>
                                        </li>
                                    </ul>
                                </div></a>
                            </div>
        <?php  
                        }
                    } 
                } ?>
        </div>
    </div>

    <!--loading all scripts-->

    <script>
      $(document).foundation();
    </script>
    
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
