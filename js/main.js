$(window).bind('load resize',function() {
  $(".slide").height($(window).height()-60);
});
$(document).ready(function() {
  $(".slide").click(function () {
    $(".slide-selected").removeClass("slide-selected");
    $(".main-title-selected").removeClass("main-title-selected").addClass("main-title");
    $(".main-icon-selected").removeClass("main-icon-selected").addClass("main-icon");
    $(this).addClass("slide-selected");
    $(this).find(".main-title").removeClass("main-title").addClass("main-title-selected");
    $(this).find(".main-icon").removeClass("main-icon").addClass("main-icon-selected");
  })
});