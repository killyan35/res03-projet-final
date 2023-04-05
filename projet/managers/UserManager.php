<?php
class UserManager extends AbstractManager {

    public function getUserById(int $id) : User
    {
       
        $query = $this->db->prepare("SELECT * FROM user WHERE id=:id");
        $parameters = [
            'id'=>$id
        ];
        $query->execute($parameters);
        $users = $query->fetch(PDO::FETCH_ASSOC);
        $return = new User(null, $users["first_name"],$users["last_name"],$users["email"],$users["password"], null);
        $return->setId($users["id"]);
        if($users["address_id"] != null)
            {
                $return->setAddress_id($users["address_id"]);
            }
        return $return;
    }
    public function getUserByEmail(string $email) : User
    {
       
        $query = $this->db->prepare("SELECT * FROM user WHERE email=:email");
        $parameters = [
            'email'=>$email
        ];
        $query->execute($parameters);
        
        $users = $query->fetch(PDO::FETCH_ASSOC);
        if($users!==false)
        {
            $return = new User(null, $users["first_name"],$users["last_name"],$users["email"],$users["password"], null);
            $return->setId($users["id"]);
            $return->setRole($users["role"]);
            if($users["address_id"] != null)
            {
                $return->setAddress_id($users["address_id"]);
            }
           
            return $return;
        }
        else
        {
            return null;
        }
        
    }
    
    public function insertUser(User $user)
    {
        $query = $this->db->prepare('INSERT INTO user VALUES (null, :prenom, :nom, :email, :mdp, :role, null)');
        $parameters= [
        'prenom' => $user->getFirstname(),
        'nom' => $user->getLastname(),
        'email' => $user->getEmail(),
        'mdp' => password_hash($user->getPassword() , PASSWORD_DEFAULT),
        'role' => $user->getRole()
        ];
        $query->execute($parameters);
    }
    
    public function editUser(User $user) : void
    {
    $query = $this->db->prepare("UPDATE user SET first_name=:first_name, last_name=:last_name, email=:email, password=:password WHERE id=:id");
    $parameters = [
        'id'=>$user->getId(),
        'first_name'=>$user->getFirstname(),
        'last_name'=>$user->getLastname(),
        'email'=>$user->getEmail(),
        'password'=> password_hash($user->getPassword() , PASSWORD_DEFAULT)
    ];
    $query->execute($parameters);
    }
    
    public function EditUserWithAddress(User $user) : void
    {
    $query = $this->db->prepare("UPDATE user SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, address_id=:address_id WHERE id=:id");
    $parameters = [
        'id'=>$user->getId(),
        'first_name'=>$user->getFirstname(),
        'last_name'=>$user->getLastname(),
        'email'=>$user->getEmail(),
        'password'=> password_hash($user->getPassword() , PASSWORD_DEFAULT),
        'address_id'=>$user->getAddress_id()
    ];
    $query->execute($parameters);
    }
    
    
    public function deleteUser(User $user)
    {
        
        $query = $this->db->prepare("DELETE FROM user WHERE id=:id");
        $parameters = [
            'id'=>$user->getId()
        ];
        $query->execute($parameters);
    }
    
    
    public function findAllUser() : array
        {
            $query = $this->db->prepare("SELECT * FROM user");
            $query->execute([]);
            $users = $query->fetchAll(PDO::FETCH_ASSOC);
          
            $return = [];
            foreach ($users as $user)
            {
                $newUser = new User(null, $user["first_name"],$user["last_name"],$user["email"],$user["password"], null);
                $newUser->setId($user["id"]);
                $return[]=$newUser;
            }
            return $return;
        }
    public function insertAdress(Adress $adress)
    {
        $query = $this->db->prepare('INSERT INTO address VALUES (null, :street, :city, :number, :zipcode)');
        $parameters= [
        'street' => $adress->getStreet(),
        'city' => $adress->getCity(),
        'number' => $adress->getNumber(),
        'zipcode' => $adress->getZipcode()
        ];
        $query->execute($parameters);
        
        return $this->db->lastInsertId();
    }
    public function editAdress(Adress $adress) : void
    {
    $query = $this->db->prepare("UPDATE address SET street=:street, city=:city, number=:number, zipcode=:zipcode WHERE id=:id");
    $parameters = [
        'id'=>$adress->getId(),
        'street'=>$adress->getStreet(),
        'city'=>$adress->getCity(),
        'number'=>$adress->getNumber(),
        'zipcode'=>$adress->getZipcode()
    ];
    $query->execute($parameters);
    }
    
    public function insertOrder(Order $order)
    {
        $query = $this->db->prepare('INSERT INTO orders VALUES (null, :address_id, :user_id, :total_price)');
        $parameters= [
        'address_id' => $order->getAddress_id(),
        'user_id' => $order->getUser_id(),
        'total_price' => $order->getTotal_price()
        ];
        $query->execute($parameters);
        
        return $this->db->lastInsertId();
    }

   public function addProductOnOrder(int $orderId, int $productId, int $size, int $number)
   {
        $query = $this->db->prepare('INSERT INTO orders_has_product VALUES (:orderId , :productId , :size , :number)');
        $parameters = [
            'orderId' => $orderId,
            'productId' => $productId,
            'size' => $size,
            'number' => $number
        ];

        $query->execute($parameters);
    }

    public function getUserAdressByAdressId(int $id) : Adress
    {
        $query = $this->db->prepare("SELECT * FROM address WHERE id=:id");
        $parameters = [
            'id'=>$id
        ];
        $query->execute($parameters);
        $address = $query->fetch(PDO::FETCH_ASSOC);
        $return = new Adress(null, $address["street"],$address["city"],intval($address["number"]),intval($address["zipcode"]) );
        $return->setId($address["id"]);
        
        return $return;
    }
    
    public function addfavorite(int $userId, int $productId)
    {
        $query = $this->db->prepare('INSERT INTO favorite VALUES (:user_id, :product_id)');
        $parameters= [
        'user_id' => $userId,
        'product_id' => $productId
        ];
        $query->execute($parameters);
    }
    public function deletefavorite(int $userId, int $productId)
    {
        
        $query = $this->db->prepare("DELETE FROM favorite WHERE user_id=:user_id AND product_id=:product_id");
        $parameters = [
            'user_id'=>$userId,
            'product_id'=>$productId
        ];
        $query->execute($parameters);
    }
    public function findAllfavorite(int $userId) : array
        {
            $query = $this->db->prepare("SELECT * FROM favorite WHERE user_id=:user_id");
            $parameters = [
            'user_id'=>$userId
            ];
            $query->execute([$parameter]);
            $favorites = $query->fetchAll(PDO::FETCH_ASSOC);
            return $favorites;
        }
}
?>