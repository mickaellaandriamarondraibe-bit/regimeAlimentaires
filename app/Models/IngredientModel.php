<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredientModel extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','name'];

    protected $validationRules = [
        'name'  =>  'required|min_length[2]|max_length[100]|is_unique[ingredients.name]'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de l\'ingrédient est requis',
            'min_length' => 'Le nom doit contenir au moins 2 caractères',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères',
            'is_unique'  => 'Cet ingrédient existe déjà'
        ]
    ];

    public function getIngredientById(int $id)
    {
        return $this->find($id);
    }

    public function getAllIngredients()
    {
        return $this->findAll();
    }

}