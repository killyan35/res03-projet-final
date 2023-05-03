function searchProduct() 
{
  // Déclaration des variables
 let input = document.getElementById('search'); // Récupère l'élément input qui contient la recherche de l'utilisateur
 let UserSearch = input.value; // Stocke la valeur de la recherche de l'utilisateur

 let li = document.getElementsByClassName("li"); // Récupère tous les éléments li qui contiennent les produits à afficher
 
 if (UserSearch === "") // Si la recherche de l'utilisateur est vide
 {
   for (let i = 0; i < li.length; i++) // Boucle sur tous les éléments li
   {
      li[i].classList.add("hidden"); // Ajoute la classe "hidden" pour cacher l'élément
      li[i].classList.remove("active"); // Retire la classe "active"
    }
 } 
 else // Sinon, si la recherche de l'utilisateur n'est pas vide
 {
    for (let i = 0; i < li.length; i++) { // Boucle sur tous les éléments li
      let result = li[i].getAttribute("data-name"); // Récupère la valeur de l'attribut data-name de l'élément li
      if (result.startsWith(UserSearch)) { // Si le résultat commence par la recherche de l'utilisateur
        li[i].classList.add("active"); // Ajoute la classe "active"
        li[i].classList.remove("hidden"); // Retire la classe "hidden"
      } 
      else // Sinon
      {
        li[i].classList.add("hidden"); // Ajoute la classe "hidden" pour cacher l'élément
        li[i].classList.remove("active"); // Retire la classe "active"
      }
    }
  }
}

window.addEventListener("DOMContentLoaded", (event) => {

let input = document.getElementById('search'); // Récupère l'élément input qui contient la recherche de l'utilisateur
input.addEventListener("keyup", searchProduct); // Ajoute un événement lorsqu'une touche est relâchée dans l'input pour exécuter la fonction searchProduct

});