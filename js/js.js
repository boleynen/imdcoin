
// go to previous page function
    function goback(){
        window.history.back();
    }


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


// hide modal 1, show modal 2 when paying user
    function selectName(val) {
        $("#searchReceiver").val(val);
        $("#suggesstion-box").hide();
            
        var pay1 = document.querySelector("#pay-1");
        var pay2 = document.querySelector("#pay-2");
            
        pay1.setAttribute('style', 'display:none !important');
        pay2.setAttribute('style', 'display:flex !important');
            
            }

