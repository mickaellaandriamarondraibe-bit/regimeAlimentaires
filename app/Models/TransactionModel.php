<?php

namespace App\Models;
use CodeIgniter\Model;
class TransactionModel extends Model
{



    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'type', 'client_id', 'montant'];

    protected $validationRules = [
        'date' => 'required|valid_date',
        'type' => 'required|in_list[D,C]',
        'client_id' => 'required|integer',
        'montant' => 'required|decimal',
    ];

    function createTransaction(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    function getTransactionById(int $id): ?array
    {
        return $this->find($id);
    }
}