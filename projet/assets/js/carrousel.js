window.addEventListener("DOMContentLoaded", (event) => {

  let carrouselIMG1 = document.getElementById("carrousel1");
  let carrouselIMG2 = document.getElementById("carrousel2");
  let carrouselIMG3 = document.getElementById("carrousel3");

  let carrousellink1 = document.getElementById("Aimg1");
  let carrousellink2 = document.getElementById("Aimg2");
  let carrousellink3 = document.getElementById("Aimg3");

function changeWithRandomImage() {
  fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/carrousel")
  .then(response => response.json())
  .then(data => {
      
       let randomIMG1 = random(data);
       let randomIMG2 = random(data);
       let randomIMG3 = random(data);
       
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
function random(data){
    let images = data;
    let randomIndex = Math.floor(Math.random() * images.length);
    return images[randomIndex];
}
changeWithRandomImage();
  setInterval(changeWithRandomImage, 4000);

});