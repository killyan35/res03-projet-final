import { addfavorite } from "/res03-projet-final/projet/assets/js/favorite.js";
window.addEventListener("DOMContentLoaded", (event) => {
   
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