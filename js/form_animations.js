
$(document).ready(function(){
   
      $("#slidingDiv_ervaringform").hide();
      $(".show_hide_ervaring_form").show();

      $("#slidingDiv_categorieform").hide();
      $(".show_hide_categorie_form").show();

      $("#slidingDiv_informatieform").hide();
      $(".show_hide_informatie_form").show();

      $("#slidingDiv_tagsform").hide();
      $(".show_hide_tags_form").show();

      $("#slidingDiv_small_tagsform").hide();
      $(".show_hide_smalltags_form").show();

      $("#slidingDiv_vraagform").hide();
      $(".show_hide_vraag_form").show();

      $("#slidingDiv_evenementform").hide();
      $(".show_hide_evenement_form").show();

      $(".show_hide_ervaring_form").click(function(){
      $("#slidingDiv_ervaringform").slideToggle();
      });
      
      $(".show_hide_categorie_form").click(function(){
      $("#slidingDiv_categorieform").slideToggle();
      });

      $(".show_hide_informatie_form").click(function(){
      $("#slidingDiv_informatieform").slideToggle();
      });

      $(".show_hide_tags_form").click(function(){
      $("#slidingDiv_tagsform").slideToggle();
      });

      $(".show_hide_smalltags_form").click(function(){
      $("#slidingDiv_small_tagsform").slideToggle();
      });

      $(".show_hide_vraag_form").click(function(){
      $("#slidingDiv_vraagform").slideToggle();
      });

      $(".show_hide_evenement_form").click(function(){
      $("#slidingDiv_evenementform").slideToggle();
      });

  });