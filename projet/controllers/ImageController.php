<?php
class ImageController extends AbstractController {
    private ImageManager $manager;
    
    public function __construct()
    {
        
        $this->manager = new ImageManager();
    }
    public function displayAllImage()
    {
        {
            $images = $this->manager->findAllImages();
            $this->render("image", $images);
        }
    }
    public function insertImage(array $post)
        {
            
            
            if (isset($post["formName"]))
            {
                 if ((isset($post['description']) && $post['description']!=='')
                 &&  (isset($post['product_id']) && $post['product_id']!=='')
                 ) 
                 {
                     $uploader = new Uploader();
                     $media = $uploader->upload($_FILES, "image");
                     $post["image"]=$media->getUrl();
                     $mediaToAdd = new Image(null, $post["image"],$post["description"], $post["product_id"]);
                     $this->manager->insertImage($mediaToAdd);
                     header("Location: /res03-projet-final/projet/admin/image");
                 }
            }
        }
}

?>