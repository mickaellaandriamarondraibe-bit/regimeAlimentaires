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

    protected $validationRules = [
        'name'                 => 'required|min_length[2]|max_length[100]',
        'type_variation'       => 'required',
        'variation_poids_jour' => 'required|numeric',
        'prix_jour'            => 'required|numeric'
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
        'variation_poids_jour' => [
            'required' => 'La variation du poids est requise',
            'numeric'  => 'La variation doit être un nombre'
        ],
        'prix_jour' => [
            'required' => 'Le prix journalier est nécessaire',
            'numeric'  => 'Le prix doit être un nombre'
        ]
    ];

    protected $allowedFields = ['id', 'name', 'type_variation', 'variation_poids_jour', 'prix_jour', 'prix_mois', 'prix_3mois', 'prix_6mois', 'prix_12mois'];

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