
$(document).ready(function(){

    $("#btnSubmitReactie").on("click", function(e){
    
        e.preventDefault();
        var user_id = $('#user_id').val();
        var reactie_id = $('#reactie_id').val();
        var count_vote = $('#count_vote').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ajax/save_reactie_vt.php",
            data: { user_id:user_id, reactie_id:reactie_id },
            cache: false,
            success: function(data) {

                count_vote = count_vote+1;

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