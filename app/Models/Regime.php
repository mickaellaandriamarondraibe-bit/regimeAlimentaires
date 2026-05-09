<?php

namespace App\Models;

use CodeIgniter\Model;
use \App\Models\VCompositionRegime;

class Regime extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'name',
        'description',
        'variation_poids_semaine',
        'objectif_id'
    ];
    
    protected $validationRules = [
        'name'                 => 'required|min_length[2]|max_length[100]',
        'type_variation'       => 'required',
        'variation_poids_semaine' => 'required|numeric',
        'objectif_id'         => 'required|integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom du régime est requis',
            'min_length' => 'Le nom doit contenir au moins 2 caractères',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères'
        ],
        'type_variation' => [
            'required' => 'Le type de la variation est requis'
        ],
        'variation_poids_semaine' => [
            'required' => 'La variation du poids est requise',
            'numeric'  => 'La variation doit être un nombre'
        ],
        'objectif_id' => [
            'required' => 'L\'objectif est requis',
            'integer'  => 'L\'objectif doit être un nombre entier'
        ]
    ];


    public function getRegimeById(int $id)
    {
        return $this->find($id);
    }

    public function getAllRegimes()
    {
        return $this->findAll();
    }

    public function getRegimeComplet(int $id)
    {
        $regime = $this->find($id);
        if (!$regime) {
            return null;
        }

        $compositionModel = new VCompositionRegime();

        $regime['compositions'] = $compositionModel->getCompositionRegimeByRegimeId($id);

        return $regime;
    }
}