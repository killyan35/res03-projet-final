function addfavorite(event)
{
        let id = event.target.getAttribute("data-id");
        
            fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/addfavorite/"+id);
       
}
function removefavorite(event)
{
        let id = event.target.getAttribute("data-id");
        
            fetch("https://kilyangerard.sites.3wa.io/res03-projet-final/projet/deletefavorite/"+id);
       
}