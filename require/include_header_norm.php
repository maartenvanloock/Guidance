<div class="contain-to-grid nav-wrapper">
	<div class=​"large-12 columns dashboard_wrap">
		<nav class="top-bar" data-topbar>
			<ul class="title-area">
			    <li class="name"><h1><img src="img/logo.png"></h1></li>
			    <li class="toggle-topbar menu-icon" id="menu"><a href="#"><span>Menu</span></a></li>
			</ul>

			<section class="top-bar-section">
				<!-- Left Nav Section -->
				<ul class="left"></ul>

    			<!-- Right Nav Section -->
    			<ul class="right">
     				<li><a href="#">Ervaringen</a></li>
     				<li><a href="#">Algemene info</a></li>
     				<li><a href="#">Evenementen</a></li>
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
					<ul class="inline-list">
						<li><img src="img/profile_img.png" id="profile_img" 
						<?php 
						if ($user_privilege == 'true')
						{
						?>

						style="border: 3px solid #5db0c6;"

						<?php 
						} 
						else
						{

						}?>
						></li>
						<li><a href="#"><?php echo $username ?></a></li>
					</ul>
    			</ul>
  			</section>
		</nav>
	</div>
</div>