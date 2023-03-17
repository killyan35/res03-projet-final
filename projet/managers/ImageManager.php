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
}
?>