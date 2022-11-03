<?php

namespace App\Controller;

use App\Model\UserSerieManager;
use App\Model\StyleTagManager;

class UserSerieController extends AbstractController
{
    public function addToUser(int $serieId): string
    {
        $userSerieManager = new UserSerieManager();
        $userSerieManager->addOrDeleteToUser($serieId);

        $styleTagManager = new StyleTagManager();
        $seriesByTag = $styleTagManager->getFirstSeriesByTag();
        return $this->twig->render('TVshows/index.html.twig', ['seriesByTag' => $seriesByTag]);
    }
}
