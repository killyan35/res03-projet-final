import { addtopanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { displayPanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { addfavorite } from "/res03-projet-final/projet/assets/js/favorite.js";
window.addEventListener("DOMContentLoaded", (event) => {
displayPanier();

let button = document.getElementById("add-to-cart");
button.addEventListener("click", addtopanier);
    
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