<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        return $this->repository->login($request->all());
    }

    public function user()
    {
        return $this->repository->user();
    }

    public function logout()
    {
        return $this->repository->logout();
    }
}
