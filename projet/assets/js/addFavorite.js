import { addfavorite } from "/res03-projet-final/projet/assets/js/favorite.js";

window.addEventListener("DOMContentLoaded", (event) => {

// On récupère tous les éléments de la classe "add-to-favorite" 
// et on boucle sur chaque élément pour ajouter un événement "click" 
// qui exécutera la fonction addfavorite avec l'id correspondant
let FavoriteToAdd = document.getElementsByClassName("add-to-favorite");
for(let i = 0; i < FavoriteToAdd.length; i++)
{
    FavoriteToAdd[i].addEventListener("click", function(event)
    {
        let id = event.target.getAttribute("data-id");
        addfavorite(id);
    });
}

});