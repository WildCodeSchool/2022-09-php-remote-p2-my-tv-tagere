<?php

namespace App\Controller;

class ConnexionController extends AbstractController
{
    public function displayConnexion(): string
    {
        return $this->twig->render('FormConnect/connect.html.twig');
    }
}
