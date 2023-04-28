window.addEventListener("DOMContentLoaded", (event) => {
function searchProduct() 
{
  // Declare variables
 let input = document.getElementById('search');
 let UserSearch = input.value;

 let ul = document.getElementById("UlProduct");
 let li = document.getElementsByClassName("li");

 if (UserSearch === "") 
 {
   for (let i = 0; i < li.length; i++) 
   {
      li[i].classList.add("hidden");
      li[i].classList.remove("active");
    }
 } 
 else 
 {
    for (let i = 0; i < li.length; i++) {
      let result = li[i].getAttribute("name");
      if (result.startsWith(UserSearch)) {
        li[i].classList.add("active");
        li[i].classList.remove("hidden");
      } 
      else 
      {
        li[i].classList.add("hidden");
        li[i].classList.remove("active");
      }
    }
  }
}
});