<?php
class AllergenManager extends AbstractManager {
    
    
    public function insertAllergen(Allergen $allergen)
    {
        $query = $this->db->prepare('INSERT INTO allergen VALUES (null, :value1, :value2)');
        $parameters = [
        'value1' => $allergen->getName(),
        'value2' => $allergen->getSlug()
        ];
        $query->execute($parameters);
    }
    
    
    public function findAllAllergens() : array
        {
            $query = $this->db->prepare("SELECT * FROM allergen");
            $query->execute([]);
            $allergens = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($allergens as $allergen)
            {
                $newAllergen = new Allergen(intval($allergen["id"]),$allergen["name"],$allergen["slug"]);
                $newAllergen->setId($allergen["id"]);
                $return[]=$newAllergen;
            }
            return $return;
        }
        
    public function displayUpdateFormAllergen(string $name)
        {
            $Allergens = $this->manager->getAllergenByName($name);
            $tab = [];
            $tab["allergen"]=$Allergens;
            $this->render("allergen", $tab);
        }
    
    public function getAllergenBySlug(string $slug) : Allergen
        {
           
            $query = $this->db->prepare("SELECT * FROM allergen WHERE slug=:slug");
            $parameter = [
                'slug'=>$slug
            ];
            $query->execute($parameter);
            $allergen = $query->fetch(PDO::FETCH_ASSOC);
            $return = new Allergen(intval($allergen["id"]),$allergen["name"],$allergen["slug"]);
            
            return $return;
        }
        
    public function editAllergen(Allergen $allergen) : void
        {
        $query = $this->db->prepare("UPDATE allergen SET name=:name WHERE id=:id");
        $parameters = [
            'id'=>$allergen->getId(),
            'name'=>$allergen->getName()
        ];
        $query->execute($parameters);
        }
        
    public function deleteAllergen(Allergen $allergen)
        {
            
            $query = $this->db->prepare("DELETE FROM allergen WHERE id=:id");
            $parameters = [
                'id'=>$allergen->getId()
            ];
            $query->execute($parameters);
        }
        
     public function getAllergensByProductId(int $Idproduct) : array  
        {  
            $query = $this->db->prepare('SELECT allergen.* FROM product_has_allergen 
            JOIN allergen ON product_has_allergen.allergen_id = allergen.id 
            JOIN product ON product_has_allergen.product_id = product.id
            WHERE product.id= :productId');
    
            $parameters = [
                'productId' => $Idproduct
            ];
    
            $query->execute($parameters);
            $allergens = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($allergens as $allergen)
            {
                $newAllergen = new Allergen(intval($allergen["id"]),$allergen["name"],$allergen["slug"]);
                $newAllergen->setId($allergen["id"]);
                $return[]=$newAllergen;
            }
            return $return;  
        }
    public function deleteOneAllergenInAllProduct(int $allergenId)
        {
            $query = $this->db->prepare('DELETE FROM product_has_allergen WHERE allergen_id=:allergen_id');
            $parameters = [
                'allergen_id' => $allergenId
            ];
    
            $query->execute($parameters);
        }
}
?>