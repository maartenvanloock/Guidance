<div class="nav-wrapper">
	<div class="row">
		<div class=​"large-12 small-12 columns dashboard_wrap">
			<nav class="top-bar" data-topbar>
				<ul class="title-area">
				    <li class="name"><h1><a href="#"><img src="img/logo.png" width="129" height="33"></a></h1></li>
				    <li class="toggle-topbar menu-icon" id="menu"><a href="#"><span>Menu</span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Left Nav Section -->
					<ul class="left"></ul>

	    			<!-- Right Nav Section -->
	    			<ul class="right">

	    				<div class="large-12 small-12 columns show-for-small-only n_pad" 
	    				     style="padding-top: 0px; margin-bottom: 0px;">	
							<ul>
								<li>
									<a href="require/log_user.php" id="BtnLogoutsmall" class="Btnsmallnohover">
										<img src="img/icons/logout.png" width="35" height="35">
									</a>
									
									<a href="profile_details.php?user=<?php echo $userid; ?>" id="BtnUserprofilesmall" class="Btnsmallnohover">
										<img src="img/icons/user_profile.png" width="35" height="35">
									</a>
								</li>
							</ul>
						</div>

						<div class="large-12 small-12 columns show-for-small-only text-center n_pad" style="margin-bottom: 10px;">
								<ul>
									<?php  

									$sql_user = "select * from tbl_users where user_id='".$_SESSION['userid']."'";
                                    $results_user = $db->query($sql_user);
                                    $row_user = mysqli_fetch_assoc($results_user); ?>
                                    <a href="profile_details.php?user=<?php echo $userid; ?>">
									<li><img src="<?php echo $row_user['user_profile_path']; ?>" width="60" height="60"
										<?php 
										if ($row_user['user_privilege'] == 'true')
										{
										?>
											style="border-radius: 30px; border: 4px solid #5db0c6;"
										<?php 
										} 
										else
										{	?>
											style="border-radius: 30px;"
								<?php	} ?> >
									</li>
									<li style="width: auto; height: auto; padding: 0px; margin-top: 10px;">
										<p style="color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 24px;"><?php echo $username; ?></p>
									</li>
									</a>
								</ul>
						</div>

						<?php 

						$directoryURI = $_SERVER['REQUEST_URI'];
						$path = parse_url($directoryURI, PHP_URL_PATH);
						$components = explode('/', $path);
						$first_part = $components[3];
						$current_p = substr($first_part, 0, strpos($first_part, "."));

						?>
						<li id="vragen_li" <?php if ($current_p == 'vraag') { echo 'class="active"'; } ?> ><a href="vraag.php"><img src="img/icons/vragen.png" id="vragen_icon" width="20" height="20" class="nav_icon">Vragen</a></li>
	     				<li id="ervaringen_li" <?php if ($current_p == 'ervaring') { echo 'class="active"'; } ?> ><a href="ervaring.php"><img src="img/icons/ervaringen.png" id="ervaringen_icon" width="19" height="20" class="nav_icon">Ervaringen</a></li>
	     				<li id="algemene_info_li" <?php if ($current_p == 'algemene_info') { echo 'class="active"'; } ?> ><a href="algemene_info.php"><img src="img/icons/info.png" id="algemene_info_icon" width="16" height="20" class="nav_icon">Algemene info</a></li>
	     				<li id="evenementen_li" <?php if ($current_p == 'evenement') { echo 'class="active"'; } ?> ><a href="evenement.php"><img src="img/icons/evenementen.png" width="19" id="evenementen_icon" height="20" class="nav_icon">Evenementen</a></li>
	     				<li id="search_li" <?php if ($current_p == 'ervaring_search') { echo 'class="active"'; } ?> ><a href="ervaring_search.php"><img src="img/icons/search.png" id="search_icon" width="20" height="20" class="nav_icon">Zoeken</a></li>
	     			
						<li class="has-dropdown not-click show-for-medium-up" id="user_dropdown">
							<a style="padding-left: 20px; padding: 0px;">
								<?php  
								 	$sql_user = "select * from tbl_users where user_id='".$_SESSION['userid']."'";
                                 	$results_user = $db->query($sql_user);
                                 	$row_user = mysqli_fetch_assoc($results_user); ?>

                                <form action="" method="post" class="hide" data-abide>
                                	<input type="text" id="user_priv" name="user_priv" value="<?php echo $row_user['user_privilege']; ?>" required>
                                </form>
								<img src="<?php echo $row_user['user_profile_path']; ?>" width="35" height="35" id="profile_img" 
								<?php 
								if ($row_user['user_privilege'] == 'true')
								{
								?>
									style="border: 3px solid #5db0c6;"
								<?php 
								} 
								else
								{
									
								} ?>
								>
								<span class="user_name_dropdown" style="padding-right: 0px;"><?php echo $username ?></span>
							</a>
							<ul class="dropdown">
								<li><a href="profile_details.php?user=<?php echo $_SESSION['userid']; ?>">Profile settings</a></li>
								<li><a href="require/log_user.php">Log out</a></li>
							</ul>
						</li>
	    			</ul>
	  			</section>
			</nav>
		</div>
	</div>
