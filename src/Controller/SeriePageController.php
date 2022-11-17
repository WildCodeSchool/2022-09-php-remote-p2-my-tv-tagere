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
        $serie = $this->seriemodel->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serieUpdate = array_map('trim', $_POST);
            $serieUpdate['year'] = (is_numeric($serieUpdate['year']) && intval($serieUpdate['year']) > 1) ?
                intval($serieUpdate['year']) : $serie["year"];
            $serieUpdate['nbOfSeasons'] = (is_numeric($serieUpdate['nbOfSeasons']) &&
                intval($serieUpdate['nbOfSeasons']) > 1) ?
                intval($serieUpdate['nbOfSeasons']) : $serie["nb_of_seasons"];
            $serieUpdate['id'] = $id;
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
