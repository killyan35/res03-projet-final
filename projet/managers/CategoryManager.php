<?php
class CategoryManager extends AbstractManager {

    public function getCategoryById(int $id) : Category
    {
       
        $query = $this->db->prepare("SELECT * FROM category WHERE id=:id");
        $parameters = [
            'id'=>$id
        ];
        $query->execute($parameters);
        $categorys = $query->fetch(PDO::FETCH_ASSOC);
        $return = new Category($categorys["name"], $categorys["imgURL"], $categorys["slug"]);
        $return->setId($categorys["id"]);
        
        return $return;
    }
    
    public function insertCategory(Category $category) : Category
    {
        $query = $this->db->prepare('INSERT INTO category VALUES (null, :value1, :value2, :value3)');
        $parameters = [
        'value1' => $category->getName(),
        'value2' => $category->getImgURL(),
        'value3' => $category->getSlug()
        ];
        $query->execute($parameters);
        
        
        
        
        $query = $this->db->prepare("SELECT * FROM category WHERE name=:value");
        $parameter = ['value' => $category->getName()];
        $query->execute($parameter);
        $categorys = $query->fetch(PDO::FETCH_ASSOC);
        $categoryToReturn = new Category($categorys["name"], $categorys["img_url"]);
        $categoryToReturn->setId($categorys["id"]);
        $categoryToReturn->setSlug($categorys["slug"]);
        return $categoryToReturn;
     
    }
    
    
    
    
    function findAllCategory() : array
        {
            $query = $this->db->prepare("SELECT * FROM category");
            $query->execute([]);
            $categorys = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($categorys as $category)
            {
                $newCat = new Category($category["name"], $category["img_url"]);
                $newCat->setId($category["id"]);
                $newCat->setSlug($category["slug"]);
                $return[]=$newCat;
            }
            return $return;
            var_dump($return);
        }
}
?>