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

    public function edit(int $id): ?string
    {
        $etagereModel = new UserSerieManager();
        $serieManager = new SerieManager();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $updatedCredential['id'] = $_GET['id'];
            $updatedCredential['user_id'] = $_SESSION['user_id'];

            $serieId = $etagereModel->selectOneByid($_GET['id']);
            $_POST['serie_id'] = $serieId['serie_id'];

            $seasonUpdate = $_POST;
            var_dump($seasonUpdate);

            $etagereModel->update($seasonUpdate);
            header('Location: /etagere/edit?id=' . $id);

            return $this->twig->render(
                'etagere/update.html.twig',
                ['post' => $_POST,
                'seasonUpdate' => $seasonUpdate]
            );
        }

        return $this->twig->render(
            'etagere/update.html.twig',
            ['post' => $_POST,]
        );
    }
}
