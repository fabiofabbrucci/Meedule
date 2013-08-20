$(document).ready(function(){
  $.each($("*[data-toggle]"), function (index, value){
    var destination = $(value).attr('data-toggle');
    $(destination).hide();
    $(this).click(function(){
      $(this).hide();
      $(destination).show();
    })
  })
});