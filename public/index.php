<?php 

//! FRONT CONTROLLER (Point d'entrée unique)

// Require du fichier autoload.php pour l'utilisations de nos dépendances et le chargement automatique de nos classes (PSR-4)
require_once __DIR__ . "/../vendor/autoload.php";

//Initialisation de la session
session_start();

//?===========================================
//?                ROUTAGE
//?===========================================

//! ALTOROUTEUR

// 1 - Création de l'objet AltoRouter
$router = new AltoRouter();

// 2 - On précise a AltoRouter notre emplacement (Si il y a un sous-répertoire, on définit le basePath d'AltoRouter sinon on donne une valeur par défaut à $_SERVER['BASE_URI'])
array_key_exists('BASE_URI', $_SERVER) ? $router->setBasePath($_SERVER['BASE_URI']) : ($_SERVER['BASE_URI'] = '/') ;

// 3 - Mise en place/création de nos routes ("mappage" de nos routes)

// MainController
$router->map( "GET",   "/",    "MainController@home",      "main-home" );

// TeacherController
$router->map( "GET",  "/teachers",                   "TeacherController@list",          "teacher-list" );
$router->map( "GET",  "/teachers/add",               "TeacherController@add",           "teacher-add" );
$router->map( "POST", "/teachers/add",               "TeacherController@addPost",       "teacher-addPost" );
$router->map( "GET",  "/teachers/[i:id]",            "TeacherController@update",        "teacher-update" );
$router->map( "POST", "/teachers/[i:id]",            "TeacherController@updatePost",    "teacher-updatePost" );
$router->map( "GET",  "/teachers/[i:id]/delete",     "TeacherController@delete",        "teacher-delete" );

// StudentController
$router->map( "GET",  "/students",                   "StudentController@list",           "student-list" );
$router->map( "GET",  "/students/add",               "StudentController@add",            "student-add" );
$router->map( "POST", "/students/add",               "StudentController@addPost",        "student-addPost" );
$router->map( "GET",  "/students/[i:id]",            "StudentController@update",         "student-update" );
$router->map( "POST", "/students/[i:id]",            "StudentController@updatePost",     "student-updatePost" );
$router->map( "GET",  "/students/[i:id]/delete",     "StudentController@delete",         "student-delete" );

// AppUserController

$router->map( "GET",  "/appusers",                   "AppUserController@list",           "user-list" );
$router->map( "GET",  "/appusers/add",               "AppUserController@add",            "user-add" );
$router->map( "POST", "/appusers/add",               "AppUserController@addPost",        "user-addPost" );
$router->map( "GET",  "/appusers/[i:id]",            "AppUserController@update",         "user-update" );
$router->map( "POST", "/appusers/[i:id]",            "AppUserController@updatePost",     "user-updatePost" );
$router->map( "GET",  "/appusers/[i:id]/delete",     "AppUserController@delete",         "user-delete" );

$router->map( "GET",  "/signin",    "AppUserController@login",        "user-login" );
$router->map( "POST", "/signin",    "AppUserController@loginPost",    "user-loginPost" );
$router->map( "GET",  "/logout",    "AppUserController@logout",       "user-logout" );

// 4 - On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

//?===========================================
//?                DISPATCH
//?===========================================

//! ALTODISPATCHER

// 1 - Création de l'objet Dispatcher
$dispatcher = new Dispatcher($match, 'ErrorController::err404');

// 2 - On indique à AltoDispatcher le namespace de nos Controllers pour l'autoload (PSR-4)
$dispatcher->setControllersNamespace('App\Controllers');

// 3 - On renseigne les variables à transmettre au constructeur du CoreController (on évite ainsi la mise en "global" de certaines de nos variables)
$dispatcher->setControllersArguments($router, $match);

// 4 - On lance le dispatch
$dispatcher->dispatch();