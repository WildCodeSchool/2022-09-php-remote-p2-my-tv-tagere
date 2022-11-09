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

            $uploadDir = __DIR__ . '/../../public/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            $serie['image'] = $_FILES['image']['name'];
            $errors = $this->verification($serie);
            if ($this->serieModel->selectOneByNameAndYear($serie)) {
                $errors['serieExist'] = 'Cette série existe déjà';
            }

            if (empty($errors)) {
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
                $this->serieModel->insertSerie($serie);
                /*return $this->twig->render('Addserie/index.html.twig', [
                    'serie' => $serie
                ]);*/
                // header("Location: /series");
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

        $extension = pathinfo($serie['image'], PATHINFO_EXTENSION);
        $authorizedExtensions = ['jpg', 'gif', 'png', 'webp'];
        $maxFileSize = 2000000;

        if ((!in_array($extension, $authorizedExtensions))) {
            $errors[] = 'Veuillez sélectionner une image de type Jpg ou Gif ou Png ou Webp !';
        }
        if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
            $errors[] = 'Votre fichier doit faire moins de 2 Mo !';
        }
        return $errors;
    }
}
