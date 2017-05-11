$(document).ready(function() {
     $(':input[type="submit"]').prop('disabled', true);
     $('input[type="text"]').keyup(function() {
        if($(this).val() != '') {
           $(':input[type="submit"]').prop('disabled', false);
        }
     });
 });

$("#submit-button").click(function(){
    // $(".header-container").addClass("activated");
    $("#phpReturn").addClass("show");
});