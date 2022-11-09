<?php

namespace App\Controller;

use App\Model\RegisterManager;

class ConnexionController extends AbstractController
{
    private RegisterManager $userTable;

    public function __construct()
    {
        parent::__construct();
        $this->userTable = new RegisterManager();
    }

    public function displayConnexion(): string
    {
        return $this->twig->render('FormConnect/connect.html.twig');
    }

    public function validate(array $userLog): array
    {
        $errors = [];
        if (empty($userLog['email'])) {
            $errors[] = 'Votre email est obligatoire';
        }
        if (empty($userLog['password'])) {
            $errors[] = 'Votre mot de passe est obligatoire';
        }
        return $errors;
    }

    public function login()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $userLog = array_map('trim', $_POST);
            $userLog = array_map('htmlentities', $userLog);

            $errors = $this->validate($userLog);


            if (empty($errors)) {
                $userCheck = $this->userTable->selectByOneByEmail($userLog['email']);
                if ($userCheck && password_verify($userLog['password'], $userCheck['password'])) {
                    $_SESSION['user_id'] = $userCheck['id'];
                    header('Location: /series');
                } else {
                    $errors[] = 'Votre email ou votre mot de passe est éronné';
                    return $this->twig->render('FormConnect/connect.html.twig', [
                        'errors' => $errors
                    ]);
                }
            }
        } else {
            return $this->twig->render('FormConnect/connect.html.twig', [
                'errors' => $errors
            ]);
        }
    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        header('Location: /connexion');
    }
}
