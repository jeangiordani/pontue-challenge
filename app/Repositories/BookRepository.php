<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BookRepository
{

    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function createBook(array $data): JsonResponse
    {
        $validated = Validator::make($data, [
            'title' => 'required|min:3',
            'category' => 'required',
            'author' => 'required'
        ]);

        if ($validated->fails()) {
            return ResponseHelper::responseFail($validated->errors()->messages(), 422);
        }

        $book = $this->model->create($data);

        return ResponseHelper::responseSuccess($book, 201);
    }

    public function getBooks(): JsonResponse
    {
        $books = $this->model->all();

        if ($books != null) {
            return ResponseHelper::responseSuccess($books, 200);
        }

        return ResponseHelper::responseNotFound('Table books is empty', 200);
    }

    public function getBook(int $id): JsonResponse
    {
        $book = $this->model->find($id);

        if ($book != null) {
            return ResponseHelper::responseSuccess($book, 200);
        }

        return ResponseHelper::responseNotFound('Book not found', 404);
    }

    public function updateBook(array $data, int $id): JsonResponse
    {
        $book = $this->model->find($id);

        $validated = Validator::make($data, [
            'title' => 'required|min:3',
            'category' => 'required',
            'author' => 'required'
        ]);

        if ($validated->fails()) {
            return ResponseHelper::responseFail($validated->errors()->messages(), 422);
        }

        if ($book != null) {
            $book->update($data);

            return ResponseHelper::responseSuccess($data, 200);
        }

        return ResponseHelper::responseNotFound('Book not found', 404);
    }

    public function deleteBook(int $id): JsonResponse
    {
        $book = $this->model->find($id);

        if ($book != null) {
            $book->delete();
            return ResponseHelper::responseSuccess([
                'messages' => 'Book deleted successfully'
            ], 200);
        }
        return ResponseHelper::responseNotFound('Book not found', 404);
    }
}
