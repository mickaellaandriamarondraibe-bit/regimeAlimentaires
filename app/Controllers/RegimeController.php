<?php

namespace App\Controllers;

use \App\Models\IngredientModel;
use \App\Models\RegimeModel;
use \App\Models\CompositionRegimeModel;
use \App\Models\ObjectifModel;
use \App\Models\PrixRegimeModel;
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

        return view('admin/regimes/detail', [
            'title' => 'Détail régime - NutriFit',
            'regime' => $regime,
            ...$this->profileData(),
        ]);
    }
}
