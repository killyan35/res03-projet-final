// Attente du chargement complet de la page
window.addEventListener("DOMContentLoaded", (event) => {
  
  // Récupération des éléments HTML nécessaires
  let Allergenselect = document.getElementById("allergens"); // Sélecteur pour les allergènes
  let Ingredientselect = document.getElementById("ingredients"); // Sélecteur pour les ingrédients
  let products = document.getElementsByClassName("product"); // Tableau contenant tous les produits
  let select = document.getElementsByClassName("select"); // Tableau contenant tous les sélecteurs
  
  // Initialisation des variables qui stockent les valeurs sélectionnées pour les allergènes et les ingrédients
  let selectedIngredient ="";
  let selectedAllergen="";
  
  // Écouteur d'événement pour la sélection d'un allergène
  Allergenselect.addEventListener("change", function() 
  {
    selectedAllergen = Allergenselect.value;
  });
  
  // Écouteur d'événement pour la sélection d'un ingrédient
  Ingredientselect.addEventListener("change", function() 
  {
    selectedIngredient = Ingredientselect.value;
  });
  
  // Boucle à travers tous les sélecteurs
  for (let i = 0; i < select.length; i++) {
    
    // Écouteur d'événement pour la sélection d'un produit
    select[i].addEventListener("change", function() {
      
      // Boucle à travers tous les produits
      for (let i = 0; i < products.length; i++) 
      {
        
        // Récupération des valeurs pour les ingrédients et les allergènes pour chaque produit
        let resultI = products[i].getAttribute("data-ingredients");
        let resultA = products[i].getAttribute("data-allergens");
          
        // Si un allergène est sélectionné mais pas d'ingrédient
        if (selectedAllergen !== "" && selectedIngredient === "") 
        {
          // Si le produit contient l'allergène sélectionné
          if (resultA.includes(selectedAllergen) === true) 
          {
            // Le produit est masqué et n'est plus actif
            products[i].classList.add("hidden");
            products[i].classList.remove("active");
          } 
          else 
          {
            // Le produit est actif et n'est plus masqué
            products[i].classList.add("active");
            products[i].classList.remove("hidden");
          }
        }
        // Si un ingrédient est sélectionné mais pas d'allergène
        else if (selectedIngredient !== "" && selectedAllergen === "") 
        {
          // Si le produit contient l'ingrédient sélectionné
          if (resultI.includes(selectedIngredient) === true) 
          {
            // Le produit est actif et n'est plus masqué
            products[i].classList.add("active");
            products[i].classList.remove("hidden");
          } 
          else 
          {
            // Le produit est masqué et n'est plus actif
            products[i].classList.add("hidden");
            products[i].classList.remove("active");
          }
        } 
        // Si un ingrédient et un allergène sont sélectionnés
        else if (selectedIngredient !== "" && selectedAllergen !== "")
        {
          if (resultA.includes(selectedAllergen) === true) // Si l'allergène sélectionné est dans la liste des allergènes du produit
          {
            products[i].classList.add("hidden"); // Ajouter la classe "hidden" pour cacher le produit
            products[i].classList.remove("active"); // Supprimer la classe "active" du produit
          } 
          else // Sinon, si l'allergène sélectionné n'est pas dans la liste des allergènes du produit
          {
            products[i].classList.add("active"); // Ajouter la classe "active" pour afficher le produit
            products[i].classList.remove("hidden"); // Supprimer la classe "hidden" du produit
          }
        }
        else if (selectedIngredient !== "" && selectedAllergen === "") // Si seul un ingrédient est sélectionné
        {
          if (resultI.includes(selectedIngredient) === true) // Si l'ingrédient sélectionné est dans la liste des ingrédients du produit
          {
            products[i].classList.add("active"); // Ajouter la classe "active" pour afficher le produit
            products[i].classList.remove("hidden"); // Supprimer la classe "hidden" du produit
          } 
          else // Sinon, si l'ingrédient sélectionné n'est pas dans la liste des ingrédients du produit
          {
            products[i].classList.add("hidden"); // Ajouter la classe "hidden" pour cacher le produit
            products[i].classList.remove("active"); // Supprimer la classe "active" du produit
          }
        } 
        else if (selectedIngredient !== "" && selectedAllergen !== "") // Si à la fois un ingrédient et un allergène sont sélectionnés
        {
          if ((resultA.includes(selectedAllergen) === true) && (resultI.includes(selectedIngredient) === true)) // Si l'allergène sélectionné est dans la liste des allergènes du produit ET l'ingrédient sélectionné est dans la liste des ingrédients du produit
          {
            products[i].classList.add("hidden"); // Ajouter la classe "hidden" pour cacher le produit
            products[i].classList.remove("active"); // Supprimer la classe "active" du produit
          } 
          else if ((resultA.includes(selectedAllergen) === true) && (resultI.includes(selectedIngredient) === false)) // Sinon, si l'allergène sélectionné est dans la liste des allergènes du produit MAIS l'ingrédient sélectionné n'est pas dans la liste des ingrédients du produit
          {
            products[i].classList.add("hidden"); // Ajouter la classe "hidden" pour cacher le produit
            products[i].classList.remove("active"); // Supprimer la classe "active" du produit
          }
          else if ((resultA.includes(selectedAllergen) === false) && (resultI.includes(selectedIngredient) === true)) // Sinon, si l'allergène sélectionné n'est pas dans la liste des allergènes du produit MAIS l'ingrédient sélectionné est dans la liste des ingrédients du produit
          {
            products[i].classList.add("active"); // Ajouter la classe "active" pour afficher le produit
            products[i].classList.remove("hidden"); // Supprimer la classe "hidden" du produit
          }
        }
        else if (selectedIngredient === "" && selectedAllergen === "") // Sinon, si rien n'est selectionner on affiche tous
        {
          products[i].classList.remove("hidden");// Supprimer la classe "hidden" du produit
          products[i].classList.add("active"); // Ajouter la classe "active" pour afficher le produit
        }
      }
    });
  }
  
});