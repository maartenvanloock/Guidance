
$(document).ready(function(){

    $("#btnSubmitReactie").on("click", function(e){
    
        e.preventDefault();
        
        var reactie_description = $('#reactie_description').val();
        var user_name = $('#user_name').val();
        var user_id = $('#user_id').val();
        var user_privilege = $('#user_privilege').val();
        var ervaring_id = $('#ervaring_id').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ajax/save_reactie_ervaring.php",
            data: { reactie_description:reactie_description, user_name:user_name, user_id:user_id, user_privilege:user_privilege, ervaring_id:ervaring_id },
            cache: false,
            success: function(data) {

                var reactie_update = 

                '<div class="large-12 columns reactie" style="padding: 10px; background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8; margin-bottom: 10px;">'+

                    '<div class="large-12 columns reactie" style="padding: 10px; background-color: #ffffff; -webkit-border-radius: 3px; border: 1px solid #d8d8d8; margin-bottom: 10px;">'+
                        '<div class="large-1 columns">'+
                            '<img src="img/profile_img.png" style="border-radius: 20px;">'
                        '</div>'+
                        
                        '<div class="large-11 columns">'+
                            '<ul style="text-decoration: none;">'
                                '<li>'+ user_name +'</li>'+
                                '<li style="margin-bottom: 5; color: #a5b1b8; font-size: 16px; font-style: italic;">'+ reactie_description +'</li>'
                            '</ul>'+
                        '</div>'+
                    '</div>'+

                    '<div class="large-12 columns">'+
                        '<form action="" method="post" data-abide>'+
                            '<ul class="small-block-grid-2" style="margin-bottom: 15px;">'+
                                '<li class="left" style="padding-bottom: 0; height: 30px; text-decoration: none;">'+
                                                        
                                '<button type="submit" href="#" class="button [radius round] left" id="btnSubmitReactie_vt" name="btnSubmitReactie_vt"
                                         style="height: auto;
                                         width: auto;
                                             -webkit-border-radius: 3px;
                                             background-color: #e6e6e6;
                                             color: #7b868c;
                                             font-size: 14px;
                                             font-style: inherit;
                                             padding: 8px;" disabled>'+
                                             '<i class="fi-check size-16"></i>'+
                                             '<span style="margin-left: 5px; margin-right: 5px;">'+Helpful+'</span>'+
                                             '<span style="-webkit-border-radius: 3px; background-color: #fafafa; padding: 3px; padding-top: 0px; padding-bottom: 0px;">0</span>'+
                                '</button>'+

                                '<li class="right" style="padding-bottom:0; width: auto; text-decoration: none; padding-top: 5px;">'+
                                        '<a href="#" style="color: #7b868c; font-size: 16px; font-weight: 600;">'+
                                        '<img src="img/icons/reacties.png" style="padding-right: 10px; padding-left: 15px;">'+reply+'</a>'+
                                '</li>'+
                            '</ul>'+
                        '</form>'+
                    '</div>'+
                '</div>';

                $('#reactie_description').html("");
                $('#reacties_update').prepend(reactie_update).slideDown();
                
                /*$('#conf_message').html("De ervaring is toegevoegd");
                $('#conf').show();*/
            },
            error: function() {
                /*$('#feedback_message').html("De ervaring is niet toegevoegd");
                $('#feedback').slideDown();*/
            }
        });

    });
});