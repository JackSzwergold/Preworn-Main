$(document).ready(function() {

  $("input").change(function(){
    $(this).delay(300).queue(function() {
      $("div.container")[0].scrollIntoView({
        behavior: "instant",
        block: "start",
        inline: "start"
      });
    });
  });

});
