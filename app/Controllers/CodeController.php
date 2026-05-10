<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\DemandeCode;
use App\Models\TransactionModel;
use App\Models\InfoClientsModel;

class CodeController extends BaseController
{
    private CodeModel $CodeModel;
    private DemandeCode $DemandeCode;
    private TransactionModel $transactionModel;
    private InfoClientsModel $infoClientModel;

    public function __construct()
    {
        $this->CodeModel = new CodeModel();
        $this->DemandeCode = new DemandeCode();
        $this->transactionModel = new TransactionModel();
        $this->infoClientModel = new InfoClientsModel();
    }

    public function code()
    {
        return view('template/healthy_food_international_landing_template(5)');
    }

    public function validationCode()
    {
        $clientId = session()->get('user_id');

        if (!$clientId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $code = trim((string) $this->request->getPost('code'));

        if ($code === '') {
            return redirect()->to('/code')->with('error', 'Veuillez saisir un code.');
        }

        $codeBase = $this->CodeModel->verifCode($code);

        if (empty($codeBase)) {
            return redirect()->to('/code')->with('error', 'Code incorrect.');
        }

        $codeId = is_array($codeBase)
            ? ($codeBase['id'] ?? null)
            : ($codeBase->id ?? null);

        if (!$codeId) {
            return redirect()->to('/code')->with('error', 'Code invalide : id introuvable.');
        }

        $demandeData = [
            'code_id'   => $codeId,
            'statut'    => 'en_attente',
            'client_id' => $clientId,
        ];

        try {
            $created = $this->DemandeCode->createDemande($demandeData);

            if (!$created) {
                return redirect()->to('/code')->with('error', 'Erreur lors de la création de la demande.');
            }

            return redirect()->to('/code')->with('success', 'Code soumis pour validation.');
        } catch (\Throwable $e) {
            return redirect()->to('/code')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function crediterBycode(int $codeId): bool
    {
        $code = $this->CodeModel->find($codeId);

        if (!$code) {
            return false;
        }

        $clientId = session()->get('user_id');

        if (!$clientId) {
            return false;
        }

        $client = $this->infoClientModel->getByUserId($clientId);

        if (!$client) {
            return false;
        }

        $soldeActuel = is_array($client)
            ? (float) ($client['solde'] ?? 0)
            : (float) ($client->solde ?? 0);

        $montant = is_array($code)
            ? (float) ($code['montant'] ?? 0)
            : (float) ($code->montant ?? 0);

        if ($montant <= 0) {
            return false;
        }

        $nouveauSolde = $soldeActuel + $montant;

        $db = \Config\Database::connect();

        try {
            $db->transBegin();

            $this->infoClientModel->updateSolde($clientId, $nouveauSolde);

            $this->transactionModel->createTransaction([
                'date'      => date('Y-m-d H:i:s'),
                'type'      => 'C',
                'client_id' => $clientId,
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
}
