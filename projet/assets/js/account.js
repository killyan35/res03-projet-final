window.addEventListener("DOMContentLoaded", (event) => {

let btn = document.getElementById("editform");
let formUser = document.getElementById("edituser");
let formAddress = document.getElementById("createAddress");
btn.addEventListener("click", function() 
{
    formAddress.setAttribute("class", "active");   
    formUser.setAttribute("class", "active");  
});
});