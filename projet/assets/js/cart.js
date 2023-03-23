// init the cart with either data from session storage or the demo data

// update the cart in session storage
function addtopanier(event)
{
    
        let id = event.target.getAttribute("data-id") ;
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
                console.log(data);
            });
       
}
// display the cart
function rendercart(data) {

    // retrieve the cart
    let cart = data;
    console.log(cart);   // remove the ul
    let cartList = document.getElementById("section");
    let ulToRemove = document.getElementById("ul");
    cartList.removeChild(ulToRemove);

    // create the new ul
    let newUl = document.createElement("ul");
    newUl.setAttribute("id", "ul");
    let Price;
    let number = 0 ;
    // create the list
    for(let i = 0; i < cart.length; i++)
    {
        Price = cart[i].price;
        number = number +1;
        let item = cart[i];
        let li = document.createElement("li");
        li.appendChild(createcartItem(item)); // append them
        newUl.appendChild(li);
    }
    let totalprice = Price * number;
    cartList.appendChild(newUl);
    // update cart total price
    let totalPrice = document.getElementById("cart-total-price");
    totalPrice.innerText = "Total : " + totalprice + " €";

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
    let cartActions = document.createElement("section");
    cartActions.classList.add("cart-cart-actions");


    let cartPrice = document.createElement("p");
    cartPrice.setAttribute("data-cart-id", item.price);
    cartPrice.classList.add("cart-cart-price");

    let cartPriceSpan = document.createElement("span");
    let cartPriceSpanContent = document.createTextNode("" + number * item.price);
    cartPriceSpan.appendChild(cartPriceSpanContent);

    let currencyContent = document.createTextNode(" €");

    cartPrice.appendChild(cartPriceSpan);
    cartPrice.appendChild(currencyContent);

    cartActions.appendChild(cartPrice);

    containerSection.appendChild(cartActions);

    return containerSection;
}
export { addtopanier };