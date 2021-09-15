$(document).ready(function () {
    $("input[type='email']").change(function () {
        $email = $("input[type='email']").val();
        $.ajax({
            type: 'POST',
            url: '../back/checkemailavailibility.php',
            data: { "email": $email },
            success: function (response) {
                var a = response;
                if (a == 1) {
                    $("#error-email").empty().append("EmailId is already taken");
                }
            }
        });
    });
    $('#submit').click(function () {

        var cData = {};

        cData['firstname'] = $('#first').val();

        cData['lastname'] = $('#last').val();

        cData['email'] = $('#email').val();

        cData['cmp'] = $('#cmp').val();

        cData['pass'] = $('#pass').val();

        cData['pass-confirm'] = $('#pass-confirm').val();

        cData['mobile'] = $('#mobile').val();

        if (cData['pass'] == cData['pass-confirm']) {
            $.ajax({
                type: 'POST',
                url: '../back/register.php',
                data: { "cData": cData },
                success: function (response) {
                    var a = response;
                    if (a == "email") {
                        $("#error-show").empty().append("PLEASE ENTER VALID EMAIL ADDRESS");
                    }
                    else if (a == "mobile") {
                        $("#error-show").empty().append("PLEASE ENTER VALID MOBILE NUMBER");
                    }
                    else if (a == "pass") {
                        $("#error-show").empty().append("PASSWORD MUST BE 8 CHARACTER LONG");
                    }
                    else if (a == "emailtaken") {
                        $("#error-email").empty().append("THIS EMAIL IS ALREADY TAKEN");
                    }
                    else if (a == "inserted") {
                        window.location.replace("http://localhost/C3/front/thankyou.php");
                    }
                    else {
                        alert("Not inserted");
                    }
                }
            });
        }
        else {
            $("#error-show").empty().append("BOTH PASSWORD MUST BE SAME");
        }
    });
});