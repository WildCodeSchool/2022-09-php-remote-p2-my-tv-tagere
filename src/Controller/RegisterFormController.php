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
                $userId = $this->registerModel->insert($user);
                $_SESSION['user_id'] = $userId;
                header('Location: /series');
            }
        }
        return $this->twig->render('FormConnect/register.html.twig', [
            'errors' => $errors
        ]);
    }

    private function validate(array $user)
    {
        $errors = [];
        if (empty($user['firstname'])) {
            $errors[] = 'Votre prémon est obligatoire';
        }
        if (empty($user['lastname'])) {
            $errors[] = 'Votre nom de famille est obligatoire';
        }
        if (empty($user['birthdate'])) {
            $errors[] = 'Votre date de naissance est obligatoire';
        }
        $registerManager = new RegisterManager();
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Votre email est obligatoire';
        } elseif ($registerManager->selectByOneByEmail($user['email'])) {
            $errors[] = 'Cette adresse email existe déjà';
        }


        if (empty($user['password'])) {
            $errors[] = 'Votre mot de passe est obligatoire';
        }
        return $errors;
    }
}
