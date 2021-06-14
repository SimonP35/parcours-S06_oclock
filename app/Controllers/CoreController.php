<?php

//! CoreController (Classe abstraite parent des autres Controllers)

//? Namespace 
namespace App\Controllers;

abstract class CoreController
{

    //?===========================================
    //?               Propriétés
    //?===========================================

    protected $router;
    protected $match;

    //?===========================================
    //?               Méthodes
    //?===========================================

    // Constructeur
    public function __construct($router, $match)
    {
        $this->router = $router;
        $this->match = $match;

        //?ACL (Access Control List)

        // Je récupère le nom de la route courante pour la mise en place de mon ACL
        $route = $match['name'];

        $acl = [
            //Main
            'main-home' => ['user', 'admin'],

            //Teacher
            'teacher-list' => ['user', 'admin'],
            'teacher-add' => ['admin'],
            'teacher-addPost' => ['admin'],
            'teacher-update' => ['admin'],
            'teacher-updatePost' => ['admin'],
            'teacher-delete' => ['admin'],

            //Student
            'student-list' => ['user', 'admin'],
            'student-add' => ['user', 'admin'],
            'student-addPost' => ['user', 'admin'],
            'student-update' => ['user', 'admin'],
            'student-updatePost' => ['user', 'admin'],
            'student-delete' => ['user', 'admin'],

            //User
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-addPost' => ['admin'],
            'user-update' => ['admin'],
            'user-updatePost' => ['admin'],
            'user-delete' => ['admin'],
        ];

        // Vérification de la correspondance entre notre le nom de la route courante avec l'une des clés de notre ACL
        if (array_key_exists($route, $acl)) {
            $requiredRole = $acl[$route];
            $this->checkAuthorization($requiredRole);
        }

        //?Sécurité CSRF

        // Tableaux des routes sensibles à la faille CSRF nécessitant la mise en place d'un Token
        $csrfTokenToCheckInPost = [
            // Teacher
            "teacher-addPost",
            "teacher-updatePost",
            // Student
            "student-addPost",
            "student-updatePost",
            // AppUser POST
            "user-loginPost",
            "user-addPost",
            "user-updatePost",
        ];

        $csrfTokenToCheckInGet = [
            // Delete
            "student-delete",
            "teacher-delete",
            "user-delete",
        ];

        // Vérification de la présence du nom de la route courante dans le tableau des routes vulnérable a la CSRF
        if (in_array($route, $csrfTokenToCheckInPost)) {
            // Si la route est présente je lance la méthode permettant de vérifier la correspondance entre le token du formulaire et le token de la session courante
            $this->checkPOSTCSRFToken();
        }
         elseif (in_array($route, $csrfTokenToCheckInGet)){
            $this->checkGETCSRFToken();
        }
    }

    public function checkPOSTCSRFToken()
    {
        $postToken = filter_input(INPUT_POST, "token");
        $sessionToken = $_SESSION["csrfToken"];

        // Si le token dans le formulaire est vide OU si le token en session est vide OU si ils sont différents l'un de l'autre
        if (empty($postToken) || empty($sessionToken) || $sessionToken != $postToken) {
            // Alors je renvoie l'utilisateur vers une erreur 403
            http_response_code(403);
            $this->show('error/err403');
            exit;
        }
    }

    public function checkGETCSRFToken()
    {
        $sessionToken = $_SESSION["csrfToken"];
        $getToken = $_GET['token'];

        // Si le token dans GET est vide OU si le token en session est vide OU si ils sont différents l'un de l'autre
        if (empty($getToken) || empty($sessionToken) || $sessionToken != $getToken) {
            // Alors je renvoie l'utilisateur vers une erreur 403
            http_response_code(403);
            $this->show('error/err403');
            exit;
        }
    }

    protected function show(string $viewName, $viewVars = [])
    {
        $router = $this->router;

        $viewVars['currentPage'] = $viewName;
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        extract($viewVars);
        // dump($viewVars);

        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    protected function checkAuthorization($requiredRole = [])
    {
        $router = $this->router;

        if (!isset($_SESSION['userObject'])) {
            header('Location: ' . $router->generate('user-login'));
            exit();
        }

        $user = $_SESSION['userObject'];
        $role = $user->getRole();

        if (in_array($role, $requiredRole))
        {
            return true;
        }       

        http_response_code(403);
        $this->show('error/err403');
        exit;
    }

    // Méthode permettant de générer un Token aléatoire contre la faille CSRF
    public function generateCSRFToken()
    {
        $bytes = random_bytes(5);
        $csrfToken = bin2hex($bytes);

        $_SESSION["csrfToken"] = $csrfToken;
        return $csrfToken;
    }
}
