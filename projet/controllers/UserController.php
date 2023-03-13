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
        
        public function login(array $Post) : void
        {
            if (isset($Post["formName"]))
            {
                if (($Post['email']!=='') && ($Post['password']!=='')) 
                 {
                     if($this->loginUser($Post["email"],$Post["password"])===true)
                     {
                         $_SESSION["Connected"]=true;
                         header ('Location: accueil');
                         var_dump($_SESSION["Connected"]);
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
        
        
        
        
        
        // private function loginUser(string $Email , string $Password):bool 
        // {
        //      $user = $this->manager->getUserByEmail($Email);
    
        //      if($user !== null && $Password === $user->getPassword())
        //      {
        //         return true;   
        //      }
        //      else
        //      {
        //         return false;
        //      }
        // }
        
        // public function login(array $Post) : void
        // {
        //     if (isset($Post["formName"]))
        //     {
        //         if (($Post['email']!=='') && ($Post['password']!=='')) 
        //          {
        //              if($this->loginUser($Post["email"],$Post["password"])===true)
        //              {
        //                  $_SESSION["Connected"]=true;
        //                  header ('Location: accueil');
        //                  var_dump($_SESSION["Connected"]);
        //              }
        //              else
        //              {
        //                  $this->render("connexion", []);
        //              }
        //          }
        //     }
        // }
        
        
        
        
        // public function register(array $post)
        // {
            
        //     if (isset($post["formName"]))
        //     {
        //          if (($post['firstname']!=='' )  &&  ($post['lastname']!=='') && ($post['email']!=='')  &&  ($post['password']!=='')) 
        //          {
        //              $userToAdd = new User($post["firstname"],$post["lastname"],$post["email"],$post["password"]);
        //              $this->manager->insertUser($userToAdd);
        //              $_SESSION["Connected"]=true;
        //              header ('Location: accueil');
        //                  var_dump($_SESSION["Connected"]);
        //          }
        //     }
        // }
}
?>