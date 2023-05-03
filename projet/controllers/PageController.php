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
    // Récupère toutes les catégories
    $Categories = $this->cmanager->findAllCategory();
    
    // Vérifie si l'utilisateur est connecté
    if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
    {
        // Récupère l'id de l'utilisateur connecté
        $user_id = $_SESSION["Connected"][0]["id"];
        // Récupère les informations de l'utilisateur connecté
        $user = $this->umanager->getUserById($user_id);
        // Tableau de données à afficher dans la vue
        $tab = [
            $user,
            "category"=>$Categories,
        ];
        // Affiche la vue "boutique"
        $this->renderpublic("boutique", $tab);    
    }
    else
    {
        // Tableau de données à afficher dans la vue
        $tab = [
            "category"=>$Categories,
        ];
        // Affiche la vue "boutique"
        $this->renderpublic("boutique", $tab);    
    }
}
public function displayAllProductsByCategory(string $slug)
{
    // Récupère la catégorie correspondant au slug donné en paramètre
    $category = $this->cmanager->getCategoryBySlug($slug);
    // Récupère l'id de la catégorie
    $category_id = $category->getId();
    // Récupère tous les produits de la catégorie
    $Allproduct = $this->pmanager->getAllProductsByCategoryId($category_id);
    // Tableau de données pour stocker les ingrédients et les allergènes de chaque produit
    $tabIngredient = [];
    $i = 0;
    // Parcourt tous les produits
    foreach($Allproduct as $products)
    {
        // Récupère l'id du produit
        $productsId = $products->getId();
        // Récupère les ingrédients du produit
        $Ingredients = $this->imanager->getIngredientsByProductId($productsId);
        // Récupère les allergènes du produit
        $Allergens= $this->amanager->getAllergensByProductId($productsId);
        // Stocke les ingrédients et les allergènes du produit dans le tableau $tabIngredient
        $tabIngredient[$i] = [
            "Ingredients"=>$Ingredients,
            "Allergens"=>$Allergens,
            "Product_id"=>$productsId
        ];  
        $i = $i +1 ;
    }
    
    // Récupère toutes les images
    $image = $this->immanager->findAllImages();
    // Récupère toutes les catégories
    $Categories = $this->cmanager->findAllCategory();
    // Vérifie si l'utilisateur est connecté
    if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
    {
        // Récupère l'id de l'utilisateur connecté
        $user_id = $_SESSION["Connected"][0]["id"];
        // Récupère les informations de l'utilisateur connecté
        $user = $this->umanager->getUserById($user_id);
        // Tableau de données à afficher dans la vue "Allproduct"
        $tab = [
            $user,
            "categorys"=>$Categories,
            "category"=>$category,
            "products"=>$Allproduct,
            "image"=>$image,
            "dataProduct"=>$tabIngredient
        ];
        // Affiche la vue "Allproduct" avec son tableau
        $this->renderpublic("Allproduct", $tab);
         
    }
    else
    {
        // Tableau de données à afficher dans la vue "Allproduct"
        $tab = [
            "categorys"=>$Categories,
            "category"=>$category,
            "products"=>$Allproduct,
            "image"=>$image,
            "dataProduct"=>$tabIngredient
        ];
    // Affiche la vue "Allproduct" avec son tableau
    $this->renderpublic("Allproduct", $tab);   
    }
   
}
public function displayOneProduct(string $slug)
{
    // Récupérer le produit associé au slug fourni en paramètre
    $product = $this->pmanager->getProductBySlug($slug);
    
    // Récupérer l'id et l'id de la catégorie du produit
    $Idproduct = $product->getId();
    $categoryId = $product->getCategoryId();
    
    // Récupérer la catégorie associée à l'id de la catégorie
    $category = $this->cmanager->getCategoryById($categoryId);
    
    // Récupérer toutes les images associées au produit
    $image = $this->immanager->findAllImagesInOneProduct($Idproduct);
    
    // Récupérer tous les ingrédients associés au produit
    $ingredients = $this->imanager->getIngredientsByProductId($Idproduct);
    
    // Récupérer tous les allergènes associés au produit
    $Allergens = $this->amanager->getAllergensByProductId($Idproduct); 
    
    // Récupérer toutes les catégories
    $Categories = $this->cmanager->findAllCategory();
    
    // Si un utilisateur est connecté, afficher la page du produit avec les informations de l'utilisateur
    if(isset($_SESSION["Connected"]) && $_SESSION["Connected"] != false)
    {
        // Récupérer l'id de l'utilisateur connecté
        $user_id = $_SESSION["Connected"][0]["id"];
        
        // Récupérer l'utilisateur associé à l'id
        $user = $this->umanager->getUserById($user_id);
        
        // Créer un tableau avec toutes les informations nécessaires pour afficher la page du produit
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
    // Si aucun utilisateur n'est connecté, afficher la page du produit sans les informations de l'utilisateur
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
    $cart=[]; // Initialisation du tableau $cart
    $InArray = false; // Initialisation de la variable $InArray à false
    $index= -1; // Initialisation de la variable $index à -1

    // Si la variable $_SESSION['cart'] n'existe pas, on la crée
    if (!isset($_SESSION['cart']))
    {
        $_SESSION['cart']=[];
    }

    // Boucle pour vérifier si le produit est déjà dans le panier
    foreach($_SESSION['cart'] as $key => $item)
    {
        if(($item["id"] === $productId) && ($item["taille"] === $size))
        {
            $InArray = true; // Si le produit est déjà dans le panier, on met $InArray à true
            $index = $key; // On sauvegarde l'index du produit dans le panier
        }
    }

    // Si le produit n'est pas dans le panier, on l'ajoute
    if ($InArray === false) 
    {
        $tableau = [
                "id" => $productId,
                "quantite" => $number,
                "taille" => $size
            ];
        $_SESSION['cart'][]=$tableau;  // On ajoute le produit au panier
    }
    else // Si le produit est déjà dans le panier, on met à jour la quantité
    {
        $_SESSION['cart'][$key]["quantite"] += $number;
    }

    // Boucle pour récupérer les informations de chaque produit dans le panier
    foreach($_SESSION['cart'] as $item)
    {
        $product = $this->pmanager->getProductById1($item["id"]); // Récupération des informations du produit
        $image = $this->immanager->getImageById($item["id"]); // Récupération de l'image du produit
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
        $cart[] = $tab; // Ajout des informations du produit dans le tableau $cart
    }
    echo json_encode($cart); // Affichage du tableau $cart en format JSON
}
    public function removeOnPanier(int $productId, int $size)
    {
        // Parcourt les éléments du panier en session
        foreach($_SESSION['cart'] as $key => $item)
        {
            // Vérifie si l'élément actuel correspond au produit et à la taille recherchés
            if( ($item["id"] === $productId) && ($item["taille"] === $size) )
            {
                // Supprime l'élément du panier en session correspondant au produit et à la taille recherchés
                unset($_SESSION['cart'][$key]);
            }
        }
    }

    public function displayPanier()
    {
        $cart = [];

        // Vérifie si le panier en session est vide
        if(empty($_SESSION['cart']) === false)
        {
            // Parcourt les éléments du panier en session
            foreach($_SESSION['cart'] as $key => $item)
            {
                // Récupère le produit et l'image correspondants à l'élément actuel du panier en session
                $product = $this->pmanager->getProductById1($item["id"]);
                $image = $this->immanager->getImageById($item["id"]);

                // Crée un tableau représentant l'élément actuel du panier en session, avec toutes ses informations nécessaires
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

                // Ajoute le tableau représentant l'élément actuel du panier en session au tableau général représentant le panier
                $cart[] = $tab;
            }
        }

        // Convertit le tableau représentant le panier en JSON et l'affiche
        echo json_encode($cart);
    }

public function panier()
{
    $userId = $_SESSION["Connected"][0]["id"];
    $user = $this->umanager->getUserById($userId);
    
    // Vérifie si l'utilisateur a une adresse enregistrée
    if(isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
    {
        // Si oui, récupère l'adresse de l'utilisateur
        $address_id = $_SESSION["Connected"][0]["address_id"];
        $address = $this->umanager->getUserAdressByAdressId($address_id);
        // Combiner l'utilisateur et l'adresse dans un tableau pour l'affichage
        $user = [$user, $address];
        $this->renderprive("panier", $user);
    }
    else
    {
        // Si non, affiche uniquement les informations de l'utilisateur
        $this->renderprive("panier", [$user]);
    }
}

public function addItem(int $productId, int $number, int $size)
{
    foreach($_SESSION['cart'] as $key => $item)
    {
        if( ($item["id"] === $productId) && ($item["taille"] === $size) )
        {
            // Ajoute 1 à la quantité du produit
            $_SESSION['cart'][$key]["quantite"] = $number + 1;
            // Obtient les informations du produit
            $product = $this->pmanager->getProductById1($item["id"]);
            $image = $this->immanager->getImageById($item["id"]);
            // Combine les informations du produit dans un tableau pour l'affichage
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
    // Convertit le panier en JSON et l'affiche
    echo json_encode($cart);
}
public function removeItem(int $productId, int $number, int $size)
{
    // boucle à travers le panier stocké dans la session
    foreach($_SESSION['cart'] as $key => $item)
    { 
        // vérifie si le produit, la taille et la quantité sont les mêmes que ceux passés en paramètre
        if( ($item["id"] === $productId) && ($item["taille"] === $size) && ($item["quantite"] > 0))
        {
            // met à jour la quantité du produit dans le panier
            $_SESSION['cart'][$key]["quantite"] = $number - 1;
            // récupère les informations du produit
            $product = $this->pmanager->getProductById1($item["id"]);
            // récupère l'image associée au produit
            $image = $this->immanager->getImageById($item["id"]);
            // crée un tableau contenant les informations du produit mis à jour
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
            // ajoute le tableau contenant les informations du produit mis à jour à un tableau
            $cart[] = $tab;
        }
    }
    // encode le tableau contenant les informations des produits mis à jour en JSON et l'affiche
    echo json_encode($cart);
}

}

?>