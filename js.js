function relocate_pay(){
     location.href = "pay.php";
} 

function goback(){
    window.history.back();
}

$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  });

var elements = document.getElementsByClassName("pay-persons");

var myFunction = function() {
    var pay1 = document.querySelector("#pay-1");
    var pay2 = document.querySelector("#pay-2");
    pay2.setAttribute('style', 'display:flex !important');
    pay1.setAttribute('style', 'display:none !important');
};




for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}

var giftAlert = document.querySelector("#gift-alert");
var giftAlertBtn = document.querySelector("#gift-alert-btn");

// giftAlertBtn.addEventListener("click", function(){
//     giftAlert.setAttribute('style', 'display:none !important');
// });

function createEventListener() {
    if (giftAlert) {
        // giftAlertBtn.addEventListener('click', function() {
            giftAlert.setAttribute('style', 'display:none !important');
        // });
        console.log("success")
    }else{
        console.log("feil");
    }
}

