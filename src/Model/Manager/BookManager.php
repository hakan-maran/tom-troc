<?php

namespace TomTroc\Model\Manager;

use TomTroc\Engine\Database\AbstractEntityManager;
use TomTroc\Model\Entity\Book;

class BookManager extends AbstractEntityManager
{
    public string $table = "books";

    /**
     * Find all books in the database.
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    /**
     * Find all available books in the database.
     */
    public function findAllAvailable(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_available = 1");
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    /**
     * Find books by a specific user ID.
     */
    public function findByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    /**
     * Find all books and sort them by title in ascending order.
     */
    public function findAllAndSortByTitle(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY title ASC");
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    /**
     * Search for books by title.
     */
    public function searchByTitle(string $search): array
    {
        $query = '%' . trim($search) . '%';
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE LOWER(title) LIKE LOWER(:search) ORDER BY title ASC");
        $stmt->execute(['search' => $query]);
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    /**
     * Find a single book by its ID.
     */
    public function findOne(int $id): ?Book
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $bookData = $stmt->fetch();
        if ($bookData) {
            return new Book($bookData);
        }
        return null;
    }

    /**
     * Create a new book in the database.
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (user_id, title, author, image, description, is_available) VALUES (:user_id, :title, :author, :image, :description, :is_available)"
        );

        $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'author' => $data['author'],
            'image' => $data['image'],
            'description' => $data['description'],
            'is_available' => $data['is_available'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Delete an existing book from the database.
     */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    /**
     * Find the latest books in the database.
     */
    public function findLatest(int $limit = 4): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC LIMIT {$limit}");
        $booksData = $stmt->fetchAll();
        $books = [];
        foreach ($booksData as $bookData) {
            $books[] = new Book($bookData);
        }
        return $books;
    }
}
