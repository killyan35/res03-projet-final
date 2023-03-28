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
        
     public function addPanier(int $productId, int $number, int $size)
     {
        
        $cart=[];
        $InArray = false;
        $index= -1;
        
        if (!isset($_SESSION['cart']))
        {
            $_SESSION['cart']=[];
        }
        
        foreach($_SESSION['cart'] as $key => $item)
        {
            if(($item["id"] === $productId) && ($item["taille"] === $size))
            {
                $InArray = true;
                $index = $key;
            }
        }
        
        if ($InArray === false) 
        {
            $tableau = [
                    "id" => $productId,
                    "quantite" => $number,
                    "taille" => $size
                ];
            $_SESSION['cart'][]=$tableau;  
        }
        else
        {
            $_SESSION['cart'][$key]["quantite"] += $number;
        }
        
        foreach($_SESSION['cart'] as $item)
        {
            $product = $this->pmanager->getProductById1($item["id"]);
            $image = $this->immanager->getImageById($item["id"]);
            $tab = [
                        "id" => $product->getId(),
                        "name" => $product->getName(),
                        "description" => $product->getDescription(),
                        "slug" => $product->getSlug(),
                        "price" => $product->getPrice(),
                        "url" => $image->getUrl(),
                        "descriptionURL" => $product->getName(),
                        "number" => $item["quantite"],
                        "size" => $item["taille"]
                    ];
            $cart[] = $tab;
        }
        echo json_encode($cart);
    }
    public function removeOnPanier(int $productId, int $size)
    {
         foreach($_SESSION['cart'] as $item)
        {
            if($item["id"] === $productId && $item["taille"] === $size)
            {
                 var_dump($item);
                 $item["id"]="";
               // unset($item);
                 var_dump($item);
                 var_dump($_SESSION['cart']);
            }
        }
       
    }
    
    public function displayPanier()
    {
        foreach($_SESSION['cart'] as $item)
        {
            $product = $this->pmanager->getProductById1($item["id"]);
            $image = $this->immanager->getImageById($item["id"]);
            $tab = [
                        "id" => $product->getId(),
                        "name" => $product->getName(),
                        "description" => $product->getDescription(),
                        "slug" => $product->getSlug(),
                        "price" => $product->getPrice(),
                        "url" => $image->getUrl(),
                        "descriptionURL" => $product->getName(),
                        "number" => $item["quantite"],
                        "size" => $item["taille"]
                    ];
            $cart[] = $tab;
        }
        echo json_encode($cart);
    }
    public function findItem(int $productId, int $size)
    {
        for($i = 0; $i < count($_SESSION["cart"]) ; $i++)
        {
            $item = $_SESSION["cart"][$i];
            if(($item["id"] === $productId) && ($item["taille"] === $size))
            {
                $product = $this->pmanager->getProductById1($item["id"]);
                $image = $this->immanager->getImageById($item["id"]);
                $tab = [
                        "id" => $product->getId(),
                        "name" => $product->getName(),
                        "description" => $product->getDescription(),
                        "slug" => $product->getSlug(),
                        "price" => $product->getPrice(),
                        "url" => $image->getUrl(),
                        "descriptionURL" => $product->getName(),
                        "number" => $item["quantite"],
                        "size" => $item["taille"]
                    ];
            $cart[] = $tab;
            }
        }
        echo json_encode($cart);
    }
}

?>