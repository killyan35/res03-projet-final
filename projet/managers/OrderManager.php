<?php
class OrderManager extends AbstractManager 
{
    public function createOrder()
    {
        // Prépare la requête SQL pour insérer une nouvelle commande dans la base de données
        $query = $this->db->prepare('INSERT INTO orders VALUES (null, :billing, :size, :number, :totalPrice, null)');
        
        // Les paramètres à insérer dans la commande sont stockés dans un tableau associatif
        $parameters= [
            'prenom' => $user->getFirstname(),
            'nom' => $user->getLastname(),
            'email' => $user->getEmail(),
            'mdp' => password_hash($user->getPassword() , PASSWORD_DEFAULT),
            'role' => $user->getRole()
        ];
        
        // Exécute la requête SQL avec les paramètres fournis
        $query->execute($parameters);
    }
}
?>