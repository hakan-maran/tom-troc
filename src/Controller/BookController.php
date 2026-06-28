<?php

namespace TomTroc\Controller;

use TomTroc\Engine\View;
use TomTroc\Model\Entity\Book;
use TomTroc\Model\Manager\BookManager;
use TomTroc\Model\Manager\UserManager;

class BookController
{
    /**
     * @todo All of this comment as nothing to do here, findAll is Manager's functionalities, 
     * this is list function!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * 
     * Retrieves and displays all books from the database, or filters books by search query if provided.
     * For each book, it fetches the associated user information (book owner) to display user details.
     * The method handles search functionality via GET parameter 'search'.
     *
     * @return void Renders the 'books' view with books and their corresponding owners
     *
     * @throws \Exception If database operations fail
     *
     * @uses BookManager::findAll() To retrieve all books
     * @uses BookManager::searchByTitle() To search books by title
     * @uses UserManager::findById() To fetch user information for each book owner
     * @uses View::render() To display the books list template
     */
    public function findAll(): void
    {
        $bookManager = new BookManager();
        $search = trim($_GET['search'] ?? '');
        $books = $search !== '' ? $bookManager->searchByTitle($search) : $bookManager->findAll();

        // Get unique user IDs
        $userIds = [];
        foreach ($books as $book) {
            $userIds[] = $book->getUserId();
        }
        
        $userIds = array_unique($userIds);

        // Fetch users information
        $userManager = new UserManager();
        $users = [];
        foreach ($userIds as $userId) {
            $user = $userManager->findById($userId);
            if ($user) {
                $users[$userId] = $user;
            }
        }

        $view = new View("Liste des livres");
        $view->render('books', ['books' => $books, 'users' => $users]);
    }

    /**
     * @todo All of this comment as nothing to do here, findOne is Manager's functionalities, 
     * this is detail function!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * 
     * Retrieves and displays a specific book by its ID. Also fetches the owner's information
     * and passes the current user's ID to the view to determine if edit/delete actions are available.
     * If the book is not found, throws an Exception with a 404 status code.
     *
     * @param int $id The ID of the book to display
     *
     * @return void Renders the 'book' view with book details, owner info, and current user ID
     *
     * @throws \Exception Throws exception with status code 404 if book is not found
     *
     * @uses BookManager::findOne() To retrieve the specific book
     * @uses UserManager::findById() To fetch the book owner's information
     * @uses View::render() To display the book details template
     */
    public function findOne(int $id)
    {
        $manager = new BookManager();
        $book = $manager->findOne($id);

        if (!$book) {
            throw new \Exception("Book not found", 404);
        }

        // Get the owner's information
        $userManager = new UserManager();
        $owner = $userManager->findById($book->getUserId());

        $currentUserId = $_SESSION['user_id'] ?? null;
        $view = new View($book->getTitle());
        $view->render('book', ['book' => $book, 'owner' => $owner, 'currentUserId' => $currentUserId]);
    }

    /**
     * @todo All of this comment as nothing to do here, this is modify function, but, 
     * edit function can handle modify function too!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * 
     * Handles both GET and POST requests. On GET request, displays the book creation form.
     * On POST request, validates the submitted data (title and author are mandatory),
     * processes the book creation, and redirects to the newly created book's detail page.
     * The current user is automatically set as the book owner, and new books are marked as available by default.
     * Optional fields like description and image are trimmed and set to null if empty.
     *
     * @param array $data Optional array of book data (typically from POST request)
     *
     * @return void Renders the 'createBook' view on GET request, or redirects to created book on successful POST
     *
     * @throws \Exception Throws exception with status 400 if required fields (title, author) are missing
     *
     * @uses BookManager::create() To save the new book to the database
     * @uses View::render() To display the book creation form template
     */
    public function create(array $data = []): void
    {
        // Récupérer les données POST si c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
        }

        // Traiter la création du livre si on a des données POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data)) {
            if (empty($data['title']) || empty($data['author'])) {
                throw new \Exception("Title and author are required", 400);
            }

            // Add current user_id to data
            $data['user_id'] = $_SESSION['user_id'] ?? 1; // Default to 1 if not logged in
            $data['is_available'] = 1; // New books are available by default
            $data['image'] = empty(trim($data['image'] ?? '')) ? null : trim($data['image']);
            $data['description'] = empty(trim($data['description'] ?? '')) ? null : trim($data['description']);

