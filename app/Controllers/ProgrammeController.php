<?php

namespace App\Controllers;

use App\Models\InfoClientsModel;
use App\Models\ObjectifModel;
use App\Models\ParametreModel;
use App\Models\RegimeModel;
use App\Models\PrixRegimeModel;
use App\Models\SportModel;
use App\Models\RegimeSportModel;
use App\Models\ProgrammeModel;
use App\Models\TransactionModel;
use App\Models\ProgrammeSportModel;

class ProgrammeController extends BaseController
{
    private InfoClientsModel $infoClientsModel;
    private ObjectifModel $objectifModel;
    private ParametreModel $parametreModel;
    private RegimeModel $regimeModel;
    private PrixRegimeModel $prixRegimeModel;
    private SportModel $sportModel;
    private RegimeSportModel $regimeSportModel;
    private ProgrammeModel $programmeModel;
    private TransactionModel $transactionModel;
    private ProgrammeSportModel $programmeSportModel;

    public function __construct()
    {
        $this->infoClientsModel = new InfoClientsModel();
        $this->objectifModel = new ObjectifModel();
        $this->parametreModel = new ParametreModel();
        $this->regimeModel = new RegimeModel();
        $this->prixRegimeModel = new PrixRegimeModel();
        $this->sportModel = new SportModel();
        $this->regimeSportModel = new RegimeSportModel();
        $this->programmeModel = new ProgrammeModel();
        $this->transactionModel = new TransactionModel();
        $this->programmeSportModel = new ProgrammeSportModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client || $client['poids'] === null || $client['taille'] === null) {
            return redirect()->to('/profil')
                ->with('error', 'Veuillez compléter votre profil avant de continuer');
        }

        $objectifs = $this->objectifModel->getAllObjectifs();

        $imc = $this->calculerIMC($client['poids'], $client['taille']);

