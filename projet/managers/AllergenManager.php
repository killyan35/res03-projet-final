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
}
?>