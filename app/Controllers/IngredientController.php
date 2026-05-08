<?php

namespace App\Controllers;

use \App\Models\Ingredient;

class IngredientController extends BaseController
{
    public function listAll()
    {
        $ingredientModel = new Ingredient();
        $ingredients = $ingredientModel->getAllIngredients();

        return $this->render('ingredient', [
            'ingredients' => $ingredients
        ]);
    }

    public function create()
    {
        $ingredientModel = new Ingredient();

        $data = [
            'name' => $this->request->getPost('name')
        ];

        if ($ingredientModel->insert($data)) {
            return redirect()->to('/ingredient')->with('success', 'Ingrédient ajouté avec succès');
        } else {
            return redirect()->to('/ingredient')->with('error', 'Erreur lors de l\'ajout de l\'ingrédient');
        }
    }

}