<?php

namespace App\Controller;

use App\Model\UserSerieManager;
use App\Model\SerieManager;

class EtagereController extends AbstractController
{
    public function index(): string
    {
        $etagereModel = new UserSerieManager();
        $displayFavSeries = $etagereModel->favoritesSeriesById();

        $serieManager = new SerieManager();
        $favSeries = $serieManager->createCards($displayFavSeries);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seasonUpdate = array_map('trim', $_POST);
            $etagereModel->update($seasonUpdate);
            header('Location: /etagere');
        }
        return $this->twig->render(
            'Etagere/index.html.twig',
            ['favSeries' => $favSeries]
        );
    }
}
