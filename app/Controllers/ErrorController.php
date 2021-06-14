<?php

//! ErrorController (Classe gérant les erreurs (404, 403))

//? Namespace 
namespace App\Controllers;

class ErrorController extends CoreController 
{
    //?===========================================
    //?               Méthodes
    //?===========================================
    
    /**
     * Méthode gérant l'affichage de la page 404
     *
     * @return void
     */
    public function err404() 
    {
        // On envoie le header 404
        header('HTTP/1.0 404 Not Found');

        // Puis on gère l'affichage
        $this->show('error/err404');
    }

    /**
     * Méthode gérant l'affichage de la page 403
     *
     * @return void
     */
    public function err403() 
    {
        // On envoie le header 403
        header('HTTP/1.1 403 Forbidden');

        // Puis on gère l'affichage
        $this->show('error/err403');
    }
}