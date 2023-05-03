
window.addEventListener("DOMContentLoaded", (event) => {
  let Allergenselect = document.getElementById("allergens");
  let Ingredientselect = document.getElementById("ingredients");
  let products = document.getElementsByClassName("product");
  let select = document.getElementsByClassName("select");
  let selectedIngredient ="";
  let selectedAllergen="";
  Allergenselect.addEventListener("change", function() 
  {
    selectedAllergen = Allergenselect.value;
  });
  Ingredientselect.addEventListener("change", function() 
  {
    selectedIngredient = Ingredientselect.value;
  });
  for (let i = 0; i < select.length; i++) {
    select[i].addEventListener("change", function() {
  
        for (let i = 0; i < products.length; i++) {
          let resultI = products[i].getAttribute("data-ingredients");
          let resultA = products[i].getAttribute("data-allergens");
          
          if (selectedAllergen !== "" && selectedIngredient === "") 
          {
            if (resultA.includes(selectedAllergen) === true) 
            {
              products[i].classList.add("hidden");
              products[i].classList.remove("active");
            } 
            else 
            {
              products[i].classList.add("active");
              products[i].classList.remove("hidden");
            }
          }
          else if (selectedIngredient !== "" && selectedAllergen === "") 
          {
            if (resultI.includes(selectedIngredient) === true) 
            {
              products[i].classList.add("active");
              products[i].classList.remove("hidden");
            } 
            else 
            {
              products[i].classList.add("hidden");
              products[i].classList.remove("active");
            }
          } 
          else if (selectedIngredient !== "" && selectedAllergen !== "")
          {
            if ((resultA.includes(selectedAllergen) === true) && (resultI.includes(selectedIngredient) === true)) 
              {
                products[i].classList.add("hidden");
                products[i].classList.remove("active");
              } 
              else if ((resultA.includes(selectedAllergen) === true) && (resultI.includes(selectedIngredient) === false))
              {
                products[i].classList.add("hidden");
                products[i].classList.remove("active");
              }
              else if ((resultA.includes(selectedAllergen) === false) && (resultI.includes(selectedIngredient) === true))
              {
                products[i].classList.add("active");
                products[i].classList.remove("hidden");
              }
          }
          else if (selectedIngredient === "" && selectedAllergen === "")
          {
            products[i].classList.remove("hidden");
            products[i].classList.add("active");
          }
        }
      });
  }
  
});