// show transaction details

var transactionDate = document.querySelector(".transaction-date");
var transactionReason = document.querySelector(".transaction-reason");
let transactionModal = document.querySelector(".bd-example-modal-sm");


document.querySelector("#transaction-ul").addEventListener('click',function(e){
    if(e.target === (e.target.tagName ==='STRONG') || (e.target.tagName ==='SMALL') || (e.target.tagName ==='IMG') || (e.target.tagName ==='DIV')){
        // console.log(e.target.getAttribute('data-id'));
        let dataId = e.target.getAttribute('data-id');
        dataId = parseInt(dataId);

        fetch('./ajax/a.transactionDetails.php?id='+dataId)
        .then(response => {
            return response.json();
        })
        .then(result => {
            var reasonAndDate = result.body;
            var reason = reasonAndDate[0]['reason'];
            var date = reasonAndDate[0]['date'];

            transactionReason.innerText = reason;
            transactionDate.innerText = date;
        })
        .catch((error) => console.log(error))
        }

});