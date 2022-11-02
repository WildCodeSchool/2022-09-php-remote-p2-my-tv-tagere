<?php

namespace App\Controller;

use App\Model\UserSerieManager;
use App\Model\SerieManager;

class UserSerieController extends AbstractController
{
    public function addToUser(int $serieId): string
    {
        $userSerieManager = new UserSerieManager();
        $userSerieManager->addOrDeleteToUser($serieId);

        $serieManager = new SerieManager();
        $series = $serieManager->selectAll();
        return $this->twig->render('TVshows/index.html.twig', ['series' => $series]);
    }
}
