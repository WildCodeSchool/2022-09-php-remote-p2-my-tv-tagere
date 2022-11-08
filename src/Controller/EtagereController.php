<?php

namespace App\Controller;

use App\Model\SerieManager;

class EtagereController extends AbstractController
{
    public function index(): string
    {
        /*$etagereModel = new SerieManager();
        $seriesByTag = $etagereModel->getFirstSeriesByTag();*/

        return $this->twig->render('Etagere/index.html.twig');
    }
}
