<!DOCTYPE html>
<html>
    <head>
        <title>ระบบจองห้องประชุมออนไลน์</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- styles -->
        <link href="css/styles.css" rel="stylesheet">
        <link href="bootstrap/fonts/css/boonjot.css" rel="stylesheet">

        <link href="bootstrap/css/smoke.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-bg">
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Logo -->
                        <div class="logo">
                            <center><h1><a href="login.php">Meeting room</a></h1></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-wrapper">
                        <div class="box">
                            <div class="content-wrap">
                                <p style="font-size:xx-large;">เข้าสู่ระบบ</p>
                                <form id="form1" class="form" action="checklogin.php" method="post">
                                    <input id="user_username" name="user_username" class="form-control" type="text" placeholder="Username" required>
                                    <input id="user_password" name="user_password" class="form-control" type="password" placeholder="Password" required>
                                    <button type="submit" name="submit" class="btn btn-primary signup">เข้าสู่ระบบ</button>
                                </form>
                            </div>
                        </div>

                        <div class="already">
                            <p style="font-size:large;">มีปัญหาหรือข้อสงสัยติดต่อ แผนก IT</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="bootstrap/js/smoke.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function () {
                $("#form1").on("submit", function (e) {
                    $.post("checklogin.php", $("#form1").serialize()).done(function (data) {
                        if (data.status === 'danger') {
                            $.smkAlert({text: data.messages, type: data.status});
                            $('#user_password').val('');
                            $("#user_password").focus();
                        } else {
                            window.location.replace('index.php');
                        }
                        e.preventDefault();
                    });
                    e.preventDefault();
                }); //close form1 .submit
            });
        </script>
    </body>
</html>
