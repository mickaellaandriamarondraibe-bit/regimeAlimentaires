<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
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
        'variation_poids_semaine'
    ];
    
    protected $validationRules = [
        'name'                 => 'required|min_length[2]|max_length[100]',
        'variation_poids_semaine' => 'required|numeric'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom du régime est requis',
            'min_length' => 'Le nom doit contenir au moins 2 caractères',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères'
        ],
        'variation_poids_semaine' => [
            'required' => 'La variation du poids est requise',
            'numeric'  => 'La variation doit être un nombre'
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

    public function getPoitiveRegimes()
    {
        return $this->where('variation_poids_semaine >', 0)->findAll();
    }

    public function getNegativeRegimes()
    {
        return $this->where('variation_poids_semaine <', 0)->findAll();
    }

    public function getRegimeComplet(int $id)
    {
        $regime = $this->find($id);
        if (!$regime) {
            return null;
        }

        $regime['compositions'] = (new VCompositionRegimeModel())->getCompositionRegimeByRegimeId($id);
        $regime['prix'] = (new PrixRegimeModel())->getPrixByRegimeId($id);

        $regime['sport_associe'] = (new RegimeSportModel())->getSportsByRegimeId($id);

        return $regime;
    }
}