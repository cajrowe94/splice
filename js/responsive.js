
$(document).ready(function(){
  $("#login-dropdown").click(function(){
    console.log("works");

    if ($("#login-form").css('visibility') == 'hidden'){
      $("#login-form").css("visibility", "visible");
    } else $("#login-form").css("visibility", "hidden");



    // if($("login-form").hasClass("responsive-login")){
    //   $("login-form").removeClass("responsive-login");
    // } else $("login-form").addClass("responsive-login");


  })
});
