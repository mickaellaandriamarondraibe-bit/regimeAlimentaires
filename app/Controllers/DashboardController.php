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

        $latestUsers = \Config\Database::connect()
            ->table('user u')
            ->select('u.id, u.email, u.role, ic.name')
            ->join('infos_clients ic', 'ic.user_id = u.id', 'left')
            ->orderBy('u.id', 'DESC')
            ->get(8)
            ->getResultArray();
        $latestRegimes = $regimeModel->orderBy('id', 'DESC')->findAll(8);
        $latestTransactions = $transactionModel->getAllMouvements();
        $db = \Config\Database::connect();
        $txByTypeRows = $db->table('transactions')
            ->select('type, COUNT(*) AS total')
            ->groupBy('type')
            ->get()
            ->getResultArray();
        $txByType = ['C' => 0, 'D' => 0];
        foreach ($txByTypeRows as $row) {
            $type = (string) ($row['type'] ?? '');
            $txByType[$type] = (int) ($row['total'] ?? 0);
        }

        $usersByRoleRows = $db->table('user')
            ->select('role, COUNT(*) AS total')
            ->groupBy('role')
            ->get()
            ->getResultArray();
        $usersByRole = ['admin' => 0, 'client' => 0];
        foreach ($usersByRoleRows as $row) {
            $role = (string) ($row['role'] ?? '');
            $usersByRole[$role] = (int) ($row['total'] ?? 0);
        }

        $demandesCodes = $db->table('demande_code dc')
            ->select('dc.id, dc.statut, dc.validated_at, c.code, ic.name AS client_name, ua.email AS validated_by_email')
            ->join('code c', 'c.id = dc.code_id')
            ->join('infos_clients ic', 'ic.id = dc.client_id')
            ->join('user ua', 'ua.id = dc.validated_by', 'left')
            ->orderBy('dc.id', 'DESC')
            ->get(12)
            ->getResultArray();

        $achatsProgrammes = $db->table('programme p')
            ->select('p.id, p.date_programme, p.prix_total, r.name AS regime_name, ic.name AS client_name')
            ->join('regimes r', 'r.id = p.regime_id')
            ->join('infos_clients ic', 'ic.id = p.client_id')
            ->orderBy('p.id', 'DESC')
            ->get(12)
            ->getResultArray();

        return view('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'stats' => $stats,
            'tx_by_type' => $txByType,
            'users_by_role' => $usersByRole,
            'demandes_codes' => $demandesCodes,
            'achats_programmes' => $achatsProgrammes,
            'latest_users' => $latestUsers,
            'latest_regimes' => $latestRegimes,
            'latest_transactions' => array_slice($latestTransactions, 0, 8),
            ...$this->profileData(),
        ]);
    }
}
