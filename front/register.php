<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTER TO C3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="../css/register.css">

</head>

<body>
    <div class="container">
        <div class="form-details">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 form-group">
                    <div class="welcome">
                        Welcome
                    </div>
                    <div id="error-show">

                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="#" class="form" method=POST>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="first" name="first">
                            </div>
                            <div class="col-md-6">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="last" name="last">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="emailid">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <p id="error-email"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="companyname">Company</label>
                                <input type="text" class="form-control" id="cmp" name="cmp">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="password">Password</label>
                                <input type="password" onkeyup="checkStrength();" class="form-control" id="pass"
                                    name="pass">
                            </div>
                            <div class="col-md-6">
                                <label for="confirm=password">Confirm Password</label>
                                <input type="password" class="form-control" id="pass-confirm" name="pass-confirm">
                            </div>
                        </div>
                        <div id="popover-password">
                            <p>
                                <span id="result"></span>
                            </p>
                            <div class="progress">
                                <div id="passwrord-strength" class="progress-var" role="progressbar" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemin="100" style="width: 0%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li type="none">
                                    <span id="low-uppper-case">
                                        <i class="fas fa-circle char" style="color:red;" aria-hidden="true"></i>
                                        Lowercase &amp; Uppercase
                                        </i>
                                    </span>
                                </li>
                                <li type="none">
                                    <span class="one-number">
                                        <i class="fas fa-circle number" style="color:red;" aria-hidden="true"></i>
                                        Number (0-9)
                                        </i>
                                    </span>
                                </li>
                                <li type="none">
                                    <span class="one-special-char">
                                        <i class="fas fa-circle special-char" style="color:red;" aria-hidden="true"></i>
                                        Special Character(!,%,&,@,$,^,*,?,_,~)
                                        </i>
                                    </span>
                                </li>
                                <li type="none">
                                    <span class="eight-character">
                                        <i class="fas fa-circle length" style="color:red;" aria-hidden="true"></i>
                                        Atleast 8 character
                                        </i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="mobile">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" maxlength="10">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class=" col-md-12 form-group">
                    <a class="btn login-btn btn-block" id="submit">
                        Create Account
                    </a>
                </div>
                <div class="col-md-12 ex-account text-center">
                    <p>Already have an account? Signin <a href="../front/userlogin.php">here</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../js/register.js"></script>
    <script>
    function checkStrength() {
        var strength = 0;
        var alphabets = /([a-zA-Z])/;
        var number = /([0-9])/;
        if (($('#pass').val()).match(alphabets)) {
            strength += 1;
            $('li i.char').removeClass('fa-circle');
            $('li i.char').addClass('fa-check');
            $('li i.char').css('color', 'green');
        } else {
            $('li i.char').removeClass('fa-check');
            $('li i.char').addClass('fa-circle');
            $('li i.char').css('color', 'red');
        }
        if (($('#pass').val()).match(number)) {
            strength += 1;
            $('li i.number').removeClass('fa-circle');
            $('li i.number').addClass('fa-check');
            $('li i.number').css('color', 'green');
        } else {
            $('li i.number').removeClass('fa-check');
            $('li i.number').addClass('fa-circle');
            $('li i.number').css('color', 'red');
        }
        if (($('#pass').val()).match(/([!,%,&,@,$,^,*,?,_,~])/)) {
            strength += 1;
            $('li i.special-char').removeClass('fa-circle');
            $('li i.special-char').addClass('fa-check');
            $('li i.special-char').css('color', 'green');
        } else {
            $('li i.special-char').removeClass('fa-check');
            $('li i.special-char').addClass('fa-circle');
            $('li i.special-char').css('color', 'red');
        }
        if (($('#pass').val()).length > 7) {
            strength += 1;
            $('li i.length').removeClass('fa-circle');
            $('li i.length').addClass('fa-check');
            $('li i.length').css('color', 'green');
        } else {
            $('li i.length').removeClass('fa-check');
            $('li i.length').addClass('fa-circle');
            $('li i.length').css('color', 'red');
        }

        if (strength == 0) {
            $('.progress div.progress-var').css("width", "0%");
        } else if (strength == 2) {
            $('.progress div.progress-var').removeClass('progress-bar-warning');
            $('.progress div.progress-var').removeClass('progress-bar-success');
            $('.progress div.progress-var').addClass('progress-bar-danger');
            $('.progress div.progress-var').css("width", "10%");
        } else if (strength == 3) {
            $('.progress div.progress-var').removeClass('progress-bar-danger');
            $('.progress div.progress-var').removeClass('progress-bar-success');
            $('.progress div.progress-var').addClass('progress-bar-warning');
            $('.progress div.progress-var').css("width", "60%");
        } else if (strength == 4) {
            $('.progress div.progress-var').removeClass('progress-bar-warning');
            $('.progress div.progress-var').removeClass('progress-bar-danger');
            $('.progress div.progress-var').addClass('progress-bar-success');
            $('.progress div.progress-var').css("width", "100%");
        }
    }
    </script>
</body>

</html>