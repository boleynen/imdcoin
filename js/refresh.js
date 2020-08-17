window.onload = function(){
    refreshCurrency();
    showTransactions();
}

var currencyOutput = document.querySelector("#my-curr");

// refresh currency
function refreshCurrency(){
        fetch('./ajax/a.refresh.php?id='+window.localStorage.getItem('myId'))
        .then(response => {
            return response.json();
        })
        .then(result => {
            var curr = result.body;
            currencyOutput.innerHTML = curr['currency'];
            setTimeout(refreshCurrency, 10000);
        })
        .catch((error) => console.log(error))
}


// show transactions op start page, then loop to see if there are changes with refreshTransactions()
var showTransactions = function() {
    fetch('./ajax/a.transaction.php?id='+window.localStorage.getItem('myId'))
    .then(response => {
        return response.json();
    })
    .then(result => {
        var payments = result.body;

        refreshContent(payments);
        refreshTransactions();

    })
    .catch((error) => console.log(error))

};


// refresh transactions
    var refreshTransactions = function() {
        setInterval(function() {
            fetch('./ajax/a.transaction.php?id='+window.localStorage.getItem('myId'))
            .then(response => {
                return response.json();
            })
            .then(result => {
                var payments = result.body;

                let paymentsStorage = parseInt(localStorage.getItem('paymentsAmount'));

                        console.log("payments = "+payments.length);
                        console.log("storage = "+paymentsStorage);

                    if(paymentsStorage === payments.length){

                        console.log("payments = "+payments.length);
                        console.log("storage = "+paymentsStorage);

                    }else if(paymentsStorage != payments.length){

                        window.localStorage.setItem('paymentsAmount', payments.length);
                        refreshContent(payments);
                        console.log("there were changes");

                    }

            })
            .catch((error) => console.log(error))
        }, 1000)

    };




    

// load transactions every 5 sec
let unorderedList = document.querySelector("#transaction-ul");

function refreshContent(payments){

    unorderedList.innerHTML="";

    payments.forEach(payment => {

        let listItem = document.createElement('li');
        listItem.setAttribute('data-id', payment['id']);
        let linkItem = document.createElement('a');
        linkItem.setAttribute('data-id', payment['id']);
        let divItem = document.createElement('div');
        divItem.setAttribute('data-id', payment['id']);
        let avatarDivItem = document.createElement('div');
        avatarDivItem.setAttribute('data-id', payment['id']);
        let nameDivItem = document.createElement('div');
        nameDivItem.setAttribute('data-id', payment['id']);
        let amountDivItem = document.createElement('div');
        amountDivItem.setAttribute('data-id', payment['id']);
        let imgItem = document.createElement('img');
        imgItem.setAttribute('data-id', payment['id']);
        let smallItem = document.createElement('small');
        smallItem.setAttribute('data-id', payment['id']);
        let strongItem = document.createElement('strong');
        strongItem.setAttribute('data-id', payment['id']);

        listItem.setAttribute('class', 'list-group-item');
        linkItem.setAttribute('href', '#');
        linkItem.setAttribute('class', 'text-dark transaction-item');
        linkItem.setAttribute('type', 'button');
        linkItem.setAttribute('data-toggle', 'modal');
        linkItem.setAttribute('data-target', '.bd-example-modal-sm');
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

        
        if(payment['sender'] == window.localStorage.getItem('myId')){
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