</div>

<!--color of icons-->

<script type="text/javascript">

	if ($("#vragen_li").hasClass('active'))
	{
		$("#vragen_icon").attr("src", "img/icons/vragen_selected.png");
	}
	else
	{
		$("#vragen_li a")
	    .mouseover(function () {
	        $("#vragen_icon").attr("src", "img/icons/vragen_selected.png");
	    })
	    .mouseout(function () {
	        $("#vragen_icon").attr("src", "img/icons/vragen.png");
	    });
	}

	if ($("#ervaringen_li").hasClass('active'))
	{
		$("#ervaringen_icon").attr("src", "img/icons/ervaringen_selected.png");
	}
	else
	{
		$("#ervaringen_li a")
	    .mouseover(function () {
	        $("#ervaringen_icon").attr("src", "img/icons/ervaringen_selected.png");
	    })
	    .mouseout(function () {
	        $("#ervaringen_icon").attr("src", "img/icons/ervaringen.png");
	    });
	}
	
	if ($("#algemene_info_li").hasClass('active'))
	{
		$("#algemene_info_icon").attr("src", "img/icons/info_selected.png");
	}
	else
	{
		$("#algemene_info_li a")
	    .mouseover(function () {
	        $("#algemene_info_icon").attr("src", "img/icons/info_selected.png");
	    })
	    .mouseout(function () {
	        $("#algemene_info_icon").attr("src", "img/icons/info.png");
	    });
	}

	if ($("#evenementen_li").hasClass('active'))
	{
		$("#evenementen_icon").attr("src", "img/icons/evenementen_selected.png");
	}
	else
	{
		$("#evenementen_li a")
	    .mouseover(function () {
	        $("#evenementen_icon").attr("src", "img/icons/evenementen_selected.png");
	    })
	    .mouseout(function () {
	        $("#evenementen_icon").attr("src", "img/icons/evenementen.png");
	    });
	}

	if ($("#search_li").hasClass('active'))
	{
		$("#search_icon").attr("src", "img/icons/search_selected.png");
	}
	else
	{
		$("#search_li a")
	    .mouseover(function () {
	        $("#search_icon").attr("src", "img/icons/search_selected.png");
	    })
	    .mouseout(function () {
	        $("#search_icon").attr("src", "img/icons/search.png");
	    });
	}

    if ($('#user_priv').val() == 'true')
    {
	    $("#user_dropdown a")
	    .mouseover(function () {
	        $("#profile_img").css("border", "solid 3px #ffffff");
	        $(".user_name_dropdown").css("color", "#ffffff");
	    })
	    .mouseout(function () {
	        $("#profile_img").css("border", "solid 3px #5db0c6");
	        $(".user_name_dropdown").css("color", "#7b868c");
	    });
	}
	else
	{
		$("#user_dropdown a")
	    .mouseover(function () {
	        $(".user_name_dropdown").css("color", "#ffffff");
	    })
	    .mouseout(function () {
	        $(".user_name_dropdown").css("color", "#7b868c");
	    });
	}
</script>