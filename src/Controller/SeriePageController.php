<?php

namespace App\Controller;

use App\Model\SeriePageManager;

class SeriePageController extends AbstractController
{
    private SeriePageManager $seriemodel;

    public function index(): string
    {
        $this->seriemodel = new SeriePageManager();
        $serie = $this->seriemodel->selectOneById($_GET["id"]);
        return $this->twig->render('SeriePage/index.html.twig', ['serie' => $serie,]);
    }
}
