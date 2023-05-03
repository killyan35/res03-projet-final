<?php
class AllergenController extends AbstractController {
    private AllergenManager $manager;
    
    public function __construct()
    {
        $this->manager = new AllergenManager();
    }
    
public function displayAllergens()
{
    // Récupération de tous les allergènes depuis la base de données
    $Allergens = $this->manager->findAllAllergens();
    // Affichage de la vue "allergen" avec les données récupérées
    $this->renderadmin("allergen", $Allergens);
}

public function createAllergen(array $post)
{
    // Vérification que le formulaire a été soumis
    if (isset($post["formName"]))
    {
        // Vérification que le champ "name" du formulaire a été rempli
        if (isset($post['name']) && $post['name']!=='') 
        {
            // Création d'un nouvel allergène
            $allergenToAdd = new Allergen(null, $post["name"]);
            // Insertion de l'allergène dans la base de données
            $this->manager->insertAllergen($allergenToAdd);
            // Redirection vers la liste de tous les allergènes
            header("Location: /res03-projet-final/projet/admin/allergen");
        }
    }
}

public function EditAllergen(array $post, string $name)
{
    // Vérification que le formulaire a été soumis
    if (isset($post["formName"]))
    {
        // Vérification que le champ "name" du formulaire a été rempli
        if (isset($post['name']) && $post['name']!=='')
        {
            // Récupération de l'allergène à modifier
            $allergenToChange = $this->manager->getAllergenBySlug($name);
            // Modification du nom de l'allergène
            $allergenToChange->setName($post['name']);
            // Mise à jour de l'allergène dans la base de données
            $this->manager->editAllergen($allergenToChange);
            // Redirection vers la liste de tous les allergènes
            header("Location: /res03-projet-final/projet/admin/allergen");
        }
    }
}

public function displayUpdateFormAllergen(string $name)
{
    // Récupération de l'allergène à modifier
    $allergens = $this->manager->getAllergenBySlug($name);
    // Stockage des données récupérées dans un tableau
    $tab = [];
    $tab["allergen"]= $allergens;
    // Affichage de la vue "edit-allergen" avec les données récupérées
    $this->renderadmin("edit-allergen", $tab);
}

public function deleteAllergen(string $name)
{
    // Récupération de l'allergène à supprimer
    $delete = $this->manager->getAllergenBySlug($name);
    $id = $delete->getId();
    // Suppression de l'allergène dans tous les produits associés
    $deleteallerg = $this->manager->deleteOneAllergenInAllProduct(intval($id));
    // Suppression de l'allergène dans la base de données
    $this->manager->deleteAllergen($delete);
    // Redirection vers la liste de tous les allergènes
    header("Location: /res03-projet-final/projet/admin/allergen");
}

}

?>