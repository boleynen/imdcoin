<?php 
include_once(__DIR__ . "/classes/c.signup.php");

session_start();

if(!empty($_POST['complete-submit'])){

    $emptyFields = false;
    $imgPath = $_FILES["avatar"]["name"];

    var_dump($imgPath);
    var_dump($_POST['name']);


    try {
        $newUser = new Signup();
        $newUser->setName($_POST['name']);
        $newUser->setAvatar($imgPath);
        $newUser->setEmail($_SESSION["user"]);

        if(empty($_POST["name"]) || empty($_FILES["avatar"]["name"])){
            $emptyFields = true;
        }

        if( $emptyFields == true){
            throw new Exception("There are empty fields.");
            
        }else{
            $newUser->complete();
            header("Location: index.php");
        }

    } catch (\Throwable $th) {
        $error = $th->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <title>Signup</title>
</head>

<body>

    <div class="container pt-5">
        <div class="row d-flex justify-content-center mt-5">

            <img src="images/logo.png" alt="logo" class="logo-img">

            <form class="mt-5" action="" method="post" enctype="multipart/form-data">

                <?php if(isset($error)):?>
                    <div  class="alert alert-danger" role="alert">
                    <?php echo $error;?></div>
                <?php endif;?>

                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="name" name="name" class="form-control" id="inputName" aria-describedby="emailHelp">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Profile picture</label>
                    <input type="file" name="avatar" class="form-control-file" id="exampleFormControlFile1">
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="complete-submit" value="Signup">
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