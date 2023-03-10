<?php
class EventController extends AbstractController {
    private EventManager $manager;
    
    public function __construct()
    {
        $this->manager = new EventManager();
    }
}

?>