<?php
class UserController extends AbstractController {
    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
    }
    
        public function home() 
        {
            $this->render("accueil", []);
        }
        public function admin() 
        {
            $this->render("admin", []);
        }
        
        
        public function login(array $Post) : void
        {
            if (isset($Post["formName"]))
            {
                if (($Post['email']!=='') && ($Post['password']!=='')) 
                 {
                    $user = $this->manager->getUserByEmail($Post["email"]);
                    
                    $mdpClair = password_verify($Post["password"],$user->getPassword());
                    
                    if($mdpClair===true)
                     {
                         if($user->getRole() === "ADMIN")
                         {
                             $_SESSION["Connected"]=true;
                             $_SESSION["admin"]=true;
                             
                             header ('Location: admin');
                             echo "admin";
                         }
                         else if($user->getRole() === "USER")
                         {
                             $_SESSION["Connected"]=true;
                             
                             $_SESSION["admin"]=false;
                             header ('Location: accueil');
                             echo "user";
                         }
                    
                         
                     }
                     else
                     {
                         $this->render("register", []);
                         echo "mdp invalide";
                     }
                 }
                 else
            {
                $this->render("register", []);
            }
            }
            else
            {
                $this->render("register", []);
            }
        }
        
        
        
        
        public function register(array $post)
        {
            
            if (isset($post["formName"]))
            {
                 if (($post['firstname']!=='' )  &&  ($post['lastname']!=='') && ($post['email']!=='')  &&  ($post['password']!=='')) 
                 {
                     $userToAdd = new User($post["firstname"],$post["lastname"],$post["email"],$post["password"]);
                     $this->manager->insertUser($userToAdd);
                     header ('Location: accueil');
                     var_dump($_SESSION["Connected"]);
                 }
            }
        }
           
        public function displayAllCategorys()
        {
            $CM = new CategoryManager();
            $Categories=$CM->findAllCategory();
            $tab = [];
            $tab["category"]=$Categories;
            $this->render("boutique", $tab);
        }
        
        
        public function displayAllUsers()
        {
            $users = $this->manager->findAllUser();
            $this->render("users", $users);
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
            $this->render("user", $user);
        }
        
}
?>