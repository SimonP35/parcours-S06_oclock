<?php

//! MainController (Classe gérant l'affichage des pages générales)

//? Namespace 
namespace App\Controllers;

class MainController extends CoreController {

    public function home()
    {
        $this->show('main/home');
    }
}
