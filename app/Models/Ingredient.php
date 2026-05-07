<?php

namespace App\Models;

use CodeIgniter\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','name'];

    public function getIngredientById(int $id)
    {
        return $this->find($id);
    }

    public function getAllIngredients()
    {
        return $this->findAll();
    }

}