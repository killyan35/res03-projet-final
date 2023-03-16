<?php
class CategoryController extends AbstractController {
    private CategoryManager $manager;
    
    public function __construct()
    {
        $this->manager = new CategoryManager();
    }
    
        public function createCategory(array $post)
        {
            if (isset($post["formName"]))
            {
                 if ((isset($post['name']) && $post['name']!=='')  &&  (isset($post['url']) && $post['url']!=='')) 
                 {
                     $categoryToAdd = new Category(null, $post["name"],$post["url"], null);
                     $this->manager->insertCategory($categoryToAdd);
                     header("Location: /res03-projet-final/projet/admin/category");
                 }
            }
        }
        public function EditCategory(array $post, string $catslug)
        { 
            if (isset($post["formName"]))
            {
                 if ((isset($post['name']) && $post['name']!=='')  &&  (isset($post['url']) && $post['url']!=='')) 
                 {
                     $categoryToChange = $this->manager->getCategoryBySlug($catslug);
                     $categoryToChange->setName($post['name']);
                     $categoryToChange->setImgURL($post['url']);
                     $this->manager->editCategory($categoryToChange);
                     header("Location: /res03-projet-final/projet/admin/category");
                 }
            }
        }
        
        
        
        public function displayUpdateFormCategory(string $slug)
        {
            $Categories = $this->manager->getCategoryBySlug($slug);
            $tab = [];
            $tab["category"]=$Categories;
            $this->render("editcat", $tab);
        }
        
        
        public function displayAllCategorys()
        {
            $Categories = $this->manager->findAllCategory();
            $this->render("category", $Categories);
        }
        
        public function deleteCategory(string $slug)
        {
            $delete = $this->manager->getCategoryBySlug($slug);
            $this->manager->deleteCat($delete);
            header("Location: /res03-projet-final/projet/admin/category");
        }
}
?>