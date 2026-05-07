<?php

namespace App\Models;

use CodeIgniter\Model;

class InfoClientsModel extends Model
{
    protected $table = 'infos_clients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id',
        'phone',
        'genre',
        'taille',
        'poids',
        'is_gold',
        'wallet',
    ];

    protected $validationRules = [
        'user_id' => 'required|integer|is_unique[infos_clients.user_id,id,{id}]',
        'phone'   => 'permit_empty|max_length[30]',
        'genre'   => 'required|in_list[H,F]',
        'taille'  => 'required|decimal',
        'poids'   => 'required|decimal',
        'is_gold' => 'permit_empty|in_list[0,1]',
        'wallet'  => 'permit_empty|decimal',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required'  => 'L utilisateur est obligatoire.',
            'integer'   => 'L identifiant utilisateur doit etre un entier.',
            'is_unique' => 'Cet utilisateur possede deja des informations client.',
        ],
        'genre' => [
            'required' => 'Le genre est obligatoire.',
            'in_list'  => 'Le genre doit etre H ou F.',
        ],
        'taille' => [
            'required' => 'La taille est obligatoire.',
            'decimal'  => 'La taille doit etre un nombre decimal valide.',
        ],
        'poids' => [
            'required' => 'Le poids est obligatoire.',
            'decimal'  => 'Le poids doit etre un nombre decimal valide.',
        ],
        'wallet' => [
            'decimal' => 'Le wallet doit etre un nombre decimal valide.',
        ],
    ];

    protected array $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'taille' => 'float',
        'poids' => 'float',
        'is_gold' => 'boolean',
        'wallet' => 'float',
    ];

    public function getByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }
}