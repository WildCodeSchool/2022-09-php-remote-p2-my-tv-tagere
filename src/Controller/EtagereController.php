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

        return $this->twig->render(
            'Etagere/index.html.twig',
            ['favSeries' => $favSeries]
        );
    }

    public function edit(): ?string
    {

        $etagereModel = new UserSerieManager();
        $displayFavSeries = $etagereModel->favoritesSeriesById();

        $serieManager = new SerieManager();
        $favSeries = $serieManager->createCards($displayFavSeries);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serieId = $etagereModel->selectOneById($_SESSION['user_id']);
            $_POST['serie_id'] = $serieId['serie_id'];

            $seasonUpdate = $_POST;
            var_dump($seasonUpdate);

            $etagereModel->update($seasonUpdate);
            header('Location: /etagere');
            return null;
        }

        return $this->twig->render(
            'Etagere/index.html.twig',
            ['favSeries' => $favSeries,
            'post' => $_POST]
        );
    }
}
