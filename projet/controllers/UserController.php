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
        if (!isset($_SESSION["Connected"]))
        {
            $this->renderpublic("accueil", []);
        }
        else if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
        {
            $userId = $_SESSION["Connected"][0]["id"];
            $user = $this->manager->getUserById($userId);
            $this->renderprive("accueil", [$user]);
        }
    }
    public function login(array $Post) : void
    {
        if (isset($Post["formName"]))
        {
            if 
            (
                (isset($Post['email']) &&($Post['email']!==''))
            && (isset($Post['password']) &&($Post['password']!==''))
            ) 
             {
                $user = $this->manager->getUserByEmail($Post["email"]);
                
                $mdpClair = password_verify($Post["password"],$user->getPassword());
                
                if($mdpClair===true)
                 {
                     if($user->getRole() === "ADMIN")
                     {
                         $_SESSION["Connected"]=false;
                         $_SESSION["admin"]=true;
                         header("Location: /res03-projet-final/projet/admin");
                     }
                     else if($user->getRole() === "USER")
                     {
                         $_SESSION["Connected"]=[];
                         $id = $user->getId();
                         $email = $user->getEmail();
                         $address = $user->getAddress_id();
                         var_dump($address);
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
                     else
                     {
                         $_SESSION["Connected"]=false;
                         $_SESSION["admin"]=false;
                         $this->renderpublic("accueil", []);
                     }
                
                     
                 }
                 else
                 {
                     $this->renderpublic("register", []);
                     echo "mdp invalide";
                 }
             }
        }
        else
        {
            $this->renderpublic("register", []);
        }
    }
    
    
    
    
    public function register(array $post)
    {
        
        if (isset($post["formName"]))
        {
             if (($post['firstname']!=='' )  &&  ($post['lastname']!=='') && ($post['email']!=='')  &&  ($post['password']!=='')) 
             {
                 $userToAdd = new User(null, $post["firstname"],$post["lastname"],$post["email"],$post["password"]);
                 $id = $this->manager->insertUser($userToAdd);
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
    public function displayAllUsers()
    {
        $users = $this->manager->findAllUser();
        $this->renderadmin("users", $users);
    }
    
    public function deleteUser(string $email)
    {
        $delete = $this->manager->getUserByEmail($email);
        $this->manager->deleteUser($delete);
        header("Location: /res03-projet-final/projet/admin/user");
    }
    
    
    public function displayOneUser(string $email)
    {
        $one = $this->manager->getUserByEmail($email);
        $user = [];
        $user ["user"] = $one;
        $this->renderadmin("user", $user);
    }
    public function CommandeUser(array $post)
    {
        if (isset($post["formName"]))
        {
             if((isset($post['street']) && ($post['street']!=='' ))
             && (isset($post['number']) && ($post['number']!=='' ))
             && (isset($post['city']) && ($post['city']!=='' ))
             && (isset($post['zipcod']) && ($post['zipcod']!=='' ))
             && (isset($post['totalprice']) && ($post['totalprice']!=='' ))
             && (isset($post['Userid']) && ($post['Userid']!=='' ))
             ) 
             {
                 
                 $usertoedit = $this->manager->getUserById(intval($post['Userid']));
                 $addressId = $usertoedit->getAddress_id();
                 if ($addressId === null)
                 {
                     var_dump($addressid);
                     $adressToAdd = new Adress(null, $post["street"],$post["city"], intval($post["number"]), intval($post["zipcod"]));
                     $adressId = $this->manager->insertAdress($adressToAdd);
                     $orderToAdd = new Order(intval($adressId),intval($post['Userid']),floatval($post['totalprice']));
                     $orderId = $this->manager->insertOrder($orderToAdd);
                     $firstname = $usertoedit->getFirstname();
                     $lastname = $usertoedit->getLastname();
                     $email = $usertoedit->getEmail();
                     $password = $usertoedit->getPassword();
                     $UserToEdit = new User(intval($post['Userid']), $firstname, $lastname, $email, $password, $adressId);
                     $this->manager->EditUserWithAddress($UserToEdit);
                     foreach($_SESSION['cart'] as $item)
                     {
                        $this->manager->addProductOnOrder(intval($orderId),intval($item["id"]), intval($item["taille"]), intval($item["quantite"]));
                     }
                     header ('Location: /res03-projet-final/projet/mon-compte/panier');
                 }
                 else 
                 {
                     var_dump($addressId);
                     $AddressToEdit = new Adress(intval($addressId) ,$post["street"],$post["city"],intval($post["number"]),intval($post["zipcod"]));
                     $this->manager->editAdress($AddressToEdit);
                     $orderToAdd = new Order(intval($addressId),intval($post['Userid']),floatval($post['totalprice']));
                     $orderId = $this->manager->insertOrder($orderToAdd);
                     $firstname = $usertoedit->getFirstname();
                     $lastname = $usertoedit->getLastname();
                     $email = $usertoedit->getEmail();
                     $password = $usertoedit->getPassword();
                     $UserToEdit = new User(intval($post['Userid']), $firstname, $lastname, $email, $password, $addressId);
                     $this->manager->EditUserWithAddress($UserToEdit);
                     
                     foreach($_SESSION['cart'] as $item)
                     {
                         var_dump(intval($orderId));
                        var_dump(intval($item["id"]));
                        var_dump(intval($item["taille"]));
                        var_dump(intval($item["quantite"]));
                        $this->manager->addProductOnOrder(intval($orderId),intval($item["id"]),intval($item["taille"]),intval($item["quantite"]));
                        
                     }
                     header ('Location: /res03-projet-final/projet/mon-compte/panier');
                 }
                 
             }
        }
    }
    public function compte()
    {
        if (!isset($_SESSION["Connected"]))
        {
            $this->renderpublic("accueil", []);
        }
        else if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
        {
            $userId = $_SESSION["Connected"][0]["id"];
            $user = $this->manager->getUserById($userId);
            if( isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
            {
                $address_id = $_SESSION["Connected"][0]["address_id"];
                if($address_id != null)
                         {
                            $address = $this->manager->getUserAdressByAdressId($address_id);
                            $user = 
                                [
                                $user,
                                $address
                                ];
                            $this->renderprive("mon-compte", $user);
                         } 
                         else
                         {
                            $this->renderprive("mon-compte", [$user]);
                         }
            }
            else
            {
                $this->renderprive("mon-compte", [$user]);
            }
        }
    }
    public function addAddress($post)
    {
        if (isset($post["formName"]))
        {
             if ( (isset($post['street'])) && ($post['street']!=='' )  
             &&   (isset($post['number'])) && ($post['number']!=='' )  
             &&  (isset($post['city'])) && ($post['city']!=='' )  
             &&  (isset($post['zipcod'])) && ($post['zipcod']!=='' )  
             )
             {
                 if($post['addressid'] === null)
                 {
                     $AddressToAdd = new Adress(null, $post["street"],$post["city"],intval($post["number"]),intval($post["zipcod"]));
                     $addressId = $this->manager->insertAdress($AddressToAdd);
                     $userId = $post['id'];
                     $usertoedit = $this->manager->getUserById(intval($userId));
                     $firstname = $usertoedit->getFirstname();
                     $lastname = $usertoedit->getLastname();
                     $email = $usertoedit->getEmail();
                     $password = $usertoedit->getPassword();
                     $UserToEdit = new User(intval($userId), $firstname, $lastname, $email, $password, intval($addressId));
                     $this->manager->EditUserWithAddress($UserToEdit);
                     
                     header ('Location: /res03-projet-final/projet/mon-compte');
                 }
                 else 
                 {
                     $addressId = $post['addressid'];
                     $AddressToEdit = new Adress(intval($addressId) ,$post["street"],$post["city"],intval($post["number"]),intval($post["zipcod"]));
                     $this->manager->editAdress($AddressToEdit);
                     header ('Location: /res03-projet-final/projet/mon-compte');
                 }
             }
        }
    }
    public function edituser($post)
    {
        if (isset($post["formName"]))
        {
             if ( (isset($post['firstname'])) && ($post['firstname']!=='' )  
             &&   (isset($post['lastname'])) && ($post['lastname']!=='' )  
             &&  (isset($post['email'])) && ($post['email']!=='' )  
             &&  (isset($post['password'])) && ($post['password']!=='' )  
             )
             {
                 $userId = $post['id'];
                 $userAddressId = $post['addressid'];
                 if($userAddressId === null)
                 {
                     $userToEdit = new User(intval($userId), $post["firstname"],$post["lastname"],$post["email"],$post["password"]);
                     $this->manager->editUser($userToEdit);
                     header ('Location: /res03-projet-final/projet/mon-compte');
                 }
                 else
                 {
                     $userToEdit = new User(intval($userId), $post["firstname"],$post["lastname"],$post["email"],$post["password"],intval($userAddressId));
                     $this->manager->EditUserWithAddress($userToEdit);
                     header ('Location: /res03-projet-final/projet/mon-compte');
                 }
             }
        }
    }
    
    public function addfavorite($product_id)
    {
        if($_SESSION["Connected"] != false)
        {
           $user_id = $_SESSION["Connected"][0]["id"];
           $this->manager->addfavorite(intval($user_id), intval($product_id));
        }
        else
        {
            echo "vous devez etre connecter";    
        }
        
    }
    public function deletefavorite($product_id)
    {
        if($_SESSION["Connected"] != false)
        {
           $user_id = $_SESSION["Connected"][0]["id"];
           var_dump($user_id);
           $this->manager->deletefavorite(intval($user_id), intval($product_id));
        }
    }
    public function displayfavorite()
    {
        if($_SESSION["Connected"] != false)
        {
            $user_id = $_SESSION["Connected"][0]["id"];
            $favorites = $this->manager->findAllfavorite(intval($user_id));
            foreach($favorites as $favorite)
            {
                $product = $this->pmanager->getProductById1($favorite["product_id"]);
                $category = $this->cmanager->getCategoryById($product->getCategoryId());
                $image = $this->imanager->getImageById($favorite["product_id"]);
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
                $cart[] = $tab;
            }
        echo json_encode($cart);   
        }
    }    
    public function displayUserFavorite()
    {
        if ((isset($_SESSION["Connected"])) && ($_SESSION["Connected"]!=false))
        {
            $userId = $_SESSION["Connected"][0]["id"];
            $user = $this->manager->getUserById($userId);
            if( isset($_SESSION["Connected"][0]["address_id"]) && $_SESSION["Connected"][0]["address_id"] != null)
            {
                $address_id = $_SESSION["Connected"][0]["address_id"];
                if($address_id != null)
                         {
                            $address = $this->manager->getUserAdressByAdressId($address_id);
                            $user = 
                                [
                                $user,
                                $address
                                ];
                            $this->renderprive("favorite", $user);
                         } 
                         else
                         {
                            $this->renderprive("favorite", [$user]);
                         }
            }
            else
            {
                $this->renderprive("favorite", [$user]);
            }
        }
    }
    public function displayError404()
    {
        $this->renderpublic("error404", []);
    }
    
}
?>