<?php
class ImageController extends AbstractController {
    private ImageManager $manager;
    
    public function __construct()
    {
        
        $this->manager = new ImageManager();
    }

public function displayAllImage()
{
    // Récupération de toutes les images dans la base de données
    $images = $this->manager->findAllImages();
    // Affichage de la vue image avec toutes les images
    $this->renderadmin("image", $images);
}

public function insertImage(array $post)
{
    // Vérification de la présence du formulaire
    if (isset($post["formName"]))
    {
        // Vérification de la présence de la description et de l'id du produit
        if ((isset($post['description']) && $post['description']!=='')
            &&  (isset($post['product_id']) && $post['product_id']!=='')
        ) 
        {
            // Upload de l'image
            $uploader = new Uploader();
            $media = $uploader->upload($_FILES, "image");
            // Récupération de l'URL de l'image uploadée
            $post["image"]=$media->getUrl();
            // Création d'une nouvelle instance de Image avec les informations fournies
            $mediaToAdd = new Image(null, $post["image"],$post["description"], $post["product_id"]);
            // Insertion de la nouvelle image dans la base de données
            $this->manager->insertImage($mediaToAdd);
            // Redirection vers la page d'affichage de toutes les images
            header("Location: /res03-projet-final/projet/admin/image");
        }
    }
}
}
?>