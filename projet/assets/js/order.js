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
    
    let form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "panier/formulaire-de-commande");
    form.setAttribute("id", "createCommande");
    
    //rue de l'adresse de facturation
    let fieldset1 = document.createElement("fieldset");
    let label1 = document.createElement("label");
    label1.setAttribute("for", "street");
    let input1 = document.createElement("input");
    input1.setAttribute("type", "string");
    input1.setAttribute("name", "street");
    input1.setAttribute("id", "street");
    let street = document.createTextNode("Rue ou Avenue");
    label1.appendChild(street);
    
    //numero de l'adresse de facturation
    let fieldset2 = document.createElement("fieldset");
    let label2 = document.createElement("label");
    label2.setAttribute("for", "number");
    let input2 = document.createElement("input");
    input2.setAttribute("type", "text");
    input2.setAttribute("name", "number");
    input2.setAttribute("id", "number");
    let number = document.createTextNode("Numéro");
    label2.appendChild(number);
    
    //ville de l'adresse de facturation
    let fieldset3 = document.createElement("fieldset");
    let label3 = document.createElement("label");
    label3.setAttribute("for", "city");
    let input3 = document.createElement("input");
    input3.setAttribute("type", "string");
    input3.setAttribute("name", "city");
    input3.setAttribute("id", "city");
    let city = document.createTextNode("Ville");
    label3.appendChild(city);
    
    //Zipcod de l'adresse de facturation
    let fieldset4 = document.createElement("fieldset");
    let label4 = document.createElement("label");
    label4.setAttribute("for", "zipcod");
    let input4 = document.createElement("input");
    input4.setAttribute("type", "text");
    input4.setAttribute("name", "zipcod");
    input4.setAttribute("id", "zipcod");
    let zipcod = document.createTextNode("Code postal");
    label4.appendChild(zipcod);
    
    // je récupere le montant total de la commande
    let fieldset5 = document.createElement("fieldset");
    fieldset5.setAttribute("class", "hidden");
    let TotalpriceOrder = document.getElementById("cart-total-price");
    console.log(TotalpriceOrder);
    let price = TotalpriceOrder.getAttribute("data-price");
    console.log(price);
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
    let fieldset6 = document.createElement("fieldset");
    fieldset6.setAttribute("class", "hidden");
    let userId = document.getElementById("userId");
    let Id = userId.getAttribute("data-user");
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
    input8.setAttribute("class", "submit");
    
    
    //Injection de tout les label dans le form
    fieldset1.appendChild(label1);
    fieldset1.appendChild(input1);
    
    fieldset2.appendChild(label2);
    fieldset2.appendChild(input2);
    
    fieldset3.appendChild(label3);
    fieldset3.appendChild(input3);
    
    fieldset4.appendChild(label4);
    fieldset4.appendChild(input4);
    
    fieldset5.appendChild(label5);
    fieldset5.appendChild(input5);
    
    fieldset6.appendChild(label6);
    fieldset6.appendChild(input6);
    
    form.appendChild(fieldset1);
    form.appendChild(fieldset2);
    form.appendChild(fieldset3);
    form.appendChild(fieldset4);
    form.appendChild(fieldset5);
    form.appendChild(fieldset6);
    
    form.appendChild(input7);
    form.appendChild(input8);
    
    section.appendChild(form);
    
   
    // je rend mon prix non modifiable par l'utilisateur
    let readonly = document.getElementById('totalprice');
    readonly.readOnly = true ; 
    
    
    let readonly2 = document.getElementById('Userid');
    readonly2.readOnly = true ;
    
    return section;
}


export { renderform };