        return view('programme/index', [
            'client' => $client,
            'objectifs' => $objectifs,
            'imc' => $imc
        ]);
    }

    public function suggestion()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client || $client['poids'] === null || $client['taille'] === null) {
            return redirect()->to('/profil')
                ->with('error', 'Veuillez compléter votre profil avant de continuer');
        }


        $objectifId = $this->request->getPost('objectif_id');

        if ($objectifId <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Veuillez choisir un objectif');
        }

        $objectif = $this->objectifModel->find($objectifId);

        if (!$objectif) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Veuillez choisir un objectif valide');
        }

        $poidsActuel = (float) $client['poids'];
        $tailleCm = (float) $client['taille'];
        $imc = $this->calculerIMC($poidsActuel, $tailleCm);

        $nomObjectif = $objectif['name'];

        $objectifKg = 0.0;
        $poidsCible = 0.0;
        $sensObjectif = null;
        $regimes = [];

        if (str_contains($nomObjectif, 'reduire') || str_contains($nomObjectif, 'réduire')) {
            $objectifKg = $this->request->getPost('objectif_kg');
            $poidsCible = $poidsActuel - $objectifKg;
            $sensObjectif = 'perte';
            $regimes = $this->regimeModel->getNegativeRegimes();
        } elseif (str_contains($nomObjectif, 'augmenter')) {
            $objectifKg = $this->request->getPost('objectif_kg');
            $poidsCible = $poidsActuel + $objectifKg;
            $sensObjectif = 'gain';
            $regimes = $this->regimeModel->getPoitiveRegimes();
        } elseif (str_contains($nomObjectif, 'imc')) {
            $poidsCible = $this->calculerPoidsIdeal($tailleCm);
            $objectifKg = abs($poidsActuel - $poidsCible);

            if ($objectifKg <= 0.1) {
                return redirect()->back()
                    ->with('success', 'Votre IMC actuel est déjà très proche de l\'IMC ideal. Continuez sur cette voie.');
            }

            if ($poidsActuel > $poidsCible) {
                $sensObjectif = 'perte';
                $regimes = $this->regimeModel->getNegativeRegimes();
            } else {
                $sensObjectif = 'gain';
                $regimes = $this->regimeModel->getPoitiveRegimes();
            }
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Objectif non reconnu');
        }

        $suggestions = [];

        foreach ($regimes as $regime) {
            $sports = $this->regimeSportModel->getSportsByRegimeId((int) $regime['id']);

            foreach ($sports as $sport) {
                $variationRegime = $regime['variation_poids_semaine'];
                $variationSport = $sport['variation_poids_semaine'];

                $variationTotale = $variationRegime + $variationSport;

                if ($variationTotale == 0) {
                    continue;
                }

                if ($sensObjectif == 'perte' && $variationTotale >= 0) {
                    continue;
                }

                if ($sensObjectif == 'gain' && $variationTotale <= 0) {
                    continue;
                }

                $dureeCalculee = (int) ceil($objectifKg / abs($variationTotale));

                if ($dureeCalculee <= 0) {
                    continue;
                }

                $prix = $this->prixRegimeModel->getPrixSelonDuree((int) $regime['id'], $dureeCalculee);

                if (!$prix) {
                    continue;
                }

                $prixBase = $prix['prix'];
                $prixFinal = $this->calculerPrixFinal($prixBase, (bool) $client['is_gold']);

                $suggestions[] = [
                    'regime' => $regime,
                    'sport' => $sport,

                    'variation_regime' => $variationRegime,
                    'variation_sport' => $variationSport,
                    'variation_totale' => $variationTotale,

                    'duree_calculee' => (int) $dureeCalculee,
                    'duree_facturee' => (int) $prix['duree_semaine'],

                    'prix_base' => $prixBase,
                    'prix_final' => $prixFinal,
                ];
            }
        }

        return view('programme/suggestions', [
            'client' => $client,
            'objectif' => $objectif,

            'objectif_kg' => $objectifKg,
            'poids_actuel' => $poidsActuel,
            'poids_cible' => $poidsCible,
            'sens_objectif' => $sensObjectif,
            'imc' => $imc,

            'suggestions' => $suggestions,
        ]);
    }

    public function catalogue()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $regimes = $this->regimeModel->findAll();

        foreach ($regimes as &$regime) {
            $regime['prix'] = $this->prixRegimeModel
                ->getPrixByRegimeId((int) $regime['id']);

            $regime['sports'] = $this->regimeSportModel
                ->getSportsByRegimeId((int) $regime['id']);
        }

        return view('programme/catalogue', [
            'regimes' => $regimes
        ]);
    }

    public function confirmer()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client || $client['poids'] === null || $client['taille'] === null) {
            return redirect()->to('/profil')
                ->with('error', 'Veuillez compléter votre profil avant de continuer');
        }

        $objectifId = (int) $this->request->getPost('objectif_id');
        $regimeId = (int) $this->request->getPost('regime_id');
        $sportId = (int) $this->request->getPost('sport_id');
        $objectifKg = (float) $this->request->getPost('objectif_kg');

        if ($objectifId <= 0 || $regimeId <= 0 || $sportId <= 0 || $objectifKg <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Données du programme invalides.');
        }

        $objectif = $this->objectifModel->find($objectifId);
        $regime = $this->regimeModel->find($regimeId);

        if (!$objectif || !$regime) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Objectif ou régime introuvable.');
        }

        $sportCompatible = $this->regimeSportModel->verifyAssociation($regimeId, $sportId);

        if (!$sportCompatible) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ce sport n’est pas compatible avec le régime choisi.');
        }

        $sport = $this->sportModel->find($sportId);

        if (!$sport) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sport introuvable.');
        }

        $variationTotale = (float) $regime['variation_poids_semaine']
            + (float) $sport['variation_poids_semaine'];

        if ($variationTotale == 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La variation totale est nulle.');
        }

        $dureeCalculee = (int) ceil($objectifKg / abs($variationTotale));

        if ($dureeCalculee <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Durée calculée invalide.');
        }

        $prix = $this->prixRegimeModel->getPrixPourDuree($regimeId, $dureeCalculee);

        if (!$prix) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Aucun tarif disponible pour cette durée.');
        }

        $dureeFacturee = (int) $prix['duree_semaine'];
        $prixBase = (float) $prix['prix'];
        $prixFinal = $this->calculerPrixFinal($prixBase, (bool) $client['is_gold']);

        if ((float) $client['wallet'] < $prixFinal) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Solde insuffisant pour acheter ce programme.');
        }

        $poidsInitial = (float) $client['poids'];
        $tailleCm = (float) $client['taille'];
        $imcInitial = $this->calculerImc($poidsInitial, $tailleCm);

        $nomObjectif = strtolower($objectif['name']);

        if (str_contains($nomObjectif, 'réduire') || str_contains($nomObjectif, 'reduire')) {
            $poidsCible = $poidsInitial - $objectifKg;
        } elseif (str_contains($nomObjectif, 'augmenter')) {
            $poidsCible = $poidsInitial + $objectifKg;
        } else {
            $poidsCible = $this->calculerPoidsIdeal($tailleCm);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $transactionId = $this->transactionModel->createDebit(
                (int) $client['id'],
                $prixFinal
            );

            $this->infoClientsModel->update((int) $client['id'], [
                'wallet' => (float) $client['wallet'] - $prixFinal,
            ]);

            $programmeId = $this->programmeModel->insert([
                'objectif_id' => $objectifId,
                'objectif_kg' => $objectifKg,
                'duree_semaine' => $dureeFacturee,
                'prix_total' => $prixFinal,
                'poids_initial' => $poidsInitial,
                'poids_cible' => $poidsCible,
                'imc_initial' => $imcInitial,
                'transaction_id' => $transactionId,
                'client_id' => $client['id'],
                'regime_id' => $regimeId,
            ], true);

            $this->programmeSportModel->insert([
                'programme_id' => $programmeId,
                'sport_id' => $sportId,
            ]);

            $db->transCommit();

            return redirect()
                ->to('/programme/detail/' . $programmeId)
                ->with('success', 'Merci de votre confiance. Nous vous encourageons dans votre quête.');
        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du programme : ' . $e->getMessage());
        }
    }

    public function confirmerDepuisCatalogue()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client || $client['poids'] === null || $client['taille'] === null) {
            return redirect()->to('/profil')
                ->with('error', 'Veuillez compléter votre profil avant de continuer');
        }

        $regimeId = (int) $this->request->getPost('regime_id');
        $sportId = (int) $this->request->getPost('sport_id');
        $prixRegimeId = (int) $this->request->getPost('prix_regime_id');

        if ($regimeId <= 0 || $sportId <= 0 || $prixRegimeId <= 0) {
            return redirect()->back()
                ->with('error', 'Données invalides.');
        }

        $regime = $this->regimeModel->find($regimeId);

        if (!$regime) {
            return redirect()->back()
                ->with('error', 'Régime introuvable.');
        }

        if (!$this->regimeSportModel->verifyAssociation($regimeId, $sportId)) {
            return redirect()->back()
                ->with('error', 'Ce sport n’est pas compatible avec ce régime.');
        }

        $sportsCompatibles = $this->regimeSportModel->getSportsByRegimeId($regimeId);

        $sport = null;

        foreach ($sportsCompatibles as $item) {
            if ((int) $item['id'] === $sportId) {
                $sport = $item;
                break;
            }
        }

        if (!$sport) {
            return redirect()->back()
                ->with('error', 'Sport introuvable.');
        }

        $prixRegime = $this->prixRegimeModel->find($prixRegimeId);

        if (
            !$prixRegime ||
            (int) $prixRegime['regime_id'] !== $regimeId
        ) {
            return redirect()->back()
                ->with('error', 'Tarif invalide pour ce régime.');
        }

        $dureeSemaine = (int) $prixRegime['duree_semaine'];
        $prixBase = (float) $prixRegime['prix'];
        $prixFinal = $this->calculerPrixFinal($prixBase, (bool) $client['is_gold']);

        $variationRegime = (float) $regime['variation_poids_semaine'];
        $variationSport = (float) $sport['variation_poids_semaine'];
        $variationTotale = $variationRegime + $variationSport;

        if ($variationTotale == 0) {
            return redirect()->back()
                ->with('error', 'La variation totale est nulle. Impossible de créer un programme.');
        }

        $objectifKg = abs($variationTotale * $dureeSemaine);

        $objectif = null;

        if ($variationTotale < 0) {
            $objectif = $this->objectifModel
                ->like('name', 'Réduire')
                ->orLike('name', 'Reduire')
                ->first();
        } else {
            $objectif = $this->objectifModel
                ->like('name', 'Augmenter')
                ->first();
        }

        if (!$objectif) {
            return redirect()->back()
                ->with('error', 'Objectif correspondant introuvable.');
        }

        $poidsInitial = (float) $client['poids'];
        $tailleCm = (float) $client['taille'];
        $imcInitial = $this->calculerImc($poidsInitial, $tailleCm);

        if ($variationTotale < 0) {
            $poidsCible = $poidsInitial - $objectifKg;
        } else {
            $poidsCible = $poidsInitial + $objectifKg;
        }

        if ((float) $client['wallet'] < $prixFinal) {
            return redirect()->back()
                ->with('error', 'Solde insuffisant pour acheter ce programme.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $transactionId = $this->transactionModel->createDebit(
                (int) $client['id'],
                $prixFinal
            );

            $this->infoClientsModel->update((int) $client['id'], [
                'wallet' => (float) $client['wallet'] - $prixFinal,
            ]);

            $programmeId = $this->programmeModel->insert([
                'objectif_id' => (int) $objectif['id'],
                'objectif_kg' => $objectifKg,
                'duree_semaine' => $dureeSemaine,
                'prix_total' => $prixFinal,
                'poids_initial' => $poidsInitial,
                'poids_cible' => $poidsCible,
                'imc_initial' => $imcInitial,
                'transaction_id' => $transactionId,
                'client_id' => (int) $client['id'],
                'regime_id' => $regimeId,
            ], true);

            $this->programmeSportModel->insert([
                'programme_id' => $programmeId,
                'sport_id' => $sportId,
            ]);

            $db->transCommit();

            return redirect()
                ->to('/programme/detail/' . $programmeId)
                ->with('success', 'Merci de votre confiance. Nous vous encourageons dans votre quête.');
        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Erreur lors de l’achat du programme : ' . $e->getMessage());
        }
    }

    public function mesProgrammes()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client) {
            return redirect()->to('/profil')
                ->with('error', 'Profil client introuvable.');
        }

        $programmes = $this->programmeModel->getProgrammesByClientId((int) $client['id']);

        return view('programme/mes_programmes', [
            'client' => $client,
            'programmes' => $programmes,
        ]);
    }

    public function detail($id)
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientsModel->getByUserId($userId);

        if (!$client) {
            return redirect()->to('/profil')
                ->with('error', 'Profil client introuvable.');
        }

        $programme = $this->programmeModel->find($id);

        if (!$programme) {
            return redirect()->to('/programme/mes-programmes')
                ->with('error', 'Programme introuvable.');
        }

        if ((int) $programme['client_id'] !== (int) $client['id']) {
            return redirect()->to('/programme/mes-programmes')
                ->with('error', 'Accès refusé.');
        }

        $programme['objectif'] = $this->objectifModel->find((int) $programme['objectif_id']);
        $programme['regime'] = $this->regimeModel->find((int) $programme['regime_id']);
        $programme['transaction'] = $programme['transaction_id']
            ? $this->transactionModel->find((int) $programme['transaction_id'])
            : null;

        $programme['sports'] = $this->programmeSportModel
            ->getSportsByProgrammeId((int) $programme['id']);

        return view('programme/detail', [
            'client' => $client,
            'programme' => $programme,
        ]);
    }

    private function calculerImc(float $poids, float $tailleCm): float
    {
        if ($poids <= 0 || $tailleCm <= 0) {
            return 0;
        }

        $tailleM = $tailleCm / 100;

        return round($poids / ($tailleM * $tailleM), 2);
    }

    private function calculerPoidsIdeal(float $tailleCm): float
    {
        if ($tailleCm <= 0) {
            return 0;
        }

        $imcIdeal = $this->parametreModel->getFloatValeur('imc_ideal');
        $tailleM = $tailleCm / 100;

        return round($imcIdeal * ($tailleM * $tailleM), 2);
    }

    private function calculerPrixFinal(float $prixNormal, bool $isGold): float
    {
        if (!$isGold) {
            return $prixNormal;
        }

        $reductionGold = $this->parametreModel->getFloatValeur('reduction_gold');

        return $prixNormal * (1 - ($reductionGold / 100));
    }
}
