<?php
class CategoryController extends AbstractController {
    private CategoryManager $manager;
    
    public function __construct()
    {
        $this->manager = new CategoryManager();
    }
        public function createCategory(array $post)
        {
            
            if (!empty($post))
            {
                 if ($post['NomCategorie']!=='') 
                 {
                     $categoryToAdd = new Category($post["NomCategorie"]);
                     $this->manager->insertCategory($categoryToAdd);
                 }
            }
            $this->render("register-category", []);
        }
        public function displayAllCategory()
        {
            
        }
        
        
}
?>