<?php

namespace App\Models;

Use CodeIgniter\Model;

class VCompositionRegime extends Model
{
    protected $table = 'v_composition_regimes';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['regime_id', 'regime_name', 'variation_poids_semaine', 'ingredient_id', 'ingredient_name', 'poucentage', 'objectif_id', 'objectif_name'];

    public function getCompositionRegimeByRegimeId(int $regimeId)
    {
        return $this->where('regime_id', $regimeId)->findAll();
    }

    public function getAllCompositionRegimes()
    {
        return $this->findAll();
    }
}