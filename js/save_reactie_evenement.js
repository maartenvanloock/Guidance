
$(document).ready(function(){

    $("#btnSubmitReactie").on("click", function(e){
    
        e.preventDefault();
        
        var reactie_description = $('#reactie_description').val();
        var user_name = $('#user_name').val();
        var user_id = $('#user_id').val();
        var user_profile = $('#profile_img_comment').attr("src");
        var user_privilege = $('#user_privilege').val();
        var evenement_id = $('#evenement_id').val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/save_reactie_evenement.php",
            data: { reactie_description : reactie_description, user_name : user_name, user_id : user_id, user_privilege : user_privilege, evenement_id : evenement_id },
            cache: false,
            success: function(data) {

                var reactie_update = '<div class="large-12 columns reactie">'+
                                        '<div class="large-1 small-2 columns w_h_auto">'+
                                            '<a href="profile_details.php?user='+user_id+'">'+
                                                '<img src="'+user_profile+'" width="40" height="40" class="reactie_profile_img">'+
                                            '</a>'+
                                        '</div>'+

                                        '<div class="large-11 small-10 columns n_pad_left">'+
                                            '<ul style="text-decoration: none; list-style: none; margin: 0px;">'+
                                                '<li>'+user_name+' - '+data.evenement_date+'</li>'+
                                                '<li class="hide">'+user_id+'</li>'+
                                                '<li class="reactie_desc">'+reactie_description+'</li>'+
                                            '</ul>'+
                                        '</div>'+
                                     '</div>';

                $('#reactie_description').html("");
                /*$('#reacties_update').hide().prepend(reactie_update).slideDown('slow');*/
                $('#reacties_update').hide().prepend(reactie_update).addClass('animated bounceIn')
            },
            error: function() {
                $('#feedback_message').html("Er is en probleem en je reactie is niet toegevoegd, probeer het nog eens");
                $('#feedback').slideDown();
            }
        });

    });
});