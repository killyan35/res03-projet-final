<?php
class IngredientManager extends AbstractManager {
    
    
    public function insertIngredient(Ingredient $ingredient)
    {
        $query = $this->db->prepare('INSERT INTO ingredient VALUES (null, :value1)');
        $parameters = [
        'value1' => $ingredient->getName()
        ];
        $query->execute($parameters);
    }
    
    
    public function findAllIngredients() : array
        {
            $query = $this->db->prepare("SELECT * FROM ingredient");
            $query->execute([]);
            $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($ingredients as $ingredient)
            {
                $newIngredient = new Ingredient(intval($ingredient["id"]),$ingredient["name"]);
                $newIngredient->setId($ingredient["id"]);
                $return[]=$newIngredient;
            }
            return $return;
        }
        
    public function displayUpdateFormIngredient(string $name)
        {
            $Ingredients = $this->manager->getCategoryByName($name);
            $tab = [];
            $tab["ingredient"]=$Ingredients;
            $this->render("ingredient", $tab);
        }
    
    public function getIngredientByName(string $name) : Ingredient
        {
           
            $query = $this->db->prepare("SELECT * FROM ingredient WHERE name=:name");
            $parameter = [
                'name'=>$name
            ];
            $query->execute($parameter);
            $ingredient = $query->fetch(PDO::FETCH_ASSOC);
            $return = new Ingredient(intval($ingredient["id"]),$ingredient["name"]);
            
            return $return;
        }
}
?>