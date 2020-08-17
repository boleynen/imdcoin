<?php 
session_start();

include_once(__DIR__."/classes/c.user.php");
include_once(__DIR__."/classes/c.transaction.php");

// GET MY DATA
$userProfile = new User();
$userProfile->setEmail($_SESSION['user']);
$profile = $userProfile->getMyData();

// MY TOKEN
$token = $profile[0]['token'];

// GET ALL USERS
$userProfile->setEmail($_SESSION['user']);
$allUsers = $userProfile->getAllUsers();

// GET ALL MY TRANSACTIONS
$payment = new Transaction();
$payment->setId($profile[0]['id']);
$transactions = $payment->getTransactions();

$payUser = new User();
$userGotPaid = new Transaction();

// PAYMENT FUNCTION
if(!empty($_POST['pay-btn'])){
    try {
        // GET MY CURRENCY AND UPDATE IT
        $payment->setEmail($profile[0]['id']);
        $myCurrency = intval($profile[0]['currency']);
        $myCurrency = $myCurrency - htmlspecialchars($_POST['amount']);
        $payment->setAmount($myCurrency);
        $payment->updateCurrency();

        // GET RECEIVERS CURRENCY AND UPDATE IT
        $payUser = new User();
        $receiver = new Transaction();
        // set receivers id
            // set id for function that retreives receivers current money
        $payUser->setId($_POST['selectReceiver']);
            // set id for function that updates new amount
        $receiver->setId($_POST['selectReceiver']);
        // get currency from receiver
        $userCurrency = $payUser->getUserCurrency();
        // convert string to int
            // users current money
        $userCurrency = intval($userCurrency['currency']);
            // users received money
        $paidAmount = intval(htmlspecialchars($_POST['amount']));
        // create var that contains receivers new amount of coins
        $userCurrency = $userCurrency + $paidAmount;
        // set that var as the amount
        $receiver->setAmount($userCurrency);
        // execute function
        $receiver->updateCurrency();



        // PUT TRANSACTION IN DATABASE
        $payment->setSender($profile[0]['id']);
        if($_POST['selectReceiver'] == NULL){
            $payment->setReceiver($_POST['selectReceiver']);
        }
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
        $userProfile->setCurrency(10);
        $userProfile->getFreeCoins();
        $userProfile->setToken(NULL);
        $userProfile->updateToken();


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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <title>Home</title>
</head>

<body >
    <main id="mainIndex" style="display: flex">
        
        <div class="h-100" style="max-width: 400px; max-height: 700px; margin: auto; overflow: hidden; position: absolute; top:0; bottom: 0; left: 0; right: 0; border: 1px solid #dfdfdf">

            <?php if(isset($error)):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error;?>
            </div>
            <?php endif;?>

            <div class="mt-4 text-center">
                <img src="images/logo2.png" class="logo-img-small" alt="logo">
            </div>
            <div class="row mt-3 navbar sticky-top bg-white" >
                <div class="col my-auto text-center" id="my-currency">
                    <p><small>Your IMD coins</small></p>
                    <h3><strong id="my-curr"></strong></h3>
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
                        <input name="claim-gift-btn" id="gift-alert-btn" class="btn btn-lg btn-block btn-light"
                            type="submit" value="Claim reward" onclick=createEventListener()>

                    </form>

                </div>

                <?php
            }
            ?>

            <!-- RECENT TRANSACTIONS -->
            <div id="my-transactions-container" style="overflow-y: scroll; margin-right: -30px; height: 700px">
            <div class="row mt-5 m-0 p-0" id="my-transactions" style="margin-bottom: 250px !important">
                <div class="ml-3 mr-3 sticky-top bg-white" style="display: block !important; width: 100%">
                    <p><strong>Recent transactions</strong></p>
                </div>
                <ul id="transaction-ul" class="ml-3 mr-3 list-group list-group-flush w-100">



                </ul>
                    <!-- INFO ABOUT TRANSACTION COLLAPSE -->
                        <div class="modal fade bd-example-modal-sm" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Transaction details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Message: </br><span class="transaction-reason font-weight-bold"> </span></p>
                                <p>Date: </br><span class="transaction-date font-weight-bold"></span></p>
                            </div>
                            </div>
                        </div>
                        </div>
            </div>
            </div>

            <!-- BOTTOM NAV -->
            <nav class="navbar position-absolute navbar-light bg-light d-flex justify-content-around" style="max-width: 400px; margin: 0 auto; top: 625px; width: 400px;">
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
                        <img src="avatars/<?php echo $profile[0]['avatar']; ?>" alt="my profile picture"
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
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search"
                                id="search-name">

                            <select id="suggesstion-box" size="3"class="list-group mt-2 w-100 overflow-auto" onClick="selectName()" name="selectReceiver"></select>
                            </ul>
                        </div>

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


        window.onload = function(){
            refreshCurrency();
            refreshTransactions();
        }

        const myId = <?php echo $profile[0]['id'] ?>;

        // refresh page

        var currencyOutput = document.querySelector("#my-curr");

        function refreshCurrency(){
                fetch('./ajax/a.refresh.php?id='+myId)
                .then(response => {
                    return response.json();
                })
                .then(result => {
                    var curr = result.body;
                    currencyOutput.innerHTML = curr['currency'];
                    setTimeout(refreshCurrency, 7000);
                })
                .catch((error) => console.log(error))
        }

        // refresh transactions
            var refreshTransactions = function() {
                fetch('./ajax/a.transaction.php?id='+myId)
                .then(response => {
                    return response.json();
                })
                .then(result => {
                    var payments = result.body;
                    refreshContent(payments);

                    setTimeout(function() {
                        refreshTransactions();
                    }, 5000)
                })
                .catch((error) => console.log(error))
            };


            // show transaction details

            var transactionDate = document.querySelector(".transaction-date");
            var transactionReason = document.querySelector(".transaction-reason");

            if(element.classList.contains(class));

            // load transactions every 5 sec
            let unorderedList = document.querySelector("#transaction-ul");
            let transactionModal = document.querySelector("#details-modal");

            function refreshContent(payments){

                unorderedList.innerHTML="";

                payments.forEach(payment => {


                    let listItem = document.createElement('li');
                    let linkItem = document.createElement('a');
                    let divItem = document.createElement('div');
                    let avatarDivItem = document.createElement('div');
                    let nameDivItem = document.createElement('div');
                    let amountDivItem = document.createElement('div');
                    let imgItem = document.createElement('img');
                    let smallItem = document.createElement('small');
                    let strongItem = document.createElement('strong');

                    listItem.setAttribute('class', 'list-group-item');
                    linkItem.setAttribute('href', '#');
                    linkItem.setAttribute('class', 'text-dark transaction-item');
                    linkItem.setAttribute('type', 'button');
                    linkItem.setAttribute('data-toggle', 'modal');
                    linkItem.setAttribute('data-target', '.bd-example-modal-sm');
                    // linkItem.setAttribute('data-id', payment['id']);
                    divItem.setAttribute('class', 'row');
                    avatarDivItem.setAttribute('class', 'col-3 align-self-start my-auto');
                    imgItem.setAttribute('class', 'transaction-img');
                    imgItem.setAttribute('src', '#');
                    imgItem.setAttribute('alt', 'avatar');
                    imgItem.setAttribute('class', 'img-responsive avatar-img');
                    nameDivItem.setAttribute('class', 'col-6 my-auto transaction-name');
                    smallItem.setAttribute('class', 'form-text text-muted transaction-year');
                    amountDivItem.setAttribute('class', 'col-3 align-self-end my-auto');
                    

                    divItem.appendChild(avatarDivItem);
                    divItem.appendChild(nameDivItem);
                    divItem.appendChild(amountDivItem);
                    avatarDivItem.appendChild(imgItem);
                    nameDivItem.appendChild(smallItem);
                    amountDivItem.appendChild(strongItem);
                    linkItem.appendChild(divItem);
                    listItem.appendChild(linkItem);
                    unorderedList.appendChild(listItem);

                    
                    if(payment['sender'] == myId){
                        strongItem.setAttribute('class', 'transaction-amount text-danger');
                        strongItem.innerHTML = "-"+payment['amount']+" C";

                        var id = payment['receiver'];
                        getUserData(id);

                        function getUserData(id){
                            fetch('./ajax/a.user.php?id='+id)
                            .then(response => {
                                return response.json();
                            })
                            .then(result => {
                                var receiver = result.body;
                                imgItem.setAttribute('src', 'avatars/'+receiver[0]['avatar']);
                                var nameText = document.createTextNode(receiver[0]['name']); 
                                nameDivItem.appendChild(nameText);
                                smallItem.innerHTML = receiver[0]['year'] + " IMD";
                            })
                            .catch((error) => console.log(error))
                        };

                    }else{
                        strongItem.setAttribute('class', 'transaction-amount text-success');
                        strongItem.innerHTML = "+"+payment['amount']+" C";

                        var id = payment['sender'];
                        getUserData(id);
                        
                        function getUserData(id){
                            fetch('./ajax/a.user.php?id='+id)
                            .then(response => {
                                return response.json();
                            })
                            .then(result => {
                                var sender = result.body;
                                imgItem.setAttribute('src', 'avatars/'+sender[0]['avatar']);
                                var nameText = document.createTextNode(sender[0]['name']); 
                                nameDivItem.appendChild(nameText);
                                smallItem.innerHTML = sender[0]['year'] + " IMD";
                            
                            })
                            .catch((error) => console.log(error))
                        };
                        
                    }


                })

                
            }

            


        // search for person autocomplete
            // search input
            var searchInput = document.querySelector("#search-name");
            // search output
            var searchResult = document.querySelector("#suggesstion-box");
            // create timer
            let timer = null;

            // add event listener for input field
            searchInput.addEventListener('input', function(event){
                if (timer) {
                    clearTimeout(timer)
                }
                // start timer
                timer = setTimeout(() => {
                    // input value from search
                    const input = searchInput.value;
                    // length must be 2 characters
                    if(input.length > 2){
                        // fetch data from search.php,
                        // $_GET['name'] (in search.php) = the search input
                        fetch('./ajax/a.search.php?name='+input)
                        .then(response => {
                            // then return response in json format
                            return response.json();
                        })
                        .then(result => {
                            // results is data from results->body
                            var results = result.body;
                            // reset innerHTML of list items
                            searchResult.innerHTML='';
                            // execute addItem function, attach results 
                            addItem(results);
                        })
                        .catch((error) => console.log(error))
                    } else if(input.length < 2){
                        searchResult.innerHTML='';
                    }
                }, 500)
            });

        // create new option item function
            function addItem(results) {
                // foreach results item, as user
                results.forEach(user => {
                    // create new option HTML element
                    let selectItem = document.createElement('option');
                    // set value as the selected users ID
                    selectItem.setAttribute("value", user['id']);
                    // set data attributes for modals (bootstrap)
                    selectItem.setAttribute("data-toggle", "modal");
                    selectItem.setAttribute("data-target", "#exampleModalCenter2"); 
                    // set classes for new option item             
                    selectItem.className = 'selected_person list-group-item list-group-item-action pay-persons';  
                    // create text node
                    var textnode = document.createTextNode(user['name']);  
                    // attach text node to new option item       
                    selectItem.appendChild(textnode);     
                    // show new option item in output                     
                    searchResult.appendChild(selectItem);
                });
            }

        // when option item is clicked, attach persons ID to input
            searchResult.addEventListener("click", function (item) {
                if (item.target && item.target.matches("li.selected_person")) {
                    searchInput.setAttribute('value', item.target.getAttribute('value'));
                }
            });


        // hide modal 1, show modal 2 when paying user
            function selectName(val) {
                $("#searchReceiver").val(val);
                $("#suggesstion-box").hide();
            
                var pay1 = document.querySelector("#pay-1");
                var pay2 = document.querySelector("#pay-2");
            
                pay1.setAttribute('style', 'display:none !important');
                pay2.setAttribute('style', 'display:flex !important');
            
            }

 


    </script>
</body>

</html>