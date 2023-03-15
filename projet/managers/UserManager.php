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
        $return = new User($users["first_name"],$users["last_name"],$users["email"],$users["password"]);
        $return->setId($users["id"]);
        
        return $return;
    }
    public function getUserByEmail(string $email) : ?User
    {
       
        $query = $this->db->prepare("SELECT * FROM user WHERE email=:email");
        $parameters = [
            'email'=>$email
        ];
        $query->execute($parameters);
        
        $users = $query->fetch(PDO::FETCH_ASSOC);
        if($users!==false)
        {
            $return = new User($users["first_name"],$users["last_name"],$users["email"],$users["password"]);
            $return->setId($users["id"]);
            $return->setRole($users["role"]);
            return $return;
        }
        else
        {
            return null;
        }
        
    }
    
    public function insertUser(User $user)
    {
        $query = $this->db->prepare('INSERT INTO user VALUES (null, :prenom, :nom, :email, :mdp, :role, null, null)');
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
        'password'=>$user->getPassword()
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
                $newUser = new User($user["first_name"],$user["last_name"],$user["email"],$user["password"]);
                $newUser->setId($user["id"]);
                $return[]=$newUser;
            }
            return $return;
        }
    
    
    public function findAllProductOnOneCat(string $slug)
    {
        
    }
    
    
}
?>