<?php
class ProductController extends AbstractController {
    private ProductManager $manager;
    private CategoryManager $cmanager;
    private IngredientManager $imanager;
    private AllergenManager $amanager;
    
    public function __construct()
    {
        $this->manager = new ProductManager();
        $this->cmanager = new CategoryManager();
        $this->imanager = new IngredientManager();
        $this->amanager = new AllergenManager();
    }
    // getIngredientsBySlugProduct
        public function displayAllProducts()
        {
            $Ingredients = $this->imanager->findAllIngredients();
            $Products = $this->manager->findAllProducts();
            $Allergens = $this->amanager->findAllAllergens();
            $categorys = $this->cmanager->findAllCategory(); 
            $tab = [
                    "products"=>$Products,
                    "categorys"=>$categorys,
                    "ingredients"=>$Ingredients,
                    "allergens"=>$Allergens
                ] ;
            $this->render("product", $tab);
        }
  
        public function createProduct(array $post)
        {
            if (isset($post["formName"]))
            {
                 if (
                     (isset($post['name']) && $post['name']!=='')
                     &&  (isset($post['description']) && $post['description']!=='')
                     &&  (isset($post['price']) && $post['price']!=='')
                     &&  (isset($post['category_id']) && $post['category_id']!=='')
                    ) 
                 {
                     $ProductToAdd = new Product(null, $post["name"],$post["description"], null, floatval($post["price"]), intval($post["category_id"]));
                     $productId= $this->manager->insertProduct($ProductToAdd);
                     $this->manager->addIngredientOnProduct(intval($post['ingredient']),intval($productId));
                     $this->manager->addAllergenOnProduct(intval($post['allergen']),intval($productId));
                     header("Location: /res03-projet-final/projet/admin/product");
                 }
            }
        }
        
         public function displayIngredientInOneProduct(int $Idproduct)
        {
            $product = $this->manager->getProductById($Idproduct);
            $ingredients = $this->imanager->getIngredientsByProductId($Idproduct);
            $Allergens = $this->amanager->getAllergensByProductId($Idproduct); 
            $tab = [
                    "product"=>$product,
                    "ingredients"=>$ingredients,
                    "allergens"=>$Allergens
                ] ;
            $this->render("infoProduct", $tab);
        }
}

?>