<?php 
session_start();

include_once(__DIR__."/classes/c.user.php");
include_once(__DIR__."/classes/c.transaction.php");

// GET MY DATA
$getProfile = new User();
$getProfile->setEmail($_SESSION['user']);
$profile = $getProfile->getMyData();

$token = $profile[0]['token'];


// GET ALL USERS
$getProfile->setEmail($_SESSION['user']);
$allUsers = $getProfile->getAllUsers();

// GET ALL MY TRANSACTIONS
$payment = new Transaction();
$payment->setId($profile[0]['id']);
$transactions = $payment->getTransactions();

// print("<pre>".print_r($transactions,true)."</pre>");


// PAYMENT FUNCTION
if(!empty($_POST['pay-btn'])){
    try {
        $payment->setEmail($profile[0]['id']);
        $currency = intval($profile[0]['currency']);
        $currency = $currency - htmlspecialchars($_POST['amount']);
        $payment->setAmount($currency);
        $payment->updateCurrency();

        // TO DO; UPDATE RECEIVER CURRENCY

        $payment->setSender($profile[0]['id']);
        $payment->setReceiver($_POST['selectReceiver']);
        $payment->setAmount(htmlspecialchars($_POST['amount']));
        $payment->setReason(htmlspecialchars($_POST['reason']));
        $payment->setDate(date("Y-m-d"));
        

        if($_POST['amount'] > intval($profile[0]['currency'])){
            throw new Exception("You can't send more coins then you own.");
        }

        if($_POST['amount'] < 1){
            throw new Exception("Amount must be bigger then 1.");
        }

        $payment->pay();



    } catch (\Throwable $th) {
        $error = $th->getMessage();
        $line = $th->getLine();
    }
}

