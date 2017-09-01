$(document).ready(function() {

// Add book form previous and next buttons
    $('#section1Next').on('click', function() {
        $("#section-2").css("display", "block");
        $("#section-1").css("display", "none");
    });

    $('#section2Prev').on('click', function() {
        $("#section-2").css("display", "none");
        $("#section-1").css("display", "block");
    });

    $('#section2Next').on('click', function() {
        $("#section-2").css("display", "none");
        $("#section-3").css("display", "block");
    });

    $('#section3Prev').on('click', function() {
        $("#section-3").css("display", "none");
        $("#section-2").css("display", "block");
    });


 // Add book form, select an existing or new author show/hide functionality
     $('input[name=authorSelect]').change(function(){

        if ($(this).val()=="existingAuthor") {
           $('#existingAuthor').slideDown();
            $('#newAuthor').hide();
        } else {
           $('#newAuthor').slideDown();
           $('#existingAuthor').hide();
        }
     });

 // Mobile menu functionality
     $(function() {
        $( ".mobileMenu" ).click(function() {
            $( "nav" ).toggle();
        });
    });

});
