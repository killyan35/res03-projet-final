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
        
    public function EditIngredient(array $post, string $slug)
        { 
            if (isset($post["formName"]))
            {
                 if (isset($post['name']) && $post['name']!=='')
                 {
                     $ingredientToChange = $this->manager->getIngredientBySlug($slug);
                     $ingredientToChange->setName($post['name']);
                     $this->manager->editIngredient($ingredientToChange);
                     header("Location: /res03-projet-final/projet/admin/ingredient");
                 }
            }
        }
        
    public function displayUpdateFormIngredient(string $slug)
        {
            $ingredients = $this->manager->getIngredientBySlug($slug);
            $tab = [];
            $tab["ingredient"]= $ingredients;
            $this->render("edit-ingredient", $tab);
        }
        
    public function deleteIngredient(string $slug)
        {
            
            $delete = $this->manager->getIngredientBySlug($slug);
            $id = $delete->getId();
            $deleteing = $this->manager->deleteOneIngredientInAllProduct(intval($id));
            $this->manager->deleteIngredient($delete);
            header("Location: /res03-projet-final/projet/admin/ingredient");
        }
}

?>