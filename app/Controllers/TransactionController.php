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
        $db = \Config\Database::connect();
        $demandesCodes = $db->table('demande_code dc')
            ->select('dc.id, dc.statut, dc.validated_at, c.code, ic.username AS client_username, ua.email AS validated_by_email')
            ->join('code c', 'c.id = dc.code_id')
            ->join('infos_clients ic', 'ic.id = dc.client_id')
            ->join('user ua', 'ua.id = dc.validated_by', 'left')
            ->orderBy('dc.id', 'DESC')
            ->get(20)
            ->getResultArray();
        $achatsProgrammes = $db->table('programme p')
            ->select('p.id, p.date_programme, p.prix_total, r.name AS regime_name, ic.username AS client_username')
            ->join('regimes r', 'r.id = p.regime_id')
            ->join('infos_clients ic', 'ic.id = p.client_id')
            ->orderBy('p.id', 'DESC')
            ->get(20)
            ->getResultArray();

        return view('template/healthy_food_international_landing_template(5)', [
            'admin_view' => 'admin-dashboard',
            'stats' => $stats,
            'latest_transactions' => $transactions,
            'demandes_codes' => $demandesCodes,
            'achats_programmes' => $achatsProgrammes,
            'latest_users' => [],
            'latest_regimes' => [],
        ]);
    }

    public function transaction(){
        return view('template/healthy_food_international_landing_template(5)');
    }
}
