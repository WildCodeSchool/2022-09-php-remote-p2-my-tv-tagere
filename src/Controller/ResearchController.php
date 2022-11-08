<?php

namespace App\Controller;

use App\Model\SerieManager;

class ResearchController extends AbstractController
{
    public function getResearch($research)
    {
        $serieManager = new SerieManager();
        $searchResults = htmlentities(trim($research));
        $searchResults = $serieManager->searchEngine($research);
        if ($searchResults) {
            $searchResults = $serieManager->createCards($searchResults);
        }
        return $this->twig->render('Layouts/search.html.twig', ['searchResults' => $searchResults]);
    }
}
