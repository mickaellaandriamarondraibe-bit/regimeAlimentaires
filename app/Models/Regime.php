<?php

namespace App\Models;

use CodeIgniter\Model;

class Regime extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','name', 'type_variation', 'variation_poids_jour', 'prix_jour', 'prix_mois', 'prix_3mois', 'prix_6mois', 'prix_12mois'];

    public function getRegimeById(int $id)
    {
        return $this->find($id);
    }

    public function getAllRegimes()
    {
        return $this->findAll();
    }

}