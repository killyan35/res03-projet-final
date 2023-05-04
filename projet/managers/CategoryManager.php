<?php
class CategoryManager extends AbstractManager {
    public function getCategoryBySlug(string $slug) : ?Category
    {
       
        // Prépare une requête SQL pour sélectionner la catégorie avec le slug donné
        $query = $this->db->prepare("SELECT * FROM category WHERE slug=:slug");
        $parameter = [
            'slug'=>$slug
        ];
        // Exécute la requête en passant le slug comme paramètre
        $query->execute($parameter);
        // Récupère la catégorie trouvée sous forme de tableau associatif
        $category = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un objet Category à partir des données récupérées et le retourne a condition qu'il existe dans la bdd
        if($category != false)
        {
            $return = new Category(intval($category["id"]),$category["name"], $category["img_url"], $category["slug"]);
            return $return;
        }
        //sinon ne retourne rien
        else
        {
            return null;
        }
    }

    public function getCategoryById(int $categoryId) : Category
    {
       
        // Prépare une requête SQL pour sélectionner la catégorie avec l'ID donné
        $query = $this->db->prepare("SELECT * FROM category WHERE id=:id");
        $parameter = [
            'id'=>$categoryId
        ];
        // Exécute la requête en passant l'ID comme paramètre
        $query->execute($parameter);
        // Récupère la catégorie trouvée sous forme de tableau associatif
        $category = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un objet Category à partir des données récupérées et le retourne
        $return = new Category(intval($category["id"]),$category["name"], $category["img_url"], $category["slug"]);
        
        return $return;
    }
    
    public function insertCategory(Category $category)
    {
        // Prépare une requête SQL pour insérer une nouvelle catégorie
        $query = $this->db->prepare('INSERT INTO category VALUES (null, :value1, :value2, :value3)');
        $parameters = [
        'value1' => $category->getName(),
        'value2' => $category->getImgURL(),
        'value3' => $category->getSlug()
        ];
        // Exécute la requête en passant les valeurs de la nouvelle catégorie comme paramètres
        $query->execute($parameters);
    }
    
    
    public function findAllCategory() : array
        {
            // Prépare une requête SQL pour sélectionner toutes les catégories
            $query = $this->db->prepare("SELECT * FROM category");
            $query->execute([]);
            // Récupère toutes les catégories trouvées sous forme de tableau associatif
            $categorys = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            // Pour chaque catégorie, crée un objet Category à partir des données récupérées
            // et l'ajoute au tableau de retour
            foreach ($categorys as $category)
            {
                $newCat = new Category(intval($category["id"]),$category["name"],
                $category["img_url"], $category["slug"]);
                $newCat->setId($category["id"]);
                $newCat->setSlug($category["slug"]);
                $return[]=$newCat;
            }
            // Retourne le tableau de toutes les catégories
            return $return;
        }
    public function editCategory(Category $category) : void
    {
        // Prépare la requête SQL pour mettre à jour une catégorie
        $query = $this->db->prepare("UPDATE category SET name=:name, img_url=:img_url, slug=:slug WHERE id=:id");
        // Définit les paramètres à utiliser dans la requête SQL
        $parameters = [
            'id'=>$category->getId(),
            'name'=>$category->getName(),
            'img_url'=>$category->getImgURL(),
            'slug'=>$category->getSlug()
        ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    public function editCategoryNameOnly(Category $category) : void
    {
        // Prépare la requête SQL pour mettre à jour le nom et le slug d'une catégorie
        $query = $this->db->prepare("UPDATE category SET name=:name, slug=:slug WHERE id=:id");
        // Définit les paramètres à utiliser dans la requête SQL
        $parameters = [
            'id'=>$category->getId(),
            'name'=>$category->getName(),
            'slug'=>$category->getSlug()
        ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    public function deleteCat(Category $category)
    {
        // Prépare la requête SQL pour supprimer une catégorie
        $query = $this->db->prepare("DELETE FROM category WHERE id=:id");
        // Définit les paramètres à utiliser dans la requête SQL
        $parameters = [
            'id'=>$category->getId()
        ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    public function getAllProductByCategoryId(int $category_id) : array
    {
        // Prépare la requête pour récupérer tous les produits liés à une catégorie spécifique
        $query = $this->db->prepare("SELECT * FROM product WHERE category_id=:category_id");
        
        // Définit les valeurs des paramètres de la requête
        $parameter = ['category_id' =>$category_id];
        
        // Exécute la requête avec les paramètres fournis
        $query->execute($parameter);
        
        // Récupère tous les résultats de la requête sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Initialise le tableau qui va stocker tous les produits retournés
        $return = [];
        
        // Boucle sur tous les produits récupérés
        foreach ($products as $product)
        {
            // Crée un nouvel objet Product avec les données du produit courant
            $Product = new Product(intval($product["id"]),$product["name"], $product["description"],
                    $product["slug"], intval($product["price"]), intval($product["category_id"]));
            
            // Définit l'ID du produit nouvellement créé avec l'ID récupéré de la base de données
            $Product->setId($product["id"]);
            
            // Définit le slug du produit nouvellement créé avec le slug récupéré de la base de données
            $Product->setSlug($product["slug"]);
            
            // Ajoute le produit nouvellement créé au tableau de retour
            $return[]=$Product;
        }
        
        // Retourne tous les produits liés à la catégorie spécifiée
        return $return;
    }

}
?>