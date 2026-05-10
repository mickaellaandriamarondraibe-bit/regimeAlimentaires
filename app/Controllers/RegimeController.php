<?php

namespace App\Controllers;

use \App\Models\IngredientModel;
use \App\Models\RegimeModel;
use \App\Models\CompositionRegimeModel;
use \App\Models\ObjectifModel;
use \App\Models\PrixRegimeModel;
use \App\Models\SportModel;
use \App\Models\RegimeSportModel;
use App\Models\UserModel;
use App\Models\InfoClientsModel;

class RegimeController extends BaseController
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

    public function showForm()
    {
        $ingredientModel = new IngredientModel();
        $ingredients = $ingredientModel->getAllIngredients();

        $objectifModel = new ObjectifModel();
        $objectifs = $objectifModel->getBaseObjectifs();

        helper(['form']);

        return view('admin/regimes/create', [
            'title' => 'Créer un régime - NutriFit',
            'ingredients' => $ingredients,
            'objectifs' => $objectifs,
            ...$this->profileData(),
        ]);
    }

    public function saveRegime()
    {
        $db = \Config\Database::connect();
        $regimeModel = new RegimeModel();
        $regimeComposition = new CompositionRegimeModel();
        $ingredientModel = new IngredientModel();

        $db->transBegin();

        try {
            $regimedata = [
                'name'                 => $this->request->getPost('regime_name'),
                'description'          => $this->request->getPost('description'),
                'variation_poids_semaine' => $this->request->getPost('variation_poids_semaine')
            ];

            if (!$regimeModel->insert($regimedata)) {
                throw new \Exception('Validation du régime échouée');
            }

            $regimeId = $regimeModel->getInsertID();

            $ingredients = $ingredientModel->findAll();

            foreach ($ingredients as $item) {
                $pourcentage = $this->request->getPost('pourcentage_' . $item['name']);

                if (!empty($pourcentage) && $pourcentage > 0) {
                    $compositionEntry = [
                        'regime_id'     => $regimeId,
                        'ingredient_id' => $item['id'],
                        'pourcentage'   => $pourcentage
                    ];

                    if (!$regimeComposition->insert($compositionEntry)) {
                        throw new \Exception('Erreur lors de l\'insertion d\'un ingrédient');
                    }
                }
            }

            $semaines = $this->request->getPost('semaine');
            $prix = $this->request->getPost('prix');

            if (is_array($semaines) && is_array($prix) && count($semaines) === count($prix)) {
                $prixModel = new PrixRegimeModel();

                for ($i = 0; $i < count($semaines); $i++) {
                    if ($semaines[$i] !== '' && $prix[$i] !== '') {
                        $prixEntry = [
                            'regime_id'     => $regimeId,
                            'duree_semaine' => $semaines[$i],
                            'prix'          => $prix[$i]
                        ];

                        if (!$prixModel->insert($prixEntry)) {
                            throw new \Exception('Erreur lors de l\'insertion du prix pour la semaine ' . $semaines[$i]);
                        }
                    }
                }
            } else {
                throw new \Exception('Les données de prix sont invalides');
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Erreur lors de la transaction']);
            } else {
                $db->transCommit();
                return redirect()->to('/regime/list')->with('message', 'Régime et composition enregistrés !');
            }
        } catch (\Exception $e) {
            $db->transRollback();

            $errors = $regimeModel->errors() ?: [$e->getMessage()];

            return redirect()->back()->withInput()->with('errors', $errors);
        }
    }

    public function list()
    {
        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->findAll();

        foreach ($regimes as &$regime) {
            $regime = $regimeModel->getRegimeComplet($regime['id']);
        }

        return view('admin/regimes/index', [
            'title' => 'Gestion des régimes - NutriFit',
            'regimes' => $regimes,
            ...$this->profileData(),
        ]);
    }

    public function detail($id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->getRegimeComplet($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        $ingredients = (new IngredientModel())->findAll();
        $allSports = (new SportModel())->findAll();

        $compositionMap = [];
        foreach (($regime['compositions'] ?? []) as $composition) {
            $ingredientId = (int) ($composition['ingredient_id'] ?? 0);
            if ($ingredientId > 0) {
                $compositionMap[$ingredientId] = (float) ($composition['pourcentage'] ?? 0);
            }
        }

        $linkedSportIds = array_map(
            static fn($value) => (int) $value,
            array_column($regime['sport_associe'] ?? [], 'id')
        );

        return view('admin/regimes/detail', [
            'title' => 'Détail régime - NutriFit',
            'regime' => $regime,
            'ingredients' => $ingredients,
            'composition_map' => $compositionMap,
            'all_sports' => $allSports,
            'linked_sport_ids' => $linkedSportIds,
            ...$this->profileData(),
        ]);
    }

    public function updateGeneral(int $id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'description' => trim((string) $this->request->getPost('description')),
            'variation_poids_semaine' => $this->request->getPost('variation_poids_semaine'),
        ];

        if (!$regimeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $regimeModel->errors());
        }

        return redirect()->to('/regime/detail/' . $id)->with('success', 'Informations générales mises à jour.');
    }

    public function updateComposition(int $id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        $ingredients = (new IngredientModel())->findAll();
        $compositionModel = new CompositionRegimeModel();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $compositionModel->where('regime_id', $id)->delete();

            foreach ($ingredients as $ingredient) {
                $ingredientId = (int) ($ingredient['id'] ?? 0);
                if ($ingredientId <= 0) {
                    continue;
                }

                $pourcentage = (float) $this->request->getPost('pourcentage_' . $ingredientId);

                if ($pourcentage > 0) {
                    $compositionModel->insert([
                        'regime_id' => $id,
                        'ingredient_id' => $ingredientId,
                        'pourcentage' => $pourcentage,
                    ]);
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Erreur lors de la mise à jour de la composition.']);
            }

            $db->transCommit();
            return redirect()->to('/regime/detail/' . $id)->with('success', 'Composition mise à jour.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Erreur: ' . $e->getMessage()]);
        }
    }

    public function updatePrix(int $id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        $semaines = $this->request->getPost('semaine');
        $prix = $this->request->getPost('prix');

        if (!is_array($semaines) || !is_array($prix) || count($semaines) !== count($prix)) {
            return redirect()->back()->withInput()->with('errors', ['Données de tarifs invalides.']);
        }

        $prixModel = new PrixRegimeModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $prixModel->where('regime_id', $id)->delete();

            for ($i = 0; $i < count($semaines); $i++) {
                $semaine = (int) $semaines[$i];
                $prixValue = (float) $prix[$i];

                if ($semaine <= 0) {
                    continue;
                }

                $prixModel->insert([
                    'regime_id' => $id,
                    'duree_semaine' => $semaine,
                    'prix' => $prixValue,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Erreur lors de la mise à jour des tarifs.']);
            }

            $db->transCommit();
            return redirect()->to('/regime/detail/' . $id)->with('success', 'Tarifs mis à jour.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Erreur: ' . $e->getMessage()]);
        }
    }

    public function updateSports(int $id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        $sportIds = $this->request->getPost('sport_ids') ?? [];
        if (!is_array($sportIds)) {
            return redirect()->back()->withInput()->with('errors', ['Données de sports invalides.']);
        }

        $regimeSportModel = new RegimeSportModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $regimeSportModel->where('regime_id', $id)->delete();

            foreach ($sportIds as $sportId) {
                $sportId = (int) $sportId;
                if ($sportId <= 0) {
                    continue;
                }

                $regimeSportModel->insert([
                    'regime_id' => $id,
                    'sport_id' => $sportId,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Erreur lors de la mise à jour des sports.']);
            }

            $db->transCommit();
            return redirect()->to('/regime/detail/' . $id)->with('success', 'Sports mis à jour.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Erreur: ' . $e->getMessage()]);
        }
    }
}
