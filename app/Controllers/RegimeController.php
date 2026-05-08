<?php

namespace App\Controllers;

use \App\Models\Ingredient;
use \App\Models\Regime;
use \App\Models\VCompositionRegime;
use \App\Models\CompositionRegime;


class RegimeController extends BaseController
{
    public function showForm()
    {
        $ingredientModel = new Ingredient();
        $ingredients = $ingredientModel->getAllIngredients();

        helper(['form']);

        return $this->render('regime_form', [
            'ingredients' => $ingredients
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
                'type_variation'       => $this->request->getPost('type_variation'),
                'variation_poids_jour' => $this->request->getPost('variation_poids_jour'),
                'prix_jour'            => $this->request->getPost('prix_jour')
            ];

            if (!$regimeModel->insert($regimedata)) {
                throw new \Exception('Validation du régime échouée');
            }

            $regimeId = $regimeModel->getInsertID();

            $ingredients = $ingredientModel->findAll();

            foreach ($ingredients as $item) {
                $pourcentage = $this->request->getPost('poucentage_' . $item['name']);

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
        }

        return $this->render('regime_list', [
            'regimes' => $regimes
        ]);
    }
}
