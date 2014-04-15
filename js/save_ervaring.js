
$(document).ready(function(){

    $("#btnSubmitErvaring").on("click", function(e){
    
        e.preventDefault();
        var ervaring_title = $('#ervaring_title').val();
        var ervaring_description = $('#ervaring_description').val();
        var categorie_name = $('#categorie_name').val();
        var user_name = $('#user_name').val();
        var user_id = $('#user_id').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ajax/save_ervaring.php",
            data: { ervaring_title : ervaring_title, ervaring_description : ervaring_description, categorie_name:categorie_name, user_name:user_name, user_id:user_id },
            cache: false,
            success: function(data) {
                $('#slidingDiv_ervaringform').slideUp();
                $('#ervaring_title').html("");
                $('#ervaring_description').html("");

                $('#conf_message').html("De ervaring is toegevoegd");
                $('#conf').show();
            },
            error: function() {
                $('#feedback_message').html("De ervaring is niet toegevoegd");
                $('#feedback').slideDown();
            }
        });

    });
});