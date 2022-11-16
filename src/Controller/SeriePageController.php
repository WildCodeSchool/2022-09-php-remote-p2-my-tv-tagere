<?php

namespace App\Controller;

use App\Model\SeriePageManager;
use App\Model\SerieStyleManager;

class SeriePageController extends AbstractController
{
    //Pourquoi pas ici et pas en mode habituel ?
    private SeriePageManager $seriemodel;

    public function index(): string
    {
        $this->seriemodel = new SeriePageManager();
        $serie = $this->seriemodel->selectOneById($_GET["id"]);
        $serieStyleManager = new SerieStyleManager();
        $serie['styleTags'] = [...$serieStyleManager->selectTagsBySerieId($_GET["id"])];
        return $this->twig->render('SeriePage/index.html.twig', ['serie' => $serie,]);
    }
}
