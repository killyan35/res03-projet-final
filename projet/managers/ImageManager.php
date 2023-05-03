<?php
class ImageManager extends AbstractManager {

    public function findAllImages() : array
    {
        // préparation de la requête SQL pour sélectionner toutes les images dans la table 'media'
        $query = $this->db->prepare("SELECT * FROM media");
        // exécution de la requête
        $query->execute([]);
        // récupération de tous les résultats de la requête sous forme de tableau associatif
        $images = $query->fetchAll(PDO::FETCH_ASSOC);
      
        $return = [];
        // boucle sur tous les résultats pour créer des objets Image à partir des données récupérées
        foreach ($images as $image)
        {
            $newimg = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
            // définir l'ID de l'image
            $newimg->setId($image["id"]);
            // ajouter l'image créée dans le tableau $return
            $return[]=$newimg;
        }
        // retourner le tableau des images
        return $return;
    }
    
    public function findAllImagesInOneProduct(int $product_id) : array
    {
        // préparation de la requête SQL pour sélectionner toutes les images d'un produit spécifique dans la table 'media'
        $query = $this->db->prepare("SELECT * FROM media WHERE product_id=:product_id");
        $parameter = ['product_id' =>$product_id];
        // exécution de la requête avec le paramètre $product_id
        $query->execute($parameter);
        // récupération de tous les résultats de la requête sous forme de tableau associatif
        $images = $query->fetchAll(PDO::FETCH_ASSOC);
      
        $return = [];
        // boucle sur tous les résultats pour créer des objets Image à partir des données récupérées
        foreach ($images as $image)
        {
            $newimg = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
            // définir l'ID de l'image
            $newimg->setId($image["id"]);
            // ajouter l'image créée dans le tableau $return
            $return[]=$newimg;
        }
        // retourner le tableau des images
        return $return;
    }
    
    public function insertImage(Image $media)
    {
        // préparation de la requête SQL pour insérer une nouvelle image dans la table 'media'
        $query = $this->db->prepare('INSERT INTO media VALUES (null, :value1, :value2, :value3)');
        $parameters = [
        'value1' => $media->getUrl(),
        'value2' => $media->getDescription(),
        'value3' => $media->getProduct_id()
        ];
        // exécution de la requête avec les paramètres $media->getUrl(), $media->getDescription() et $media->getProduct_id()
        $query->execute($parameters);
    }
    // La fonction retourne une instance de la classe Image en fonction de son identifiant
    public function getImageById(int $product_id) : Image
    {
        // Préparation de la requête SQL avec un paramètre nommé :product_id
        $query = $this->db->prepare("SELECT * FROM media WHERE product_id=:product_id");
        // Définition de la valeur du paramètre product_id
        $parameter = ['product_id' =>$product_id];
        // Exécution de la requête SQL avec le paramètre
        $query->execute($parameter);
        // Récupération de la première ligne du résultat de la requête
        $image = $query->fetch(PDO::FETCH_ASSOC);
        // Création d'une instance de la classe Image avec les données récupérées depuis la base de données
        $ImageToReturn = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
        // Définition de l'identifiant de l'image
        $ImageToReturn->setId($image["id"]);
        // Retour de l'instance de la classe Image
        return $ImageToReturn;
    }
    
    // La fonction supprime une instance de la classe Image depuis la base de données
    public function deleteImage(Image $image)
    {
        // Préparation de la requête SQL avec un paramètre nommé :id
        $query = $this->db->prepare("DELETE FROM media WHERE id=:id");
        // Définition de la valeur du paramètre id
        $parameters = [
            'id'=>$image->getId()
        ];
        // Exécution de la requête SQL avec le paramètre
        $query->execute($parameters);
    }

}
?>