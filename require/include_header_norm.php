<div class="nav-wrapper">
	<div class="row">
		<div class=​"large-12 small-12 columns dashboard_wrap">
			<nav class="top-bar" data-topbar>
				<ul class="title-area">
				    <li class="name"><h1><a href="dashboard.php"><img src="img/logo.png"></a></h1></li>
				    <li class="toggle-topbar menu-icon" id="menu"><a href="#"><span>Menu</span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Left Nav Section -->
					<ul class="left"></ul>

	    			<!-- Right Nav Section -->
	    			<ul class="right">

						<div class="large-12 small-12 columns show-for-small-only text-center" style="padding: 0px;">
							<a href="profile_details.php">
								<ul>
									<li><img src="img/profile_img.png" style="border-radius: 20px;"></li>
									<li style="width: auto; height: auto; padding: 0px; margin-top: 10px;">
										<p style="color: #7b868c; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 24px;"><?php echo $username; ?></p>
									</li>
								</ul>
							</a>
						</div>

	     				<li><a href="ervaring.php"><img src="img/icons/ervaringen.png" onmouseover="this.src='img/icons/ervaringen_selected.png'" onmouseout="this.src='img/icons/ervaringen.png'" class="nav_icon">Ervaringen</a></li>
	     				<li><a href="algemene_info.php"><img src="img/icons/info.png" onmouseover="this.src='img/icons/info_selected.png'" onmouseout="this.src='img/icons/info.png'" class="nav_icon">Algemene info</a></li>
	     				<li><a href="#"><img src="img/icons/evenementen.png" onmouseover="this.src='img/icons/evenementen_selected.png'" onmouseout="this.src='img/icons/evenementen.png'" class="nav_icon">Evenementen</a></li>
	     				<li><a href="ervaring_search.php"><img src="img/icons/search.png" onmouseover="this.src='img/icons/search.png'" onmouseout="this.src='img/icons/search.png'" class="nav_icon">Search</a></li>
	     				<!--<li class="has-form">
	  						<div class="row collapse">
	    						<div class="large-8 small-9 columns">
	      							<input type="text" placeholder="zoek naar tags" style="height: 30px;">
	    						</div>
	    						<div class="large-4 small-3 columns">
	      							<a href="#" class="alert button expand">Search</a>
	   							</div>
	  						</div>
						</li>-->
						<!--<ul>
							<li><img src="img/profile_img.png" id="profile_img" 
							<?php 
							/*if ($user_privilege == 'true')*/
							{
							?>

							style="border: 3px solid #5db0c6;"

							<?php 
							} 
							/*else*/
							{

							}?>
							></li>
							<li><a href="#"><?php /*echo*/ $username ?></a></li>
						</ul>-->
						<li class="has-dropdown not-click show-for-medium-up">
							<a style="padding-left: 20px; padding: 0px;">
								<img src="img/profile_img.png" id="profile_img" 
								<?php 
								if ($user_privilege == 'true')
								{
								?>
									style="border: 3px solid #5db0c6;"
								<?php 
								} 
								else
								{
									
								} ?>
								>
								<span style="padding-right: 0px;"><?php echo $username ?></span>
							</a>
							<ul class="dropdown">
								<li><a href="profile_details.php">Profile settings</a></li>
								<li><a href="require/log_user.php">Sign out</a></li>
							</ul>
						</li>
	    			</ul>
	  			</section>
			</nav>
		</div>
	</div>
</div>