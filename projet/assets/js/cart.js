// init the cart with either data from session storage or the demo data

// update the cart in session storage
function addtopanier(event)
{
        let select = document.getElementById("select");
        let choice = select.selectedIndex;
        let value = select.options[choice].value;
        let sizeChoice = document.getElementById("add-to-cart");
        sizeChoice.setAttribute("data-size", value);
        
        let id = event.target.getAttribute("data-id");
        let number = event.target.getAttribute("data-number") ;
        let size = event.target.getAttribute("data-size") ;
        const options = 
        {
            method: 'GET'
        };
        
        
            fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/addPanier/"+id+"/"+number+"/"+size ,options)
            .then(response => response.json())
            .then(data => {
                rendercart(data);
                TotalPrices(data);
            });
       
}
// display the cart
function rendercart(data) {

    // retrieve the cart
    let cart = data;
    // remove the ul
    let cartList = document.getElementById("section");
    let ulToRemove = document.getElementById("ul");
    cartList.removeChild(ulToRemove);

    // create the new ul
    let newUl = document.createElement("ul");
    newUl.setAttribute("id", "ul");
    // create the list
    for(let i = 0; i < cart.length; i++)
    {
        let item = cart[i];
        let li = document.createElement("li");
        li.appendChild(createcartItem(item)); // append them
        newUl.appendChild(li);
    }
    let TotalPrice = TotalPrices(data);
    cartList.appendChild(newUl);
    // update cart total price
    let totalPrice = document.getElementById("cart-total-price");
    totalPrice.innerText = "Total : " + TotalPrice + " €";
    loadListeners()
}

// create one cart item to be injected in the html
function createcartItem(item)
{
    let containerSection = document.createElement("section");
    let number = item.number;
    // creating the figure and img
    let figure = document.createElement("figure");
    let img = document.createElement("img");
    img.setAttribute("alt", "image du produit " + item.name);
    img.setAttribute("src", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/" + item.url);
    figure.appendChild(img);
    containerSection.appendChild(figure);

    // creating the cart info
    let cartInfo = document.createElement("section");
    cartInfo.classList.add("cart-cart-info");
    let cartName = document.createElement("h3");
    let cartNameContent = document.createTextNode(item.name);
    cartName.appendChild(cartNameContent);
    cartInfo.appendChild(cartName);

    containerSection.appendChild(cartInfo);

    // creating the cart actions
    let newbtn = document.createElement("button");
    newbtn.setAttribute("removedata-id", item.id);
    newbtn.setAttribute("removedata-size", item.size);
    newbtn.setAttribute("id", item.id);
    newbtn.setAttribute("class", "supp");
    let removeitemtext = document.createTextNode("supprimer");
    newbtn.appendChild(removeitemtext);
    
    
    let cartActions = document.createElement("section");
    cartActions.classList.add("cart-cart-actions");
    
    let cartPrice = document.createElement("p");
    cartPrice.setAttribute("data-cart-id", item.price);
    cartPrice.classList.add("cart-cart-price");

    let cartPriceSpan = document.createElement("span");
    cartPriceSpan.setAttribute("class", "price");
    let cartPriceSpanContent = document.createTextNode("" + (item.number * item.price * item.size));
    cartPriceSpan.appendChild(cartPriceSpanContent);

    let currencyContent = document.createTextNode(" €");

    cartPrice.appendChild(cartPriceSpan);
    cartPrice.appendChild(currencyContent);

    cartActions.appendChild(cartPrice);
    
    containerSection.appendChild(cartActions);
    containerSection.appendChild(newbtn);

    return containerSection;
}
function TotalPrices(data)
{
    let cart = data ;
    let price = [];
    let TotalPrice = 0;
    
    for(let i = 0; i < cart.length; i++)
    {
            price.push(cart[i].number * cart[i].price * cart[i].size);
    } 
    
    for (let i = 0; i < price.length; i++) 
    {
        TotalPrice += price[i];
    }
    
    return TotalPrice;
}
function remove(id, size)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/removePanier/"+id+"/"+size);
    
    setTimeout(function() {
 displayPanier();
}, 10);
    
}
function displayPanier()
{
        
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/displayPanier")
    .then(response => response.json())
    .then(data => {
        rendercart(data);
        TotalPrices(data);
        
    });
}

function loadListeners()
{
    let buttons = document.getElementsByClassName("supp");
        for(let i = 0; i < buttons.length; i++)
        {
          buttons[i].addEventListener("click", function(event){
              
            let removeId = event.target.getAttribute("removedata-id");
            let removeSize = event.target.getAttribute("removedata-size");
            remove(removeId, removeSize);
          });
        }
    
  //  let $addButtons = document.getElementsByClassName("cart-button-add");
  //  let $removeButtons = document.getElementsByClassName("cart-button-remove");

 //   for(var i = 0; i < $addButtons.length; i++)
 //   {
//        $addButtons[i].addEventListener("click", addItem);
 //       $removeButtons[i].addEventListener("click", removeItem);
 //   }
    
}

function finditem(id, size)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/findItem/"+id+"/"+size)
    .then(response => response.json())
    .then(data => {
        
    });
    
}
export { finditem };
export { remove };
export { displayPanier };
export { addtopanier };