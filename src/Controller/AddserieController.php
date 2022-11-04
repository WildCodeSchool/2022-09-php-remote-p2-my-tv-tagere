<?php

namespace App\Controller;

use App\Model\SerieManager;

class AddserieController extends AbstractController
{
    private SerieManager $serieModel;

    public function addSerie()
    {
        $errors = [];
        $this->serieModel = new SerieManager();
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $serie = array_map('trim', $_POST);
            $serie = array_map('htmlentities', $serie);

            $errors = $this->verification($serie);
            if ($this->serieModel->selectOneByNameAndYear($serie)) {
                $errors['serieExist'] = 'Cette série existe déjà';
            }

            if (empty($errors)) {
                $this->serieModel->insertSerie($serie);
                /*return $this->twig->render('Addserie/index.html.twig', [
                    'serie' => $serie
                ]);*/
                header("Location: /series");
            }
        }
        return $this->twig->render('Addserie/index.html.twig', [
            'errors' => $errors
        ]);
    }

    private function verification(array $serie)
    {
        $errors = [];
        if (empty($serie['serieName'])) {
            $errors[] = 'Le nom de la série est obligatoire';
        }
        if (empty($serie['year'])) {
            $errors[] = 'La date de parution est obligatoire';
        }
        if (empty($serie['nbOfSeasons'])) {
            $errors[] = 'le nombre de saisons est obligatoire';
        }
        if (empty($serie['description'])) {
            $errors[] = 'La description de la série est obligatoire';
        }
        return $errors;
    }
}
