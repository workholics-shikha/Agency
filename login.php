<?php

session_start();

include("include/function.php");
global $prbsl;


$login_error = '';
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['adminId']);
    header("Location:" . admin_url() . "login.php");
}

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
    unset($_SESSION['adminId']);
    header("Location:" . admin_url() . "login.php");
}
// $error=false;
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = $prbsl->get_row("SELECT * FROM `userdetail` WHERE `email`='$email' AND `password`='$password'");

    if ($sql) {

        $query = $prbsl->get_row("SELECT email FROM `userdetail` WHERE `email`='$email' AND `password`='$password'");

        $_SESSION['email'] = $query;
        $tt = $_SESSION['email'];

        header("Location:" . admin_url() . "login.php");
    } else {
        $checkadmin = $prbsl->get_row("SELECT * FROM `admin_user` WHERE `email`='$email' AND `password`='$password'");
        if ($checkadmin !== "") {
            $_SESSION['email'] = $checkadmin['email'];
            $_SESSION['adminId'] = $checkadmin['id'];
            $_SESSION['cur_user'] = 'admin';

            header("Location:" . admin_url() . "index.php");
        }
        $error = true;
        $login_error = "Please Check Username And Password";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agency Admin | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= admin_url() ?>/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= admin_url() ?>/css/AdminLTE.min.css">
    
</head>

<body class="hold-transition login-page">
    <?php if ($login_error != '') {
        echo '<div style="width:100%;text-align:center;font-size:20px;font-weight:bold;background-color:#FFF;">' . $login_error . '</div>';
    } ?>
    <div class="login-box">
        <div class="login-logo">
            <div> 
                <h1 style="color:#fff;">Agency Admin</h1>
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form method="post">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" autofocus required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>

                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery 2.2.0 -->
    <script src="https://www.viraatswadeshihaat.com/agency/js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="https://www.viraatswadeshihaat.com/agency/js/bootstrap.min.js"></script>
</body>

</html>