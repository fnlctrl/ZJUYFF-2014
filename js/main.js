// $(window).scroll(function() {
   
// })
$(window).bind('load resize',function() {
  window.H = $(window).height();
  window.W = $(window).width();
  $(".slide").height(window.H-60);
  if (window.W<850) {
    $('body').height(60+5*(window.H-60));
    $('body').css("overflow-y","visible");
    $(".slide").addClass("slide-small");
    $(".main-icon").addClass("main-icon-small");
    $(".main-title").addClass("main-title-small");
  }
  else {
    $('body').css("overflow","hidden");
    $('body').height(window.H);
    $(".slide-small").removeClass("slide-small");
    $(".main-icon-small").removeClass("main-icon-small");
    $(".main-title-small").removeClass("main-title-small");
  };
});
$(document).ready(function() {
  $(".slide").click(function () {
    $(".slide-selected").removeClass("slide-selected");
    $(".main-title-selected").removeClass("main-title-selected");
    $(".main-icon-selected").removeClass("main-icon-selected");
    $(this).addClass("slide-selected");
    $(this).find(".main-title").addClass("main-title-selected");
    $(this).find(".main-icon").addClass("main-icon-selected");
  });
});