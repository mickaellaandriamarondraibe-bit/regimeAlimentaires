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

    private function profileData(): array
    {
        $userId = (int) session()->get('user_id');
        $user = (new \App\Models\UserModel())->find($userId);
        $client = $this->infoClientsModel->getByUserId($userId);

        return ['user' => $user, 'client' => $client];
    }

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

        $imc = $this->calculerImc($client['poids'], $client['taille']);

        return view('programmes/index', [
            'title' => 'Programmes - NutriFit',
            'objectifs' => $objectifs,
            'imc' => $imc,
            'suggestions' => [],
            ...$this->profileData(),
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
        $imc = $this->calculerImc($poidsActuel, $tailleCm);

        $objectifKg = 0.0;
        $poidsCible = 0.0;
        $sensObjectif = null;
        $regimes = [];

        $nomObjectif = strtolower((string) ($objectif['name'] ?? ''));
        $isReduce = ((int) $objectifId === 1)
            || str_contains($nomObjectif, 'reduire')
            || str_contains($nomObjectif, 'réduire');
        $isGain = ((int) $objectifId === 2)
            || str_contains($nomObjectif, 'augmenter');
        $isImc = ((int) $objectifId === 3)
            || str_contains($nomObjectif, 'imc');

        if ($isReduce) {
            $objectifKg = (float) $this->request->getPost('objectif_kg');
            if ($objectifKg <= 0) {
                return redirect()->back()->withInput()->with('error', 'Veuillez saisir un objectif KG valide.');
            }
            $poidsCible = $poidsActuel - $objectifKg;
            $sensObjectif = 'perte';
            $regimes = $this->regimeModel->getNegativeRegimes();
        } elseif ($isGain) {
            $objectifKg = (float) $this->request->getPost('objectif_kg');
            if ($objectifKg <= 0) {
                return redirect()->back()->withInput()->with('error', 'Veuillez saisir un objectif KG valide.');
            }
            $poidsCible = $poidsActuel + $objectifKg;
            $sensObjectif = 'gain';
            $regimes = $this->regimeModel->getPoitiveRegimes();
        } elseif ($isImc) {
            $poidsCible = $this->calculerPoidsIdeal($tailleCm);
            $objectifKg = abs($poidsActuel - $poidsCible);

            if ($objectifKg <= 0.1) {
                return view('programmes/index', [
                    'title' => 'Suggestions - NutriFit',
                    'objectifs' => $this->objectifModel->getAllObjectifs(),
                    'imc' => $imc,
                    'objectif_selectionne' => (int) $objectifId,
                    'objectif_kg_saisi' => (float) $objectifKg,
                    'suggestions' => [],
                    'sucess' => 'Vous êtes déjà proche de votre poids idéal',
                    ...$this->profileData(),
                ]);
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

        // Garder une trace simple du dernier diagnostic pour l'afficher sur le profil
        session()->set([
            'last_objectif_name' => $objectif['name'] ?? '',
            'last_objectif_kg' => (float) $objectifKg,
            'last_objectif_sens' => (string) $sensObjectif,
        ]);

        return view('programmes/index', [
            'title' => 'Suggestions - NutriFit',
            'objectifs' => $this->objectifModel->getAllObjectifs(),
            'imc' => $imc,
            'objectif_selectionne' => (int) $objectifId,
            'objectif_kg_saisi' => (float) $objectifKg,
            'suggestions' => $suggestions,
            ...$this->profileData(),
        ]);
    }

    public function catalogue()
    {
        $regimes = $this->regimeModel->findAll();

        foreach ($regimes as &$regime) {
            $regime['prix'] = $this->prixRegimeModel
                ->getPrixByRegimeId((int) $regime['id']);

            $regime['sports'] = $this->regimeSportModel
                ->getSportsByRegimeId((int) $regime['id']);
        }

        return view('programmes/catalogue', [
            'title' => 'Catalogue des régimes - NutriFit',
            'regimes' => $regimes,
            ...$this->profileData(),
        ]);
    }

    public function apercuAvantAchat()
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

        // Récupérer les paramètres de query string
        $objectifId = (int) ($this->request->getGet('objectif_id') ?? 0);
        $regimeId = (int) ($this->request->getGet('regime_id') ?? 0);
        $sportId = (int) ($this->request->getGet('sport_id') ?? 0);
        $objectifKg = (float) ($this->request->getGet('objectif_kg') ?? 0);
        $source = (string) ($this->request->getGet('source') ?? 'suggestion');

        if ($regimeId <= 0 || $sportId <= 0) {
            return redirect()->to('/programme')
                ->with('error', 'Données invalides.');
        }

        // Récupérer les objets
        $regime = $this->regimeModel->getRegimeComplet($regimeId);
        $sport = $this->sportModel->find($sportId);

        if (!$regime || !$sport) {
            return redirect()->to('/programme')
                ->with('error', 'Régime ou sport introuvable.');
        }

        // Vérifier la compatibilité
        if (!$this->regimeSportModel->verifyAssociation($regimeId, $sportId)) {
            return redirect()->to('/programme')
                ->with('error', 'Ce sport n\'est pas compatible avec le régime choisi.');
        }

        $variationTotale = (float) $regime['variation_poids_semaine']
            + (float) $sport['variation_poids_semaine'];

        if ($variationTotale == 0) {
            return redirect()->to('/programme')
                ->with('error', 'La variation totale est nulle.');
        }

        // Pour le catalogue
        if ($source === 'catalogue') {
            $prixRegimeId = (int) ($this->request->getGet('prix_regime_id') ?? 0);
            $prix = $this->prixRegimeModel->find($prixRegimeId);

            if (!$prix || (int) $prix['regime_id'] !== $regimeId) {
                return redirect()->to('/programme/catalogue')
                    ->with('error', 'Tarif invalide.');
            }

            $dureeFacturee = (int) $prix['duree_semaine'];
            $prixBase = (float) $prix['prix'];
            $objectifKg = abs($variationTotale) * $dureeFacturee;
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
        } else {
            // Pour les suggestions
            $objectifId = (int) ($this->request->getGet('objectif_id') ?? 0);
            $objectifKg = (float) ($this->request->getGet('objectif_kg') ?? 0);

            if ($objectifId <= 0 || $objectifKg <= 0) {
                return redirect()->to('/programme')
                    ->with('error', 'Données invalides.');
            }

            $objectif = $this->objectifModel->find($objectifId);

            if (!$objectif) {
                return redirect()->to('/programme')
                    ->with('error', 'Objectif introuvable.');
            }

            $dureeCalculee = (int) ceil($objectifKg / abs($variationTotale));

            if ($dureeCalculee <= 0) {
                return redirect()->to('/programme')
                    ->with('error', 'Durée calculée invalide.');
            }

            $prixData = $this->prixRegimeModel->getPrixSelonDuree($regimeId, $dureeCalculee);

            if (!$prixData) {
                return redirect()->to('/programme')
                    ->with('error', 'Aucun tarif disponible pour cette durée.');
            }

            $dureeFacturee = (int) $prixData['duree_semaine'];
            $prixBase = (float) $prixData['prix'];
            $prixRegimeId = (int) $prixData['id'];
        }

        $prixFinal = $this->calculerPrixFinal($prixBase, (bool) $client['is_gold']);

        // Calculer le poids cible
        $poidsInitial = (float) $client['poids'];
        $tailleCm = (float) $client['taille'];
        $imcInitial = $this->calculerImc($poidsInitial, $tailleCm);

        $nomObjectif = strtolower($objectif['name'] ?? '');

        if (str_contains($nomObjectif, 'réduire') || str_contains($nomObjectif, 'reduire')) {
            $poidsCible = $poidsInitial - $objectifKg;
        } elseif (str_contains($nomObjectif, 'augmenter')) {
            $poidsCible = $poidsInitial + $objectifKg;
        } else {
            $poidsCible = $this->calculerPoidsIdeal($tailleCm);
        }

        // Vérifier le solde
        $soldeActuel = (float) $client['wallet'];
        $soldeInsuffisant = $soldeActuel < $prixFinal;

        return view('programmes/apercu-achat', [
            'title' => 'Aperçu du programme - NutriFit',
            'regime' => $regime,
            'sport' => $sport,
            'objectif' => $objectif,
            'objectif_id' => $objectifId,
            'objectif_kg' => $objectifKg,
            'duree_facturee' => $dureeFacturee,
            'prix_base' => $prixBase,
            'prix_final' => $prixFinal,
            'poids_initial' => $poidsInitial,
            'poids_cible' => $poidsCible,
            'imc_initial' => $imcInitial,
            'solde_actuel' => $soldeActuel,
            'solde_insuffisant' => $soldeInsuffisant,
            'variation_totale' => $variationTotale,
            'regime_id' => $regimeId,
            'sport_id' => $sportId,
            'prix_regime_id' => $prixRegimeId,
            'source' => $source,
            ...$this->profileData(),
        ]);
    }

    public function acheterProgramme()
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

        // Récupérer les paramètres POST
        $objectifId = (int) $this->request->getPost('objectif_id');
        $regimeId = (int) $this->request->getPost('regime_id');
        $sportId = (int) $this->request->getPost('sport_id');
        $objectifKg = (float) $this->request->getPost('objectif_kg');
        $prixFinal = (float) $this->request->getPost('prix_final');
        $dureeFacturee = (int) $this->request->getPost('duree_facturee');
        $poidsInitial = (float) $this->request->getPost('poids_initial');
        $poidsCible = (float) $this->request->getPost('poids_cible');
        $imcInitial = (float) $this->request->getPost('imc_initial');

        // Vérifications
        if ($regimeId <= 0 || $sportId <= 0 || $prixFinal < 0 || $dureeFacturee <= 0) {
            return redirect()->to('/programme')
                ->with('error', 'Données invalides.');
        }

        // Vérifier que le solde est suffisant
        if ((float) $client['wallet'] < $prixFinal) {
            return redirect()->to('/programme')
                ->with('error', 'Solde insuffisant pour acheter ce programme.');
        }

        // Vérifier la compatibilité du sport et régime
        if (!$this->regimeSportModel->verifyAssociation($regimeId, $sportId)) {
            return redirect()->to('/programme')
                ->with('error', 'Ce sport n\'est pas compatible avec le régime choisi.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Créer la transaction de débit
            $transactionId = $this->transactionModel->createDebit(
                (int) $client['id'],
                $prixFinal
            );

            // Mettre à jour le wallet
            $this->infoClientsModel->update((int) $client['id'], [
                'wallet' => (float) $client['wallet'] - $prixFinal,
            ]);

            // Insérer le programme
            $programmeId = $this->programmeModel->insert([
                'objectif_id' => $objectifId,
                'objectif_kg' => $objectifKg,
                'duree_semaine' => $dureeFacturee,
                'prix_total' => $prixFinal,
                'poids_initial' => $poidsInitial,
                'poids_cible' => $poidsCible,
                'imc_initial' => $imcInitial,
                'transaction_id' => $transactionId,
                'client_id' => (int) $client['id'],
                'regime_id' => $regimeId,
            ], true);

            // Associer le sport au programme
            $this->programmeSportModel->insert([
                'programme_id' => $programmeId,
                'sport_id' => $sportId,
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/programme')
                    ->with('error', 'Erreur lors de la création du programme.');
            }

            $db->transCommit();

            return redirect()
                ->to('/programme/detail/' . $programmeId)
                ->with('success', 'Merci de votre confiance. Nous vous encourageons dans votre quête.');
        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->to('/programme')
                ->with('error', 'Erreur lors de l\'achat du programme : ' . $e->getMessage());
        }
    }

    public function confirmer()
    {
        // Rétrocompatibilité : rediriger vers la preview
        return redirect()->to('/programme/apercu-achat?'
            . 'objectif_id=' . (int) $this->request->getPost('objectif_id')
            . '&regime_id=' . (int) $this->request->getPost('regime_id')
            . '&sport_id=' . (int) $this->request->getPost('sport_id')
            . '&objectif_kg=' . (float) $this->request->getPost('objectif_kg')
            . '&source=suggestion'
        );
    }

    public function confirmerDepuisCatalogue()
    {
        // Rétrocompatibilité : rediriger vers la preview
        return redirect()->to('/programme/apercu-achat?'
            . 'objectif_id=0'
            . '&regime_id=' . (int) $this->request->getPost('regime_id')
            . '&sport_id=' . (int) $this->request->getPost('sport_id')
            . '&prix_regime_id=' . (int) $this->request->getPost('prix_regime_id')
            . '&objectif_kg=0'
            . '&source=catalogue'
        );
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

        return view('programmes/mes_programmes', [
            'title' => 'Mes programmes - NutriFit',
            'programmes' => $programmes,
            ...$this->profileData(),
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

        return view('programmes/detail', [
            'title' => 'Détail programme - NutriFit',
            'programme' => $programme,
            ...$this->profileData(),
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
