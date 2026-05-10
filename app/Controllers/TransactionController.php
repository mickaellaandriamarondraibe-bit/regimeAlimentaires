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

        return view('profil/transactions', [
            'title' => 'Mes transactions - NutriFit',
            'transactions' => $transactions,
            ...$this->profileData(),
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
        $stats = [
            'users' => (new UserModel())->countAllResults(),
            'regimes' => (new \App\Models\RegimeModel())->countAllResults(),
            'ingredients' => (new \App\Models\IngredientModel())->countAllResults(),
            'montant_total' => (float) (\Config\Database::connect()->table('transactions')->selectSum('montant')->get()->getRowArray()['montant'] ?? 0),
        ];
        $db = \Config\Database::connect();
        $demandesCodes = $db->table('demande_code dc')
            ->select('dc.id, dc.statut, dc.validated_at, c.code, ic.name AS client_name, ua.email AS validated_by_email')
            ->join('code c', 'c.id = dc.code_id')
            ->join('infos_clients ic', 'ic.id = dc.client_id')
            ->join('user ua', 'ua.id = dc.validated_by', 'left')
            ->orderBy('dc.id', 'DESC')
            ->get(20)
            ->getResultArray();
        $achatsProgrammes = $db->table('programme p')
            ->select('p.id, p.date_programme, p.prix_total, r.name AS regime_name, ic.name AS client_name')
            ->join('regimes r', 'r.id = p.regime_id')
            ->join('infos_clients ic', 'ic.id = p.client_id')
            ->orderBy('p.id', 'DESC')
            ->get(20)
            ->getResultArray();

        return view('admin/transactions', [
            'title' => 'Transactions - NutriFit',
            'stats' => $stats,
            'latest_transactions' => $transactions,
            'demandes_codes' => $demandesCodes,
            'achats_programmes' => $achatsProgrammes,
            'latest_users' => [],
            'latest_regimes' => [],
        ]);
    }
}
