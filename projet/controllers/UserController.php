<?php
class UserController extends AbstractController {
    private UserManager $manager;
    private ProductManager $pmanager;
    private ImageManager $imanager;
    private CategoryManager $cmanager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
        $this->pmanager = new ProductManager();
        $this->imanager = new ImageManager();
        $this->cmanager = new CategoryManager();
    }
    public function admin() 
    {
        $this->renderadmin("admin", []);
    }
    
public function home()
{
    // Trouver tous les produits enregistrés
    $products = $this->pmanager->findAllProducts();
    // Trouver toutes les catégories enregistrées
    $categorys = $this->cmanager->findAllCategory();
    // Trouver toutes les images enregistrées
    $img = $this->imanager->findAllImages();
    // Vérifier si la session "Connected" est définie ou non
    if (!isset($_SESSION["Connected"]))
    {
        // Si l'utilisateur n'est pas connecté, passer les données suivantes à la vue publique
        $tab = [
            "image" => $img,
            "products"=>$products, 
            "categorys" => $categorys
        ];
        // Appeler la méthode 'renderpublic' pour afficher la vue publique avec les données passées
        $this->renderpublic("accueil", $tab);
    }
    else if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
    {
        // Si l'utilisateur est connecté, trouver son id
        $userId = $_SESSION["Connected"][0]["id"];
        // Trouver les détails de l'utilisateur à partir de son id
        $user = $this->manager->getUserById($userId);
        
        // Passer les données suivantes à la vue privée
        $tab = [
            $user ,
            "image" => $img,
            "products" => $products,
            "categorys" => $categorys
        ];
        // Appeler la méthode 'renderprive' pour afficher la vue privée avec les données passées
        $this->renderprive("accueil", $tab);
    }
    
}

public function carrousel()
{
    // Trouver toutes les images enregistrées
    $imgs = $this->imanager->findAllImages();
    // Initialiser un tableau vide pour stocker les données du carrousel
    $Carrousels = [];
    // Parcourir chaque image
    foreach($imgs as $img)
    {
        // Trouver l'identifiant du produit associé à l'image
        $product_id= $img->getProduct_id();
        // Trouver les détails du produit associé à l'image
        $product = $this->pmanager->getProductById1($product_id);
        // Trouver l'identifiant de la catégorie associée au produit
        $catID = $product->getCategoryId();
        // Trouver les détails de la catégorie associée au produit
        $cat = $this->cmanager->getCategoryById($catID);
        
        // Récupérer le slug de la catégorie
        $catSlug = $cat->getSlug();
        // Récupérer le slug du produit
        $slug= $product->getSlug();
        // Récupérer la description de l'image
        $descriptionImg= $img->getDescription();
        // Récupérer l'URL de l'image
        $url= $img->getUrl();
        
        // Stocker les données du carrousel dans un tableau associatif
        $Carrousel=[
            "slug" => $slug,
            "catslug" => $catSlug,
            "url" => $url,
            "descriptionIMG" => $descriptionImg
        ];
        // Ajouter le tableau associatif au tableau de tous les carrousels
        array_push($Carrousels, $Carrousel);
    }
         
        echo json_encode($Carrousels);
}

