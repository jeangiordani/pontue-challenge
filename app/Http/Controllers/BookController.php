<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createBook(Request $request): JsonResponse
    {
        return $this->repository->createBook($request->all());
    }

    public function getBooks(Request $request): JsonResponse
    {
        return $this->repository->getBooks();
    }

    public function getBook(int $id): JsonResponse
    {
        return $this->repository->getBook($id);
    }
    public function updateBook(Request $request, int $id): JsonResponse
    {
        return $this->repository->updateBook($request->all(), $id);
    }

    public function deleteBook(int $id): JsonResponse
    {
        return $this->repository->deleteBook($id);
    }
}
