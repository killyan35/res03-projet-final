<?php
class AdminController extends AbstractController {
    private AdminManager $manager;
    
    public function __construct()
    {
        
        $this->manager = new AdminManager();
    }
    public function category() 
        {
            $this->render("category", []);
        }
}

?>