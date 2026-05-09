<?php
namespace App\Controllers;

use App\Models\InfoClientsModel;
use App\Models\ObjectifModel;

class ProgrammeController extends BaseController
{
    private InfoClientsModel $infoClientsModel;
    private ObjectifModel $objectifModel;

    public function __construct()
    {
        $this->infoClientsModel = new InfoClientsModel();
        $this->objectifModel = new ObjectifModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if ($client['poids'] <=0 || $client['taille'] <= 0) {
            return redirect()->to('/profil')
                    ->with('error', 'Veuillez compléter votre profil avant de continuer');
        }

        $objectifs = $this->objectifModel->getAllObjectifs();

        $imc = $this->calculerIMC($client['poids'], $client['taille']);

        return view('programme/index', [
            'client' => $client,
            'objectifs' => $objectifs,
            'imc' > $imc
        ]);
    }

    private function calculerIMC(float $poids, float $tailleCm): float
    {
        if ($poids <= 0 || $tailleCm <= 0) {
            return 0;
        }

        $tailleM = $tailleCm / 100;

        return round($poids / ($tailleM * $tailleM), 2);
    }
}