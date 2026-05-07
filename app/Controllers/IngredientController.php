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

}