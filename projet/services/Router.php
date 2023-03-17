<?php

class Router {
    private UserController $uc;
    private CategoryController $cc;
    private ProductController $pc;
    private AdminController $ac;
    private EventController $ec;
    private IngredientController $ic;
    private AllergenController $alc;
    private ImageController $imc;
    public function __construct()
    {
        $this->uc = new UserController();
        $this->cc = new CategoryController();
        $this->pc = new ProductController();
        $this->ac = new AdminController();
        $this->ec = new EventController();
        $this->ic = new IngredientController();
        $this->alc = new AllergenController();
        $this->imc = new ImageController();
    }
    
    function checkRoute() : void
    {
        // je veux vérifier si $_GET["PATH"] existe
        
        // si il existe je veux faire explode pour récupérer les différents éléments de ma route
        
        // ensuite je veux vérifier mes routes
        
        if (!isset($_GET['path'])) {

            echo "marche plus"; // Si pas de route , je redirige sur la homepage
            var_dump($_GET["path"]);
        }

        else {

            $route = explode("/", $_GET['path']); // Je sépare tout ce qui se trouve entre les "/" pour les différentes routes
        
        var_dump($_GET["path"]);
    
        if($route[0] === "boutique")
        {
            if(!isset($route[1])) // j'ai donc juste /boutique
            {
                // c'est la liste des catégories
                echo "boutique";
                $this->uc->displayAllCategorys();
            }
            else if(isset($route[1])  && !isset($route[2])) // j'ai bien /boutique/un-truc mais rien après
            {
                // c'est donc la liste des produits dans une catégorie
                $this->pc->displayAllProducts($route[1]);
                echo "produits";
                // $route[1] = Tarte (par exemple)
                // et le slug de ma catégorie c'est $route[1]
            }
            else // j'ai donc boutique/un-truc/un-autre-truc
            {
                // c'est la page d'un produit précis
                // et le slug de mon produit c'est $route[2]
                // $route[2] = tarte-chocolat (par exemple)
                $this->pc->displayOneProduct($route[2]);
                echo "detail produit";
            }
        }
        if($route[0] === "admin")
        {
            if(!isset($route[1])) // j'ai donc juste /admin
            {
                // on vérifie que c'est bien un admin et on le renvoi vers la user list 
                if(!isset($route[1]) && ($_SESSION["Connected"] === true) && ($_SESSION["admin"] === true))
                {
                    echo "je suis admin";
                    $this->uc->admin();
                    
                }
                else
                {
                    $this->uc->login($_POST);
                }
            }
            else if(isset($route[1]) && !isset($route[2])) // j'ai donc /admin/ un-truc
            {
                if ($route[1] === "user")
                { 
                    // c'est donc la liste des user 
                    $this->uc->displayAllUsers();
                }
                else if ($route[1] === "category")
                {
                    // c'est donc la liste des category 
                    $this->cc->displayAllCategorys();
                }
                else if ($route[1] === "product")
                {
                    // c'est donc la liste des product 
                    $this->pc->displayAllProducts();
                }
                else if ($route[1] === "ingredient")
                {
                    // c'est donc la liste des product 
                    $this->ic->displayIngredients();
                }
                else if ($route[1] === "allergen")
                {
                    // c'est donc la liste des product 
                    $this->alc->displayAllergens();
                }
                else if ($route[1] === "image")
                {
                    // c'est donc la liste des product 
                    $this->imc->displayAllImage();
                }
                else if ($route[1] === "events")
                {
                    // c'est donc la liste des product 
                    $this->ac->displayAllEvents();
                }
            }
             else if(isset($route[1]) && isset($route[2]))  // j'ai donc admin/un-truc/un-autre-truc
            {
                if ($route[1] === "user")
                { 
                    if ($route[2] === "delete")
                    {
                        if(isset($route[3]))
                        {
                            $this->uc->deleteUser($route[3]);
                        }
                    }
                    else if ($route[2] === "info")
                    {
                        if(isset($route[3]))
                        {
                            $this->uc->displayOneUser($route[3]);
                        }
                    }
                    // else if ($route[2] === "update")
                    // {
                    //     if(isset($route[3]))
                    //     {
                    //         $this->uc->displayUpdateFormUser($route[3]);
                    //         $this->uc->EditUser($_POST, $route[3]);
                    //     }
                    // }
                }
                
                
                else if ($route[1] === "category")
                {
                    if ($route[2] === "delete")
                    {
                        if(isset($route[3]))
                        {
                            $this->cc->deleteCategory($route[3]);
                        }
                    }
                    else if ($route[2] === "create")
                    {
                        $this->cc->createCategory($_POST);
                        header("Location: /res03-projet-final/projet/admin/category");
                    }
                    else if ($route[2] === "update")
                    {
                        if(isset($route[3]))
                        {
                            $this->cc->displayUpdateFormCategory($route[3]);
                            $this->cc->EditCategory($_POST, $route[3]);
                        }
                    }
                }
                else if ($route[1] === "ingredient")
                {
                    if ($route[2] === "delete")
                    {
                        if(isset($route[3]))
                        {
                            $this->ic->deleteIngredient($route[3]);
                        }
                    }
                    else if ($route[2] === "create")
                    {
                        $this->ic->createIngredient($_POST);
                        header("Location: /res03-projet-final/projet/admin/ingredient");
                    }
                    else if ($route[2] === "update")
                    {
                        if(isset($route[3]))
                        {
                            $this->ic->displayUpdateFormIngredient($route[3]);
                            $this->ic->EditIngredient($_POST, $route[3]);
                        }
                    }
                }
                else if ($route[1] === "allergen")
                {
                    if ($route[2] === "delete")
                    {
                        if(isset($route[3]))
                        {
                            $this->alc->deleteAllergen($route[3]);
                        }
                    }
                    else if ($route[2] === "create")
                    {
                        $this->alc->createAllergen($_POST);
                        header("Location: /res03-projet-final/projet/admin/allergen");
                    }
                    else if ($route[2] === "update")
                    {
                        if(isset($route[3]))
                        {
                            $this->alc->displayUpdateFormAllergen($route[3]);
                            $this->alc->EditAllergen($_POST, $route[3]);
                        }
                    }
                }
                else if ($route[1] === "image")
                {
                    if ($route[2] === "delete")
                    {
                        if(isset($route[3]))
                        {
                            $this->imc->deleteImage($route[3]);
                        }
                    }
                    else if ($route[2] === "create")
                    {
                        $this->imc->insertImage($_POST);
                        header("Location: /res03-projet-final/projet/admin/image");
                    }
                }
                else if ($route[1] === "product")
                {
                    if ($route[2] === "delete")
                    {
                        $this->ac->deleteProduct();
                    }
                    else if ($route[2] === "create")
                    {
                        $this->pc->createProduct($_POST);
                    }
                    else if ($route[2] === "update")
                    {
                        $this->ac->updateProduct();
                    }
                    else if ($route[2]=== "info")
                    {
                        if(isset($route[3]))
                        {
                            $this->pc->displayIngredientInOneProduct($route[3]);
                        }
                    }
                }
                else if ($route[1] === "events")
                {
                    if ($route[2] === "delete")
                    {
                        $this->ac->deleteEvent();
                    }
                    else if ($route[2] === "create")
                    {
                        $this->ac->createEvent();
                    }
                    else if ($route[2] === "update")
                    {
                        $this->ac->updateEvent();
                    }
                    
                }
            }
        }
        if($route[0] === "accueil")
        {
            if(!isset($route[1]) && !isset($_SESSION["Connected"])) // j'ai donc juste /accueil
            {
                // j'affiche ma homepage
                echo "je suis pas co";
                $this->uc->home();
            }
            else if(!isset($route[1]) && ($_SESSION["Connected"] === true) && ($_SESSION["admin"] === false))
            {
                echo "je suis co";
                $this->uc->home();
                var_dump($_SESSION["Connected"]);
            }
            
        }
        
        if($route[0] === "connexion")
        {
            if(!isset($route[1])) // j'ai donc juste /connexion
            {
                // j'affiche mon login
                $this->uc->login($_POST);
            }
        }
        if($route[0] === "deconnexion")
        {
            if(!isset($route[1])) // j'ai donc juste /connexion
            {
                // j'affiche mon login
                session_destroy();
                session_start();
                header("Location: /res03-projet-final/projet/accueil");
            }
        }
        if($route[0] === "register")
        {
            if(!isset($route[1])) // j'ai donc juste /connexion
            {
                $this->uc->register($_POST);
            }
        }
        if($route[0] === "evenements")
        {
            if(!isset($route[1])) // j'ai donc juste /evenements
            {
                // j'affiche mes evenements
                $this->ec->displayAllEvents();
                
                if(isset($route[1]) && !isset($route[2])) // j'ai donc /evenements/ un-truc
                {
                    $this->ec->displayEvent($route[1]);
                }    
            }
        }
        if($route[0] === "mon-compte")
        {
            if(!isset($route[1])) // j'ai donc juste /connexion
            {
                // j'affiche mon compte
                $this->uc->displayOneUser();
                
                if(isset($route[1]) && !isset($route[2])) // j'ai donc /mon-compte/ un-truc
                {
                    if ($route[1] === "panier")
                    { 
                        // c'est donc le panier 
                        $this->uc->displayUserPanier();
                    }
                    else if ($route[1] === "favoris")
                    {
                        // c'est donc la liste des favoris 
                        $this->uc->displayUserfavorite();
                    }
                }    
                 else if(isset($route[1]) && isset($route[2]))  // j'ai donc admin/un-truc/un-autre-truc
                {
                    if ($route[1] === "panier")
                    { 
                        if ($route[2] === "formulaire-de-commande")
                        {
                            $this->uc->CommandeUser();
                        }
                    }
                }
            }
        }
        else
        {
            // renvoi erreur 404
        }
    }
  }
}
?>