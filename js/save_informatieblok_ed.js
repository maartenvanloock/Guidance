
$(document).ready(function(){

    $('.ed_form').on('submit', function(e){
        
        e.preventDefault();

        var informatie_title = $('#informatieblok_title').val();
        var informatie_description = $('#informatieblok_description').val();
        var informatie_id = $('#informatieblok_id').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ajax/save_informatieblok_ed.php",
            data: { informatie_title:informatie_title, informatie_description:informatie_description, informatie_id:informatie_id },
            cache: false,
            success: function(data) {
                
                var info_update = 

                    '<div class="large-12 columns" style="padding: 0px;">'+
                        '<div class="large-11 small-11 columns left" style="padding: 0px;">'+
                            '<p id="info_title" style="margin-bottom: 10px; font-size: 18px; font-style: inherit; font-weight: 600;">'+informatie_title+'</p>'+
                        '</div>'+

                        '<div class="large-2 small-2 columns right" style="padding: 0px; width: auto; height: auto;">'+
                            '<a class="btnEdit" name="btnEdit">'+'<i class="fi-widget size-21 style_1">'+'</i>'+'</a>'+
                        '</div>'+
                    '</div>'+

                    '<p id="info_description" style="margin-bottom: 0px;">'+informatie_description+'</p>';

                $("#ed_info_form").slideToggle();
                $('#info_update').prepend(info_update).slideToggle();

                $('#conf_message').html("De wijziging is toegevoegd");
                $('#conf').show();
            },
            error: function() {
                $('#feedback_message').html("De wijziging is niet toegevoegd");
                $('#feedback').slideDown();
            }
        });

    });
});