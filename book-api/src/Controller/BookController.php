<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Entity\Book;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/apiV2/books', name: 'book_create', methods: ['POST'])]
    /**
     * Creates a new book.
     *
     * @param Request $request The request object containing the book data.
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @return JsonResponse
     */

    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setTitle($data['title'] ?? null);
        $book->setAuthor($data['author'] ?? null);
        $book->setPublishedAt(new \DateTime($data['published_at'] ?? 'now'));
        $book->setIsbn($data['isbn'] ?? null);

        // ggf. weitere Felder

        $em->persist($book);
        $em->flush();

        return $this->json($book, 201);
    }

    #[Route('/apiV2/books/{id}', name: 'book_update', methods: ['PUT'])]
    /**
     * Updates an existing book.
     *
     * @param Request $request The request object containing the updated book data.
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @param int $id The ID of the book to update.
     * @return JsonResponse
     */
    public function update(Request $request, EntityManagerInterface $em, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $book->setTitle($data['title'] ?? $book->getTitle());
        $book->setAuthor($data['author'] ?? $book->getAuthor());
        $book->setPublishedAt(new \DateTime($data['published_at'] ?? $book->getPublishedAt()->format('Y-m-d')));
        $book->setIsbn($data['isbn'] ?? $book->getIsbn());

        $em->flush();

        return $this->json($book);
    }

    #[Route('/apiV2/books/{id}', name: 'book_delete', methods: ['DELETE'])]
    /**
     * Deletes a book by its ID.
     *
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @param int $id The ID of the book to delete.
     * @return JsonResponse
     */
    public function delete(EntityManagerInterface $em, int $id): JsonResponse
    {
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $em->remove($book);
        $em->flush();

        return $this->json(['message' => 'Book deleted successfully']);
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
