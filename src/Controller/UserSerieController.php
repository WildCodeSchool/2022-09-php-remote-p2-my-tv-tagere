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

    public function addToUserAjax(int $serieId)
    {
        $userSerieManager = new UserSerieManager();
        return json_encode(['action' => $userSerieManager->addOrDeleteToUser($serieId)]);
    }
}
