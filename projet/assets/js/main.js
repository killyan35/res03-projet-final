import { addtopanier } from "/res03-projet-final/projet/assets/js/cart.js";

window.addEventListener("DOMContentLoaded", (event) => {
let button = document.getElementById("add-to-cart");
button.addEventListener("click", addtopanier);

});