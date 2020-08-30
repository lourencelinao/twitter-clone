$(document).ready(function() {
    /* switch active state for pill items*/
    $(".nav-item").on("click", function(e){
        $("#pills-tab").find(".active").removeClass("active");
        $(this).addClass("active");
     });
     if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
      }
     //display when fully loaded
     $('#tweets').show();
     
});


$(window).scroll(function() {
    sessionStorage.scrollTop = $(this).scrollTop();
  });