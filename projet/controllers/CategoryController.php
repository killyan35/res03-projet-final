<?php
class CategoryController extends AbstractController {
    private CategoryManager $manager;
    
    public function __construct()
    {
        $this->manager = new CategoryManager();
    }
    
        public function createCategory(array $post)
        {
            echo "j'eassaye de créer un truc";
            
            if (isset($post["formName"]))
            {
                 if (($post['name']!=='' )  &&  ($post['url']!=='')) 
                 {
                     $categoryToAdd = new Category($post["name"],$post["url"]);
                     $this->manager->insertCategory($categoryToAdd);
                 }
            }
        }
        public function displayAllCategory()
        {
            $this->manager->findAllCategory();
            
        }
        
        
}
?>