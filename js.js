
// go to previous page function
    function goback(){
        window.history.back();
    }

// every person, list items
    var elements = document.getElementsByClassName("pay-persons");


// gift alert popup (for first login reward)
    var giftAlert = document.querySelector("#gift-alert");
    var giftAlertBtn = document.querySelector("#gift-alert-btn");

// if gist alert exists, create event listener
    function createEventListener() {
        if (giftAlert) {
            // giftAlertBtn.addEventListener('click', function() {
                giftAlert.setAttribute('style', 'display:none !important');
            // });
            console.log("success")
        }else{
            console.log("fail");
        }
    }

// toggle modal function
    // back button on modal
    var backBtn = document.querySelector("#backBtn");
    // add event listener to back button
    backBtn.addEventListener("click", toggleModal);

    function toggleModal() {
        var pay1 = document.querySelector("#pay-1");
        var pay2 = document.querySelector("#pay-2");
                // hide second modal
                pay2.setAttribute('style', 'display:none !important');
        // show first modal
        pay1.setAttribute('style', 'display:flex !important');

    };

// show new transactions every 5 seconds
    // $(document).ready(function() {
    //     // execute refreshCurrency every 5 seconds
    //     setInterval(refreshCurrency, 5000);
    //     function refreshCurrency() {
    //         // refresh mu currency
    //         $('#my-currency h3').load('index.php #my-currency h3');
    //         // refresh recent transactions
    //         $('#my-transactions-container').load('index.php #my-transactions');
    //     }
    // });

