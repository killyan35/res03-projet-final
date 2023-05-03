window.addEventListener("DOMContentLoaded", (event) => {
    
let allergenSelect = document.getElementsByClassName('allergen');
for(let i = 0; (allergenSelect = document.getElementsByClassName('allergen')) && (i < allergenSelect.length); i++)
        {
            allergenSelect[i].addEventListener('change', () => {
                
                addSelecteur();
             });
        }
        
let IngredientSelect = document.getElementsByClassName('ingredient');
for(let i = 0; (IngredientSelect = document.getElementsByClassName('ingredient')) && (i < IngredientSelect.length); i++)
        {
            IngredientSelect[i].addEventListener('change', () => {
                
                addIngSelecteur();
             });
        }
});

function addSelecteur()
{
        // Je récupere la section 
        let section = document.getElementById("section-allergen");
        //je créer un nouveau label
        let label = document.createElement("label");
        label.setAttribute("for", "allergen");
        label.innerText = "avec quel allergen ?"
        //je créer un nouveau select
        let select = document.createElement("select");
        select.setAttribute("name", "allergen");
        select.setAttribute("class", "allergen");
        
        //je créer une premiere option vide
        let op = document.createElement("option");
        op.setAttribute("value", "");
        op.setAttribute("class", "op-allergen");
        select.appendChild(op);
        
        //je récupere mes allergen
        let allergenOption = document.getElementsByClassName("data-allergen");

        for(let i = 0; i < allergenOption.length; i++)
                {
                    //je créer une nouvelle option pour chaque allergen recuperée
                    let option = document.createElement("option");
                    option.setAttribute("value", allergenOption[i].value);
                     
                    let optionText = allergenOption[i].textContent;
                    option.innerText= optionText;
                    
                    select.appendChild(option);
                 }
        section.appendChild(label);
        section.appendChild(select);
        
        let allergenSelect = document.getElementsByClassName('allergen');
        for(let i = 0; (allergenSelect = document.getElementsByClassName('allergen')) && (i < allergenSelect.length); i++)
        {
            allergenSelect[i].addEventListener('change', () => {
                
                addSelecteur();
                
             });
        }
        let result = [];
        for(let i = 0;i < allergenSelect.length; i++)
        {
            if(allergenSelect[i].value != "")
            {
               result.push(allergenSelect[i].value);  
            }
        }
        let Data = document.getElementById("allergenData").value = JSON.stringify(result);
}


function addIngSelecteur()
{
        // Je récupere la section 
        let section = document.getElementById("section-ingredient");
        //je créer un nouveau label
        let label = document.createElement("label");
        label.setAttribute("for", "ingredient");
        label.innerText = "avec quel ingredient ?"
        //je créer un nouveau select
        let select = document.createElement("select");
        select.setAttribute("name", "ingredient");
        select.setAttribute("class", "ingredient");
        
        //je créer une premiere option vide
        let op = document.createElement("option");
        op.setAttribute("value", "");
        op.setAttribute("class", "op-ingredient");
        select.appendChild(op);
        
        //je récupere mes ingredient
        let ingredientOption = document.getElementsByClassName("data-ingredient");

        for(let i = 0; i < ingredientOption.length; i++)
                {
                    //je créer une nouvelle option pour chaque ingredient recuperée
                    let option = document.createElement("option");
                    option.setAttribute("value", ingredientOption[i].value);
                     
                    let optionText = ingredientOption[i].textContent;
                    option.innerText= optionText;
                    
                    select.appendChild(option);
                 }
        section.appendChild(label);
        section.appendChild(select);
        
        let ingredientSelect = document.getElementsByClassName('ingredient');
        for(let i = 0; (ingredientSelect = document.getElementsByClassName('ingredient')) && (i < ingredientSelect.length); i++)
        {
            ingredientSelect[i].addEventListener('change', () => {
                
                addIngSelecteur(i);
                
             });
        }
        let result = [];
        for(let i = 0;i < ingredientSelect.length; i++)
        {
            if(ingredientSelect[i].value != "")
            {
               result.push(ingredientSelect[i].value);  
            }
        }
        let Data = document.getElementById("ingredientsData").value = JSON.stringify(result);
}
