<?php
class CategoryManager extends AbstractManager {

    public function getCategoryBySlug(string $slug) : Category
    {
       
        $query = $this->db->prepare("SELECT * FROM category WHERE slug=:slug");
        $parameter = [
            'slug'=>$slug
        ];
        $query->execute($parameter);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $return = new Category(intval($category["id"]),$category["name"], $category["img_url"], $category["slug"]);
        
        return $return;
    }
    
    public function insertCategory(Category $category)
    {
        $query = $this->db->prepare('INSERT INTO category VALUES (null, :value1, :value2, :value3)');
        $parameters = [
        'value1' => $category->getName(),
        'value2' => $category->getImgURL(),
        'value3' => $category->getSlug()
        ];
        $query->execute($parameters);
    }
    
    
    public function findAllCategory() : array
        {
            $query = $this->db->prepare("SELECT * FROM category");
            $query->execute([]);
            $categorys = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($categorys as $category)
            {
                $newCat = new Category(intval($category["id"]),$category["name"], $category["img_url"], $category["slug"]);
                $newCat->setId($category["id"]);
                $newCat->setSlug($category["slug"]);
                $return[]=$newCat;
            }
            return $return;
        }
        
        
    public function editCategory(Category $category) : void
    {
    $query = $this->db->prepare("UPDATE category SET name=:name, img_url=:img_url, slug=:slug WHERE id=:id");
    $parameters = [
        'id'=>$category->getId(),
        'name'=>$category->getName(),
        'img_url'=>$category->getImgURL(),
        'slug'=>$category->getSlug()
    ];
    $query->execute($parameters);
    }
    
    
    public function deleteCat(Category $category)
    {
        
        $query = $this->db->prepare("DELETE FROM category WHERE id=:id");
        $parameters = [
            'id'=>$category->getId()
        ];
        $query->execute($parameters);
    }
}
?>