$(document).ready(function(){
    //On click signup, hide login and how registration
    $("#signup").click(function(){   
        $('#login__section').slideUp(260, function() {
            $('#signup__section').slideDown(260);
        })
    })
    $("#login").click(function(){ 
        $('#signup__section').slideUp(260, function() {
            $('#login__section').slideDown(260);
        })
    })


});