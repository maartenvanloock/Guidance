
$(document).ready(function(){
   
      $("#slidingDiv_bugform").hide();
      $(".show_hide_bugform").show();

      $("#slidingDiv_projectform").hide();
      $(".show_hide_projectform").show();

   
      $('.show_hide_bugform').click(function(){
      $("#slidingDiv_bugform").slideToggle();
      });

      $('.show_hide_projectform').click(function(){
      $("#slidingDiv_projectform").slideToggle();
      });
  });