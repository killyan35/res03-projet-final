<?php
class UserManager extends AbstractManager {

    public function getUserById(int $id) : User
    {
        // Prépare la requête SQL
        $query = $this->db->prepare("SELECT * FROM user WHERE id=:id");
        // Définit les paramètres de la requête SQL
        $parameters = [
            'id'=>$id
        ];
        // Exécute la requête SQL
        $query->execute($parameters);
        // Récupère les résultats de la requête SQL
        $users = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet User à partir des résultats de la requête SQL
        $return = new User(null, $users["first_name"],$users["last_name"],$users["email"],$users["password"], null);
        // Définit l'id de l'utilisateur
        $return->setId($users["id"]);
        // Si l'adresse de l'utilisateur existe, la définit également
        if($users["address_id"] != null)
        {
            $return->setAddress_id($users["address_id"]);
        }
        // Retourne l'objet User créé
        return $return;
    }
    
    public function getUserByEmail(string $email) : User
    {
        // Prépare la requête SQL
        $query = $this->db->prepare("SELECT * FROM user WHERE email=:email");
        // Définit les paramètres de la requête SQL
        $parameters = [
            'email'=>$email
        ];
        // Exécute la requête SQL
        $query->execute($parameters);
        // Récupère les résultats de la requête SQL
        $users = $query->fetch(PDO::FETCH_ASSOC);
        // Si des résultats sont retournés
        if($users!==false)
        {
            // Crée un nouvel objet User à partir des résultats de la requête SQL
            $return = new User(null, $users["first_name"],$users["last_name"],$users["email"],$users["password"], null);
            // Définit l'id de l'utilisateur
            $return->setId($users["id"]);
            // Définit le rôle de l'utilisateur
            $return->setRole($users["role"]);
            // Si l'adresse de l'utilisateur existe, la définit également
            if($users["address_id"] != null)
            {
                $return->setAddress_id($users["address_id"]);
            }
            // Retourne l'objet User créé
            return $return;
        }
        else
        {
            // Si aucun résultat n'est retourné, retourne null
            return null;
        }
    }

    public function insertUser(User $user) :int
    {
        // Préparer la requête SQL pour insérer un nouvel utilisateur dans la base de données
        $query = $this->db->prepare('INSERT INTO user VALUES (null, :prenom, :nom, :email, :mdp, :role, null)');
    
        // Définir les paramètres pour la requête SQL
        $parameters= [
            'prenom' => $user->getFirstname(),
            'nom' => $user->getLastname(),
            'email' => $user->getEmail(),
            'mdp' => password_hash($user->getPassword() , PASSWORD_DEFAULT),
            'role' => $user->getRole()
        ];
    
        // Exécuter la requête SQL avec les paramètres
        $query->execute($parameters);
    
        // Récupérer l'identifiant unique de l'utilisateur nouvellement créé
        $id = intval($this->db->lastInsertId());
    
        // Retourner l'identifiant de l'utilisateur
        return $id;
    }
    
    public function editUser(User $user) : void
    {
        // Préparer la requête SQL pour mettre à jour les informations d'un utilisateur existant
        $query = $this->db->prepare("UPDATE user SET first_name=:first_name, last_name=:last_name, email=:email, password=:password WHERE id=:id");
    
        // Définir les paramètres pour la requête SQL
        $parameters = [
            'id'=>$user->getId(),
            'first_name'=>$user->getFirstname(),
            'last_name'=>$user->getLastname(),
            'email'=>$user->getEmail(),
            'password'=> password_hash($user->getPassword() , PASSWORD_DEFAULT)
        ];
    
        // Exécuter la requête SQL avec les paramètres
        $query->execute($parameters);
    }
    
    public function EditUserWithAddress(User $user) : void
    {
        // Préparer la requête SQL pour mettre à jour les informations d'un utilisateur existant avec son adresse
        $query = $this->db->prepare("UPDATE user SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, address_id=:address_id WHERE id=:id");
    
        // Définir les paramètres pour la requête SQL
        $parameters = [
            'id'=>$user->getId(),
            'first_name'=>$user->getFirstname(),
            'last_name'=>$user->getLastname(),
            'email'=>$user->getEmail(),
            'password'=> password_hash($user->getPassword() , PASSWORD_DEFAULT),
            'address_id'=>$user->getAddress_id()
        ];
    
        // Exécuter la requête SQL avec les paramètres
        $query->execute($parameters);
    }

