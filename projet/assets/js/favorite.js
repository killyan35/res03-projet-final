// Ajoute un produit aux favoris
function addfavorite(id)
{
    // Envoie une requête fetch à l'URL pour ajouter le produit avec l'ID spécifié aux favoris
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/addfavorite/"+id)
    .then(response => response.json());
}

// Supprime un produit des favoris
function removefavorite(id)
{
    // Envoie une requête fetch à l'URL pour supprimer le produit avec l'ID spécifié des favoris
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/deletefavorite/"+id)
    .then(response => displayfavorite()); // Met à jour l'affichage des favoris
}

// Affiche les produits favoris
function displayfavorite()
{
    // Envoie une requête fetch à l'URL pour récupérer les produits favoris
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/displayFavorite")
    .then(response => response.json()) // Transforme la réponse en JSON
    .then(data => {
        rendercart(data); // Appelle la fonction pour afficher les produits favoris
        loadListeners(); // Charge les listeners pour la suppression des produits favoris
    });
}

// Charge les listeners pour la suppression des produits favoris
function loadListeners()
{
    // Récupère tous les boutons pour supprimer des favoris
    let removeButtons = document.getElementsByClassName("remove-to-favorite");
    for(let i = 0; i < removeButtons.length; i++)
    {
         // Ajoute un listener pour chaque bouton de suppression de favori
         removeButtons[i].addEventListener("click", function(event)
         {
            let id = event.target.getAttribute("data-id"); // Récupère l'ID du produit favori à supprimer
            removefavorite(id); // Appelle la fonction pour supprimer le produit favori
          });
    }
    
}

// Affiche les produits favoris dans le HTML
function rendercart(data) 
{
    // Récupère les produits favoris
    let cart = data;
    // Récupère la liste des favoris dans le HTML
    let cartList = document.getElementById("section");
    let ulToRemove = document.getElementById("ul");
    cartList.removeChild(ulToRemove); // Supprime la liste des favoris existante

    // Crée une nouvelle liste des favoris
    let newUl = document.createElement("ul");
    newUl.setAttribute("id", "ul");
    // Crée un élément pour chaque produit favori
    for(let i = 0; i < cart.length; i++)
    {
        let item = cart[i];
        let li = document.createElement("li");
        li.appendChild(createFavoriteItem(item)); // Ajoute les éléments HTML pour chaque produit
        newUl.appendChild(li);
    }
    cartList.appendChild(newUl); // Ajoute la nouvelle liste de favoris au HTML
    
}

function createFavoriteItem(item) {

    // Créer un élément section qui servira de conteneur pour l'article favori
    let containerSection = document.createElement("section");
    containerSection.setAttribute("id", item.id);
        
    // Créer un titre pour l'article favori en utilisant l'élément h2
    let NomProduits = document.createElement("h2");
    let TextH2 = document.createTextNode(item.name);
    NomProduits.classList.add("cart-cart-info");
    NomProduits.appendChild(TextH2);
    
    // Ajouter le titre à l'élément section créé précédemment
    containerSection.appendChild(NomProduits);
        
    // Créer l'image en utilisant l'élément img et la figure pour la contenir
    let a = document.createElement("a");
    a.setAttribute("href", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/boutique/"+item.catslug+"/"+item.slug);
    let figure = document.createElement("figure");
    let img = document.createElement("img");
    img.setAttribute("alt", "image du produit " + item.name);
    img.setAttribute("src", "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/" + item.url);
    figure.appendChild(img);
    a.appendChild(figure);
    containerSection.appendChild(a);
    
    // Créer le bouton de suppression de l'article en utilisant l'élément button
    let newbtn = document.createElement("button");
    newbtn.setAttribute("data-id", item.id);
    newbtn.setAttribute("class", "remove-to-favorite");
    let removeitemtext = document.createTextNode("supprimer");
    newbtn.appendChild(removeitemtext);
 
    // Ajouter le bouton de suppression à l'élément section
    containerSection.appendChild(newbtn);
    
    // Retourner l'élément section complet pour pouvoir l'afficher dans la page
    return containerSection;
}


export { addfavorite };
export { displayfavorite };
