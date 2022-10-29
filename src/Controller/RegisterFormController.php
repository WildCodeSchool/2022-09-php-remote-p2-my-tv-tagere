<?php

namespace App\Controller;

use App\Model\RegisterManager;

class RegisterFormController extends AbstractController
{
    private RegisterManager $registerModel;



    // Je n'arrive pas à intitialiser la paramètre du constructeur dans les méthodes ci-dessous.
    //On me signale toujours une erreur. Pourrait on revoir çs ensemble ?
    // Dans l'ItemController, la nouvelle lasse est initialisée dans chaque méthode, sans passer par le contruct.
    // Je suis assez perplexe.

    // public function __construct()
    // {

    //     $this->registerModel = new RegisterManager();

    // }


    public function displayRegister(): string
    {

        $this->registerModel = new RegisterManager();
        return $this->twig->render('FormConnect/register.html.twig');
    }


    public function addUser()
    {
        $errors = [];
        $this->registerModel = new RegisterManager();
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $user = array_map('trim', $_POST);
            $user = array_map('htmlentities', $user);

            $errors = $this->validate($user);


            if (empty($errors)) {
                $this->registerModel->insert($user);
                return $this->twig->render('FormConnect/connect.html.twig', [
                    'user' => $user
                ]);
            } else {
                return $this->twig->render('FormConnect/register.html.twig', [
                    'errors' => $errors
                ]);
            }
        }
    }

    private function validate(array $user)
    {
        $errors = [];
        if (empty($user['firstname']) || $user['firstname'] <= 2) {
            $errors[] = 'Votre prémon est obligatoire';
        }
        if (empty($user['lastname']) || $user['firstname'] <= 2) {
            $errors[] = 'Votre nom de famille est obligatoire';
        }
        if (empty($user['birthdate'])) {
            $errors[] = 'Votre date de naissance est obligatoire';
        }
        return $errors;
    }
}
