<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class BookController extends AbstractController
{
    #[Route('/apiV2/books', name: 'book_index', methods: ['GET'])]
    /**
     * Displays a list of all books.
     *
     * @return Response
     */

    public function list(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();

        return $this->json($books);
    }

    /**
     * Displays a single book by its ID.
     *
     * @param int $id The ID of the book to display.
     * @return JsonResponse
     */

    #[Route('/apiV2/books/{id}', name: 'book_show', methods: ['GET'])]
    public function show(BookRepository $bookRepository, int $id): JsonResponse
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        return $this->json($book);
    }

    /**
     * Displays a list of books by a specific author.
     *
     * @param string $author The name of the author.
     * @return JsonResponse
     */
    #[Route('/apiV2/books/author/{author}', name: 'book_by_author', methods: ['GET'])]
    public function listByAuthor(BookRepository $bookRepository, string $author): JsonResponse
    {
        $books = $bookRepository->findBy(['author' => $author]);

        if (!$books) {
            return $this->json(['error' => 'No books found for this author'], 404);
        }

        return $this->json($books);
    }
}
