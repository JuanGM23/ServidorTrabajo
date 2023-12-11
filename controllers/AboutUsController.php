<?php
// controllers/AboutUsController.php

class AboutUsController
{
    public function index()
    {
        $aboutUsModel = new AboutUsModel();
        $roles = $aboutUsModel->getRoles();

        // Pasar los roles a la vista
        require 'views/about_us_view.php';
    }
}
?>
