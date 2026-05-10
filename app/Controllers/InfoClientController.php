<?php

namespace App\Controllers;
use App\Models\InfoClientsModel;
use App\Models\TransactionModel;

class InfoClientController extends BaseController
{
    private $infoClientModel;
    private $transactionModel;
    public function __construct()
    {
        $this->infoClientModel = new InfoClientsModel();
        $this->transactionModel = new TransactionModel();
    }
    function infoClient(){
        return view('template/healthy_food_international_landing_template(5)');
    }

    
    function validationDepense(){
        $userId = (int) session()->get('user_id');
        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $client = $this->infoClientModel->getByUserId($userId);
        if (!$client) {
            return redirect()->to('/test')->with('error', 'Profil client introuvable.');
        }

        $solde = (float) ($client['wallet'] ?? 0);
        $depense = (float) $this->request->getPost('prix');
        if ($depense <= 0) {
            return redirect()->to('/test')->with('error', 'Depense invalide.');
        }
        if ($depense > $solde) {
            return redirect()->to('/test')->with('error', 'Depense depasse le solde disponible.');
        }
        $transactionData = [
                'date' => date('Y-m-d H:i:s'),
                'type' => 'D',
                'client_id' => (int) $client['id'],
                'montant' => $depense,
        
        ];
        $transactionDataCredi = [
                'date' => date('Y-m-d H:i:s'),
                'type' => 'C',
                'client_id' => 1,
                'montant' => $depense,
        
        ];
        $montantADebiter = -$depense;
        
        try {
                 $this->transactionModel->createTransaction($transactionData);
                 $this->transactionModel->createTransaction($transactionDataCredi);
                 $this->infoClientModel->updateSolde($userId, $montantADebiter);
        } catch (\Throwable $th) {
             return redirect()->to('/test')->with('error', 'Erreur lors de la mise a jour du solde.');
        }
        return redirect()->to('/test')->with('success', 'Depense enregistree avec succes.');
    }

    function test(){
        return view('template/healthy_food_international_landing_template(5)');
    }
    

    
    
}
