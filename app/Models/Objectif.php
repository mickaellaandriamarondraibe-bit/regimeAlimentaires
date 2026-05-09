<?php

namespace App\Models;

use CodeIgniter\Model;

class Objectif extends Model
{
    protected $table = 'objectif';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'name'
    ];

    public function getObjectifById(int $id)
    {
        return $this->find($id);
    }

    public function getAllObjectifs()
    {
        return $this->findAll();
    }
}