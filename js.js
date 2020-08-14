
function goback(){
    window.history.back();
}

// $('#myModal').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
//   });

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


var searchInput = document.querySelector("#search-name");
var searchResult = document.querySelector("#suggesstion-box");
let timer = null;

searchInput.addEventListener('input', function(event){
    if (timer) {
        clearTimeout(timer)
    }
    timer = setTimeout(() => {
        const input = searchInput.value;
        if(input.length > 2){
            
            fetch('./ajax/search.php?name='+input)
            .then(response => {
                return response.json();
            })
            .then(result => {
                var results = result.body;
                searchResult.innerHTML='';
                addItem(results);
            })
            .catch((error) => console.log(error))
        } else if(input.length < 2){
            searchResult.innerHTML='';
        }
    }, 500)
});

// create new option item
function addItem(results) {
    results.forEach(user => {
        let selectItem = document.createElement('option');
        selectItem.setAttribute("value", user['id']);
        selectItem.setAttribute("data-toggle", "modal");
        selectItem.setAttribute("data-target", "#exampleModalCenter2");              
        selectItem.className = 'selected_person list-group-item list-group-item-action pay-persons';  
        var textnode = document.createTextNode(user['name']);         
        selectItem.appendChild(textnode);                              
        searchResult.appendChild(selectItem);
    })
}

searchResult.addEventListener("click", function (item) {
    if (item.target && item.target.matches("li.selected_person")) {
        searchInput.setAttribute('value', item.target.getAttribute('value'));
    }
});


function selectName(val) {
    $("#searchReceiver").val(val);
    $("#suggesstion-box").hide();

    var pay1 = document.querySelector("#pay-1");
    var pay2 = document.querySelector("#pay-2");

    pay1.setAttribute('style', 'display:none !important');
    pay2.setAttribute('style', 'display:flex !important');

}

var backBtn = document.querySelector("#backBtn");

backBtn.addEventListener("click", toggleModal);

function toggleModal() {
    var pay1 = document.querySelector("#pay-1");
    var pay2 = document.querySelector("#pay-2");
    pay1.setAttribute('style', 'display:flex !important');
    pay2.setAttribute('style', 'display:none !important');
};

$(document).ready(function() {
    setInterval(refreshCurrency, 5000);
    function refreshCurrency() {
        $('#my-currency h3').load('index.php #my-currency h3');
        $('#my-transactions-container').load('index.php #my-transactions');
    }
});

