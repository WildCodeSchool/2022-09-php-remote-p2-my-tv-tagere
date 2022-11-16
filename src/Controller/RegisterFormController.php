<?php

namespace App\Controller;

use App\Model\RegisterManager;

class RegisterFormController extends AbstractController
{
    private RegisterManager $registerModel;


    public function __construct()
    {
        parent::__construct();
        $this->registerModel = new RegisterManager();
    }


    public function displayRegister(): string
    {
        return $this->twig->render('FormConnect/register.html.twig');
    }


    public function addUser()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $user = array_map('trim', $_POST);
            $user = array_map('htmlentities', $user);

            $errors = $this->validate($user);

            if (empty($errors)) {
                $this->registerModel->insert($user);
                header('Location: connexion');
            }
        }
        return $this->twig->render('FormConnect/register.html.twig', [
            'errors' => $errors
        ]);
    }

    private function validate(array $user)
    {
        $errors = [];
        if (empty($user['firstname']) || mb_strlen($user['firstname']) <= 1) {
            $errors[] = 'Votre prémon est obligatoire et doit comporter plus d\'une lettre';
        }
        if (empty($user['lastname']) || mb_strlen($user['lastname']) <= 1) {
            $errors[] = 'Votre nom de famille est obligatoire et doit comporter plus d\'une lettre';
        }
        if (empty($user['birthdate'])) {
            $errors[] = 'Votre date de naissance est obligatoire';
        }
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Votre email est obligatoire';
        }
        if (empty($user['password'])) {
            $errors[] = 'Votre mot de passe est obligatoire';
        }
        return $errors;
    }
}
