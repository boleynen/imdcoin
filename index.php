<?php 
session_start();

include_once(__DIR__."/classes/c.user.php");

$getProfile = new User();
$getProfile->setEmail($_SESSION['user']);
$profile = $getProfile->getMyData();

$getProfile->setEmail($_SESSION['user']);
$allUsers = $getProfile->getAllUsers();

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <link rel="stylesheet" href="style.css">

    <title>Home</title>
</head>

<body>
    <main>
        <div class="h-100">
            <div class="mt-4 text-center">
                <img src="images/logo2.png" class="logo-img-small" alt="logo">
            </div>
            <div class="row mt-3 navbar sticky-top bg-white">
                <div class="col my-auto text-center">
                    <p><small>Your IMD coins</small></p>
                    <h3><strong>85.00</strong></h3>
                </div>
                <div class="col my-auto text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModalCenter1">Send coins</button>
                </div>
            </div>

            <div class="row mt-5 m-0 p-0 container-fluid">
                <div class="ml-3 mr-3">
                    <p><strong>Recent transactions</strong></p>
                </div>
                <ul class="ml-3 mr-3 list-group list-group-flush w-100">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-3 align-self-start my-auto">
                                <img src="images/avatar.jpg" alt="avatar" class="img-responsive avatar-img">
                            </div>
                            <div class="col-6 my-auto">
                                Bryan
                            </div>
                            <div class="col-3 align-self-end my-auto">
                                <strong>+20 C</strong>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>

            <!-- BOTTOM NAV -->
            <nav class="navbar fixed-bottom navbar-light bg-light d-flex justify-content-around">
                <a class="navbar-brand" href="#" data-toggle="modal" data-target="#exampleModalCenter">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="images/profile.svg" class="navbar-icons" alt="profile icon">
                        <small class="navbar-text pt-0">my profile</small>
                    </div>
                </a>

                <a class="navbar-brand" href="#" data-toggle="modal" data-target="#exampleModalCenter1">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="images/pay.svg" class="navbar-icons" alt="profile icon">
                        <small class="navbar-text pt-0">send coins</small>
                    </div>
                </a>
            </nav>


        </div>

        <!-- MY PROFILE POPUP -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Your profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body d-flex flex-column align-items-center">
                        <img src="images/<?php echo $profile[0]['avatar']; ?>" alt="my profile picture"
                            class="img-responsive profile-picture mt-2">
                        <h4 class="pt-3 mb-0 my-auto">
                            <strong>
                                <?php echo $profile[0]['name'] ?>
                            </strong>
                        </h4>
                        <p class="pt-3">
                            <?php echo $profile[0]['year']?>IMD
                        </p>
                    </div>

                    <div class="modal-body d-flex justify-content-around">
                        <a href="#" class="btn btn-primary btn-lg" role="button" aria-disabled="true">Update account</a>
                        <a href="logout.php" class="btn btn-secondary btn-lg" role="button"
                            aria-disabled="true">Logout</a>
                    </div>

                </div>
            </div>
        </div>

        <!-- SEND PERSON COINS POPUP -->
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Send coins</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="post">
                        <div class="modal-body d-flex flex-column align-items-center" id="pay-1">
                            <div class="w-100 m-0 p-0 pb-3 pt-3 bg-white">
                                <p>Send IMD coins to</p>
                                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                            </div>

                            <select multiple style="height: 60vh;" class="list-group mt-2 w-100 overflow-auto">

                                <?php
                                foreach($allUsers as $user){
                                ?>
                                <option class="form-control pay-persons" value="<?php echo $user['id'] ?>">
                                    <a href="#" class="row text-dark list-item-person" data-toggle="modal"
                                        data-target="#exampleModalCenter2">
                                        <div class="col my-auto">
                                            <img src="images/<?php echo $user['avatar']; ?>" alt="avatar"
                                                class="img-responsive avatar-img mr-2">
                                            <?php echo $user['name']; ?>
                                        </div>
                                    </a>
                                </option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div class="modal-body d-flex flex-column align-items-center" id="pay-2">
                                <div class="w-100 navbar sticky-top m-0 p-0 pb-3 pt-3 bg-white">
                                    <p>Preparing to send coins to <strong><?php  ?></strong></p>
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
                                    <p>Reason for payment</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control long-text">
                                    </div>
                                </div>

                                <div class="w-100 navbar d-flex justify-content-between m-0 p-0 pb-3 pt-3 bg-white">
                                    <input class="btn btn-secondary btn-lg"  id="backBtn" type="submit" value="Back">
                                    <input class="btn btn-primary btn-lg" type="submit" value="Pay">
                                </div>

                            </div>

                    </form>

                </div>
            </div>

            <!-- SEND AMOUNT COINS POPUP -->
            <!-- <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Send coins</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body d-flex flex-column align-items-center">
                            <div class="w-100 navbar sticky-top m-0 p-0 pb-3 pt-3 bg-white">
                                <p>Preparing to send coins to <strong><?php  ?></strong></p>
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
                    </div>
                </div> -->
    </main>




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