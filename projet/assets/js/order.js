// afficher le formulaire de commande
function renderform(event) {
    
    // Je récupere la section 
    let section = document.getElementById("sec");
    
    // je rajoute un titre a mon formulaire
    let h2 = document.createElement("h2");
    let texth2 = document.createTextNode("Adresse de Facturation");
    h2.appendChild(texth2);
    section.appendChild(h2);
    // création du form
    let fieldset = document.createElement("fieldset");
    let form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "panier/formulaire-de-commande");
    form.setAttribute("id", "createCommande");
    
    //rue de l'adresse de facturation
    let label1 = document.createElement("label");
    label1.setAttribute("for", "street");
    let input1 = document.createElement("input");
    input1.setAttribute("type", "string");
    input1.setAttribute("name", "street");
    input1.setAttribute("id", "street");
    let street = document.createTextNode("Rue ou Avenue");
    label1.appendChild(street);
    
    //numero de l'adresse de facturation
    let label2 = document.createElement("label");
    label2.setAttribute("for", "number");
    let input2 = document.createElement("input");
    input2.setAttribute("type", "text");
    input2.setAttribute("name", "number");
    input2.setAttribute("id", "number");
    let number = document.createTextNode("Numéro");
    label2.appendChild(number);
    
    //ville de l'adresse de facturation
    let label3 = document.createElement("label");
    label3.setAttribute("for", "city");
    let input3 = document.createElement("input");
    input3.setAttribute("type", "string");
    input3.setAttribute("name", "city");
    input3.setAttribute("id", "city");
    let city = document.createTextNode("Ville");
    label3.appendChild(city);
    
    //Zipcod de l'adresse de facturation
    let label4 = document.createElement("label");
    label4.setAttribute("for", "zipcod");
    let input4 = document.createElement("input");
    input4.setAttribute("type", "text");
    input4.setAttribute("name", "zipcod");
    input4.setAttribute("id", "zipcod");
    let zipcod = document.createTextNode("Code postal");
    label4.appendChild(zipcod);
    
    // je récupere le montant total de la commande
    let TotalpriceOrder = document.getElementById("cart-total-price");
    let price = TotalpriceOrder.getAttribute("price");
    // je créer son input pour le récuperer plus tard
    let label5 = document.createElement("label");
    label5.setAttribute("for", "totalprice");
    label5.setAttribute("class", "hidden");
    let input5 = document.createElement("input");
    input5.setAttribute("type", "text");
    input5.setAttribute("name", "totalprice");
    input5.setAttribute("id", "totalprice");
    input5.setAttribute("value", price);
    input5.setAttribute("class", "hidden");
    label5.innerText = "Montant de la commande en €";
    
    // je récupere l'id de l'utilisateur
    let userId = document.getElementById("userId");
    let Id = userId.getAttribute("idus");
    // je créer son input pour le récuperer plus tard
    let label6 = document.createElement("label");
    label6.setAttribute("for", "Userid");
    label6.setAttribute("class", "hidden");
    let input6 = document.createElement("input");
    input6.setAttribute("type", "text");
    input6.setAttribute("name", "Userid");
    input6.setAttribute("id", "Userid");
    input6.setAttribute("value", Id);
    input6.setAttribute("class", "hidden");
    input6.innerText = Id;
    label6.innerText = "id";
    
    // je créer le submit
    let input7 = document.createElement("input");
    input7.setAttribute("type", "hidden");
    input7.setAttribute("name", "formName");
    input7.setAttribute("value", "createCommande");
    let input8 = document.createElement("input");
    input8.setAttribute("type", "submit");
    input8.setAttribute("value", "Envoyer");
    
    
    //Injection de tout les label dans le form
    form.appendChild(label1);
    form.appendChild(input1);
    
    form.appendChild(label2);
    form.appendChild(input2);
    
    form.appendChild(label3);
    form.appendChild(input3);
    
    form.appendChild(label4);
    form.appendChild(input4);
    
    form.appendChild(label5);
    form.appendChild(input5);
    
    form.appendChild(label6);
    form.appendChild(input6);
    
    form.appendChild(input7);
    form.appendChild(input8);
    
    fieldset.appendChild(form);
    section.appendChild(fieldset);
    
   
    // je rend mon prix non modifiable par l'utilisateur
    let readonly = document.getElementById('totalprice');
    readonly.readOnly = true ; 
    
    
    let readonly2 = document.getElementById('Userid');
    readonly2.readOnly = true ;
    
    return section;
}


export { renderform };