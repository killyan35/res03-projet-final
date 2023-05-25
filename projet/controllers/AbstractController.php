<?php
abstract class AbstractController {

    public function renderadmin(string $view, array $values) : void
    {
        $template=$view;
        $data=$values;
        require 'templates/layout-admin.phtml';
    }
    public function renderpublic(string $view, array $values) : void
    {
        $template=$view;
        $data=$values;
        require 'templates/layout-public.phtml';
    }
    public function renderprive(string $view, array $values) : void
    {
        $template=$view;
        $data=$values;
        require 'templates/layout-prive.phtml';
    }
    public function cleanInput($unsafeCode)
    {
        $safeCode = htmlspecialchars($unsafeCode);
        return $safeCode;
    }
}
?>