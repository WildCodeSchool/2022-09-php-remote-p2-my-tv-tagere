<?php

namespace App\Controller;

use App\Model\StyleTagManager;

class SerieController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $styleTagManager = new StyleTagManager();
        $seriesByTag = $styleTagManager->getFirstSeriesByTag();
        return $this->twig->render('TVshows/index.html.twig', ['seriesByTag' => $seriesByTag]);
    }
}
