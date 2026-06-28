<?php

namespace TomTroc\Controller;

use TomTroc\Engine\View;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Manager\UserManager;


class AuthController
{
    /**
     * Display the login page.
     */
    public function login()
    {
        $view = new View('Connexion');
        $view->render('login');
    }

    /**
     * Display the registration page.
     */
    public function register()
    {
        $view = new View('Inscription');
        $view->render('register');
    }

    /**
     * Handle user registration.
     */
    public function createUser(): void
    {
        if (empty(trim($_POST['username'] ?? '')) || empty(trim($_POST['email'] ?? '')) || empty(trim($_POST['password'] ?? ''))) {
            header("Location: index.php?action=register");
            exit();
        }
        
        $manager = new UserManager();
        $user = new User($_POST);
        $userId = $manager->save($user);

        // Redirect to the login page after successful registration
        header("Location: index.php?action=login");
        exit();
    }

    /**
     * Handle user login verification.
     */
    public function verifyLogin(): void
    {
        // Validate input
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            header('Location: index.php?action=login');
            exit();
        }

        $manager = new UserManager();
        $user = $manager->getUserByEmail($email);

        if (!$user) {
            header('Location: index.php?action=login');
            exit();
        }

        // Verify password
        if (!password_verify($password, $user->getPassword())) {
            header('Location: index.php?action=login');
            exit();
        }

        // Successful login: set session and redirect to home
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();

        header('Location: index.php');
        exit();
    }

    /**
     * Handle user logout.
     */
    public function logout(): void
    {
        // Destroy the session
        session_destroy();

        // Redirect to home page
        header('Location: index.php');
        exit();
    }
}
