<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\DemandeCode;
use App\Models\TransactionModel;
use App\Models\InfoClientsModel;
use App\Models\UserModel;

class CodeController extends BaseController
{
    private CodeModel $CodeModel;
    private DemandeCode $DemandeCode;
    private TransactionModel $transactionModel;
    private InfoClientsModel $infoClientModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->CodeModel = new CodeModel();
        $this->DemandeCode = new DemandeCode();
        $this->transactionModel = new TransactionModel();
        $this->infoClientModel = new InfoClientsModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $codes = $this->CodeModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/codes/index', [
            'title' => 'Codes de recharge - NutriFit',
            'codes' => $codes,
        ]);
    }

    public function create()
    {
        return view('admin/codes/form', [
            'title' => 'Créer un code - NutriFit',
        ]);
    }

    public function store()
    {
        $data = [
            'code' => trim((string) $this->request->getPost('code')),
            'montant' => (float) $this->request->getPost('montant'),
        ];

        if (!$this->CodeModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->CodeModel->errors());
        }

        return redirect()->to('/codes')
            ->with('success', 'Code ajouté avec succès.');
    }

    public function edit(int $id)
    {
        $codeRecharge = $this->CodeModel->find($id);

        if (!$codeRecharge) {
            return redirect()->to('/codes')
                ->with('error', 'Code introuvable.');
        }

        return view('admin/codes/form', [
            'title' => 'Modifier un code - NutriFit',
            'codeRecharge' => $codeRecharge,
        ]);
    }

    public function update(int $id)
    {
        $codeRecharge = $this->CodeModel->find($id);

        if (!$codeRecharge) {
            return redirect()->to('/codes')
                ->with('error', 'Code introuvable.');
        }

        $data = [
            'code' => trim((string) $this->request->getPost('code')),
            'montant' => (float) $this->request->getPost('montant'),
        ];

        if (!$this->CodeModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->CodeModel->errors());
        }

        return redirect()->to('/codes')
            ->with('success', 'Code modifié avec succès.');
    }

    public function delete(int $id)
    {
        $codeRecharge = $this->CodeModel->find($id);

        if (!$codeRecharge) {
            return redirect()->to('/codes')
                ->with('error', 'Code introuvable.');
        }

        $this->CodeModel->delete($id);

        return redirect()->to('/codes')
            ->with('success', 'Code supprimé avec succès.');
    }

    public function validationCode()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->infoClientModel->getByUserId($userId);

        if (!$client) {
            return redirect()->back()->with('error', 'Vous n\'avez encore de profil client.');
        }

        $clientId = $client['id'];

        $code = trim((string) $this->request->getPost('code'));

        if ($code === '') {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un code.');
        }

        $codeBase = $this->CodeModel->verifCode($code);

        if (empty($codeBase)) {
            return redirect()->back()->withInput()->with('error', 'Code invalide.');
        }

        $codeId = is_array($codeBase)
            ? ($codeBase['id'] ?? null)
            : ($codeBase->id ?? null);

        if (!$codeId) {
            return redirect()->back()->withInput()->with('error', 'Code invalide : id introuvable.');
        }

        $demandeExistante = $this->DemandeCode
            ->where('code_id', $codeId)
            ->where('client_id', $clientId)
            ->where('statut', 'en_attente')
            ->first();

        if ($demandeExistante) {
            return redirect()->back()->with('success', 'Votre demande est déjà en attente. Vous recevrez une réponse plus tard.');
        }

        $demandeData = [
            'code_id'   => $codeId,
            'statut'    => 'en_attente',
            'client_id' => $clientId,
        ];

        try {
            $created = $this->DemandeCode->createDemande($demandeData);

            if (!$created) {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la création de la demande.');
            }

            return redirect()->back()->with('success', 'Code valide. Votre demande est envoyée, vous recevrez un message plus tard.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function crediterBycode(int $codeId): bool
    {
        $code = $this->CodeModel->find($codeId);

        if (!$code) {
            return false;
        }

        $userId = session()->get('user_id');

        if (!$userId) {
            return false;
        }

        $client = $this->infoClientModel->getByUserId($userId);

        if (!$client) {
            return false;
        }

        $montant = is_array($code)
            ? (float) ($code['montant'] ?? 0)
            : (float) ($code->montant ?? 0);

        if ($montant <= 0) {
            return false;
        }

        $db = \Config\Database::connect();

        try {
            $db->transBegin();

            $this->infoClientModel->updateSolde($userId, $montant);

            $this->transactionModel->createTransaction([
                'date'      => date('Y-m-d H:i:s'),
                'type'      => 'C',
                'client_id' => $client['id'],
                'montant'   => $montant,
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return false;
            }

            $db->transCommit();
            return true;
        } catch (\Throwable $e) {
            $db->transRollback();
            return false;
        }
    }

    public function validerDemande(int $demandeId)
    {
        $adminId = (int) session()->get('user_id');
        if ($adminId <= 0) {
            return redirect()->to('/login');
        }
        if (!$this->userModel->isAdmin($adminId)) {
            return redirect()->to('/admin/transactions')->with('error', 'Accès réservé à l’admin.');
        }

        $demande = $this->DemandeCode->find($demandeId);
        if (!$demande) {
            return redirect()->to('/admin/transactions')->with('error', 'Demande introuvable.');
        }
        if (($demande['statut'] ?? '') !== 'en_attente') {
            return redirect()->to('/admin/transactions')->with('error', 'Cette demande a déjà été traitée.');
        }

        $codeId = (int) ($demande['code_id'] ?? 0);
        $clientInfoId = (int) ($demande['client_id'] ?? 0);
        if ($codeId <= 0 || $clientInfoId <= 0) {
            return redirect()->to('/admin/transactions')->with('error', 'Données de demande invalides.');
        }

        // Un code validé = une seule personne
        $alreadyValidated = $this->DemandeCode
            ->where('code_id', $codeId)
            ->where('statut', 'valide')
            ->first();
        if ($alreadyValidated) {
            $this->DemandeCode->update($demandeId, [
                'statut' => 'refuse',
                'validated_by' => $adminId,
                'validated_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/admin/transactions')->with('error', 'Code déjà utilisé par un autre client.');
        }

        $code = $this->CodeModel->find($codeId);
        if (!$code) {
            return redirect()->to('/admin/transactions')->with('error', 'Code introuvable.');
        }
        $montant = (float) ($code['montant'] ?? 0);
        if ($montant <= 0) {
            return redirect()->to('/admin/transactions')->with('error', 'Montant du code invalide.');
        }

        $client = $this->infoClientModel->find($clientInfoId);
        if (!$client) {
            return redirect()->to('/admin/transactions')->with('error', 'Client introuvable.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $walletActuel = (float) ($client['wallet'] ?? 0);
            $this->infoClientModel->update($clientInfoId, [
                'wallet' => $walletActuel + $montant,
            ]);

            $this->transactionModel->createTransaction([
                'date' => date('Y-m-d H:i:s'),
                'type' => 'C',
                'client_id' => $clientInfoId,
                'montant' => $montant,
            ]);

            $this->DemandeCode->update($demandeId, [
                'statut' => 'valide',
                'validated_by' => $adminId,
                'validated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/admin/transactions')->with('error', 'Erreur lors de la validation.');
            }

            $db->transCommit();
            return redirect()->to('/admin/transactions')->with('success', 'Demande validée et wallet crédité.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/admin/transactions')->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function refuserDemande(int $demandeId)
    {
        $adminId = (int) session()->get('user_id');
        if ($adminId <= 0) {
            return redirect()->to('/login');
        }
        if (!$this->userModel->isAdmin($adminId)) {
            return redirect()->to('/admin/transactions')->with('error', 'Accès réservé à l’admin.');
        }

        $demande = $this->DemandeCode->find($demandeId);
        if (!$demande) {
            return redirect()->to('/admin/transactions')->with('error', 'Demande introuvable.');
        }
        if (($demande['statut'] ?? '') !== 'en_attente') {
            return redirect()->to('/admin/transactions')->with('error', 'Cette demande a déjà été traitée.');
        }

        $this->DemandeCode->update($demandeId, [
            'statut' => 'refuse',
            'validated_by' => $adminId,
            'validated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/transactions')->with('success', 'Demande refusée.');
    }
}
