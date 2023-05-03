<?php
class ProductController extends AbstractController {
    private ProductManager $manager;
    private CategoryManager $cmanager;
    private IngredientManager $imanager;
    private AllergenManager $amanager;
    private ImageManager $immanager;
    private UserManager $umanager;
    public function __construct()
    {
        $this->manager = new ProductManager();
        $this->cmanager = new CategoryManager();
        $this->imanager = new IngredientManager();
        $this->amanager = new AllergenManager();
        $this->immanager = new ImageManager();
        $this->umanager = new UserManager();
    }
    // getIngredientsBySlugProduct
        public function displayAllProducts()
        {
            $Ingredients = $this->imanager->findAllIngredients();
            $Products = $this->manager->findAllProducts();
            $Allergens = $this->amanager->findAllAllergens();
            $categorys = $this->cmanager->findAllCategory(); 
            $image = $this->immanager->findAllImages(); 
            $tab = [
                    "products"=>$Products,
                    "categorys"=>$categorys,
                    "ingredients"=>$Ingredients,
                    "allergens"=>$Allergens,
                    "image"=>$image
                ] ;
            $this->renderadmin("product", $tab);
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
                     &&  (isset($post['descriptionimg']) && $post['descriptionimg']!=='')
                    ) 
                 {
                     $ProductToAdd = new Product(null, $post["name"],$post["description"], null, floatval($post["price"]), intval($post["category_id"]));
                     $productId= $this->manager->insertProduct($ProductToAdd);
                     $allergenData = json_decode($_POST['allergenData']);
                     foreach($allergenData as $allergenId)
                     {
                        $this->manager->addAllergenOnProduct(intval($allergenId),intval($productId));
                     }
                     $ingredientData = json_decode($_POST['ingredientsData']);
                     foreach($ingredientData as $ingredientId)
                     {
                        $this->manager->addIngredientOnProduct(intval($ingredientId),intval($productId));
                     }
                     $uploader = new Uploader();
                     $media = $uploader->upload($_FILES, "image");
                     $post["image"]=$media->getUrl();
                     $mediaToAdd = new Image(null, $post["image"],$post["descriptionimg"], intval($productId));
                     $this->immanager->insertImage($mediaToAdd);
                     header("Location: /res03-projet-final/projet/admin/product");
                 }
                 else
                 {
                     header("Location: /res03-projet-final/projet/error404");
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
            $this->renderadmin("infoProduct", $tab);
        }
        
    public function EditProduct(array $post, string $prodslug)
        { 
            if (isset($post["formName"]))
            {
                 if ((isset($post['name']) && $post['name']!=='')
                 &&  (isset($post['description']) && $post['description']!=='')
                 &&  (isset($post['price']) && $post['price']!=='')
                 ) 
                 {
                     $productToChange = $this->manager->getProductBySlug($prodslug);
                     $productToChange->setName($post['name']);
                     $productToChange->setDescription($post['description']);
                     $productToChange->setPrice($post['price']);
                     $productId = $productToChange->getId();
                     $allergenData = json_decode($_POST['allergenData']);
                     if((isset($allergenData) && $allergenData!==''))
                     {
                         foreach($allergenData as $allergenId)
                         {
                            $this->manager->addAllergenOnProduct(intval($allergenId),intval($productId));
                         }
                     }
                     $ingredientData = json_decode($_POST['ingredientsData']);
                     if((isset($ingredientData) && $ingredientData!==''))
                     {
                        foreach($ingredientData as $ingredientId)
                         {
                            $this->manager->addIngredientOnProduct(intval($ingredientId),intval($productId));
                         }
                     }
                     $this->manager->editProduct($productToChange);
                 }
                 
                 
            }
        }
        
    public function displayUpdateFormProduct(string $slug)
        {
            $Ingredients = $this->imanager->findAllIngredients();
            $Allergens = $this->amanager->findAllAllergens();
            $Products = $this->manager->getProductBySlug($slug);
            $tab = [
                    "product"=>$Products,
                    "ingredients"=>$Ingredients,
                    "allergens"=>$Allergens
                ] ;
            $this->renderadmin("editproduct", $tab);
        }
        
    public function deleteProduct(int $Product_id)
        {
            $deleteing = $this->manager->deleteAllergenOnProduct(intval($Product_id));
            $deletealler = $this->manager->deleteIngredientOnProduct(intval($Product_id));
            $deleteimg = $this->immanager->getImageById(intval($Product_id));
            $deleteim = $this->immanager->deleteImage($deleteimg);
            $deletefavorite = $this->umanager->deletefavoritefromProductId(intval($Product_id));
            $delete = $this->manager->getProductbyId1(intval($Product_id));
            
            $this->manager->deleteProduct($delete);
            header("Location: /res03-projet-final/projet/admin/product");
        }
}

?>