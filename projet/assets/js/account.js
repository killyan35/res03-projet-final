window.addEventListener("DOMContentLoaded", (event) => {
// On récupere les Element HTML
let btnuser = document.getElementById("editform");
let btnaddress =document.getElementById("editaddress");
let formAddress = document.getElementById("createAddress");
let formUser = document.getElementById("edituser");

btnuser.addEventListener("click", function() { 
    // Vérifier si le formulaire est caché
    if (formUser.classList.contains("hidden")) 
    {
      // Afficher le formulaire et le marquer comme "actif"
      formUser.classList.remove("hidden");
      formUser.classList.add("active"); 
    
      // Vérifier si le formulaire d'adresse est actif et le cacher si nécessaire
      if (formAddress.classList.contains("active")) 
      {
        formAddress.classList.remove("active");
        formAddress.classList.add("hidden"); 
      }
    } 
    // Si le formulaire est actif, le cacher
    else if (formUser.classList.contains("active")) 
    {
      formUser.classList.remove("active");
      formUser.classList.add("hidden"); 
    }
});



btnaddress.addEventListener("click", function() { 
    // Vérifier si le formulaire d'adresse est caché
    if (formAddress.classList.contains("hidden")) 
    {
      // Afficher le formulaire et le marquer comme "actif"
      formAddress.classList.remove("hidden");
      formAddress.classList.add("active"); 
    
      // Vérifier si le formulaire utilisateur est actif et le cacher si nécessaire
      if (formUser.classList.contains("active")) 
      {
        formUser.classList.remove("active");
        formUser.classList.add("hidden"); 
      }
    } 
    // Si le formulaire est actif, le cacher
    else if (formAddress.classList.contains("active")) 
    {
      formAddress.classList.remove("active");
      formAddress.classList.add("hidden"); 
    }
});

});




