<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'date',
        'type',
        'client_id',
        'montant'
    ];

    protected $validationRules = [
        'date' => 'required',
        'type' => 'required|in_list[D,C]',
        'client_id' => 'required|integer',
        'montant' => 'required|numeric'
    ];

    protected $validationMessages = [
        'date' => ['required' => 'Le mouvement doit être daté.'],
        'type' => [
            'required' => 'Le type du mouvement doit être précisé',
            'in_list' => 'Le mouvement ne peut être que soit un débit D ou un crédit C'
        ],
        'client_id' => [
            'required' => 'Le mouvement doit être associé à un client',
            'integer' => 'L\'id du client doit être un entier'
        ],
        'montant' => [
            'required' => 'Le montant du mouvement est requis',
            'numeric' => 'Le montant du mouvement doit être un nombre valide'
        ]
    ];

    public function getAllMouvements(): array
    {
        return $this->select('
            transactions.*,
            infos_clients.phone,
            user.username,
            user.email
        ')
            ->join('infos_clients', 'infos_clients.id = transactions.client_id')
            ->join('user', 'user.id = infos_clients.user_id')
            ->orderBy('transactions.date', 'DESC')
            ->findAll();
    }

    public function getTransactionByClientId($clientId)
    {
        return $this->where('client_id', $clientId)
            ->orderBy('date', 'DESC')
            ->findAll();
    }

    public function getClientSolde(int $clientId): float
    {
        $creditResult = (float) $this->where([
            'client_id' => $clientId,
            'type' => 'C'
        ])
            ->selectSum('montant')
            ->first();

        $debitResult = (float) $this->where([
            'client_id' => $clientId,
            'type' => 'D'
        ])
            ->selectSum('montant')
            ->first();

        $credit = (float) ($creditResult['montant'] ?? 0);
        $debit = (float) ($debitResult['montant'] ?? 0);
        return $credit - $debit;
    }

    public function createCredit(int $clientId, float $montant): int
    {
        $this->insert([
            'type'      => 'C',
            'client_id' => $clientId,
            'montant'   => $montant,
        ]);

        return $this->getInsertID();
    }

    public function createDebit(int $clientId, float $montant): int
    {
        $this->insert([
            'type'      => 'D',
            'client_id' => $clientId,
            'montant'   => $montant,
        ]);

        return $this->getInsertID();
    }
}
