$(document).ready(function() {

        e.preventDefault();
        
        var tag_name = $('#tag_name').val();

          $.ajax({
            type: "POST",
            dataType: "html",
            url: "fetch_pages.php",
            data: { tag_name:tag_name },
            cache: false,
            success: function(data) {

            },
            error: function() {

            }
        });

          $("#results").load("fetch_pages.php", {'page':0}, function() {$("#1-page").addClass('current');});  //eerste page nummer

          $(".paginate_click").click(function (e) {
            
            var clicked_id = $(this).attr("id").split("-"); //id van de pagina bepalen, split() om de pagina nummer te bepalen
            var page_num = parseInt(clicked_id[0]); //clicked_id[0] geeft de pagina nummer 

            $('.paginate_click').removeClass('current'); //remove any current class
            
            //post page number and load returned data into result element
            //notice (page_num-1), subtract 1 to get actual starting point
            $("#results").load("fetch_pages.php", {'page':(page_num-1)}, function(){

            });

            $(this).addClass('current'); //add current class to currently clicked element (style purpose)
            
            return false; //prevent going to href link
          });
        });