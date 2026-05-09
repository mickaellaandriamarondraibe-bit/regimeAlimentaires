<?php

namespace App\Models;
use CodeIgniter\Model;

class DemandeCode extends Model
{
    protected $table = 'demande_code';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code_id', 'statut', 'client_id', 'validated_by', 'validated_at'];

    protected $validationRules = [
        'code_id' => 'required|integer',
        'statut' => 'required|in_list[en_attente,valide,refuse]',
        'client_id' => 'required|integer',
        'validated_by' => 'permit_empty|integer',
        'validated_at' => 'permit_empty|valid_date',
    ];
   
    function createDemande(array $data): bool
    {
        $this->insert($data);
        return $this->getInsertID();
    }
    function getDemandeById(int $id): ?array
    {
        return $this->find($id);
    }
}