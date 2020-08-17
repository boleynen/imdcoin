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