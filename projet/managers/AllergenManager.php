<?php
class AllergenManager extends AbstractManager {
    
    
public function insertAllergen(Allergen $allergen)
{
    // Prépare la requête SQL pour insérer l'allergène dans la base de données
    $query = $this->db->prepare('INSERT INTO allergen VALUES (null, :value1, :value2)');
    // Définit les paramètres pour la requête SQL
    $parameters = [
    'value1' => $allergen->getName(),
    'value2' => $allergen->getSlug()
    ];
    // Exécute la requête SQL avec les paramètres
    $query->execute($parameters);
}


public function findAllAllergens() : array
{
    // Prépare la requête SQL pour récupérer tous les allergènes dans la base de données
    $query = $this->db->prepare("SELECT * FROM allergen");
    // Exécute la requête SQL sans paramètres
    $query->execute([]);
    // Récupère tous les résultats de la requête SQL sous forme de tableau associatif
    $allergens = $query->fetchAll(PDO::FETCH_ASSOC);

    // Initialise un tableau pour stocker les objets Allergen à retourner
    $return = [];
    // Parcourt tous les résultats de la requête SQL
    foreach ($allergens as $allergen)
    {
        // Crée un nouvel objet Allergen à partir des données récupérées dans la base de données
        $newAllergen = new Allergen(intval($allergen["id"]),$allergen["name"],$allergen["slug"]);
        $newAllergen->setId($allergen["id"]);
        // Ajoute l'objet Allergen créé au tableau à retourner
        $return[]=$newAllergen;
    }
    // Retourne le tableau contenant tous les objets Allergen
    return $return;
}

public function displayUpdateFormAllergen(string $name)
{
    // Récupère l'allergène à modifier par son nom
    $Allergens = $this->manager->getAllergenByName($name);
    // Initialise un tableau pour stocker les données à transmettre à la vue
    $tab = [];
    $tab["allergen"]=$Allergens;
    // Affiche le formulaire de modification de l'allergène avec les données récupérées
    $this->render("allergen", $tab);
}

public function getAllergenBySlug(string $slug) : Allergen
{
    // Prépare la requête SQL pour récupérer l'allergène correspondant au slug donné
    $query = $this->db->prepare("SELECT * FROM allergen WHERE slug=:slug");
    // Définit les paramètres pour la requête SQL
    $parameter = [
        'slug'=>$slug
    ];
    // Exécute la requête SQL avec les paramètres
    $query->execute($parameter);
    // Récupère le résultat de la requête SQL sous forme de tableau associatif
    $allergen = $query->fetch(PDO::FETCH_ASSOC);
    // Crée un nouvel objet Allergen à partir des données récupérées dans la base de données
    $return = new Allergen(intval($allergen["id"]),$allergen["name"],$allergen["slug"]);

    // Retourne l'objet Allergen créé
    return $return;
}
public function editAllergen(Allergen $allergen) : void
{
    // Prépare la requête SQL pour mettre à jour le nom d'un allergène dans la table allergen
    $query = $this->db->prepare("UPDATE allergen SET name=:name WHERE id=:id");
    $parameters = [
        'id'=>$allergen->getId(),
        'name'=>$allergen->getName()
    ];
    // Exécute la requête SQL avec les paramètres définis
    $query->execute($parameters);
}

public function deleteAllergen(Allergen $allergen)
{
    // Prépare la requête SQL pour supprimer un allergène de la table allergen
    $query = $this->db->prepare("DELETE FROM allergen WHERE id=:id");
    $parameters = [
        'id'=>$allergen->getId()
    ];
    // Exécute la requête SQL avec les paramètres définis
    $query->execute($parameters);
}

public function getAllergensByProductId(int $Idproduct) : array  
{  
    // Prépare la requête SQL pour récupérer tous les allergènes associés à un produit donné
    $query = $this->db->prepare('SELECT allergen.* FROM product_has_allergen 
        JOIN allergen ON product_has_allergen.allergen_id = allergen.id 
        JOIN product ON product_has_allergen.product_id = product.id
        WHERE product.id= :productId');

    $parameters = [
        'productId' => $Idproduct
    ];

    // Exécute la requête SQL avec les paramètres définis
    $query->execute($parameters);
    $allergens = $query->fetchAll(PDO::FETCH_ASSOC);

    // Convertit les résultats de la requête en objets Allergen et les stocke dans un tableau
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
    // Prépare la requête SQL pour supprimer un allergène de tous les produits dans la table product_has_allergen
    $query = $this->db->prepare('DELETE FROM product_has_allergen WHERE allergen_id=:allergen_id');
    $parameters = [
        'allergen_id' => $allergenId
    ];

    // Exécute la requête SQL avec les paramètres définis
    $query->execute($parameters);
}

}
?>