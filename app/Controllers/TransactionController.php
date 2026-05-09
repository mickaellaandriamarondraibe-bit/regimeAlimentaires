<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\InfoClientsModel;
use App\Models\UserModel;

class TransactionController extends BaseController
{
    private TransactionModel $transactionModel;
    private InfoClientsModel $infoClientsModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->infoClientsModel = new InfoClientsModel();
        $this->userModel = new UserModel();
    }

    public function myTransaction()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client) {
            throw new \Exception("Profil client introuvable");
        }

        $transactions = $this->transactionModel->getTransactionByClientId($client['id']);

        return view('transaction/index', [
            'client' => $client,
            'transactions' => $transactions
        ]);
    }

    public function getAllTransactions()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        if (!$this->userModel->isAdmin($userId)) {
            throw new \Exception('Seul l\'admin peut voir toutes les transactions');
        }

        $transactions = $this->transactionModel->getAllMouvements();

        return view('admin/transactions', [
            'transactions' => $transactions
        ]);
    }

    public function transaction(){
        return view('template/transaction');
    }
}
