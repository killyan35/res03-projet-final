<?php
class ProductManager extends AbstractManager {

    public function getProductById(int $id) : array
    {
        //préparez la requête SQL pour sélectionner tous les produits de la table product ayant pour id la valeur de l'entrée
        $query = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $parameter = ['id' =>$id]; //création d'un tableau associatif contenant l'entrée $id sous le nom 'id'
        $query->execute($parameter); //exécution de la requête SQL en liant le paramètre
        $product = $query->fetch(PDO::FETCH_ASSOC); //récupération d'une seule ligne du résultat de la requête sous la forme d'un tableau associatif
        $return = []; //initialisation d'un tableau vide
        $ProductToReturn = new Product(intval($product["id"]),$product["name"], $product["description"], $product["slug"], floatval($product["price"]), intval($product["category_id"])); //instanciation d'un objet Product à partir des données obtenues dans la requête SQL
        $ProductToReturn->setId($product["id"]); //définition de la valeur de l'identifiant du produit
        $return[]=$ProductToReturn; //ajout du produit obtenu dans le tableau de résultats
        return $return; //renvoie le tableau de résultats
    }
    
    public function getProductById1(int $id) : Product
    {
        //préparez la requête SQL pour sélectionner tous les produits de la table product ayant pour id la valeur de l'entrée
        $query = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $parameter = ['id' =>$id]; //création d'un tableau associatif contenant l'entrée $id sous le nom 'id'
        $query->execute($parameter); //exécution de la requête SQL en liant le paramètre
        $product = $query->fetch(PDO::FETCH_ASSOC); //récupération d'une seule ligne du résultat de la requête sous la forme d'un tableau associatif
        $ProductToReturn = new Product(intval($product["id"]),$product["name"], $product["description"], $product["slug"], floatval($product["price"]), intval($product["category_id"])); //instanciation d'un objet Product à partir des données obtenues dans la requête SQL
        $ProductToReturn->setId($product["id"]); //définition de la valeur de l'identifiant du produit
        return $ProductToReturn; //renvoie l'objet Product obtenu
    }
    
    public function insertProduct(Product $product)
    {
        // Prépare la requête SQL pour insérer un produit
        $query = $this->db->prepare('INSERT INTO product VALUES (null, :value1, :value2, :value3, :value4, :value5)');
        // Les valeurs des paramètres de la requête SQL
        $parameters = [
            'value1' => $product->getName(),
            'value2' => $product->getDescription(),
            'value3' => $product->getSlug(),
            'value4' => $product->getPrice(),
            'value5' => $product->getCategoryId()
        ];
        // Exécute la requête SQL avec les paramètres
        $query->execute($parameters);
        
        // Renvoie l'identifiant du dernier enregistrement inséré
        return $this->db->lastInsertId();
    }
    
    public function getProductByName(string $name) : Product
    {
        // Prépare la requête SQL pour récupérer un produit par son nom
        $query = $this->db->prepare("SELECT * FROM product WHERE name=:name");
        // Les valeurs des paramètres de la requête SQL
        $parameter = ['name' =>$name];
        // Exécute la requête SQL avec les paramètres
        $query->execute($parameter);
        // Récupère les résultats de la requête sous forme de tableau associatif
        $products = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet de type Product avec les données récupérées de la base de données
        $ProductToReturn = new Product($products["name"],$products["description"],$products["price"],$products["category_id"]);
        $ProductToReturn->setId($products["id"]);
        
        // Renvoie l'objet Product créé
        return $ProductToReturn ;
    }
    
    public function getProductBySlug(string $slug) : Product
    {
        // Prépare la requête SQL pour récupérer un produit par son slug
        $query = $this->db->prepare("SELECT * FROM product WHERE slug=:slug");
        // Les valeurs des paramètres de la requête SQL
        $parameter = ['slug' =>$slug];
        // Exécute la requête SQL avec les paramètres
        $query->execute($parameter);
        // Récupère les résultats de la requête sous forme de tableau associatif
        $products = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet de type Product avec les données récupérées de la base de données
        $ProductToReturn = new Product(intval($products["id"]),$products["name"],$products["description"],$products["slug"],floatval($products["price"]),intval($products["category_id"]));
        $ProductToReturn->setId(intval($products["id"]));
        $ProductToReturn->setSlug($products["slug"]);
        
        // Renvoie l'objet Product créé
        return $ProductToReturn ;
    }
    public function getAllProductsByCategoryId(int $category_id) : array
    {
        // préparation de la requête SQL
        $query = $this->db->prepare("SELECT * FROM product WHERE category_id=:category_id");
        // spécification des paramètres de la requête
        $parameter = ['category_id' =>$category_id];
        // exécution de la requête avec les paramètres
        $query->execute($parameter);
        // récupération de tous les produits résultants de la requête
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // initialisation du tableau à retourner
        $return = [];
        
        // boucle pour parcourir tous les produits récupérés et créer des objets Product correspondants
        foreach ($products as $product)
        {
            // création d'un nouvel objet Product avec les données du produit
            $newProduct = new Product(intval($product["id"]),$product["name"], $product["description"], $product["slug"], intval($product["price"]), intval($product["category_id"]));
            // spécification de l'ID du produit
            $newProduct->setId($product["id"]);
            // spécification du slug du produit
            $newProduct->setSlug($product["slug"]);
            // ajout du produit nouvellement créé au tableau à retourner
            $return[]=$newProduct;
        }
        
        // retourne le tableau contenant tous les produits correspondant à l'ID de la catégorie spécifiée
        return $return;
    }
    
