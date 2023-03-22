<?php
class PageController extends AbstractController {
    private ProductManager $pmanager;
    private CategoryManager $cmanager;
    private IngredientManager $imanager;
    private AllergenManager $amanager;
    private ImageManager $immanager;
    public function __construct()
    {
        $this->pmanager = new ProductManager();
        $this->cmanager = new CategoryManager();
        $this->imanager = new IngredientManager();
        $this->amanager = new AllergenManager();
        $this->immanager = new ImageManager();
    }
    public function displayAllCategorys()
        {
            $Categories = $this->cmanager->findAllCategory();
            $tab = [];
            $tab["category"]=$Categories;
            $this->renderpublic("boutique", $tab);
        }
    public function displayAllProductsByCategory(string $slug)
        {
           $category = $this->cmanager->getCategoryBySlug($slug);
           $category_id = $category->getId();
           $Allproduct = $this->pmanager->getAllProductsByCategoryId($category_id);
           $image = $this->immanager->findAllImages();
           $tab = [
               "category"=>$category,
               "products"=>$Allproduct,
               "image"=>$image
           ];
           $this->renderpublic("Allproduct", $tab);
        }
    public function displayOneProduct(string $slug)
        {
            $product = $this->pmanager->getProductBySlug($slug);
            $Idproduct = $product->getId();
            $categoryId = $product->getCategoryId();
            $category = $this->cmanager->getCategoryById($categoryId);
            $image = $this->immanager->findAllImagesInOneProduct($Idproduct);
            $ingredients = $this->imanager->getIngredientsByProductId($Idproduct);
            $Allergens = $this->amanager->getAllergensByProductId($Idproduct); 
            $tab = [
                    "category"=>$category,
                    "image"=>$image,
                    "product"=>$product,
                    "ingredients"=>$ingredients,
                    "allergens"=>$Allergens
                ] ;
            $this->renderpublic("Oneproduct", $tab);
        }
        
    public function addPanier(int $poductId){
        // $productManager = new ProductManager();
        // $result = $productManager->getProductById($id);
        // $result2 = $result->test();
        // $_SESSION["cart"][]=$result2;
        // return $data = json_encode($_SESSION["cart"]);
        
        $cart=[];
        $_SESSION['cart'][]=$poductId;
        foreach($_SESSION['cart'] as $id)
        {
            $product = $this->pmanager->getProductById1($id);
            $image = $this->immanager->getImageById($id);
            $tab = [
                        "id" => $product->getId(),
                        "name" => $product->getName(),
                        "description" => $product->getDescription(),
                        "slug"=>$product->getSlug(),
                        "price"=>$product->getPrice(),
                        "url"=>$image->getUrl(),
                        "descriptionURL"=>$product->getName()
                    ];
            $cart[] = $tab;
        }
        echo json_encode($cart);
    }
}

?>