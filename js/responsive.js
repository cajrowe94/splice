
$(document).ready(function(){
  $("#login-dropdown").click(function(){
    //check if the form is visible
    if ($("#login-form").css('visibility') == 'hidden'){
      $("#login-form").css("visibility", "visible");
    } else $("#login-form").css("visibility", "hidden");
  })
  $(".mobile-nav").click(function(){
    //check if the nav is visible
    if ($("#nav-list").css('visibility') == 'hidden'){
      $("#nav-list").css("visibility", "visible");
      $("#login-dropdown").css("visibility", "visible");
    } else {
      $("#login-dropdown").css("visibility", "hidden");
      $("#login-form").css("visibility", "hidden");
      $("#nav-list").css("visibility", "hidden");
    }
  })
});
