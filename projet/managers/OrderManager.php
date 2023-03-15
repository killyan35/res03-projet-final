<?php
class OrderManager extends AbstractManager 
{
    // 'SELECT products.* FROM products_categories JOIN products ON products_categories.products_id = products.id JOIN categories 
    // ON products_categories.category_id = categories.id WHERE categories.slug =:slug '
    public function getOrderByUser(string $slug)
    {
        
    }
    
    public function  createOrder()
    {
        $query = $this->db->prepare('INSERT INTO order VALUES (null, :billing, :size, :number, :totalPrice, null)');
        $parameters= [
        'prenom' => $user->getFirstname(),
        'nom' => $user->getLastname(),
        'email' => $user->getEmail(),
        'mdp' => password_hash($user->getPassword() , PASSWORD_DEFAULT),
        'role' => $user->getRole()
        ];
        $query->execute($parameters);
    }
}
?>