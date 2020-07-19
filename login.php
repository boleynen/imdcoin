<?php
include_once(__DIR__ . "/classes/c.login.php");

session_start();

$passwordMatch = true;

if(!empty($_POST['login-submit'])){
    try {
        $verification = new Login();
        $verification->setEmail(htmlspecialchars($_POST["email"]));
        $verification->setPassword(htmlspecialchars($_POST["pass"]));

        $passwordVerification = $verification->fetchPassword();

        if(password_verify($_POST["pass"], $passwordVerification)){
            $passwordMatch = true;
        }
        else{
            throw new Exception("Wrong email or password.");
            $passwordMatch = false;
        }

        if($passwordMatch == true){

            $_SESSION["user"] = $_POST["email"];

            header("Location: index.php");
        }

    }catch (\Throwable $th){
        $error = $th->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="en" class="html-login">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <link rel="stylesheet" href="style.css">

    <title>Login</title>
</head>

<body  class="body-login">

    <div class="container pt-5">
        <div class="row d-flex justify-content-center mt-5">
        <img src="images/logo.png" alt="logo" class="logo-img">

            <form class="mt-5" action="" method="post">

                <?php if(isset($error)):?>
                    <div  class="alert alert-danger" role="alert">
                    <?php echo $error;?></div>
                <?php endif;?>

                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small>
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="pass" class="form-control" id="inputPassword">
                </div>

                <div class="form-group d-flex justify-content-between
                align-items-center">
                    <input class="btn btn-primary" type="submit" name="login-submit" value="Login">
                    <a href="signup.php">Sign up here</a>
                </div>

            </form>

        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="js.js"></script>
</body>

</html>