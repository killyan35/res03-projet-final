<?php
class PageController extends AbstractController {
    private ProductManager $pmanager;
    private CategoryManager $cmanager;
    private IngredientManager $imanager;
    private AllergenManager $amanager;
    private ImageManager $immanager;
    private UserManager $umanager;
    public function __construct()
    {
        $this->pmanager = new ProductManager();
        $this->cmanager = new CategoryManager();
        $this->imanager = new IngredientManager();
        $this->amanager = new AllergenManager();
        $this->immanager = new ImageManager();
        $this->umanager = new UserManager();
    }
    public function displayAllCategorys()
        {
            $Categories = $this->cmanager->findAllCategory();
            
            if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
            {
                $user_id = $_SESSION["Connected"][0]["id"];
                $user = $this->umanager->getUserById($user_id);
                $tab = 
                    [
                    $user,
                    "category"=>$Categories,
                    ];
                $this->renderpublic("boutique", $tab);
                 
            }
            else
            {
                $tab = [];
                $tab["category"]=$Categories;
                $this->renderpublic("boutique", $tab);    
            }
            
        }
    public function displayAllProductsByCategory(string $slug)
        {
            
           $category = $this->cmanager->getCategoryBySlug($slug);
           $category_id = $category->getId();
           $Allproduct = $this->pmanager->getAllProductsByCategoryId($category_id);
           $tabIngredient = [];
           $i = 0;
           foreach($Allproduct as $products)
           {
               $productsId = $products->getId();
               $Ingredients = $this->imanager->getIngredientsByProductId($productsId);
               $Allergens= $this->amanager->getAllergensByProductId($productsId);
               $tabIngredient[$i] = [
                        "Ingredients"=>$Ingredients,
                        "Allergens"=>$Allergens,
                        "Product_id"=>$productsId
                   ];  
                $i = $i +1 ;
           }
           
           $image = $this->immanager->findAllImages();
           $Categories = $this->cmanager->findAllCategory();
            if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
            {
                $user_id = $_SESSION["Connected"][0]["id"];
                $user = $this->umanager->getUserById($user_id);
                $tab = 
                    [
                    $user,
                    "categorys"=>$Categories,
                    "category"=>$category,
                    "products"=>$Allproduct,
                    "image"=>$image,
                    "dataProduct"=>$tabIngredient
                    ];
                $this->renderpublic("Allproduct", $tab);
                 
            }
            else
            {
                $tab = [
                    "categorys"=>$Categories,
                    "category"=>$category,
                    "products"=>$Allproduct,
                    "image"=>$image,
                    "dataProduct"=>$tabIngredient
                ];
           $this->renderpublic("Allproduct", $tab);   
            }
           
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
            $Categories = $this->cmanager->findAllCategory();
            
            if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
            {
                $user_id = $_SESSION["Connected"][0]["id"];
                $user = $this->umanager->getUserById($user_id);
                $tab = 
                    [
                    $user,
                    "categorys"=>$Categories,
                    "category"=>$category,
                    "image"=>$image,
                    "product"=>$product,
                    "ingredients"=>$ingredients,
                    "allergens"=>$Allergens
                    ];
                $this->renderpublic("Oneproduct", $tab);
                 
            }
            else
            {
               $tab = [
                    "categorys"=>$Categories,
                    "category"=>$category,
                    "image"=>$image,
                    "product"=>$product,
                    "ingredients"=>$ingredients,
                    "allergens"=>$Allergens
                ] ;
            $this->renderpublic("Oneproduct", $tab);   
            }
            
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
         foreach($_SESSION['cart'] as $key => $item)
        {
            if( ($item["id"] === $productId) && ($item["taille"] === $size) )
            {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
    public function displayPanier()
    {
        $cart = [];
        if(empty($_SESSION['cart']) === false)
        {
            foreach($_SESSION['cart'] as $key => $item)
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
    public function panier()
    {
        $userId = $_SESSION["Connected"][0]["id"];
        $user = $this->umanager->getUserById($userId);
        
        if(isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
        {
            $address_id = $_SESSION["Connected"][0]["address_id"];
            $address = $this->umanager->getUserAdressByAdressId($address_id);
            $user = 
                [
                $user,
                $address
                ];
            $this->renderprive("panier", $user);
        }
        else
        {
            $this->renderprive("panier", [$user]);
        }
    }
    public function addItem(int $productId, int $number, int $size)
    {
        foreach($_SESSION['cart'] as $key => $item)
        {
            if( ($item["id"] === $productId) && ($item["taille"] === $size) )
            {
                $_SESSION['cart'][$key]["quantite"] = $number + 1;
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
    
    public function removeItem(int $productId, int $number, int $size)
    {
        foreach($_SESSION['cart'] as $key => $item)
        { 
            if( ($item["id"] === $productId) && ($item["taille"] === $size) && ($item["quantite"] > 0))
            {
                $_SESSION['cart'][$key]["quantite"] = $number - 1;
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