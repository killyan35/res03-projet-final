window.addEventListener("DOMContentLoaded", (event) => {
  
  // On récupère les éléments HTML qui contiendront les images du carrousel
  let carrouselIMG1 = document.getElementById("carrousel1");
  let carrouselIMG2 = document.getElementById("carrousel2");
  let carrouselIMG3 = document.getElementById("carrousel3");

  // On récupère les éléments HTML qui contiendront les liens vers les produits correspondant aux images du carrousel
  let carrousellink1 = document.getElementById("Aimg1");
  let carrousellink2 = document.getElementById("Aimg2");
  let carrousellink3 = document.getElementById("Aimg3");

  // Cette fonction va changer les images du carrousel avec des images aléatoires récupérées depuis une API
  function changeWithRandomImage() {
    // On effectue une requête fetch pour récupérer les données depuis l'API
    fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/carrousel")
    .then(response => response.json()) // On transforme la réponse en format JSON
    .then(data => {
      // On choisit des images aléatoires depuis les données récupérées
      let randomIMG1 = random(data);
      let randomIMG2 = random(data);
      let randomIMG3 = random(data);
       
      // On modifie les sources et les descriptions des images du carrousel avec les données des images aléatoires choisies
      carrouselIMG1.src = "/res03-projet-final/projet/"+randomIMG1.url;
      carrouselIMG1.alt = randomIMG1.descriptionIMG;
      carrousellink1.href = "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/boutique/" + randomIMG1.catslug + "/" + randomIMG1.slug;
      carrouselIMG2.src = "/res03-projet-final/projet/"+randomIMG2.url;
      carrouselIMG2.alt = randomIMG2.descriptionIMG;
      carrousellink2.href = "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/boutique/" + randomIMG2.catslug + "/" + randomIMG2.slug;
      carrouselIMG3.src = "/res03-projet-final/projet/"+randomIMG3.url;
      carrouselIMG3.alt = randomIMG3.descriptionIMG;
      carrousellink3.href = "https://kilyangerard.sites.3wa.io/res03-projet-final/projet/boutique/" + randomIMG3.catslug + "/" + randomIMG3.slug;
    });   
  }
  
  // Cette fonction va retourner une image aléatoire depuis un tableau de données d'images
  function random(data){
    let images = data;
    let randomIndex = Math.floor(Math.random() * images.length);
    return images[randomIndex];
  }

  // On appelle la fonction "changeWithRandomImage" pour initialiser les images du carrousel avec des images aléatoires
  changeWithRandomImage();

  // On utilise la méthode "setInterval" pour appeler la fonction "changeWithRandomImage" toutes les 4 secondes (4000 millisecondes)
  setInterval(changeWithRandomImage, 4000);
});