
$(document).ready(function(){

    $("#btnSubmitCategorie").on("click", function(e){
    
        e.preventDefault();
        var categorie_title = $('#categorie_title').val();
        var categorie_chose = $('#categorie_chose').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ajax/save_categorie_ervaring.php",
            data: { categorie_title : categorie_title, categorie_chose : categorie_chose },
            cache: false,
            success: function(data) {
                $('#slidingDiv_categorieform').slideUp();
                $('#categorie_title').html("");

                $('#conf_message').html("De nieuwe categorie is toegevoegd");
                $('#conf').show();
            },
            error: function() {
                $('#feedback_message').html("De nieuwe categorie is niet toegevoegd");
                $('#feedback').slideDown();
            }
        });

    });
});