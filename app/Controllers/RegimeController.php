<?php

namespace App\Controllers;

use \App\Models\IngredientModel;
use \App\Models\RegimeModel;
use \App\Models\VCompositionRegimeModel;
use \App\Models\CompositionRegimeModel;
use \App\Models\ObjectifModel;
use \App\Models\PrixRegimeModel;

class RegimeController extends BaseController
{
    public function showForm()
    {
        $ingredientModel = new IngredientModel();
        $ingredients = $ingredientModel->getAllIngredients();

        $objectifModel = new ObjectifModel();
        $objectifs = $objectifModel->getBaseObjectifs();

        helper(['form']);

        return $this->render('regime_form', [
            'ingredients' => $ingredients,
            'objectifs' => $objectifs
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

        return $this->render('regime_list', [
            'regimes' => $regimes
        ]);
    }

    public function detail($id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->getRegimeComplet($id);

        if (!$regime) {
            return redirect()->to('/regime/list')->with('errors', ['Régime introuvable.']);
        }

        return $this->render('regime_detail', [
            'regime' => $regime
        ]);
    }
}
