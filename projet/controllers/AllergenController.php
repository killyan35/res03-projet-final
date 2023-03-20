<?php
class AllergenController extends AbstractController {
    private AllergenManager $manager;
    
    public function __construct()
    {
        $this->manager = new AllergenManager();
    }
    
    public function displayAllergens()
        {
            $Allergens = $this->manager->findAllAllergens();
            $this->render("allergen", $Allergens);
        }
    
    public function createAllergen(array $post)
        {
            if (isset($post["formName"]))
            {
                 if (isset($post['name']) && $post['name']!=='') 
                 {
                     $allergenToAdd = new Allergen(null, $post["name"]);
                     $this->manager->insertAllergen($allergenToAdd);
                     header("Location: /res03-projet-final/projet/admin/allergen");
                 }
            }
        }
        
    public function EditAllergen(array $post, string $name)
        { 
            if (isset($post["formName"]))
            {
                 if (isset($post['name']) && $post['name']!=='')
                 {
                     $allergenToChange = $this->manager->getAllergenBySlug($name);
                     $allergenToChange->setName($post['name']);
                     $this->manager->editAllergen($allergenToChange);
                     header("Location: /res03-projet-final/projet/admin/allergen");
                 }
            }
        }
        
    public function displayUpdateFormAllergen(string $name)
        {
            $allergens = $this->manager->getAllergenBySlug($name);
            $tab = [];
            $tab["allergen"]= $allergens;
            $this->render("edit-allergen", $tab);
        }
        
    public function deleteAllergen(string $name)
        {
            
            $delete = $this->manager->getAllergenBySlug($name);
            $id = $delete->getId();
            $deleteallerg = $this->manager->deleteOneAllergenInAllProduct(intval($id));
            $this->manager->deleteAllergen($delete);
            header("Location: /res03-projet-final/projet/admin/allergen");
        }
}

?>