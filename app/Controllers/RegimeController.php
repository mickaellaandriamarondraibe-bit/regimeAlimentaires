<?php

namespace App\Controllers;

use \App\Models\Ingredient;
use \App\Models\Regime;
use \App\Models\VCompositionRegime;
use \App\Models\CompositionRegime;
use \App\Models\Objectif;
use \App\Models\PrixRegime;

class RegimeController extends BaseController
{
    public function showForm()
    {
        $ingredientModel = new Ingredient();
        $ingredients = $ingredientModel->getAllIngredients();

        $objectifModel = new Objectif();
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
        $regimeModel = new Regime();
        $regimeComposition = new CompositionRegime();
        $ingredientModel = new Ingredient();

        $db->transBegin();

        try {
            $regimedata = [
                'name'                 => $this->request->getPost('regime_name'),
                'description'          => $this->request->getPost('description'),
                'variation_poids_semaine' => $this->request->getPost('variation_poids_semaine'),
                'objectif_id'         => $this->request->getPost('objectif_id')
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
                $prixModel = new PrixRegime();

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
        $regimeModel = new Regime();
        $regimes = $regimeModel->findAll();

        foreach ($regimes as &$regime) {
            $compositionModel = new VCompositionRegime();
            $regime['compositions'] = $compositionModel->getCompositionRegimeByRegimeId($regime['id']);
            $prixModel = new PrixRegime();
            $regime['prix'] = $prixModel->getPrixByRegimeId($regime['id']);
        }

        return $this->render('regime_list', [
            'regimes' => $regimes
        ]);
    }
}
