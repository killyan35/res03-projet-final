function addfavorite(id)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/addfavorite/"+id)
    .then(response => response.json());
}
function removefavorite(id)
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/deletefavorite/"+id)
    .then(response => displayfavorite());
}
function displayfavorite()
{
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/displayFavorite")
    .then(response => response.json())
    .then(data => {
        rendercart(data);
        loadListeners();
    });
}
function loadListeners()
{
    let removeButtons = document.getElementsByClassName("remove-to-favorite");
    for(let i = 0; i < removeButtons.length; i++)
    {
         removeButtons[i].addEventListener("click", function(event)
         {
            let id = event.target.getAttribute("data-id");
            console.log(id);
            removefavorite(id);
          });
    }
    
}
// display the cart
function rendercart(data) 
{
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
        li.appendChild(createFavoriteItem(item)); // append them
        newUl.appendChild(li);
    }
    cartList.appendChild(newUl);
    
}

// create one cart item to be injected in the html
function createFavoriteItem(item)
{
    
        let containerSection = document.createElement("section");
        containerSection.setAttribute("id", item.id);
        
        // creating the cart title
        let NomProduits = document.createElement("h2");
        let TextH2 = document.createTextNode(item.name);
        NomProduits.classList.add("cart-cart-info");
        NomProduits.appendChild(TextH2);
    
        containerSection.appendChild(NomProduits);
        
        // creating the figure and img
        let a = document.createElement("a");
        a.setAttribute("href", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/boutique/"+item.catslug+"/"+item.slug);
        let figure = document.createElement("figure");
        let img = document.createElement("img");
        img.setAttribute("alt", "image du produit " + item.name);
        img.setAttribute("src", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/" + item.url);
        figure.appendChild(img);
        a.appendChild(figure);
        containerSection.appendChild(a);
    
        // creating the cart actions
        let newbtn = document.createElement("button");
        newbtn.setAttribute("data-id", item.id);
        newbtn.setAttribute("class", "remove-to-favorite");
        let removeitemtext = document.createTextNode("supprimer");
        newbtn.appendChild(removeitemtext);
 
        containerSection.appendChild(newbtn);
    
        return containerSection;
}

export { addfavorite };
export { displayfavorite };
