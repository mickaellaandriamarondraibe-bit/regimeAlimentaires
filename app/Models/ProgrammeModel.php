<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammeModel extends Model
{
    protected $table = 'programme';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'objectif_id',
        'objectif_kg',
        'duree_semaine',
        'prix_total',
        'poids_initial',
        'poids_cible',
        'imc_initial',
        'date_programme',
        'transaction_id',
        'client_id',
        'regime_id',
    ];

    protected $validationRules = [
        'objectif_id'   => 'required|integer',
        'objectif_kg'   => 'required|numeric',
        'duree_semaine' => 'required|integer|greater_than[0]',
        'prix_total'    => 'required|numeric|greater_than_equal_to[0]',
        'client_id'     => 'required|integer',
        'regime_id'     => 'required|integer',
    ];

    public function getProgrammesByClientId(int $clientId): array
    {
        return $this->select('
                programme.*,
                objectif.name AS objectif_name,
                regimes.name AS regime_name,
                transactions.montant AS montant_transaction,
                transactions.type AS type_transaction
            ')
            ->join('objectif', 'objectif.id = programme.objectif_id')
            ->join('regimes', 'regimes.id = programme.regime_id')
            ->join('transactions', 'transactions.id = programme.transaction_id', 'left')
            ->where('programme.client_id', $clientId)
            ->orderBy('programme.date_programme', 'DESC')
            ->findAll();
    }

    public function createProgramme(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }
}