    public function AddAddressOnUser(int $userId, int $addressId)
    {
        // Prépare une requête pour mettre à jour l'adresse de l'utilisateur spécifié
        $query = $this->db->prepare("UPDATE user SET address_id=:address_id WHERE id=:id");
        // Prépare les paramètres pour la requête
        $parameters = [
            'id'=>$userId,
            'address_id'=>$addressId
        ];
        // Exécute la requête avec les paramètres spécifiés
        $query->execute($parameters);
    }
    
    public function deleteUser(User $user)
    {
        // Prépare une requête pour supprimer l'utilisateur spécifié
        $query = $this->db->prepare("DELETE FROM user WHERE id=:id");
        // Prépare les paramètres pour la requête
        $parameters = [
            'id'=>$user->getId()
        ];
        // Exécute la requête avec les paramètres spécifiés
        $query->execute($parameters);
    }
    
    public function findAllUser() : array
    {
        // Prépare une requête pour sélectionner tous les utilisateurs
        $query = $this->db->prepare("SELECT * FROM user");
        // Exécute la requête sans paramètres
        $query->execute([]);
        // Récupère tous les utilisateurs sous forme de tableau associatif
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $return = [];
        // Pour chaque utilisateur, crée un nouvel objet User et l'ajoute au tableau $return
        foreach ($users as $user)
        {
            $newUser = new User(null, $user["first_name"],$user["last_name"],$user["email"],$user["password"], null);
            $newUser->setId($user["id"]);
            $return[]=$newUser;
        }
        // Retourne le tableau $return contenant tous les objets User créés
        return $return;
    }

    public function insertAdress(Adress $adress)
    {
        // Préparation de la requête SQL avec des paramètres nommés
        $query = $this->db->prepare('INSERT INTO address VALUES (null, :street, :city, :number, :zipcode)');
    
        // Tableau associatif des valeurs à insérer dans la requête
        $parameters= [
            'street' => $adress->getStreet(),
            'city' => $adress->getCity(),
            'number' => $adress->getNumber(),
            'zipcode' => $adress->getZipcode()
        ];
    
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
        
        // Renvoi de l'ID de la dernière ligne insérée
        return $this->db->lastInsertId();
    }
    
    public function editAdress(Adress $adress) : void
    {
        // Préparation de la requête SQL avec des paramètres nommés
        $query = $this->db->prepare("UPDATE address SET street=:street, city=:city, number=:number, zipcode=:zipcode WHERE id=:id");
    
        // Tableau associatif des valeurs à insérer dans la requête
        $parameters = [
            'id'=>$adress->getId(),
            'street'=>$adress->getStreet(),
            'city'=>$adress->getCity(),
            'number'=>$adress->getNumber(),
            'zipcode'=>$adress->getZipcode()
        ];
    
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
    }
    
    public function insertOrder(Order $order)
    {
        // Préparation de la requête SQL avec des paramètres nommés
        $query = $this->db->prepare('INSERT INTO orders VALUES (null, :address_id, :user_id, :total_price)');
    
        // Tableau associatif des valeurs à insérer dans la requête
        $parameters= [
            'address_id' => $order->getAddress_id(),
            'user_id' => $order->getUser_id(),
            'total_price' => $order->getTotal_price()
        ];
    
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
        
        // Renvoi de l'ID de la dernière ligne insérée
        return $this->db->lastInsertId();
    }
    
    public function addProductOnOrder(int $orderId, int $productId, int $size, int $number)
    {
        // Préparation de la requête SQL avec des paramètres nommés
        $query = $this->db->prepare('INSERT INTO orders_has_product VALUES (null, :orderId , :productId , :size , :number)');
    
        // Tableau associatif des valeurs à insérer dans la requête
        $parameters = [
            'orderId' => $orderId,
            'productId' => $productId,
            'size' => $size,
            'number' => $number
        ];
    
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
    }

