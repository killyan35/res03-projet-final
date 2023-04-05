import { addtopanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { displayPanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { addfavorite } from "/res03-projet-final/projet/assets/js/favorite.js";
import { removefavorite } from "/res03-projet-final/projet/assets/js/favorite.js";
window.addEventListener("DOMContentLoaded", (event) => {


displayPanier();

let button = document.getElementById("add-to-cart");
button.addEventListener("click", addtopanier);
    
let favoritebtnadd = document.getElementById("add-to-favorite");
favoritebtnadd.addEventListener("click", addfavorite);

let favoritebtnremove = document.getElementById("remove-to-favorite");
favoritebtnremove.addEventListener("click", removefavorite);      
});