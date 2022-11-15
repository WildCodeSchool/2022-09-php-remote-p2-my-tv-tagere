<?php

namespace App\Controller;

use App\Model\SeriePageManager;

class SeriePageController extends AbstractController
{
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
