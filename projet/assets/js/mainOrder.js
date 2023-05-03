// Importation de deux modules cart.js et order.js
import { displayPanier } from "/res03-projet-final/projet/assets/js/cart.js";
import { renderform } from "/res03-projet-final/projet/assets/js/order.js";

window.addEventListener("DOMContentLoaded", (event) => {
  
  // Appel de la fonction displayPanier pour afficher le panier
  displayPanier();
  
  // Récupération du bouton "commander"
  let btn = document.getElementById("order");
  
  // Ajout d'un écouteur d'événements sur le bouton "commander"
  btn.addEventListener("click", function() {
    
    // Appel de la fonction renderform qui va afficher le formulaire de commande
    renderform();
    
  }, {once : true}); // L'option {once : true} permet de n'exécuter l'événement qu'une seule fois
});