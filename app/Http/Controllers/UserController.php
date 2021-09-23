<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser(Request $request): JsonResponse
    {
        return $this->repository->createUser($request->all());
    }

    public function getAllUsers(): JsonResponse
    {
        return $this->repository->getAllUsers();
    }

    public function getUser(int $id): JsonResponse
    {
        return $this->repository->getUser($id);
    }

    public function updateUser(Request $request, int $id): JsonResponse
    {
        return $this->repository->updateUser($request->all(), $id);
    }

    public function destroyUser(int $id)
    {
        return $this->repository->destroyUser($id);
    }
}
