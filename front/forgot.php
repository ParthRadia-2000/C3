<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WELCOME TO OUR SITE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="../css/forgot.css">

</head>

<body>
    <div class="container overflow-hidden">
        <div class="row">
            <div class="header">
                <a href="#default" class="logo"></a>
                <div class="header-right">
                    <a href="../front/userlogin.php">signin</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form class="box" method="POST">
                    <h4>Password Reset</h4>
                    <div class="error" id="error" style="color:red" ;></div>
                    <div class="fields">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" id="email" placeholder="Enter your email">
                    </div>
                    <div class="fields">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pass" id="pass" placeholder="Enter new password">
                    </div>
                    <div class="fields">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pass-confirm" id="pass-confirm" placeholder="Re enter password">
                    </div>
                    <div class="btn-field">
                        <button id="reset">Reset Password</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../js/forgot.js"></script>
</body>

</html>