<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectif';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name'
    ];

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Le nom de l’objectif est requis.',
            'min_length' => 'Le nom doit contenir au moins 2 caractères.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
        ],
    ];

    public function getObjectifById(int $id)
    {
        return $this->find($id);
    }

    public function getBaseObjectifs()
    {
        return $this->select('id, name')
            ->where('name NOT LIKE', '%IMC idéal%')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    public function getAllObjectifs()
    {
        return $this->findAll();
    }
}
