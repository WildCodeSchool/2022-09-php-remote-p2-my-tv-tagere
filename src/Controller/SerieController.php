<?php

namespace App\Controller;

use App\Model\StyleTagManager;

class SerieController extends AbstractController
{
    /**
     * Display home page
     */
    public function index()
    {
        if (!$this->user) {
            echo "Tu n'as rien à faire là si tu n'es pas connecté";
            header('HTTP/1.1 401 Unauthorized');
        } else {
            $styleTagManager = new StyleTagManager();
            $styleTagManager->getFirstSeriesByTag();
            // $styleTagManager->getNumSeriesBytags();
            $styleTagManager->getMostUsedFavs();

            $seriesByTag = $styleTagManager->getFirstSeriesByTag();
            $seriesRecoms = $styleTagManager->getMostUsedFavs();

            return $this->twig->render('TVshows/index.html.twig', [
                'seriesByTag' => $seriesByTag,
                'seriesRecoms' => $seriesRecoms
            ]);
        }
    }
}