public function login(array $post) : void
{
    // Vérification si le formulaire est soumis
    if (isset($post["formName"]))
    {
        // Vérification des champs de formulaire "email" et "password"
        if (
            (isset($post['email']) &&($post['email']!==''))
            && (isset($post['password']) &&($post['password']!==''))
        ) 
        {
            // On sécurise ce que l'utilisateur a envoyé
            $UserEmail = $this->cleanInput($post['email']);
            $UserPassword = $this->cleanInput($post['password']);
            // Récupération de l'utilisateur associé à l'email entré
            $user = $this->manager->getUserByEmail($UserEmail);
            if($user != null)
            {
                // Vérification si le mot de passe entré correspond au mot de passe hashé de l'utilisateur
                $mdpClair = password_verify($UserPassword,$user->getPassword());
                
                if($mdpClair===true)
                {
                    // Si le mot de passe est correct, vérification si l'utilisateur est un administrateur
                    if($user->getRole() === "ADMIN")
                    {
                        // Si c'est un administrateur, la variable de session "admin" est initialisée à true et l'utilisateur est redirigé vers la page d'administration
                        $_SESSION["admin"]=true;
                        header("Location: /res03-projet-final/projet/admin");
                    }
                    // Sinon, c'est un utilisateur standard
                    else if($user->getRole() === "USER")
                    {
                        // Initialisation de la variable de session "Connected" à un tableau vide et ajout des informations de l'utilisateur à ce tableau
                        $_SESSION["Connected"]=[];
                        $id = $user->getId();
                        $email = $user->getEmail();
                        $address = $user->getAddress_id();
                        if($address === null)
                        {
                            $tableau = [
                                "id" => $id,
                                "email" => $email
                            ];
                        }
                        else
                        {
                             
                            $tableau = [
                                "id" => $id,
                                "email" => $email,
                                "address_id" => $address
                            ];
                        } 
                        $_SESSION['Connected'][]=$tableau;
                        
                        // Initialisation de la variable de session "admin" à false et redirection de l'utilisateur vers la page d'accueil
                        $_SESSION["admin"]=false;
                        $tab = [
                            "user"=>$user
                        ];
                        header("Location: /res03-projet-final/projet/accueil");
                    }
                    // Si le rôle de l'utilisateur est inconnu, la variable de session "Connected" est initialisée à false et l'utilisateur est redirigé vers la page d'accueil
                    else
                    {
                        $_SESSION["Connected"]=false;
                        $_SESSION["admin"]=false;
                        $this->renderpublic("accueil", []);
                    }
                }
                // Si le mot de passe est incorrect, l'utilisateur est redirigé vers la page d'inscription avec un message d'erreur
                else
                {
                    $this->renderpublic("register", []);
                }
            }
            else{
                $this->renderpublic("register", []);
            }
            
        }
    }
    // Si le formulaire n'est pas soumis, l'utilisateur est redirigé vers la page d'inscription
    else
    {
        $this->renderpublic("register", []);
    }
}
  
    
    
    
public function register(array $post)
{
        
    // Vérifie si le formulaire a été soumis
    if (isset($post["formName"]))
    {
        // Vérifie si les champs obligatoires sont remplis
        if((isset($post['firstname']) && ($post['firstname']!==''))
        && (isset($post['lastname']) && ($post['lastname']!==''))
        && (isset($post['email']) && ($post['email']!==''))
        && (isset($post['password']) && ($post['password']!==''))
        )
        {
            // On sécurise ce que l'utilisateur a envoyé
            $UserFirstname = $this->cleanInput($post['firstname']);
            $UserLastname = $this->cleanInput($post['lastname']);
            $UserEmail = $this->cleanInput($post['email']);
            $UserPassword = $this->cleanInput($post['password']);
            
            // Crée un nouvel utilisateur à partir des informations saisies dans le formulaire
            $userToAdd = new User(null, $UserFirstname,$UserLastname,$UserEmail,$UserPassword);
            // Insère le nouvel utilisateur dans la base de données
            $id = $this->manager->insertUser($userToAdd);
            
            // Initialise la session utilisateur et redirige vers la page d'accueil
            $_SESSION["Connected"]=[];
            $user = $this->manager->getUserById($id);
            $email = $user->getEmail();
            $address = $user->getAddress_id();
            if($address === null)
            {
                $tableau = [
                            "id" => $id,
                            "email" => $email
                        ];
            }
            else
            {
                $tableau = [
                            "id" => $id,
                            "email" => $email,
                            "address_id" => $address
                        ];
            } 
            
            $_SESSION['Connected'][]=$tableau;
            
            $_SESSION["admin"]=false;
            $tab = [
            "user"=>$user
            ];
            header("Location: /res03-projet-final/projet/accueil");
        }
    }
}

// Fonction pour afficher tous les utilisateurs
public function displayAllUsers()
{
    // Récupère tous les utilisateurs avec la méthode findAllUser du manager
    $users = $this->manager->findAllUser();
    
    // Utilise la méthode renderadmin pour afficher la vue "users" avec les données récupérées
    $this->renderadmin("users", $users);
}

