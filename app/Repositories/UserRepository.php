<?php

namespace App\Repositories;

use App\Dto\Auth\RegisterDto;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(RegisterDto $dto): User
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);
    }
}
