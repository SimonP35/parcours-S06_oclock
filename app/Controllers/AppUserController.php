<?php

//! AppUserController (Classe gérant l'affichage des pages relatives aux utilisateurs)

//? Namespace 
namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    public function login()
    {
        $this->generateCSRFToken();

        $this->show('appuser/signin');
    }

    public function loginPost()
    {
        $router = $this->router;

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $errorList = [];

        if (empty($email) && empty($password)) {
            $errorList [] = "Merci de remplir le champ Email !";
            $errorList [] = "Merci de remplir le champ Password !";
            $this->show('appuser/signin', [ "errorList" => $errorList ]);
            exit;
        } elseif (empty($email)) {
            $errorList [] = "Merci de remplir le champ Email !";
            $this->show('appuser/signin', [ "errorList" => $errorList ]);
            exit;
        } elseif (empty($password)) {
            $errorList [] = "Merci de remplir le champ Password !";
            $this->show('appuser/signin', [ "errorList" => $errorList ]);
            exit;
        }

        $user = AppUser::findByEmail($email);

        if ($user != false) {
           $hashPassword = $user->getPassword();
        }

        if ($user === false) {
            $errorList [] = "Votre adresse Email est incorrecte, veuillez vous identifiez à nouveau !";
            $errorList [] = "Votre mot de passe est incorrecte, veuillez vous identifiez à nouveau !";
            $this->show('appuser/signin', [ 'errorList' => $errorList ]);
        } elseif ($user != false && !password_verify($password, $hashPassword)) {
            $errorList [] = "Votre mot de passe est incorrecte, veuillez vous identifiez à nouveau !";
            $this->show('appuser/signin', [ 'errorList' => $errorList ]);
        } elseif ($user != false && password_verify($password, $hashPassword)) {
            $_SESSION['userId'] = $user->getId();
            $_SESSION['userObject'] = $user;

            header('Location: ' . $router->generate('main-home'));
        }

    }

    public function logout()
    {
        $router = $this->router;
        unset($_SESSION['userObject']);
        header("Location: ".$router->generate('user-login'));
    }

    public function list()
    {
        $this->generateCSRFToken();

        $appuserList = AppUser::findAll("app_user", "AppUser");

        $viewVars = [
            "appuserList" => $appuserList,
        ];

        $this->show("appuser/list", $viewVars);
    }

    public function add()
    {
        $this->generateCSRFToken();

        $appuser = AppUser::findAll("app_user", "AppUser");

        $viewVars = [
            'appuser' => $appuser,
        ];

        $this->show('appuser/add', $viewVars);
    }

    public function addPost()
    {
        $router = $this->router;

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        $errorList = [];

        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errorList[] = "Merci de remplir le champ : {$key} !";
            }
        }

        if (empty($errorList)) {

            $hasedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $student = new AppUser();
            $student->setEmail($email);
            $student->setName($name);
            $student->setPassword($hasedPassword);
            $student->setRole($role);
            $student->setStatus($status);

            if ($student->save()) {
                header("Location: ".$router->generate('user-list'));
                exit;
            } else {
                $errorList[] = 'La sauvegarde a échoué';
            }
        }

        if (!empty($errorList)) {
            $this->show('appuser/add', [ 'errorList' => $errorList ]);
            exit;
        }
    }

    public function update($id)
    {
        $this->generateCSRFToken();

        $appuser = AppUser::find($id, "app_user", "AppUser");

        $viewVars = [
            'appuser' => $appuser,
        ];

        $this->show('appuser/edit', $viewVars);
    }

    public function updatePost($id)
    {
        $router = $this->router;

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        $errorList = [];

        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errorList[] = "Merci de remplir le champ : {$key} !";
            }
        }

        if (empty($errorList)) {

            $hasedPassword = password_hash($password, PASSWORD_DEFAULT);

            $appuser = AppUser::find($id, "app_user", "AppUser");

            $appuser->setEmail($email);
            $appuser->setName($name);
            $appuser->setPassword($hasedPassword);
            $appuser->setRole($role);
            $appuser->setStatus($status);

            if ($appuser->save()) {
                header("Location: " . $router->generate("user-update", [ "id" => $appuser->getId()]));
                exit;
            } else {
                $errorList[] = 'La sauvegarde a échoué';
            }
        }

        if (!empty($errorList)) {
            $this->show('appuser/edit', ['errorList' => $errorList]);
            exit;
        }
    }

    public function delete($id)
    {
        $router = $this->router;

        $appuser = AppUser::find($id, "app_user", "AppUser");

        $appuser->delete();

        header("Location: ".$router->generate('user-list'));
        exit;
    }

}