    public function findAllProducts() : array
    {
        // préparation de la requête SQL pour sélectionner tous les produits
        $query = $this->db->prepare("SELECT * FROM product");
        
        // exécution de la requête sans paramètres
        $query->execute([]);
        
        // récupération de tous les produits résultants de la requête
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // initialisation du tableau à retourner
        $return = [];
        
        // boucle pour parcourir tous les produits récupérés et créer des objets Product correspondants
        foreach ($products as $product)
        {
            // création d'un nouvel objet Product avec les données du produit
            $newProduct = new Product(intval($product["id"]),$product["name"], $product["description"], $product["slug"], intval($product["price"]), intval($product["category_id"]));
            
            // spécification de l'ID du produit
            $newProduct->setId($product["id"]);
            
            // spécification du slug du produit
            $newProduct->setSlug($product["slug"]);
            
            // ajout du produit nouvellement créé au tableau à retourner
            $return[]=$newProduct;
        }
        
        // retourne le tableau contenant tous les produits
        return $return;
    }

    public function editProduct(Product $product) : void
    {
        // préparation de la requête SQL pour mettre à jour un produit spécifié par son ID
        $query = $this->db->prepare("UPDATE product SET name=:name, description=:description, price=:price, category_id=:category_id WHERE id=:id");
        
        // spécification des paramètres de la requête
        $parameters = [
            'id'=>$product->getId(),
            'name'=>$product->getName(),
            'description'=>$product->getDescription(),
            'price'=>$product->getPrice(),
            'category_id'=>$product->getCategoryId()
        ];
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }
    
    public function addIngredientOnProduct(int $ingredientId,int $productId)
    {
        // Prépare la requête SQL pour ajouter un ingrédient à un produit
        $query = $this->db->prepare('INSERT INTO product_has_ingredient VALUES (:ProductId , :ingredientId )');
        // Associe les valeurs des paramètres à des noms pour les passer à la requête SQL
        $parameters = [
            'ingredientId' => $ingredientId,
            'ProductId' => $productId
        ];
    
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }
    
    public function addAllergenOnProduct(int $allergenId,int $productId)
    {
        // Prépare la requête SQL pour ajouter un allergène à un produit
        $query = $this->db->prepare('INSERT INTO product_has_allergen VALUES (:ProductId , :allergenId )');
        // Associe les valeurs des paramètres à des noms pour les passer à la requête SQL
        $parameters = [
            'allergenId' => $allergenId,
            'ProductId' => $productId
        ];
    
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }
    
    public function deleteProduct(Product $product)
    {
        // Prépare la requête SQL pour supprimer un produit de la base de données
        $query = $this->db->prepare("DELETE FROM product WHERE id=:id");
        // Associe les valeurs des paramètres à des noms pour les passer à la requête SQL
        $parameters = [
            'id'=>$product->getId()
        ];
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }
    
    public function deleteAllergenOnProduct(int $productId)
    {
        // Prépare la requête SQL pour supprimer un allergène d'un produit
        $query = $this->db->prepare('DELETE FROM product_has_allergen WHERE product_id=:product_id');
        // Associe les valeurs des paramètres à des noms pour les passer à la requête SQL
        $parameters = [
            'product_id' => $productId
        ];
    
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }
    
    public function deleteIngredientOnProduct(int $productId)
    {
        // Prépare la requête SQL pour supprimer un ingrédient d'un produit
        $query = $this->db->prepare('DELETE FROM product_has_ingredient WHERE product_id=:product_id');
        // Associe les valeurs des paramètres à des noms pour les passer à la requête SQL
        $parameters = [
            'product_id' => $productId
        ];
    
        // Exécute la requête SQL avec les paramètres associés
        $query->execute($parameters);
    }

}
?>