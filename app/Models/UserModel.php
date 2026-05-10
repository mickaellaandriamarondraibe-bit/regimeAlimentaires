<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'role', 'password'];

    protected $validationRules = [
        'email'    => 'required|valid_email|max_length[150]|is_unique[user.email,id,{id}]',
        'password' => 'required|min_length[6]|max_length[255]',
        'role'     => 'required|in_list[admin,client]',
    ];

    public function getUserByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }


    public function getUserById(int $id): ?array
    {
        return $this->find($id);
    }
    public function updateUser(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    public function updateProfilById(int $userId, array $data): bool
    {
        return $this->builder()
            ->where('id', $userId)
            ->update($data);
    }

    public function isAdmin(int $userId): bool
    {
        $user = $this->find($userId);

        if (!$user) {
            return false;
        }

        return $user['role'] === 'admin';
    }
}
