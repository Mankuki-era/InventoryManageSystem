$(function(){
  $(".for_new_item_making").css({
    "position": "fixed",
    "right": "45px",
    "bottom": "40px"
  });
  $(window).on("scroll", function(){
    scrollHeight = $(document).height();
    scrollPosition = $(window).height() + $(window).scrollTop();
    footHeight = $("footer").innerHeight();
    if ( scrollHeight - scrollPosition  <= footHeight ) {
      $(".for_new_item_making").css({
        "position":"absolute",
        "bottom": "20px"
      });
    } else {
      $(".for_new_item_making").css({
        "position": "fixed",
        "right": "45px",
        "bottom": "40px"
      });
    }
  });
});