// Fonction pour supprimer un utilisateur par son adresse email
public function deleteUser(string $email)
{
    // Récupère l'utilisateur à supprimer avec la méthode getUserByEmail du manager
    $delete = $this->manager->getUserByEmail($email);
    
    // Utilise la méthode deleteUser du manager pour supprimer l'utilisateur
    $this->manager->deleteUser($delete);
    
    // Redirige l'utilisateur vers la page d'affichage des utilisateurs
    header("Location: /res03-projet-final/projet/admin/user");
}

public function CommandeUser(array $post)
{
    if (isset($post["formName"]))
    {
        // Vérification de la présence des informations requises pour passer une commande utilisateur
        if((isset($post['street']) && ($post['street']!==''))
        && (isset($post['number']) && ($post['number']!==''))
        && (isset($post['city']) && ($post['city']!==''))
        && (isset($post['zipcod']) && ($post['zipcod']!==''))
        && (isset($post['totalprice']) && ($post['totalprice']!==''))
        && (isset($post['Userid']) && ($post['Userid']!==''))
        )
        {
            // On sécurise ce que l'utilisateur a envoyé
            $UserStreet = $this->cleanInput($post['street']);
            $UserNumber = $this->cleanInput($post['number']);
            $UserCity = $this->cleanInput($post['city']);
            $UserZipcod = $this->cleanInput($post['zipcod']);
            $UserTotalprice = $this->cleanInput($post['totalprice']);
            $Userid = $this->cleanInput($post['Userid']);
            
            // Récupération de l'utilisateur à partir de son ID
            $userId = intval($Userid);
            $usertoedit = $this->manager->getUserById($userId);
            $addressId = $usertoedit->getAddress_id();
            
            // Si l'utilisateur n'a pas d'adresse enregistrée, ajout de l'adresse et création de la commande correspondante
            if ($addressId === null)
            {
                $adressToAdd = new Adress(null, $UserStreet, $UserCity, intval($UserNumber), intval($UserZipcod));
                $adressId = $this->manager->insertAdress($adressToAdd);
                $orderToAdd = new Order(intval($adressId),intval($Userid),floatval($UserTotalprice));
                $orderId = $this->manager->insertOrder($orderToAdd);
                $this->manager->AddAddressOnUser(intval($Userid), intval($adressId));
                
                // Ajout des produits du panier à la commande
                foreach($_SESSION['cart'] as $item)
                {
                    $this->manager->addProductOnOrder(intval($orderId),intval($item["id"]), intval($item["taille"]), intval($item["quantite"]));
                }
                $email = $usertoedit->getEmail();
                $tableau = [
                            "id" => $userId,
                            "email" => $email,
                            "address_id" => $adressId
                        ];
                $_SESSION['Connected'][]=$tableau;
                // Vidage du panier et redirection vers l'historique des commandes
                $_SESSION['cart']=[];
                header ('Location: /res03-projet-final/projet/mon-compte/mes-commandes');
            }
            // Si l'utilisateur a déjà une adresse enregistrée, modification de cette adresse et création de la commande correspondante
            else
            {
                $AddressToEdit = new Adress(intval($addressId),$UserStreet,$UserCity,intval($UserNumber),intval($UserZipcod));
                $this->manager->editAdress($AddressToEdit);
                $orderToAdd = new Order(intval($addressId),intval($Userid),floatval($UserTotalprice));
                $orderId = $this->manager->insertOrder($orderToAdd);
                $this->manager->AddAddressOnUser(intval($Userid), intval($addressId));
                
                    // Ajout des produits du panier à la commande
                    foreach($_SESSION['cart'] as $item)
                    {
                        // Ajoute chaque produit du panier dans la commande
                        $this->manager->addProductOnOrder(intval($orderId),intval($item["id"]),intval($item["taille"]),intval($item["quantite"]));
                    }
                    // Vide le panier en supprimant son contenu de la variable de session
                    $_SESSION['cart']=[];
                    // Redirige l'utilisateur vers l'historique des commandes après que la commande a été passée
                    header ('Location: /res03-projet-final/projet/mon-compte/mes-commandes');
                 }
                 
             }
        }
    }

