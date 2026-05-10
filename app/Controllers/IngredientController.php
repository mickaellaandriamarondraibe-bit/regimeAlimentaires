<?php

namespace App\Controllers;

use \App\Models\IngredientModel;
use App\Models\UserModel;
use App\Models\InfoClientsModel;

class IngredientController extends BaseController
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

    public function listAll()
    {
        $ingredientModel = new IngredientModel();
        $ingredients = $ingredientModel->getAllIngredients();

        return view('template/healthy_food_international_landing_template(5)', [
            'admin_view' => 'admin-ingredient',
            'ingredients' => $ingredients,
            ...$this->profileData(),
        ]);
    }

    public function create()
    {
        $ingredientModel = new IngredientModel();

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
