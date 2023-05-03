<?php
class IngredientManager extends AbstractManager {
        
    public function insertIngredient(Ingredient $ingredient)
    {
        // Prépare la requête d'insertion avec les paramètres nécessaires.
        $query = $this->db->prepare('INSERT INTO ingredient VALUES (null, :value1, :value2)');
        $parameters = [
        'value1' => $ingredient->getName(),
        'value2' => $ingredient->getSlug()
        ];
        // Exécute la requête avec les paramètres.
        $query->execute($parameters);
    }
    
    public function findAllIngredients() : array
    {
        // Prépare la requête de sélection de tous les ingrédients.
        $query = $this->db->prepare("SELECT * FROM ingredient");
        $query->execute([]);
        // Récupère tous les ingrédients sous forme d'un tableau associatif.
        $ingredients = $query->fetchAll(PDO::FETCH_ASSOC);
      
        $return = [];
        // Pour chaque ingrédient, crée un nouvel objet Ingredient et l'ajoute au tableau à retourner.
        foreach ($ingredients as $ingredient)
        {
            $newIngredient = new Ingredient(intval($ingredient["id"]),$ingredient["name"],$ingredient["slug"]);
            $newIngredient->setId($ingredient["id"]);
            $return[]=$newIngredient;
        }
        // Retourne le tableau d'objets Ingredient.
        return $return;
    }
    
    public function displayUpdateFormIngredient(string $name)
    {
        // Récupère tous les ingrédients correspondant à la catégorie passée en paramètre.
        $Ingredients = $this->manager->getCategoryByName($name);
        $tab = [];
        $tab["ingredient"]=$Ingredients;
        // Affiche le formulaire de mise à jour des ingrédients.
        $this->render("ingredient", $tab);
    }
    
    public function getIngredientBySlug(string $slug) : Ingredient
    {
        // Prépare la requête de sélection d'un ingrédient par son slug.
        $query = $this->db->prepare("SELECT * FROM ingredient WHERE slug=:slug");
        $parameter = [
            'slug'=>$slug
        ];
        $query->execute($parameter);
        // Récupère l'ingrédient sous forme d'un tableau associatif.
        $ingredient = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet Ingredient avec les informations récupérées.
        $return = new Ingredient(intval($ingredient["id"]),$ingredient["name"],$ingredient["slug"]);
        
        // Retourne l'objet Ingredient.
        return $return;
    }
    
    public function editIngredient(Ingredient $ingredient) : void
    {
        // Prépare la requête de mise à jour d'un ingrédient.
        $query = $this->db->prepare("UPDATE ingredient SET name=:name WHERE id=:id");
        $parameters = [
            'id'=>$ingredient->getId(),
            'name'=>$ingredient->getName()
        ];
        // Exécute la requête avec les paramètres.
        $query->execute($parameters);
    }
    
    public function deleteIngredient(Ingredient $ingredient)
    {
        // Prépare la requête de suppression d'un ingrédient.
        $query = $this->db->prepare("DELETE FROM ingredient WHERE id=:id");
        $parameters = [
            'id'=>$ingredient->getId()
        ];
        // Exécute la requête avec les paramètres.
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
    
    
    public function deleteOneIngredientInAllProduct(int $ingredientId)
    {
        // Prépare la requête de suppression avec un paramètre nommé ":ingredient_id"
        $query = $this->db->prepare('DELETE FROM product_has_ingredient WHERE ingredient_id=:ingredient_id');
        // Associe la valeur de l'identifiant de l'ingrédient à supprimer au paramètre nommé 
        $parameters = [
            'ingredient_id' => $ingredientId
        ];
        // Exécute la requête de suppression avec les paramètres associés
        $query->execute($parameters);
    }
}
?>