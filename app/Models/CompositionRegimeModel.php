<?php

namespace App\Models;

Use CodeIgniter\Model;

class CompositionRegimeModel extends Model
{
    protected $table = 'composition_regimes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'regime_id', 'ingredient_id', 'pourcentage'];

}