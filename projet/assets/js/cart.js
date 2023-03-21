// init the cart with either data from session storage or the demo data
function initCart() {

    
        saveCart();
    

}

function getCart()
{
    return JSON.parse(sessionStorage.getItem("cart"));
}
// update the cart in session storage
function saveCart()
{
    let button = document.getElementById("add-to-cart");
    button.addEventListener("click",function(e)
    {
        let id = e.target.getAttribute("data-id") ;
        const options = 
        {
            method: 'GET',
        };
        
            fetch("/res03-projet-final/projet/addPanier/"+id,options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });

    })
    
}

// display the cart
function renderCart() {

    // retrieve the cart
    var $cart = getCart();

    // remove the ul
    var $productList = document.querySelector("body > aside > main");
    var $ulToRemove = document.querySelector("body > aside > main > ul");
    $productList.removeChild($ulToRemove);

    // create the new ul
    var $newUl = document.createElement("ul");

    // create the lis
    for(var i = 0; i < $cart.items.length; i++)
    {
        if($cart.items[i].amount > 0)
        {
            var $item = $cart.items[i];
            var $li = document.createElement("li");
            $li.appendChild(createCartItem($item)); // append them
            $newUl.appendChild($li);
        }
    }

    $productList.appendChild($newUl);

    // update cart total price
    let $totalPrice = document.getElementById("cart-total-price");
    $totalPrice.innerText = "Total : " + $cart.totalPrice + " $";

    loadListeners();
}

// create one cart item to be injected in the html
function createCartItem($item)
{
    var $containerSection = document.createElement("section");

    // creating the figure and img
    var $figure = document.createElement("figure");
    var $img = document.createElement("img");
    $img.setAttribute("alt", "image du produit " + $item.id);
    $img.setAttribute("src", $item.imageUrl);
    $figure.appendChild($img);

    $containerSection.appendChild($figure);

    // creating the product info
    let $productInfo = document.createElement("section");
    $productInfo.classList.add("cart-product-info");
    let $productName = document.createElement("h3");
    let $productNameContent = document.createTextNode("Nom du produit " + $item.id);
    $productName.appendChild($productNameContent);
    $productInfo.appendChild($productName);

    $containerSection.appendChild($productInfo);

    // creating the product actions
    let $productActions = document.createElement("section");
    $productActions.classList.add("cart-product-actions");

    let $buttonsSection = document.createElement("section");

    let $removeButton = document.createElement("button");
    $removeButton.setAttribute("data-product-id", $item.id);
    $removeButton.classList.add("cart-btn");
    $removeButton.classList.add("cart-button-remove");
    let $minus = document.createTextNode("-");
    $removeButton.appendChild($minus);

    let $amountSpan = document.createElement("span");
    let $amountContent = document.createTextNode($item.amount);
    $amountSpan.appendChild($amountContent);

    let $addButton = document.createElement("button");
    $addButton.setAttribute("data-product-id", $item.id);
    $addButton.classList.add("cart-btn");
    $addButton.classList.add("cart-button-add");
    let $plus = document.createTextNode("+");
    $addButton.appendChild($plus);

    $buttonsSection.appendChild($removeButton);
    $buttonsSection.appendChild($amountSpan);
    $buttonsSection.appendChild($addButton);

    $productActions.appendChild($buttonsSection);

    let $productPrice = document.createElement("p");
    $productPrice.setAttribute("data-product-id", $item.id);
    $productPrice.classList.add("cart-product-price");

    let $productPriceSpan = document.createElement("span");
    let $productPriceSpanContent = document.createTextNode("" + $item.amount * $item.price);
    $productPriceSpan.appendChild($productPriceSpanContent);

    let $currencyContent = document.createTextNode("$");

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
    let $itemKey = findItem($id);
    let $cart = getCart();

    if($itemKey !== null)
    {
        $cart.items[$itemKey].amount += 1;
        saveCart($cart);
        computeCartTotal();
        renderCart();
    }
}

// get the item key in the cart.items array
function findItem($id)
{
    let $cart = getCart();

    for(var i = 0; i < $cart.items.length; i++)
    {
        if($cart.items[i].id === parseInt($id))
        {
            return i;
        }
    }

    return null;
}

// update the total price of the cart
function computeCartTotal()
{
    let $cart = getCart();
    let $price = 0;

    for(var i = 0; i < $cart.items.length; i++)
    {
        $price += ($cart.items[i].price * $cart.items[i].amount);
    }

    $cart.totalPrice = $price;
    saveCart($cart);
}


// update the item amount to - 1
function removeItem(event)
{
    let $id = event.target.getAttribute("data-product-id");
    let $itemKey = findItem($id);
    let $cart = getCart();

    if($itemKey !== null)
    {
        $cart.items[$itemKey].amount -= 1;
        saveCart($cart);
        computeCartTotal();
        renderCart();
    }

}
export { initCart };