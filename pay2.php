<?php 
include_once(__DIR__ . "/classes/c.user.php");

session_start();

$findUser = new User();

$uid = intval($_GET['id']);

$findUser->setId($uid);
$user = $findUser->getUser();


// echo '<pre>';
// var_dump($user);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <link rel="stylesheet" href="style.css">

    <title>Pay</title>
</head>

<body>
    <div class="row mt-3 m-2">
        <button type="button" class="btn btn-link pl-0 text-dark" onclick="goback()"><small>&lt; go
                back</small></button>
    </div>
    <form action="" method="post">
        <div class="row mt-3 m-2">

            <div class="w-100 navbar sticky-top m-0 p-0 pb-3 pt-3 bg-white">
                <p>Preparing to send coins to <strong><?php  echo $user[0]['name']; ?></strong></p>
            </div>


            <div class="w-100 navbar sticky-top m-0 p-0 pt-3 bg-white">
                <p>Give an amount</p>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="0.00">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">IMD coins</span>
                    </div>
                </div>
            </div>

            <div class="w-100 navbar sticky-top m-0 p-0 pb-3 pt-3 bg-white">
                <p>Give a reason</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control long-text">
                </div>
            </div>

            <div class="w-100 navbar d-flex justify-content-end m-0 p-0 pb-3 pt-3 bg-white">
                <input class="btn btn-primary mr-3" type="submit" value="Pay">
            </div>

        </div>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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