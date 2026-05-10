<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\InfoClientsModel;
use App\Models\RegimeModel;
use App\Models\IngredientModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    private function profileData(): array
    {
        $userId = (int) session()->get('user_id');
        $user = (new UserModel())->find($userId);
        $client = (new InfoClientsModel())->getByUserId($userId);

        if (!$client && $user) {
            $client = \Config\Database::connect()
                ->table('infos_clients ic')
                ->select('ic.*')
                ->join('user u', 'u.id = ic.user_id')
                ->where('u.email', $user['email'])
                ->get()
                ->getRowArray();
        }

        return ['user' => $user, 'client' => $client];
    }

    public function index()
    {
        $userModel = new UserModel();
        $regimeModel = new RegimeModel();
        $ingredientModel = new IngredientModel();
        $transactionModel = new TransactionModel();

        $stats = [
            'users' => $userModel->countAllResults(),
            'regimes' => $regimeModel->countAllResults(),
            'ingredients' => $ingredientModel->countAllResults(),
            'montant_total' => (float) (\Config\Database::connect()->table('transactions')->selectSum('montant')->get()->getRowArray()['montant'] ?? 0),
        ];

        $latestUsers = $userModel->orderBy('id', 'DESC')->findAll(8);
        $latestRegimes = $regimeModel->orderBy('id', 'DESC')->findAll(8);
        $latestTransactions = $transactionModel->getAllMouvements();

        return view('template/healthy_food_international_landing_template(5)', [
            'admin_view' => 'admin-dashboard',
            'stats' => $stats,
            'latest_users' => $latestUsers,
            'latest_regimes' => $latestRegimes,
            'latest_transactions' => array_slice($latestTransactions, 0, 8),
            ...$this->profileData(),
        ]);
    }
}
