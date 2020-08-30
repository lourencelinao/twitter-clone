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
     
     //disable follow button after clicking
    //  $("#followBtn").click(function(){
    //     if(this.followBtn = 'click'){
    //       $("#followBtn").attr("disabled", true);
    //     }
    //  })
});

