<?php
class ProductController extends AbstractController {
    private ProductManager $manager;
    
    public function __construct()
    {
        
        $this->manager = new ProductManager();
    }
    
        public function displayAllProducts()
        {
            $Products = $this->manager->findAllProducts();
            $this->render("product", $Products);
        }
  
        public function createProduct(array $post)
        {
            if (isset($post["formName"]))
            {
                var_dump($post);
                
                 if (
                     (isset($post['name']) && $post['name']!=='')
                     &&  (isset($post['description']) && $post['description']!=='')
                     &&  (isset($post['price']) && $post['price']!=='')
                     &&  (isset($post['category_id']) && $post['category_id']!=='')
                    ) 
                 {
                     
                     
                     $ProductToAdd = new Product(null, $post["name"],$post["description"], null, floatval($post["price"]), intval($post["category_id"]));
                     var_dump($ProductToAdd);
                     $this->manager->insertProduct($ProductToAdd);
                     header("Location: /res03-projet-final/projet/admin/product");
                 }
            }
        }
}

?>