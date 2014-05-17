
$(document).ready(function(){

    $("#btnSubmitVraag").on("click", function(e){

        e.preventDefault();

        var vraag_title = $('#vraag_title').val();
        var vraag_description = $('#vraag_description').val();
        var categorie_name = $('#categorie_name').val();
        var user_name = $('#user_name').val();
        var user_id = $('#user_id').val();
        var user_profile = $('#user_profile').val();
        var vraag_tags = $('#vraag_tags').val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/save_vraag.php",
            data: { vraag_title : vraag_title, vraag_description : vraag_description, categorie_name : categorie_name, user_name : user_name, user_id : user_id, vraag_tags : vraag_tags },
            cache: false,
            success: function(data) {

                /*$.getJSON("ajax/save_vraag.php", function(data) {
                    var categorie_name_upd = data.categorie_name_upd;
                    var categorie_color_upd = data.categorie_color;
                    var last_vraag_upd = data.last_vraag_id;
                    var vraag_date_upd = data.vraag_date;
                });*/

                var vraag_update = '<div class="large-4 columns dashboard_container">'+
                                        '<a href="vraag_details.php?id='+data.last_vraag_id+'&categorie_name='+data.categorie_name_upd+'" class="a_ervaring">'+
                                            '<div class="panel ervaring_panel" style="border-bottom: 10px solid'+data.categorie_color+'; margin-bottom: 10px;">'+
                                                '<ul class="small-block-grid-2 profile_info">'+
                                                    '<li class="n_p_btm" style="width: 12%; padding-right: 0;">'+
                                                    '<img src="'+user_profile+'" width="40" height="40" class="ervaring_profile_pre">'+
                                                    '</li>'+
                                                    '<li class="p_l_t" style="width: 88%; padding-bottom: 0;">'+
                                                        '<p class="ervaring_title_pre" style="color: #7b868c;">'+vraag_title.substring(0,70)+'</p>'+
                                                        '<p class="ervaring_username_pre" style="color: #7b868c;">'+user_name+'</p>'+
                                                        '<p class="ervaring_desc_pre" style="color: #a5b1b8;">'+vraag_description.substring(0,118)+'</p>'+
                                                    '</li>'+
                                                    '<li class="left ervaring_date_pre" style="padding-bottom: 0; width: 100px;">'+data.vraag_date+'</li>'+
                                                    '<li class="right ervaring_likes_pre" style="padding-bottom:0; width: auto;">'+
                                                        '<img src="img/icons/like.png" class="p_r_t">'+'0'+
                                                        '<img src="img/icons/reacties.png" class="p_r_t" style="padding-left: 15px;">'+'0'+
                                                    '</li>'+
                                                '</ul>'+
                                            '</div>'+
                                        '</a>'+
                                    '</div>';

                $('#slidingDiv_vraagform').slideUp();
                document.getElementById("vraag_form").reset();

                $('#results').prepend(vraag_update).slideDown();
                /*$('#conf_message').html("De vraag is toegevoegd op het platform");
                $('#conf').show();*/
            },
            error: function() {
                $('#feedback_message').html("niet toegevoegd");
                $('#feedback').slideDown();
            }
        });

    });
});