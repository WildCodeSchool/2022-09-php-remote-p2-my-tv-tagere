<?php

namespace App\Controller;

use App\Model\UserSerieManager;

class UserSerieController extends AbstractController
{
    public function addToUser(int $serieId)
    {
        $userSerieManager = new UserSerieManager();
        $userSerieManager->addOrDeleteToUser($serieId);
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
