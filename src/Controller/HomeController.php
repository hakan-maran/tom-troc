<?php

namespace TomTroc\Controller;

use TomTroc\Engine\View;
use TomTroc\Model\Manager\BookManager;

class HomeController
{
    /**
     * Display the home page with the latest books.
     */
    public function index()
    {
        $logged_in = $_SESSION['auth'] ?? false;

        $bookManager = new BookManager();
        $books = $bookManager->findLatest(4);

        $view = new View('Accueil');
        $view->render('home', ['logged_in' => $logged_in, 'books' => $books]);
    }
}
