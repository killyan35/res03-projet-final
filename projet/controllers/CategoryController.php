<?php
class CategoryController extends AbstractController {
    private CategoryManager $manager;
    private ProductManager $pmanager;
    private ImageManager $immanager;
    
    public function __construct()
    {
        $this->manager = new CategoryManager();
        $this->pmanager = new ProductManager();
        $this->immanager = new ImageManager();
    }
    
        public function createCategory(array $post)
        {
            if (isset($post["formName"]))
            {
                 if ((isset($post['name']) && $post['name']!=='')) 
                 {
                     $uploader = new Uploader();
                     $media = $uploader->upload($_FILES, "url");
                     $post["url"]=$media->getUrl();
                     
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
            $this->renderadmin("editcat", $tab);
        }
        
        
        public function displayAllCategorys()
        {
            $Categories = $this->manager->findAllCategory();
            $this->renderadmin("category", $Categories);
        }
        
        public function deleteCategory(string $slug)
        {
            $delete = $this->manager->getCategoryBySlug($slug);
            $id = $delete->getId();
            $deleteproducts = $this->manager->getAllProductByCategoryId($id);
            foreach($deleteproducts as $deleteproduct)
            {
                $id = $deleteproduct->getId();
                $deleteing = $this->pmanager->deleteAllergenOnProduct(intval($id));
                $deletealler = $this->pmanager->deleteIngredientOnProduct(intval($id));
                $deleteimg = $this->immanager->getImageById(intval($id));
                $deleteim = $this->immanager->deleteImage($deleteimg);
                $deletep = $this->pmanager->getProductbyId1(intval($id));
                $this->pmanager->deleteProduct($deletep);
            }
            $this->manager->deleteCat($delete);
            header("Location: /res03-projet-final/projet/admin/category");
        }
}
?>