<?php

namespace App\Models;

Use CodeIgniter\Model;

class CompositionRegime extends Model
{
    protected $table = 'composition_regime';
    protected $primaryKey = 'id';

    protected $allowedFields = ['regime_id', 'composition_id', 'poucentage'];

}