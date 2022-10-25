<?php

namespace App\Controller;

use App\Model\ItemManager;

class TVshowsController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('TVshows/index.html.twig');
    }
}
