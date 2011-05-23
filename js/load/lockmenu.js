jQuery(document).ready(function($) {

  var a = function() {
    var b = $(window).scrollTop();
    var d = $("#scroller-anchor").offset({scroll:false}).top;
    var c=$("#scroller");
    if (b>d) {
      c.css({position:"fixed",top:"0px"})
    } else {
      if (b<=d) {
        c.css({position:"relative",top:""})
      }
    }
  };
  $(window).scroll(a);a()
  
  
});