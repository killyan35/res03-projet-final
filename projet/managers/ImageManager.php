<?php
class ImageManager extends AbstractManager {
    // https://picsum.photos/200/300
    
    public function findAllImages() : array
        {
            $query = $this->db->prepare("SELECT * FROM media");
            $query->execute([]);
            $images = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($images as $image)
            {
                $newimg = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
                $newimg->setId($image["id"]);
                $return[]=$newimg;
            }
            return $return;
        }
    public function findAllImagesInOneProduct(int $product_id) : array
        {
            $query = $this->db->prepare("SELECT * FROM media WHERE product_id=:product_id");
            $parameter = ['product_id' =>$product_id];
            $query->execute($parameter);
            $images = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($images as $image)
            {
                $newimg = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
                $newimg->setId($image["id"]);
                $return[]=$newimg;
            }
            return $return;
        }
    public function insertImage(Image $media)
        {
            $query = $this->db->prepare('INSERT INTO media VALUES (null, :value1, :value2, :value3)');
            $parameters = [
            'value1' => $media->getUrl(),
            'value2' => $media->getDescription(),
            'value3' => $media->getProduct_id()
            ];
            $query->execute($parameters);
        }
     public function getImageById(int $product_id) : Image
    {
       
        $query = $this->db->prepare("SELECT * FROM media WHERE product_id=:product_id");
        $parameter = ['product_id' =>$product_id];
        $query->execute($parameter);
        $image = $query->fetch(PDO::FETCH_ASSOC);
       
        $ImageToReturn = new Image(intval($image["id"]),$image["url"],$image["description"], $image["product_id"]);
        $ImageToReturn->setId($image["id"]);
        
        return $ImageToReturn;
    }
    public function deleteImage(Image $image)
    {
        
        $query = $this->db->prepare("DELETE FROM media WHERE id=:id");
        $parameters = [
            'id'=>$image->getId()
        ];
        $query->execute($parameters);
    }
}
?>