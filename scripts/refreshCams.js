$(document).ready(function(){
  var refreshIntervalId = setInterval(function(){
    $(".image-grid img").each(function(){
      var currentSrc = $(this).attr("src");
      $(this).attr("src", currentSrc + "?t=" + new Date().getTime());
    });
  }, 3000); // refresh every 3 seconds

  setTimeout(function(){
    clearInterval(refreshIntervalId);
    $("#clocks").css("background-color", "crimson");
    $("#clocks").css("color", "white");
    $("#refresh-paused").show();
  }, 10000); // pause after 5 minutes (300000 milliseconds)

  $("#clocks").click(function(){
    $("#clocks").css("background-color", "#DDD");
    $("#clocks").css("color", "black");
    $("#refresh-paused").hide();
    refreshIntervalId = setInterval(function(){
      $(".image-grid img").each(function(){
        var currentSrc = $(this).attr("src");
        $(this).attr("src", currentSrc + "?t=" + new Date().getTime());
      });
    }, 3000);
  });
});