<?php  

if(isset($feedback))
      { ?>
        <div class="row">
            <div data-alert class="alert-box alert radius" class="feedback">
                <?php echo $feedback; ?>
                <a class="close" href="#">×</a>
            </div>
        </div>
<?php } ?>