if(!empty($_POST['claim-gift-btn'])){
    try {
        $getProfile->setCurrency(10);
        $getProfile->getFreeCoins();
        $getProfile->setToken(NULL);
        $getProfile->updateToken();


    } catch (\Throwable $th) {
        $error = $th->getMessage();
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <title>Home</title>
</head>

<body>
    <main>
        <div class="h-100">

        <?php if(isset($error)):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error;?>
            </div>
        <?php endif;?>

            <div class="mt-4 text-center">
                <img src="images/logo2.png" class="logo-img-small" alt="logo">
            </div>
            <div class="row mt-3 navbar sticky-top bg-white">
                <div class="col my-auto text-center">
                    <p><small>Your IMD coins</small></p>
                    <h3><strong><?php echo $profile[0]['currency']; ?> C</strong></h3>
                </div>
                <div class="col my-auto text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModalCenter1">Send coins</button>
                </div>
            </div>

            <!-- FIRST LOGIN POPUP -->

            <?php 

            if($token == 1){
                ?>
                <div class="alert alert-success mx-5 mt-2" id="gift-alert" role="alert">
                    <h4 class="alert-heading">You received a gift!</h4>
                    <p>You received 10 IMD coins as a welcome gift.</p>
                    <form action="" method="post">
                        <input name="claim-gift-btn" id="gift-alert-btn" class="btn btn-lg btn-block btn-light" type="submit" value="Claim reward" onclick=createEventListener()>

                    </form>

                </div>

                <?php
            }
            ?>

            <div class="row mt-5 mb-5 m-0 p-0 container-fluid">
                <div class="ml-3 mr-3">
                    <p><strong>Recent transactions</strong></p>
                </div>
                <ul class="ml-3 mr-3 list-group list-group-flush w-100">

                <?php 
                $i=-1;
                foreach($transactions as $transaction){
                
                    if($transaction['sender'] == $profile[0]['id']){
                        $i++;
                        $getProfile->setId($transactions[$i]['receiver']);
                        $transactionUser = $getProfile->getUser();
                        $avatarUser = $getProfile->getUserAvatar();
                        ?>
                
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-3 align-self-start my-auto">
                                    <img src="images/<?php echo $avatarUser[0]['avatar'] ?>" alt="avatar" class="img-responsive avatar-img">
                                </div>
                                <div class="col-6 my-auto">
                                    <?php echo $transactionUser[0]['name'] ?>
                                </div>
                                <div class="col-3 align-self-end my-auto">
                                    <strong class="text-danger">-<?php echo $transactions[$i]['amount']?> C</strong>
                                </div>
                            </div>
                        </li>
                        <?php
                        
                    }else{
                        $i++;
                        $getProfile->setId($transactions[$i]['sender']);
                        $transactionUser = $getProfile->getUser();
                        $avatarUser = $getProfile->getUserAvatar();
                        ?>
                
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-3 align-self-start my-auto">
                                    <img src="images/<?php echo $avatarUser[0]['avatar'] ?>" alt="avatar" class="img-responsive avatar-img">
                                </div>
                                <div class="col-6 my-auto">
                                    <?php echo $transactionUser[0]['name'] ?>
                                </div>
                                <div class="col-3 align-self-end my-auto">
                                    <strong class="text-success">+<?php echo $transactions[$i]['amount']?> C</strong>
                                </div>
                            </div>
                        </li>

                        <?php
                    }

                }
                ?>
                    

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

                            <?php if(isset($error)):?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error;?></div>
                                <?php echo $line;?></div>
                            <?php endif;?>

                            <div class="w-100 m-0 p-0 pb-3 pt-3 bg-white">
                                <p>Send IMD coins to</p>
                                <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search-name">
                                <div id="suggesstion-box"></div>
                            </div>

                            <select multiple size="5" class="list-group mt-2 w-100 overflow-auto " 
                                name="selectReceiver">

                                <?php
                                foreach($allUsers as $user){
                                ?>
                                <option class="form-control pay-persons " data-toggle="modal"
                                        data-target="#exampleModalCenter2" value="<?php echo $user['id'] ?>">
                                   
                                            <?php echo $user['name']; ?>
                                        
                                </option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div class="modal-body d-flex flex-column align-items-center" id="pay-2">

                            <?php if(isset($error)):?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error;?></div>
                            <?php endif;?>


                            <div class="w-100 navbar sticky-top m-0 p-0 pt-3 bg-white">
                                <p>Give an amount</p>
                                <div class="input-group mb-3">
                                    <input type="number" name="amount" class="form-control" placeholder="0.00">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">IMD coins</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100 navbar sticky-top m-0 p-0 pb-3 pt-3 bg-white">
                                <p>Reason for payment</p>
                                <div class="input-group mb-3">
                                    <input type="text" name="reason" class="form-control long-text">
                                </div>
                            </div>

                            <div class="w-100 navbar d-flex justify-content-between m-0 p-0 pb-3 pt-3 bg-white">
                                <input class="btn btn-secondary btn-lg" id="backBtn" type="submit" value="Back">
                                <input class="btn btn-primary btn-lg" name="pay-btn" type="submit" value="Pay">
                            </div>

                        </div>

                    </form>

                </div>
            </div>

    </main>

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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script>
        $(document).ready(function(){
            $("#search-name").keyup(function(){
                $.ajax({
                type: "POST",
                url: "autocomplete.php",
                data:'name='+$(this).val(),
                    success: function(data){
                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(data);
                        $("#search-name").css("background","#FFF");
                    },
                });
            });
        });

        function selectName(val) {
            $("#searchReceiver").val(val);
            $("#suggesstion-box").hide();

            var pay1 = document.querySelector("#pay-1");
            var pay2 = document.querySelector("#pay-2");

            pay1.setAttribute('style', 'display:none!important');
            pay2.setAttribute('style', 'display:flex !important');
            
        }

        var backBtn = document.querySelector("#backBtn");

        backBtn.addEventListener("click", myFunction1);

        var myFunction1 = function() {
            var pay1 = document.querySelector("#pay-1");
            var pay2 = document.querySelector("#pay-2");
            pay1.setAttribute('style', 'display:flex !important');
            pay2.setAttribute('style', 'display:none !important');
        };

</script>
</body>

</html>