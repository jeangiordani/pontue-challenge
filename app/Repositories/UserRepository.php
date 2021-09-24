<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function createUser(array $data): JsonResponse
    {
        $validated = Validator::make(
            $data,
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        if ($validated->fails()) {
            return ResponseHelper::responseFail($validated->errors()->messages(), 422);
        }

        $data['password'] = bcrypt($data['password']);

        $user = $this->model->create($data);

        return ResponseHelper::responseSuccess($user, 201);
    }

    public function getAllUsers(): JsonResponse
    {
        $users = $this->model->all();

        if ($users != null) {
            return ResponseHelper::responseSuccess($users, 200);
        }
        return ResponseHelper::responseNotFound('Table users is empty', 200);
    }

    public function getUser(int $id): JsonResponse
    {
        $user = $this->findById($id);

        if ($user != null) {
            return ResponseHelper::responseSuccess($user, 200);
        }
        return ResponseHelper::responseNotFound('User not found', 404);
    }

    public function updateUser(array $data, int $id): JsonResponse
    {
        $user = $this->findById($id);

        $validated = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required'
        ]);

        if ($validated->fails()) {
            return ResponseHelper::responseFail($validated->errors()->messages(), 422);
        }

        if ($user != null) {
            $data['password'] = bcrypt($data['password']);
            $user->update($data);
            unset($data['password']);
            return ResponseHelper::responseSuccess($data, 201);
        }

        return ResponseHelper::responseNotFound('User not found', 404);
    }

    public function destroyUser(int $id)
    {
        $user = $this->findById($id);

        if ($user != null) {
            $user->delete();
            return response()->json([
                'status' => 'success',
                'messages' => 'User deleted successfully'
            ], 200);
        }
        return ResponseHelper::responseNotFound('User not found', 404);
    }

    protected function findById(int $id)
    {
        return $this->model->find($id);
    }
}
