// init the cart with either data from session storage or the demo data

// update the cart in session storage
function addtoCart(event)
{
    
        let id = event.target.getAttribute("data-id") ;
        const options = 
        {
            method: 'GET',
        };
        
        
            fetch("/res03-projet-final/projet/addPanier/"+id,options)
            .then(response => response.json())
            .then(data => {
                renderCart(data);
                console.log(data);
                
            });
       
}
// display the cart
function renderCart(panier) {

    // retrieve the cart
    let cart = panier;
    console.log(cart);   // remove the ul
    let productList = document.getElementById("section");
    let ulToRemove = document.getElementById("ul");
    productList.removeChild(ulToRemove);

    // create the new ul
    let newUl = document.createElement("ul");
    let totalprice = 0;
    // create the list
    for(let i = 0; i < cart.length; i++)
    {
        let Price = cart[i].price;
        let number = cart.length;
        totalprice = Price * number ;
        let item = cart[i];
        let li = document.createElement("li");
        li.appendChild(createCartItem(item)); // append them
        newUl.appendChild(li);
    }
    productList.appendChild(newUl);

    // update cart total price
    let totalPrice = document.getElementById("cart-total-price");
    totalPrice.innerText = "Total : " + totalprice + " €";

    loadListeners();
}

// create one cart item to be injected in the html
function createCartItem(item)
{
    let $containerSection = document.createElement("section");
    let number = 1;
    // creating the figure and img
    let $figure = document.createElement("figure");
    let $img = document.createElement("img");
    $img.setAttribute("alt", "image du produit " + item.name);
    $img.setAttribute("src", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/" + item.url);
    $figure.appendChild($img);
    $containerSection.appendChild($figure);

    // creating the product info
    let $productInfo = document.createElement("section");
    $productInfo.classList.add("cart-product-info");
    let $productName = document.createElement("h3");
    let $productNameContent = document.createTextNode(item.name);
    $productName.appendChild($productNameContent);
    $productInfo.appendChild($productName);

    $containerSection.appendChild($productInfo);

    // creating the product actions
    let $productActions = document.createElement("section");
    $productActions.classList.add("cart-product-actions");

    let $buttonsSection = document.createElement("section");

    let $removeButton = document.createElement("button");
    $removeButton.setAttribute("data-product-id", item.id);
    $removeButton.classList.add("cart-btn");
    $removeButton.classList.add("cart-button-remove");
    let $minus = document.createTextNode("-");
    $removeButton.appendChild($minus);

    let $amountSpan = document.createElement("span");
    let $amountContent = document.createTextNode(number);
    $amountSpan.appendChild($amountContent);

    let $addButton = document.createElement("button");
    $addButton.setAttribute("data-product-id", item.id);
    $addButton.classList.add("cart-btn");
    $addButton.classList.add("cart-button-add");
    let $plus = document.createTextNode("+");
    $addButton.appendChild($plus);

    $buttonsSection.appendChild($removeButton);
    $buttonsSection.appendChild($amountSpan);
    $buttonsSection.appendChild($addButton);

    $productActions.appendChild($buttonsSection);

    let $productPrice = document.createElement("p");
    $productPrice.setAttribute("data-product-id", item.price);
    $productPrice.classList.add("cart-product-price");

    let $productPriceSpan = document.createElement("span");
    let $productPriceSpanContent = document.createTextNode("" + number * item.price);
    $productPriceSpan.appendChild($productPriceSpanContent);

    let $currencyContent = document.createTextNode(" €");

    $productPrice.appendChild($productPriceSpan);
    $productPrice.appendChild($currencyContent);

    $productActions.appendChild($productPrice);

    $containerSection.appendChild($productActions);

    return $containerSection;
}


// load the listeners for the add and remove buttons
function loadListeners()
{
    let $addButtons = document.getElementsByClassName("cart-button-add");
    let $removeButtons = document.getElementsByClassName("cart-button-remove");

    for(var i = 0; i < $addButtons.length; i++)
    {
        $addButtons[i].addEventListener("click", addItem);
        $removeButtons[i].addEventListener("click", removeItem);
    }
}

// update the item amount to + 1
function addItem(event)
{
    let $id = event.target.getAttribute("data-product-id");
    let itemKey = findItem($id);
    let $cart = addtoCart();
    
    if(itemKey !== null)
    {
        $cart[itemKey].amount += 1;
        addtoCart($cart);
        computeCartTotal();
        renderCart();
    }
}

// get the item key in the cart.items array
function findItem($id)
{
    let $cart = addtoCart();

    for(var i = 0; i < $cart.length; i++)
    {
        if($cart[i].id === parseInt($id))
        {
            return i;
        }
    }

    return null;
}

// update the total price of the cart
function computeCartTotal()
{
    let $cart = addtoCart();
    let $price = 0;

    for(var i = 0; i < $cart.length; i++)
    {
        $price += ($cart[i].price * $cart[i].amount);
    }

    $cart.totalPrice = $price;
    addtoCart($cart);
}


// update the item amount to - 1
function removeItem(event)
{
    let $id = event.target.getAttribute("data-product-id");
    let itemKey = findItem($id);
    let $cart = addtoCart();

    if(itemKey !== null)
    {
        $cart[itemKey].amount -= 1;
        addtoCart($cart);
        computeCartTotal();
        renderCart();
    }

}
export { addtoCart };