            $manager = new BookManager();
            $bookId = $manager->create($data);

            // Redirect to the newly created book
            header("Location: index.php?action=book&id={$bookId}");
            exit();
        }

        $view = new View("Créer un livre");
        $view->render('createBook');
    }

    /**
     * @todo All of this comment as nothing to do here, edit function can handle modify 
     * function too!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * 
     * Handles both GET and POST requests for editing a book. On GET request, displays the edit form.
     * On POST request, updates the book with new data including title, author, description, and availability status.
     * Supports image upload functionality: validates file type (jpg, jpeg, png), stores the new image,
     * and deletes the old image if a new one is uploaded.
     * Only the book owner (current user) can edit the book. Unauthorized access redirects to the books list.
     * If validation fails, stores error message and old inputs in session for user-friendly error handling.
     *
     * @param int $id The ID of the book to edit
     *
     * @return void Renders the 'updateBook' view on GET request, or redirects after successful update on POST
     *
     * @throws \Exception If book not found or user is not authorized
     *
     * @uses BookManager::findOne() To retrieve the book to edit
     * @uses BookManager::update() To save updated book data
     * @uses View::render() To display the book edit form template
     */
    public function edit(int $id): void
    {
        $manager = new BookManager();
        $book = $manager->findOne($id);

        if (!$book) {
            header('Location: index.php?action=books');
            exit();
        }

        if ($book->getUserId() !== ($_SESSION['user_id'] ?? null)) {
            header('Location: index.php?action=books');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $available = $_POST['available'] ?? '1';
            $currentImage = $book->getImage();
            $image = $currentImage;

            if (!empty($_FILES['image_file']['tmp_name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $tmpFile = $_FILES['image_file']['tmp_name'];
                $originalName = $_FILES['image_file']['name'];
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png'];
                if (in_array($extension, $allowed, true)) {
                    $imageName = sprintf('book_%d_%s.%s', $id, uniqid(), $extension);
                    $destination = __DIR__ . '/../../public/img/books/' . $imageName;
                    if (!is_dir(dirname($destination))) {
                        mkdir(dirname($destination), 0755, true);
                    }
                    if (move_uploaded_file($tmpFile, $destination)) {
                        $image = $imageName;
                        if (!empty($currentImage)) {
                            $oldImagePath = __DIR__ . '/../../public/img/books/' . $currentImage;
                            if (is_file($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                    }
                }
            }

            if (empty($title) || empty($author)) {
                // Avoid throwing a generic exception which bubbles to a 400 route.
                // Show a friendly error and redirect back to the edit form.
                $_SESSION['flash_error'] = "Le titre et l'auteur sont requis.";
                // preserve submitted values so the user doesn't lose work
                $_SESSION['old_inputs'] = ['title' => $title, 'author' => $author, 'description' => $description, 'available' => $available];
                header("Location: index.php?action=editBook&id={$id}");
                exit();
            }

            $book = new Book();
            $book->setId($id);
            $book->setUserId($_SESSION['user_id']);
            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setImage($image === '' ? null : $image);
            $book->setDescription($description === '' ? null : $description);
            if ($available == 1) {
                $book->setIsAvailable(true);
            } else {
                $book->setIsAvailable(false);
            }
            $manager->update($book);

            header("Location: index.php?action=book&id={$id}");
            exit();
        }

        $view = new View("Modifier le livre");
        $view->render('updateBook', ['book' => $book]);
    }

    /**
     * @todo All of this comment as nothing to do here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * 
     * Removes a book from the database. Includes security checks: ensures user is logged in
     * and verifies that the current user is the book owner before allowing deletion.
     * Unauthorized attempts (not logged in or not the owner) redirect to the books list.
     * After successful deletion, redirects to the books list page.
     *
     * @param int $id The ID of the book to delete
     *
     * @return void Redirects to books list after successful deletion or on authorization failure
     *
     * @throws \Exception If book not found or user is not authorized
     *
     * @uses BookManager::findOne() To retrieve the book to verify ownership
     * @uses BookManager::delete() To remove the book from the database
     */
    public function delete(int $id): void
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $manager = new BookManager();
        $book = $manager->findOne($id);

        // Check if book exists and user is the owner
        if (!$book || $book->getUserId() !== $_SESSION['user_id']) {
            header("Location: index.php?action=books");
            exit();
        }

        $manager->delete($id);

        // Redirect to the book list after deletion
        header("Location: index.php?action=books");
        exit();
    }
}
