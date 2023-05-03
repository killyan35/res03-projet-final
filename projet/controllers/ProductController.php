<?php
class ProductController extends AbstractController {
    private ProductManager $manager;
    private CategoryManager $cmanager;
    private IngredientManager $imanager;
    private AllergenManager $amanager;
    private ImageManager $immanager;
    private UserManager $umanager;
    public function __construct()
    {
        $this->manager = new ProductManager();
        $this->cmanager = new CategoryManager();
        $this->imanager = new IngredientManager();
        $this->amanager = new AllergenManager();
        $this->immanager = new ImageManager();
        $this->umanager = new UserManager();
    }
    
public function displayAllProducts()
{
    // récupère tous les ingrédients, produits, allergènes, catégories et images pour les afficher dans la vue des produits
    $Ingredients = $this->imanager->findAllIngredients();
    $Products = $this->manager->findAllProducts();
    $Allergens = $this->amanager->findAllAllergens();
    $categorys = $this->cmanager->findAllCategory(); 
    $image = $this->immanager->findAllImages(); 
    // stocke les données dans un tableau
    $tab = [
            "products"=>$Products,
            "categorys"=>$categorys,
            "ingredients"=>$Ingredients,
            "allergens"=>$Allergens,
            "image"=>$image
        ] ;
    // affiche la vue des produits
    $this->renderadmin("product", $tab);
}

public function createProduct(array $post)
{
    // vérifie si le formulaire a été soumis
    if (isset($post["formName"]))
    {
         // vérifie si les champs obligatoires sont remplis
         if (
             (isset($post['name']) && $post['name']!=='')
             &&  (isset($post['description']) && $post['description']!=='')
             &&  (isset($post['price']) && $post['price']!=='')
             &&  (isset($post['category_id']) && $post['category_id']!=='')
             &&  (isset($post['descriptionimg']) && $post['descriptionimg']!=='')
            ) 
         {
             // crée un nouvel objet produit avec les données envoyées dans le formulaire
             $ProductToAdd = new Product(null, $post["name"],$post["description"], null, floatval($post["price"]), intval($post["category_id"]));
             // insère le nouveau produit dans la base de données et récupère son ID
             $productId= $this->manager->insertProduct($ProductToAdd);
             // récupère les données des allergènes sélectionnés dans le formulaire et les ajoute au produit
             $allergenData = json_decode($_POST['allergenData']);
             foreach($allergenData as $allergenId)
             {
                $this->manager->addAllergenOnProduct(intval($allergenId),intval($productId));
             }
             // récupère les données des ingrédients sélectionnés dans le formulaire et les ajoute au produit
             $ingredientData = json_decode($_POST['ingredientsData']);
             foreach($ingredientData as $ingredientId)
             {
                $this->manager->addIngredientOnProduct(intval($ingredientId),intval($productId));
             }
             // télécharge l'image envoyée dans le formulaire et l'ajoute au produit
             $uploader = new Uploader();
             $media = $uploader->upload($_FILES, "image");
             $post["image"]=$media->getUrl();
             $mediaToAdd = new Image(null, $post["image"],$post["descriptionimg"], intval($productId));
             $this->immanager->insertImage($mediaToAdd);
             // redirige l'utilisateur vers la page des produits
             header("Location: /res03-projet-final/projet/admin/product");
         }
         // si les champs obligatoires ne sont pas remplis, redirige l'utilisateur vers la page d'erreur
         else
         {
             header("Location: /res03-projet-final/projet/error404");
         }
    }
}
public function displayIngredientInOneProduct(int $Idproduct)
{
    // Récupération du produit par son ID
    $product = $this->manager->getProductById($Idproduct);
    // Récupération des ingrédients du produit par son ID
    $ingredients = $this->imanager->getIngredientsByProductId($Idproduct);
    // Récupération des allergènes du produit par son ID
    $Allergens = $this->amanager->getAllergensByProductId($Idproduct); 
    // Création d'un tableau contenant le produit, ses ingrédients et ses allergènes
    $tab = [
            "product"=>$product,
            "ingredients"=>$ingredients,
            "allergens"=>$Allergens
        ] ;
    // Affichage de la page "infoProduct" avec le tableau créé précédemment
    $this->renderadmin("infoProduct", $tab);
}

public function EditProduct(array $post, string $prodslug)
{ 
    // Vérification si le formulaire est soumis
    if (isset($post["formName"]))
    {
         // Vérification si tous les champs requis sont remplis
         if ((isset($post['name']) && $post['name']!=='')
         &&  (isset($post['description']) && $post['description']!=='')
         &&  (isset($post['price']) && $post['price']!=='')
         ) 
         {
             // Récupération du produit à modifier par son slug
             $productToChange = $this->manager->getProductBySlug($prodslug);
             // Modification du nom, de la description et du prix du produit
             $productToChange->setName($post['name']);
             $productToChange->setDescription($post['description']);
             $productToChange->setPrice($post['price']);
             // Récupération de l'ID du produit
             $productId = $productToChange->getId();
             // Récupération des données sur les allergènes en JSON et ajout des allergènes au produit
             $allergenData = json_decode($_POST['allergenData']);
             if((isset($allergenData) && $allergenData!==''))
             {
                 foreach($allergenData as $allergenId)
                 {
                    $this->manager->addAllergenOnProduct(intval($allergenId),intval($productId));
                 }
             }
             // Récupération des données sur les ingrédients en JSON et ajout des ingrédients au produit
             $ingredientData = json_decode($_POST['ingredientsData']);
             if((isset($ingredientData) && $ingredientData!==''))
             {
                foreach($ingredientData as $ingredientId)
                 {
                    $this->manager->addIngredientOnProduct(intval($ingredientId),intval($productId));
                 }
             }
             // Enregistrement des modifications sur le produit
             $this->manager->editProduct($productToChange);
         }
         
         
    }
} 
public function displayUpdateFormProduct(string $slug)
    {
        //Récupération de tous les ingrédients
        $Ingredients = $this->imanager->findAllIngredients();
        //Récupération de tous les allergènes
        $Allergens = $this->amanager->findAllAllergens();
        //Récupération du produit correspondant au slug passé en paramètre
        $Products = $this->manager->getProductBySlug($slug);
        //Création d'un tableau contenant les données à passer à la vue
        $tab = [
                "product"=>$Products,
                "ingredients"=>$Ingredients,
                "allergens"=>$Allergens
            ] ;
        //Affichage de la vue d'édition de produit avec les données récupérées
        $this->renderadmin("editproduct", $tab);
    }
    
public function deleteProduct(int $Product_id)
    {
        //Suppression des liens entre le produit et ses allergènes
        $deleteing = $this->manager->deleteAllergenOnProduct(intval($Product_id));
        //Suppression des liens entre le produit et ses ingrédients
        $deletealler = $this->manager->deleteIngredientOnProduct(intval($Product_id));
        //Récupération de l'image correspondant au produit
        $deleteimg = $this->immanager->getImageById(intval($Product_id));
        //Suppression de l'image correspondant au produit
        $deleteim = $this->immanager->deleteImage($deleteimg);
        //Suppression des favoris correspondant au produit
        $deletefavorite = $this->umanager->deletefavoritefromProductId(intval($Product_id));
        //Récupération du produit à supprimer
        $delete = $this->manager->getProductbyId1(intval($Product_id));
        //Suppression du produit
        $this->manager->deleteProduct($delete);
        //Redirection vers la liste des produits après suppression
        header("Location: /res03-projet-final/projet/admin/product");
    }

}

?>