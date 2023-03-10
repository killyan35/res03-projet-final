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
        $return = new User($users["firstname"],$users["lastname"],$users["email"],$users["password"],$users["role"]);
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
            $return = new User($users["firstname"],$users["lastname"],$users["email"],$users["password"],$users["role"]);
            $return->setId($users["id"]);
            return $return;
        }
        else
        {
            return null;
        }
        
    }
    
    public function insertUser(User $user) : User
    {
        $query = $this->db->prepare('INSERT INTO user VALUES (null, :value1, :value2, :value3, :value4, :value5)');
        $parameter = [
        'value1' => $user->getFirstname(),
        'value2' => $user->getLastname(),
        'value3' => $user->getEmail(),
        'value4' => $user->getPassword(),
        'value5' => $user->getRole()
        ];
        $query->execute($parameter);
        
        $query = $this->db->prepare("SELECT * FROM user WHERE email=:value");
        $parameters = ['value' => $user->getEmail()];
        $query->execute($parameters);
        $users = $query->fetch(PDO::FETCH_ASSOC);
        $UserToReturn = new User($users["firstname"],$users["lastname"],$users["email"],$users["password"],$users["role"]);
        $UserToReturn->setId($users["id"]);
        return $UserToReturn ;
    }
    
}
?>