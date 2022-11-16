<?php

namespace App\Controller;

use App\Model\SeriePageManager;
use App\Model\SerieStyleManager;

class SeriePageController extends AbstractController
{
    //Pourquoi pas ici et pas en mode habituel ?
    private SeriePageManager $seriemodel;
    public const TABLE = "serie";

    public function __construct()
    {
        parent::__construct();
        $this->seriemodel = new SeriePageManager();
    }

    public function index(): string
    {

        $serie = $this->seriemodel->selectOneById($_GET["id"]);
        $serieStyleManager = new SerieStyleManager();
        $serie['styleTags'] = [...$serieStyleManager->selectTagsBySerieId($_GET["id"])];
        return $this->twig->render('SeriePage/index.html.twig', ['serie' => $serie,]);
    }

    public function edit(int $id): ?string
    {

        $serie = 'serie';
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
