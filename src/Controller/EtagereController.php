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

        $seenUpdate = new UserSerieManager();
        $serieUpdate = $this->seriemodel->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['id'] = $_GET['id'];
            $serieUpdate = array_map('trim', $_POST);


            $this->seriemodel->update($serieUpdate);

            header('Location: /seriepage?id=' . $id);
            return null;
        } else {
            return $this->twig->render('SeriePage/update.html.twig', [
                'serie' => $serie,
            ]);
        }
    }
}
