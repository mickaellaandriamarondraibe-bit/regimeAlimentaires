<?php

namespace App\Models;

use CodeIgniter\Model;

class PrixRegimeModel extends Model
{
    protected $table = 'prix_regimes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'regime_id', 'duree_semaine', 'prix'];

    protected $validationRules = [
        'regime_id' => 'required|integer',
        'duree_semaine' => 'required|integer',
        'prix' => 'required|numeric'
    ];

    protected $validationMessages = [
        'regime_id' => [
            'required' => 'Le régime est requis',
            'integer'  => 'Le régime doit être un nombre entier'
        ],
        'duree_semaine' => [
            'required' => 'La durée en semaine est requise',
            'integer'  => 'La durée doit être un nombre entier'
        ],
        'prix' => [
            'required' => 'Le prix est requis',
            'numeric'  => 'Le prix doit être un nombre'
        ]
    ];

    public function getPrixByRegimeId(int $regimeId)
    {
        return $this->where('regime_id', $regimeId)->findAll();
    }
}