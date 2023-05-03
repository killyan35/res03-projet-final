<?php
class IngredientController extends AbstractController {
    private IngredientManager $manager;
    
    public function __construct()
    {
        $this->manager = new IngredientManager();
    }
    
public function displayIngredients()
{
    // récupère tous les ingrédients
    $Ingredients = $this->manager->findAllIngredients();
    // affiche la vue des ingrédients avec le tableau d'ingrédients récupéré
    $this->renderadmin("ingredient", $Ingredients);
}

public function createIngredient(array $post)
{
    // si le formulaire est soumis
    if (isset($post["formName"]))
    {
         // si le champ nom est rempli
         if (isset($post['name']) && $post['name']!=='') 
         {
             // crée un nouvel ingrédient avec le nom du champ
             $ingredientToAdd = new Ingredient(null, $post["name"]);
             // insère le nouvel ingrédient dans la base de données
             $this->manager->insertIngredient($ingredientToAdd);
             // redirige vers la liste des ingrédients
             header("Location: /res03-projet-final/projet/admin/ingredient");
         }
    }
}

public function EditIngredient(array $post, string $slug)
{ 
    // si le formulaire est soumis
    if (isset($post["formName"]))
    {
         // si le champ nom est rempli
         if (isset($post['name']) && $post['name']!=='')
         {
             // récupère l'ingrédient correspondant au slug dans l'URL
             $ingredientToChange = $this->manager->getIngredientBySlug($slug);
             // modifie le nom de l'ingrédient
             $ingredientToChange->setName($post['name']);
             // met à jour l'ingrédient dans la base de données
             $this->manager->editIngredient($ingredientToChange);
             // redirige vers la liste des ingrédients
             header("Location: /res03-projet-final/projet/admin/ingredient");
         }
    }
}

public function displayUpdateFormIngredient(string $slug)
{
    // récupère l'ingrédient correspondant au slug dans l'URL
    $ingredients = $this->manager->getIngredientBySlug($slug);
    // crée un tableau contenant l'ingrédient récupéré
    $tab = [];
    $tab["ingredient"]= $ingredients;
    // affiche la vue de modification d'ingrédient avec le tableau contenant l'ingrédient
    $this->renderadmin("edit-ingredient", $tab);
}

public function deleteIngredient(string $slug)
{
    // récupère l'ingrédient correspondant au slug dans l'URL
    $delete = $this->manager->getIngredientBySlug($slug);
    // récupère l'ID de l'ingrédient à supprimer
    $id = $delete->getId();
    // supprime l'ingrédient de tous les produits qui le contiennent
    $deleteing = $this->manager->deleteOneIngredientInAllProduct(intval($id));
    // supprime l'ingrédient de la base de données
    $this->manager->deleteIngredient($delete);
    // redirige vers la liste des ingrédients
    header("Location: /res03-projet-final/projet/admin/ingredient");
}

}

?>