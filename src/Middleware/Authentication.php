<?php

namespace TomTroc\Middleware;

class Authentication
{
    /**
     * Check if the user is authenticated.
     */
    public function checkAuth()
    {
        $logged_in = $_SESSION['auth'] ?? false;
        if (!$logged_in) {
            return header('location: index.php?action=403');
        }
    }
}
