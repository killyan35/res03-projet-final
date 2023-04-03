<?php
class UserController extends AbstractController {
    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
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
                         $address =  $user->getAddress_id();
                         if($address != null)
                         {
                             
                             $tableau = [
                                        "id" => $id,
                                        "email" => $email,
                                        "address_id" => $address
                                    ];
                         } 
                         else
                         {
                            $tableau = [
                                        "id" => $id,
                                        "email" => $email
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
                 $this->manager->insertUser($userToAdd);
                 header ('Location: accueil');
                 ($_SESSION["Connected"]);
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
                 $adressToAdd = new Adress($post["street"],$post["city"], intval($post["number"]), intval($post["zipcod"]));
                 $adressId = $this->manager->insertAdress($adressToAdd);
                 $orderToAdd = new Order(intval($adressId),intval($post['Userid']),floatval($post['totalprice']));
                 $orderId = $this->manager->insertOrder($orderToAdd);
                 $usertoedit = $this->manager->getUserById(intval($post['Userid']));
                 $firstname = $usertoedit->getFirstname();
                 $lastname = $usertoedit->getLastname();
                 $email = $usertoedit->getEmail();
                 $password = $usertoedit->getPassword();
                 $UserToEdit = new User(intval($post['Userid']), $firstname, $lastname, $email, $password, $adressId);
                 $this->manager->addAddressinUser($UserToEdit);
                 foreach($_SESSION['cart'] as $item)
                 {
                    $this->manager->addProductOnOrder(intval($orderId),intval($item["id"]), intval($item["taille"]), intval($item["quantite"]));
                 }
                 header ('Location: /res03-projet-final/projet/mon-compte/panier');
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
    
    public function displayError404()
    {
        $this->renderpublic("error404", []);
    }
    
}
?>