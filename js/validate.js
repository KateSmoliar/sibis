$(document).ready(function() {

    document.getElementById('messageform-user_name').required = true;
    document.getElementById('messageform-email').required = true;
    document.getElementById('messageform-captcha').required = true;


    document.getElementById('messageform-text').required = true;

//            check valid name


    $('#messageform-user_name'). change(function() {

        var name_pattern = /^[a-zA-Z0-9]+$/;
        var name = $("#messageform-user_name").val();
        console.log(name_pattern.test(name));



        if (!name_pattern.test(name)) {

            $("#messageform-user_name").css('border', 'red 1px solid');
            $('#errorBlock').html('Enter correct name');
            $('#errorBlock').css("display", "inline");
            document.getElementById('my').disabled = true;

        }
        else
        {
            $("#messageform-user_name").css('border', 'black 1px solid');
            $('#errorBlock').css("display", "none");
            document.getElementById('my').disabled = false;



        }

    });


    // email validation


    $('#messageform-email'). change(function() {

        var pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email = $("#messageform-email").val();
        console.log(pattern.test(email));



        if (!pattern.test(email)) {

            $("#messageform-email").css('border', 'red 1px solid');
            $('#errorBlock-email').html('Enter correct email');
            $('#errorBlock-email').css("display", "inline");
            document.getElementById('my').disabled = true;
            console.log("here");

        }
        else
        {
            $("#messageform-email").css('border', 'black 1px solid');
            $('#errorBlock-email').css("display", "none");
            document.getElementById('my').disabled = false;



        }

    });



    // url validation


    $('#messageform-home_page'). change(function() {

        var pattern = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
        var page = $("#messageform-home_page").val();
        console.log(pattern.test(page));



        if (!pattern.test(page)) {

            $("#messageform-home_page").css('border', 'red 1px solid');
            $('#errorBlock-home_page').html('Enter correct URL');
            $('#errorBlock-home_page').css("display", "inline");
            document.getElementById('my').disabled = true;
            console.log("here");

        }
        else
        {
            $("#messageform-home_page").css('border', 'black 1px solid');
            $('#errorBlock-home_page').css("display", "none");
            document.getElementById('my').disabled = false;



        }

    });






});