<?php
namespace App\Models; 
use CodeIgniter\Model;

class UserModele extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'role', 'password'];

    protected $validationRules = [
        'username' => 'required|max_length[100]',
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

    public function deleteUser($id){
        return $this->delete($id);
    }
    public function updateProfilById(int $userId, array $data): bool
    {
        return $this->builder()
            ->where('id', $userId)
            ->update($data);
    }

}
