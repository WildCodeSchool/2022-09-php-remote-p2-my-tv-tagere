<?php

namespace App\Controller;

use App\Model\UserSerieManager;
use App\Model\StyleTagManager;

class UserSerieController extends AbstractController
{
    public function addToUser(int $serieId)
    {
        $userSerieManager = new UserSerieManager();
        $userSerieManager->addOrDeleteToUser($serieId);
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
