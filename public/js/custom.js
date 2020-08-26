$(document).ready(function() {
    /* switch active state for pill items*/
    $(".nav-item").on("click", function(e){
        $("#pills-tab").find(".active").removeClass("active");
        $(this).addClass("active");
     });

     //display when fully loaded
     $('#middle').show();
     $('#middle-loading').fadeOut('slow');
     $('#right').show();
     $('#right-loading').fadeOut('slow');
});
