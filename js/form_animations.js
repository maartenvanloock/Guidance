
$(document).ready(function(){
   
      $("#slidingDiv_ervaringform").hide();
      $(".show_hide_ervaring_form").show();

      $("#slidingDiv_categorieform").hide();
      $(".show_hide_categorie_form").show();

      $('.show_hide_ervaring_form').click(function(){
      $("#slidingDiv_ervaringform").slideToggle();
      });
      
      $('.show_hide_categorie_form').click(function(){
      $("#slidingDiv_categorieform").slideToggle();
      });

  });