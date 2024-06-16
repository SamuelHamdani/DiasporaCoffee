<?php
    session_start();
    require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="stylesheet" href="../JS/login.js">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
                <div class="panel border bg-white">
                    <div class="panel-heading">
                        <h3 class="pt-3 font-weight-bold">Login</h3>
                    </div>
                    <div class="panel-body p-3">
                        <form action="" method="POST">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <span class="far fa-user p-2"></span>
                                    <input type="text" placeholder="Username or Email" name="username" id="username">
                                </div>
                            </div>
                            <div class="form-group py-1 pb-2">
                                <div class="input-field">
                                    <span class="fas fa-lock px-2"></span>
                                    <input type="password" placeholder="Enter your Password" name="password" id="password">
                                </div>
                            </div>
                            <div class="form-inline">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember" class="text-muted">Remember me</label>
                                <a href="/forgotpw.html" id="forgot" class="font-weight-bold">Forgot password?</a>
                            </div>
                            <button class="btn btn-primary btn-block mt-3" type="submit" name="loginbtn">Login</button>
                            <div class="text-center pt-4 text-muted">Don't have an account? <a href="/signup.html">Sign
                                    up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container alert-con">
        <?php
            if(isset($_POST['loginbtn'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if($countdata > 0){
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: ../adminpanel');
                    }
                    else {
                        ?>
                    <div class="alert alert-warning" role="alert">
                       Password Salah
                    </div>
                    <?php
                    }
                }
                else{
                    ?>
                    <div class="alert alert-warning" role="alert">
                       Akun tidak tersedia
                    </div>
                    <?php
                }
            }
        ?>
    </div>
</body>

</html>