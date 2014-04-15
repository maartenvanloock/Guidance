<?php  

if(isset($feedback))
      { ?>
        <div class="row">
            <div data-alert="" class="alert-box alert radius" class="feedback">
                <?php echo $feedback; ?>
                <a class="close" href="#">×</a>
            </div>
        </div>
<?php }

      if(isset($conf))
      { ?>
        <div class="row">
            <div data-alert="" class="alert-box success radius" class="conf">
                <?php echo $conf; ?>
                <a class="close" href="#">×</a>
            </div>
        </div>
<?php } ?>
