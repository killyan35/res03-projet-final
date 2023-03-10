<?php
class ProductController extends AbstractController {
    private ProductManager $manager;
    
    public function __construct()
    {
        
        $this->manager = new ProductManager();
    }
  
        public function createProduct(array $post)
        {
            $CM = new CategoryManager();
            
            if (!empty($post))
            {
                 if ($post['name']!=='' && $post["description"]!=='' && $post["price"]!=='' && $post["categoryId"]!=='') 
                 {
                     $ProductToAdd = new Product($products["name"],$products["description"],$products["price"],$products["categoryId"]);
                     $this->manager->insertProduct($ProductToAdd);
                 }
            }
            $Categories=$CM->findAllCategory();
            $this->render("Product", $Categories);
            
        }
        public function displayAllProducts($post)
        {
           
        }
         public function displayOneProduct($post)
        {
            
        }
}

?>