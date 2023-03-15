<?php
class IngredientController extends AbstractController {
    private IngredientManager $manager;
    
    public function __construct()
    {
        $this->manager = new IngredientManager();
    }
    
    public function displayIngredients()
        {
            $Ingredients = $this->manager->findAllIngredients();
            $this->render("ingredient", $Ingredients);
        }
    
    public function createIngredient(array $post)
        {
            if (isset($post["formName"]))
            {
                 if (isset($post['name']) && $post['name']!=='') 
                 {
                     $ingredientToAdd = new Ingredient(null, $post["name"]);
                     $this->manager->insertIngredient($ingredientToAdd);
                     header("Location: /res03-projet-final/projet/admin/ingredient");
                 }
            }
        }
        
    public function EditIngredient(array $post, string $name)
        { 
            if (isset($post["formName"]))
            {
                 if (isset($post['name']) && $post['name']!=='')
                 {
                     $ingredientToChange = $this->manager->getIngredientByName($name);
                     $ingredientToChange->setName($post['name']);
                     $this->manager->editIngredient($ingredientToChange);
                 }
            }
        }
        
    public function displayUpdateFormIngredient(string $name)
        {
            $ingredients = $this->manager->getIngredientByName($name);
            $tab = [];
            $tab["ingredient"]=$ingredients;
            $this->render("edit-ingredient", $tab);
        }
}

?>