    public function getUserAdressByAdressId(int $id) : Adress
    {
        // Prépare une requête pour sélectionner une adresse par son ID
        $query = $this->db->prepare("SELECT * FROM address WHERE id=:id");
        $parameters = [
            'id'=>$id
        ];
        // Exécute la requête avec les paramètres fournis
        $query->execute($parameters);
        // Récupère la première ligne de résultat de la requête sous forme d'array associatif
        $address = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet adresse avec les données récupérées de la base de données
        $return = new Adress(null, $address["street"],$address["city"],intval($address["number"]),intval($address["zipcode"]) );
        // Définit l'ID de l'adresse créée
        $return->setId($address["id"]);
        
        // Retourne l'objet adresse créé
        return $return;
    }
    
    public function addfavorite(int $userId, int $productId)
    {
        // Prépare une requête pour insérer une ligne dans la table favorite avec l'ID de l'utilisateur et l'ID du produit
        $query = $this->db->prepare('INSERT INTO favorite VALUES (:user_id, :product_id)');
        $parameters= [
        'user_id' => $userId,
        'product_id' => $productId
        ];
        // Exécute la requête avec les paramètres fournis
        $query->execute($parameters);
    }

    public function deletefavorite(int $userId, int $productId)
    {
        // Préparation de la requête SQL pour supprimer le favori
        $query = $this->db->prepare("DELETE FROM favorite WHERE user_id=:user_id AND product_id=:product_id");
        // Paramètres à passer à la requête
        $parameters = [
            'user_id'=>$userId,
            'product_id'=>$productId
        ];
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
    }
    
    public function deletefavoritefromProductId(int $productId)
    {
        // Préparation de la requête SQL pour supprimer tous les favoris associés à un produit
        $query = $this->db->prepare("DELETE FROM favorite WHERE product_id=:product_id");
        // Paramètres à passer à la requête
        $parameters = [
            'product_id'=>$productId
        ];
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
    }
    
    public function findAllfavorite(int $userId): array
    {
        // Préparation de la requête SQL pour récupérer tous les favoris d'un utilisateur
        $query = $this->db->prepare("SELECT * FROM favorite WHERE user_id = :user_id");
        // Paramètres à passer à la requête
        $parameters = [
            'user_id' => $userId
        ];
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
        // Récupération des résultats de la requête
        $favorites = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne les résultats
        return $favorites;
    }
    
    public function findAllOrdersForOneUser(int $userId): array
    {
        // Préparation de la requête SQL pour récupérer toutes les commandes d'un utilisateur
        $query = $this->db->prepare("
        SELECT orders.*, product.*, orders_has_product.*, media.* FROM orders
        JOIN orders_has_product ON orders.id = orders_has_product.orders_id
        JOIN product ON product.id = orders_has_product.product_id
        JOIN media ON media.id = orders_has_product.product_id
        WHERE orders.user_id = :user_id");
        // Paramètres à passer à la requête
        $parameters = [
            'user_id' => $userId
        ];
        // Exécution de la requête avec les paramètres
        $query->execute($parameters);
        // Récupération des résultats de la requête
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        // Initialisation d'un tableau vide pour stocker les produits par commande
        $myProducts = [];
        $result = $orders;
        // Parcours de tous les résultats
        foreach($result as $item)
        {
            // Si la commande a déjà été ajoutée au tableau, on ajoute le produit correspondant
            if(isset($myProducts[$item["orders_id"]]))
            {
                $myProducts[$item["orders_id"]]["products"][] = $item;
            }
            // Sinon, on crée une nouvelle entrée pour la commande et on y ajoute le produit correspondant
            else
            {
                $myProducts[$item["orders_id"]] = [];
                $myProducts[$item["orders_id"]]["products"] = [];
                $myProducts[$item["orders_id"]]["products"][] = $item;
            }
        }
        // Retourne le tableau contenant toutes les commandes avec les produits correspondants
        return $myProducts;
    }
    
}
?>