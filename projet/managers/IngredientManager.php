<?php
class IngredientManager extends AbstractManager {
    
    
    public function insertIngredient(Ingredient $ingredient)
    {
        $query = $this->db->prepare('INSERT INTO ingredient VALUES (null, :value1, :value2)');
        $parameters = [
        'value1' => $ingredient->getName(),
        'value2' => $ingredient->getSlug()
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
                $newIngredient = new Ingredient(intval($ingredient["id"]),$ingredient["name"],$ingredient["slug"]);
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
    
    public function getIngredientBySlug(string $slug) : Ingredient
        {
           
            $query = $this->db->prepare("SELECT * FROM ingredient WHERE slug=:slug");
            $parameter = [
                'slug'=>$slug
            ];
            $query->execute($parameter);
            $ingredient = $query->fetch(PDO::FETCH_ASSOC);
            $return = new Ingredient(intval($ingredient["id"]),$ingredient["name"],$ingredient["slug"]);
            
            return $return;
        }
        
    public function editIngredient(Ingredient $ingredient) : void
        {
        $query = $this->db->prepare("UPDATE ingredient SET name=:name WHERE id=:id");
        $parameters = [
            'id'=>$ingredient->getId(),
            'name'=>$ingredient->getName()
        ];
        $query->execute($parameters);
        }
        
    public function deleteIngredient(Ingredient $ingredient)
        {
            
            $query = $this->db->prepare("DELETE FROM ingredient WHERE id=:id");
            $parameters = [
                'id'=>$ingredient->getId()
            ];
            $query->execute($parameters);
        }
        
    public function getIngredientsByProductId(int $Idproduct) : array 
        {  
            $query = $this->db->prepare('SELECT ingredient.* FROM product_has_ingredient 
            JOIN ingredient ON product_has_ingredient.ingredient_id = ingredient.id 
            JOIN product ON product_has_ingredient.product_id = product.id
            WHERE product.id= :productId');
    
            $parameters = [
                'productId' => $Idproduct
            ];
    
            $query->execute($parameters);
            
            $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($ingredients as $ingredient)
            {
                $newIngredient = new Ingredient(intval($ingredient["id"]),$ingredient["name"],$ingredient["slug"]);
                $newIngredient->setId($ingredient["id"]);
                $return[]=$newIngredient;
            }
            return $return;
        }
}
?>