<?php

namespace App\Controller;

use App\Model\SerieManager;
use App\Model\UserSerieManager;

class SerieController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $serieManager = new SerieManager();
        $series = $serieManager->selectAll();
        return $this->twig->render('TVshows/index.html.twig', ['series' => $series]);
    }
}
