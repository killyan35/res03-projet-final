import { displayPanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { renderform } from "/res03-projet-final/projet/assets/js/order.js";
window.addEventListener("DOMContentLoaded", (event) => {


displayPanier();

let btn = document.getElementById("order");

btn.addEventListener("click", function() 
{
    renderform();
}, {once : true});
    
});