// Fonction pour afficher la page de compte utilisateur
public function compte()
{
    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION["Connected"]))
    {
        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        header("Location: /res03-projet-final/projet/connexion");    
    }
    else if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
    {
        // Si l'utilisateur est connecté, récupère son identifiant depuis la variable de session
        $userId = $_SESSION["Connected"][0]["id"];
        
        // Récupère les informations de l'utilisateur avec la méthode getUserById du manager
        $user = $this->manager->getUserById($userId);
        
        // Vérifie si l'utilisateur a une adresse associée à son compte
        if( isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
        {
            // Si l'utilisateur a une adresse, récupère les informations de l'adresse avec la méthode getUserAdressByAdressId du manager
            $address_id = $_SESSION["Connected"][0]["address_id"];
            if($address_id != null)
            {
                $address = $this->manager->getUserAdressByAdressId($address_id);
                // Rassemble les informations de l'utilisateur et de l'adresse dans un tableau pour afficher dans la vue
                $user = [
                    $user,
                    $address
                ];
                $this->renderprive("mon-compte", $user);
            } 
            else
            {
                // Si l'utilisateur a une adresse_id mais elle est nulle, affiche seulement les informations de l'utilisateur
                $this->renderprive("mon-compte", [$user]);
            }
        }
        else
        {
            // Si l'utilisateur n'a pas d'adresse associée à son compte, affiche seulement les informations de l'utilisateur
            $this->renderprive("mon-compte", [$user]);
        }
    }
}

// Fonction pour ajouter une adresse à un utilisateur
public function addAddress($post)
{
    // Vérifie si la variable post contient le nom du formulaire
    if (isset($post["formName"]))
    {
        // Vérifie que tous les champs requis sont remplis
        if ( (isset($post['street'])) && ($post['street']!=='' )  
        &&   (isset($post['number'])) && ($post['number']!=='' )  
        &&  (isset($post['city'])) && ($post['city']!=='' )  
        &&  (isset($post['zipcod'])) && ($post['zipcod']!=='' )  
        )
        {
            // Si l'identifiant d'adresse est vide, crée une nouvelle adresse et l'ajoute à l'utilisateur avec la méthode insertAddress du manager
            if($post['addressid'] === "")
            {
                $AddressToAdd = new Adress(null, $post["street"],$post["city"],intval($post["number"]),intval($post["zipcod"]));
                $addressId = $this->manager->insertAdress($AddressToAdd);
                $userId = $post['id'];
                $this->manager->AddAddressOnUser(intval($userId), intval($addressId));
                $user = $this->manager->getUserById(intval($userId));
                $email = $user->getEmail();
                $tableau = [
                            "id" => $userId,
                            "email" => $email,
                            "address_id" => $addressId
                        ];
                $_SESSION['Connected'][]=$tableau;
                // Redirige l'utilisateur vers la page de compte après l'ajout de l'adresse
                header ('Location: /res03-projet-final/projet/mon-compte');
            }
            // Si l'identifiant d'adresse existe déjà, modifie l'adresse existante avec la méthode editAddress du manager
            else 
            {
                $addressId = $post['addressid'];
                $AddressToEdit = new Adress(intval($addressId) ,$post["street"],$post["city"],intval($post["number"]),intval($post["zipcod"]));
                $this->manager->editAdress($AddressToEdit);
                // Redirige l'utilisateur vers la page de compte après la modification de l'adresse
                header ('Location: /res03-projet-final/projet/mon-compte');
            }
        }
    }
}
public function edituser($post)
{
    if (isset($post["formName"])) // Vérifie si le formulaire a été soumis
    {
         if ( (isset($post['firstname'])) && ($post['firstname']!=='' )  
         &&   (isset($post['lastname'])) && ($post['lastname']!=='' )  
         &&  (isset($post['email'])) && ($post['email']!=='' )  
         &&  (isset($post['password'])) && ($post['password']!=='' )  
         ) // Vérifie si toutes les informations obligatoires ont été fournies
         {
            // On sécurise ce que l'utilisateur a envoyé
            $UserFirstname = $this->cleanInput($post['firstname']);
            $UserLastname = $this->cleanInput($post['lastname']);
            $UserEmail = $this->cleanInput($post['email']);
            $UserPassword = $this->cleanInput($post['password']);
            
             $userId = $post['id']; // Récupère l'ID de l'utilisateur à modifier
             $userAddressId = $post['addressid']; // Récupère l'ID de l'adresse de l'utilisateur
             if($userAddressId === null) // Si l'utilisateur n'a pas d'adresse
             {
                 $userToEdit = new User(intval($userId), $UserFirstname,$UserLastname,$UserEmail,$UserPassword); // Crée un objet User avec les données postées
                 $this->manager->editUser($userToEdit); // Modifie les informations de l'utilisateur dans la base de données
                 header ('Location: /res03-projet-final/projet/mon-compte'); // Redirige l'utilisateur vers la page de son compte
             }
             else // Si l'utilisateur a une adresse
             {
                 $userToEdit = new User(intval($userId), $UserFirstname,$UserLastname,$UserEmail,$UserPassword,intval($userAddressId)); // Crée un objet User avec les données postées et l'ID de l'adresse
                 $this->manager->EditUserWithAddress($userToEdit); // Modifie les informations de l'utilisateur et de son adresse dans la base de données
                 header ('Location: /res03-projet-final/projet/mon-compte'); // Redirige l'utilisateur vers la page de son compte
             }
         }
    }
}
public function addfavorite($product_id)
{
    // Vérifie si un utilisateur est connecté
    if($_SESSION["Connected"] != false)
    {
       // Récupère l'identifiant de l'utilisateur connecté
       $user_id = $_SESSION["Connected"][0]["id"];
       // Ajoute le produit aux favoris de l'utilisateur
       $this->manager->addfavorite(intval($user_id), intval($product_id));
    }
    else
    {
        // Affiche un message d'erreur si aucun utilisateur n'est connecté
        echo "vous devez etre connecter";    
    }
    
}

