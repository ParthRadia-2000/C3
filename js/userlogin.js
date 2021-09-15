$(document).ready(function () {
    $("#submit").click(function () {
        var cData = {};
        cData["email"] = $("#email").val();
        cData["pass"] = $("#pass").val();

        $.ajax({
            type: 'POST',
            url: '../back/userlogin.php',
            data: { "cData": cData },
            success: function (response) {
                var a = response;
                if (a == "email") {
                    $("#error").empty().append("PLEASE ENTER VALID EMAIL ADDRESS").css("color", "red");
                }
                else if (a == "vkey") {
                    $("#error").empty().append("PLEASE VERIFY YOUR ACCOUNT FIRST").css("color", "red");
                }
                else if (a == "notmatched") {
                    $("#error").empty().append("PLEASE ENTER VALID USERNAME OR  PASSWORD").css("color", "red");
                }
                else if (a == "matched") {
                    window.location.replace("http://localhost/C3/front/dashboard.php");
                }
            }
        });
        return false;
    });
});