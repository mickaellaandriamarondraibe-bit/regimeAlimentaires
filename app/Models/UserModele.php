<?php
namespace App\Models; 
use CodeIgniter\Model;

class UserModele extends Model{
    protected $table = 'user' ; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['email','username','password' ];

    protected $validationRules = [
        'username' => 'required|max_length[100]',
        'email'        => 'required|valid_email|max_length[150]|is_unique[users.email,id,{id}]',
        'mot_de_passe' => 'required|min_length[6]|max_length[255]',
        'role'         => 'required|in_list[admin,enseignant]',

    ]; 

    public function getUserByEmail(string $email){
        return this->where('email',$email)->first();

    }



}