public function deletefavorite($product_id)
{
    // Vérifie si un utilisateur est connecté
    if($_SESSION["Connected"] != false)
    {
       // Récupère l'identifiant de l'utilisateur connecté
       $user_id = $_SESSION["Connected"][0]["id"];
       // Supprime le produit des favoris de l'utilisateur
       $this->manager->deletefavorite(intval($user_id), intval($product_id));
    }
    else
    {
        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        header("Location: /res03-projet-final/projet/connexion");
    }
}

public function displayfavorite()
{
    // Vérifie si un utilisateur est connecté
    if($_SESSION["Connected"] != false)
    {
        // Récupère l'identifiant de l'utilisateur connecté
        $user_id = $_SESSION["Connected"][0]["id"];
        // Récupère tous les favoris de l'utilisateur
        $favorites = $this->manager->findAllfavorite(intval($user_id));
        // Boucle à travers chaque favori pour récupérer les détails du produit correspondant
        foreach($favorites as $favorite)
        {
            // Récupère le produit correspondant au favori
            $product = $this->pmanager->getProductById1($favorite["product_id"]);
            // Récupère la catégorie correspondant au produit
            $category = $this->cmanager->getCategoryById($product->getCategoryId());
            // Récupère l'image correspondant au produit
            $image = $this->imanager->getImageById($favorite["product_id"]);
            // Crée un tableau contenant les détails du produit
            $tab = [
                        "id" => $product->getId(),
                        "name" => $product->getName(),
                        "description" => $product->getDescription(),
                        "slug" => $product->getSlug(),
                        "price" => $product->getPrice(),
                        "url" => $image->getUrl(),
                        "descriptionURL" => $product->getName(),
                        "catslug" => $category->getSlug()
                    ];
            // Ajoute le tableau au panier
            $cart[] = $tab;
        }
        // Retourne le panier au format JSON
        echo json_encode($cart);   
    }
    else
    {
        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        header("Location: /res03-projet-final/projet/connexion");
    }
}
// Cette fonction affiche la page des favoris d'un utilisateur connecté
public function displayUserFavorite()
{
    // Vérifier que l'utilisateur est connecté
    if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
    {
        // Récupérer l'id de l'utilisateur connecté
        $userId = $_SESSION["Connected"][0]["id"];

        // Récupérer l'utilisateur grâce à son id
        $user = $this->manager->getUserById($userId);

        // Vérifier si l'utilisateur a une adresse de livraison enregistrée
        if( isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
        {
            // Récupérer l'id de l'adresse de livraison de l'utilisateur
            $address_id = $_SESSION["Connected"][0]["address_id"];

            // Vérifier si l'id de l'adresse est non nul
            if($address_id != null)
            {
                // Récupérer l'adresse de livraison de l'utilisateur
                $address = $this->manager->getUserAdressByAdressId($address_id);

                // Stocker l'utilisateur et son adresse dans un tableau
                $user = [
                    $user,
                    $address
                ];

                // Afficher la page des favoris de l'utilisateur avec son adresse de livraison
                $this->renderprive("favorite", $user);
            } 
            else
            {
                // Afficher la page des favoris de l'utilisateur sans son adresse de livraison
                $this->renderprive("favorite", [$user]);
            }
        }
        else
        {
            // Afficher la page des favoris de l'utilisateur sans son adresse de livraison
            $this->renderprive("favorite", [$user]);
        }
    }
    else
    {
        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        header("Location: /res03-projet-final/projet/connexion");
    }
}

// Cette fonction affiche la page des commandes d'un utilisateur connecté
public function displayAllOrders()
{
    // Vérifier que l'utilisateur est connecté
    if($_SESSION["Connected"] != false)
    {
        // Récupérer l'id de l'utilisateur connecté
        $user_id = $_SESSION["Connected"][0]["id"];

        // Récupérer l'utilisateur grâce à son id
        $user = $this->manager->getUserById($user_id);

        // Récupérer l'id de l'adresse de livraison de l'utilisateur
        $address_id = $user->getAddress_id();

        // Récupérer toutes les commandes de l'utilisateur
        $orders = $this->manager->findAllOrdersForOneUser($user_id);

        // Vérifier si l'id de l'adresse est non nul
        if($address_id != null)
        {
            // Récupérer l'adresse de livraison de l'utilisateur
            $address = $this->manager->getUserAdressByAdressId($address_id);

            // Stocker l'utilisateur, son adresse et ses commandes dans un tableau
            $tab = [
                $user,
                $address,
                $orders
            ];

            // Afficher la page des commandes de l'utilisateur avec son adresse de livraison
            $this->renderprive("mes-commandes", $tab);
        } 
    }
    else
    {
        // Si l'utilisateur n'est pas connecté, affiche la page de connexion
        header("Location: /res03-projet-final/projet/connexion");
    }
}

public function displayOneUser(string $email)
{
    // Récupération de l'utilisateur avec l'email donné
    $user = $this->manager->getUserByEmail($email);
    // Récupération de l'id de l'utilisateur
    $user_id = $user->getId();
    // Récupération de l'id de l'adresse de l'utilisateur
    $userAdress_id = $user->getAddress_id();
    // Vérification de la présence d'une adresse pour l'utilisateur
    if( isset($userAdress_id) && $userAdress_id !== null ) 
    {
        // Récupération de l'adresse de l'utilisateur
        $address = $this->manager->getUserAdressByAdressId($userAdress_id);
        // Récupération de toutes les commandes de l'utilisateur
        $orders = $this->manager->findAllOrdersForOneUser($user_id);
        // Vérification de la présence de commandes pour l'utilisateur
        if( isset($orders) && $orders !== null ) 
        {
            // Création d'un tableau contenant les informations de l'utilisateur, son adresse et ses commandes
            $tab = 
                [
                $user,
                $address,
                $orders
                ];
        }
        else
        {
             // Création d'un tableau contenant les informations de l'utilisateur et son adresse
            $tab = 
                [
                $user,
                $address
                ];
        }
    }
    else
    {
        // Création d'un tableau contenant uniquement les informations de l'utilisateur
        $tab = 
                [
                $user
                ];
    }
    // Affichage de la vue "user" avec le tableau créé précédemment
    $this->renderadmin("user", $tab);
}


public function displayError404()
{
    // Affichage de la vue "error404" sans passer de paramètres
    $this->renderpublic("error404", []);
}

    
}
?>