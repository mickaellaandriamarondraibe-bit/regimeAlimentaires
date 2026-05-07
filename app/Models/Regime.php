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

    protected $validation = [
        'name' => 'required|min_length[2]|max_length[100]',
        'type_variation' => 'required',
        'variation_poids_jour' => 'required|numeric',
        'prix_jour' => 'required|numeric'
    ];

    protected $validationMessages = [
        'name' => 'Le nom du regime est requis',
        'type_variation' => 'Le type de la variation est requis',
        'variation_poids_jour' => 'La variation du poids est requis',
        'prix_jour' => 'La variation de prix est nécéssaire'
    ];

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