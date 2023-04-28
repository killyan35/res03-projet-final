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
                displayPanier();
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
        li.setAttribute("class", "liArticle");
        li.appendChild(createcartItem(item)); // append them
        newUl.appendChild(li);
    }
    let TotalPrice = TotalPrices(data);
    cartList.appendChild(newUl);
    // update cart total price
    let totalPrice = document.getElementById("cart-total-price");
    totalPrice.innerText = "Total : " + TotalPrice + " €";
    totalPrice.setAttribute("price", TotalPrice);
    loadListeners()
}

// create one cart item to be injected in the html
function createcartItem(item)
{
    if(item.number !== 0)
    {
        let containerSection = document.createElement("article");
        containerSection.setAttribute("id", item.id);
        let number = item.number;
    
        // creating the cart title
        let cartName = document.createElement("h3");
        let cartNameContent = document.createTextNode(item.number + "  " + item.name + " " + item.size + "p");
        cartName.appendChild(cartNameContent);
    
        containerSection.appendChild(cartName);
    
        // creating the figure and img
        let figure = document.createElement("figure");
        let img = document.createElement("img");
        img.setAttribute("alt", "image du produit " + item.name);
        img.setAttribute("src", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/" + item.url);
        figure.appendChild(img);
        containerSection.appendChild(figure);
    
        // creating the cart actions
        let newbtn = document.createElement("button");
        newbtn.setAttribute("removedata-id", item.id);
        newbtn.setAttribute("removedata-size", item.size);
        newbtn.setAttribute("id", item.id);
        newbtn.classList.add("supp");
        newbtn.classList.add("button");
        let removeitemtext = document.createTextNode("supprimer");
        newbtn.appendChild(removeitemtext);
        
        // bouton -
        let reButton = document.createElement("button");
        reButton.setAttribute("reData-id", item.id);
        reButton.setAttribute("reData-size", item.size);
        reButton.setAttribute("reData-number", item.number);
        reButton.classList.add("cart-btn");
        reButton.classList.add("cart-button-remove");
        let minus = document.createTextNode("-");
        reButton.appendChild(minus);
        
        // quantité du produit
        let amountSpan = document.createElement("span");
        let amountContent = document.createTextNode("   " + item.number + "   ");
        amountSpan.appendChild(amountContent);
    
        // bouton +
        let addButton = document.createElement("button");
        addButton.setAttribute("addData-id", item.id);
        addButton.setAttribute("addData-size", item.size);
        addButton.setAttribute("addData-number", item.number);
        addButton.classList.add("cart-btn");
        addButton.classList.add("cart-button-add");
        let plus = document.createTextNode("+");
        addButton.appendChild(plus);
        
        let buttonsSection = document.createElement("section");
        buttonsSection.classList.add("buttonSection");
        
        buttonsSection.appendChild(reButton);
        buttonsSection.appendChild(amountSpan);
        buttonsSection.appendChild(addButton);
        
        
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
    
        
        containerSection.appendChild(buttonsSection);
        containerSection.appendChild(cartPrice);
        containerSection.appendChild(newbtn);
    
        return containerSection;
    }
    else
    {
        
        let containerSection = document.createElement("section");
        containerSection.setAttribute("class", "hidden");
        remove(item.id, item.size);
        return containerSection;
    }
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
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/removePanier/"+id+"/"+size)
    .then(response => displayPanier());
    
}
function displayPanier()
{
    let aside = document.getElementById("asidePanier");
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/displayPanier")
    .then(response => response.json())
    .then(data => {
    
    console.log(data);
    if(data.length > 0)
    {
        rendercart(data);
        TotalPrices(data);
        aside.classList.remove("hidden");
    }
    else
    {
        aside.classList.add("hidden");
    }
  })
    .catch(error => {
     console.log("catch");
     
  });
    
}

function loadListeners()
{
    let buttons = document.getElementsByClassName("supp");
        for(let i = 0; i < buttons.length; i++)
        {
          buttons[i].addEventListener("click", function(event)
          {
            let removeId = event.target.getAttribute("removedata-id");
            let removeSize = event.target.getAttribute("removedata-size");
            let section = document.getElementById(removeId);
            section.setAttribute("class", "hidden");
            remove(removeId, removeSize);
          });
        }
    
    let addButtons = document.getElementsByClassName("cart-button-add");
    for(let i = 0; i < addButtons.length; i++)
    {
         addButtons[i].addEventListener("click", function(event)
         {
            let addId = event.target.getAttribute("addData-id");
            let addNumber = event.target.getAttribute("addData-number");
            let addSize = event.target.getAttribute("addData-size");
            additem(addId, addNumber, addSize);
          });
    }
    
    let removeButtons = document.getElementsByClassName("cart-button-remove");
    for(let i = 0; i < removeButtons.length; i++)
    {
         removeButtons[i].addEventListener("click", function(event)
         {
            let reId = event.target.getAttribute("reData-id");
            let reNumber = event.target.getAttribute("reData-number");
            let reSize = event.target.getAttribute("reData-size");
            removeItem(reId, reNumber, reSize);
          });
    }
    
}

function additem(id, number, size)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/addItem/"+id+"/"+number+"/"+size)
    .then(response => displayPanier());
    
}
function removeItem(id, number, size)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/removeItem/"+id+"/"+number+"/"+size)
    .then(response => displayPanier());
}



export { remove };
export { displayPanier };
export { addtopanier };