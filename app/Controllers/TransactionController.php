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

        return view('template/healthy_food_international_landing_template(5)');
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
        $stats = [
            'users' => (new UserModel())->countAllResults(),
            'regimes' => (new \App\Models\RegimeModel())->countAllResults(),
            'ingredients' => (new \App\Models\IngredientModel())->countAllResults(),
            'montant_total' => (float) (\Config\Database::connect()->table('transactions')->selectSum('montant')->get()->getRowArray()['montant'] ?? 0),
        ];

        return view('template/healthy_food_international_landing_template(5)', [
            'admin_view' => 'admin-dashboard',
            'stats' => $stats,
            'latest_transactions' => $transactions,
            'latest_users' => [],
            'latest_regimes' => [],
        ]);
    }

    public function transaction(){
        return view('template/healthy_food_international_landing_template(5)');
    }
}
