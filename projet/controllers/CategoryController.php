<?php
class CategoryController extends AbstractController {
    private CategoryManager $manager;
    private ProductManager $pmanager;
    private ImageManager $immanager;
    
    public function __construct()
    {
        $this->manager = new CategoryManager();
        $this->pmanager = new ProductManager();
        $this->immanager = new ImageManager();
    }

public function createCategory(array $post)
{
    // Vérifie si le formulaire a été soumis
    if (isset($post["formName"]))
    {
        // Vérifie si le champ nom n'est pas vide
        if ((isset($post['name']) && $post['name']!=='')) 
        {
            // On sécurise ce que l'utilisateur a envoyé
            $catName = $this->cleanInput($post['name']);
            // Création d'un objet Uploader pour gérer le téléchargement des images
            $uploader = new Uploader();
            // Envoie du fichier image avec la clé "url" et stockage de l'objet Media retourné dans $media
            $media = $uploader->upload($_FILES, "url");
            // Ajout de l'URL de l'image dans le tableau de données post
            $post["url"]=$media->getUrl();
            
            // Création d'un objet Category avec les données du formulaire
            $categoryToAdd = new Category(null, $catName,$post["url"], null);
            // Ajout de la nouvelle catégorie à la base de données
            $this->manager->insertCategory($categoryToAdd);
            // Redirection vers la page de gestion des catégories
            header("Location: /res03-projet-final/projet/admin/category");
        }
    }
}

public function EditCategory(array $post, string $catslug)
{ 
    // Vérifie si le formulaire a été soumis
    if (isset($post["formName"]))
    {
        // Vérifie si le champ nom n'est pas vide
        if (isset($post['name']) && $post['name']!=='') 
        {
            // On sécurise ce que l'utilisateur a envoyé
            $catName = $this->cleanInput($post['name']);
            // Récupération de l'objet Category à modifier depuis la base de données
            $categoryToChange = $this->manager->getCategoryBySlug($catslug);
            // Modification du nom de la catégorie
            $categoryToChange->setName($catName);
            // Création d'un objet Uploader pour gérer le téléchargement des images
            $uploader = new Uploader();
            // Envoie du fichier image avec la clé "url" et stockage de l'objet Media retourné dans $media
            $media = $uploader->upload($_FILES, "url");
            
            // Si une nouvelle image a été téléchargée, on la stocke et on modifie l'URL de l'image de la catégorie
            if(isset($media) && $media!=='' && $media!== null)
            {
                $post['url'] = $media->getUrl();
                $categoryToChange->setImgURL($post['url']);
                $this->manager->editCategory($categoryToChange);
            }
            // Sinon, on ne modifie que le nom de la catégorie
            else
            {
                $this->manager->editCategoryNameOnly($categoryToChange);
            }
            
            // Redirection vers la page de gestion des catégories
            header("Location: /res03-projet-final/projet/admin/category");
        }
    }
}
public function displayUpdateFormCategory(string $slug)
{
    // Récupération de la catégorie à partir du slug
    $Categories = $this->manager->getCategoryBySlug($slug);

    // Initialisation d'un tableau contenant la catégorie
    $tab = [];
    $tab["category"]=$Categories;

    // Affichage de la page de mise à jour de la catégorie
    $this->renderadmin("editcat", $tab);
}


public function displayAllCategorys()
{
    // Récupération de toutes les catégories
    $Categories = $this->manager->findAllCategory();

    // Affichage de la page listant toutes les catégories
    $this->renderadmin("category", $Categories);
}

public function deleteCategory(string $slug)
{
    // Récupération de la catégorie à partir du slug
    $delete = $this->manager->getCategoryBySlug($slug);

    // Récupération de l'ID de la catégorie
    $id = $delete->getId();

    // Récupération de tous les produits liés à la catégorie
    $deleteproducts = $this->manager->getAllProductByCategoryId($id);

    // Suppression de tous les produits liés à la catégorie
    foreach($deleteproducts as $deleteproduct)
    {
        $id = $deleteproduct->getId();
        $deleteing = $this->pmanager->deleteAllergenOnProduct(intval($id));
        $deletealler = $this->pmanager->deleteIngredientOnProduct(intval($id));
        var_dump($id);
        $deleteimg = $this->immanager->getImageById(intval($id));
        var_dump($deleteimg);
        $deleteim = $this->immanager->deleteImage($deleteimg);
        $deletep = $this->pmanager->getProductbyId1(intval($id));
        $this->pmanager->deleteProduct($deletep);
    }

    // Suppression de la catégorie
    $this->manager->deleteCat($delete);

    // Redirection vers la page listant toutes les catégories
    header("Location: /res03-projet-final/projet/admin/category");
}

}
?>