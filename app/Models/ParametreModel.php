<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table = 'parametres';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'cle',
        'valeur',
        'description'
    ];

    protected $validationRules = [
        'cle' => 'required|max_length[100]',
        'valeur' => 'required|max_length[100]',
    ];

    public function getValeur(string $cle): ?string
    {
        $parametre = $this->where('cle', $cle)->first();

        if (!$parametre) {
            return null;
        }

        return $parametre['valeur'];
    }

    public function getFloatValeur(string $cle): float
    {
        return (float) ($this->getValeur($cle) ?? 0);
    }

    public function updateValeur(string $cle, string $valeur): bool
    {
        return $this->where('cle', $cle)
            ->set(['valeur' => $valeur])
            ->update();
    }
}