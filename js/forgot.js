$(document).ready(function () {
    $('#reset').click(function () {
        var rData = {};

        rData["email"] = $('#email').val();
        rData["pass"] = $('#pass').val();
        rData["pass-confirm"] = $('#pass-confirm').val();

        if (rData["pass"] == rData["pass-confirm"]) {
            $.ajax({
                type: 'POST',
                url: '../back/forgot.php',
                data: { "rData": rData },
                success: function (response) {
                    var a = response;
                    if (a == "email") {
                        $("#error").empty().append("PLEASE ENTER VALID EMAIL ADDRESS").css("color", "red");
                    }
                    else if (a == "reset") {
                        $("#error").empty().append("PASSWORD CHANGED SUCCESSFULLY").css("color", "rgb(29, 156, 67)");
                        location.reload();
                    }
                    else if (a == "emailinvalid") {
                        $("#error").empty().append("PLEASE ENTER REGISTERED EMAIL ADDRESS").css("color", "red");
                    }
                    else if (a == "notreset") {
                        $("#error").empty().append("PROBLEM WHILE RESET PASSWORD").css("color", "red");
                    }
                }
            });
        }
        else {
            $("#error").empty().append("BOTH PASSWORD MUST BE SAME");
        }
        return false;
    });
});