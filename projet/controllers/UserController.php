<?php
class UserController extends AbstractController {
    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
    }
    
        
        public function login(array $Post) : void
        {
            
            if (!empty($Post))
            {
                if (($Post['email2']!=='') && ($Post['password2']!=='')) 
                 {
                     if($this->loginUser($Post["email2"],$Post["password2"])===true)
                     {
                         $_SESSION["Connected"]=true;
                         $this->render("accueil", []);
                     }
                     else 
                     {
                         $this->render("connexion", []);
                     }
                 }
            }
            else
            {
                $this->render("register", []);
            }
        }
        
        
        public function register(array $post)
        {
            
            if (!empty($post))
            {
                 if (($post['firstname']!=='' )  &&  ($post['lastname']!=='') && ($post['email']!=='')  &&  ($post['password']!=='')) 
                 {
                     $userToAdd = new User($post["firstname"],$post["lastname"],$post["email"],$post["password"]);
                     $this->manager->insertUser($userToAdd);
                 }
            }
            $this->render("register", []);
        }
        
        
        
        private function loginUser(string $Email , string $Password):bool 
        {
             $user = $this->manager->getUserByEmail($Email);
    
             if($user !== null && $Password === $user->getPassword())
             {
                return true;   
             }
             else
             {
                return false;
             }
        }
        public function displayCategory()
        {
            $CM = new CategoryManager("kilyangerard_distorsion","3306","db.3wa.io","kilyangerard","e17f39e5cb4de95dba99a2edd6835ab4");
            $SM = new SalonManager("kilyangerard_distorsion","3306","db.3wa.io","kilyangerard","e17f39e5cb4de95dba99a2edd6835ab4");
            $CR = new PostManager("kilyangerard_distorsion","3306","db.3wa.io","kilyangerard","e17f39e5cb4de95dba99a2edd6835ab4");
            $Salons=$SM->findAllSalon();
            $Posts=$CR->findAllPost();
            $Categories=$CM->findAllCategory();
            $tab = [];
            $tab["category"]=$Categories;
            $tab["salon"]=$Salons;
            $tab["post"]=$Posts;
            $this->render("homepage", $tab);
        }
        // public function displaySalon()
        // {
        //     $SM = new SalonManager("kilyangerard_distorsion","3306","db.3wa.io","kilyangerard","e17f39e5cb4de95dba99a2edd6835ab4");
            
        //     $Salons=$SM->findAllSalon();
        //     $this->render("homepage", $Salons);
            
        // }
}
?>