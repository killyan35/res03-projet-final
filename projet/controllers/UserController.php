<?php
class UserController extends AbstractController {
    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
    }
    
        public function home() 
        {
            $this->renderpublic("accueil", []);
        }
        public function admin() 
        {
            $this->renderadmin("admin", []);
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
                             $_SESSION["Connected"]=true;
                             $_SESSION["admin"]=true;
                             
                             header ('Location: admin');
                             echo "admin";
                         }
                         else if($user->getRole() === "USER")
                         {
                             $_SESSION["Connected"]=true;
                             $_SESSION["admin"]=false;
                             $tab = [
                             "user"=>$user
                             ];
                             $this->renderpublic("accueil", $tab);
                             echo "user";
                         }
                         else
                         {
                             $_SESSION["Connected"]=false;
                             $_SESSION["admin"]=false;
                             $this->renderpublic("accueil", []);
                             echo "user";
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
                     $userToAdd = new User($post["firstname"],$post["lastname"],$post["email"],$post["password"]);
                     $this->manager->insertUser($userToAdd);
                     header ('Location: accueil');
                     var_dump($_SESSION["Connected"]);
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
        public function CommandeUser()
        {
            $order = $this->findOrder();
            $this->render("formulaire-de-commande", $order);
        }
        public function sendOrder(array $post)
        {
            
        }
        public function displayError404()
        {
            $this->renderpublic("error404", []);
        }
        
}
?>