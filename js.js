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

var myFunction1 = function() {
    var pay1 = document.querySelector("#pay-1");
    var pay2 = document.querySelector("#pay-2");
    pay1.setAttribute('style', 'display:flex !important');
    pay2.setAttribute('style', 'display:none !important');
};

// var backBtn = document.querySelector("#backBtn");

// backBtn.addEventListener("click", myFunction1);

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}
