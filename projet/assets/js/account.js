window.addEventListener("DOMContentLoaded", (event) => {

let btnuser = document.getElementById("editform");
let btnaddress =document.getElementById("editaddress");
let formAddress = document.getElementById("createAddress");
let formUser = document.getElementById("edituser");

btnuser.addEventListener("click", function() { 
  if (formUser.classList.contains("hidden")) 
  {
    formUser.classList.remove("hidden");
    formUser.classList.add("active"); 
        if (formAddress.classList.contains("active")) 
        {
            formAddress.classList.remove("active");
            formAddress.classList.add("hidden"); 
        }
  } 
  else if (formUser.classList.contains("active")) 
  {
    formUser.classList.remove("active");
    formUser.classList.add("hidden"); 
  }
});



btnaddress.addEventListener("click", function() { 
  if (formAddress.classList.contains("hidden")) 
  {
    formAddress.classList.remove("hidden");
    formAddress.classList.add("active"); 
        if (formUser.classList.contains("active")) 
        {
            formUser.classList.remove("active");
            formUser.classList.add("hidden"); 
        }
  } 
  else if (formAddress.classList.contains("active")) 
  {
    formAddress.classList.remove("active");
    formAddress.classList.add("hidden"); 
  }
});

});




