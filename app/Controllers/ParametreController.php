<?php

namespace App\Controllers;

use App\Models\ParametreModel;
use App\Models\UserModel;

class ParametreController extends BaseController
{
    private ParametreModel $parametreModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
        $this->userModel = new UserModel();
    }

    private function checkAdmin()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')
                ->with('error', 'Veuillez vous connecter.');
        }

        if (!$this->userModel->isAdmin((int) $userId)) {
            return redirect()->to('/acceuil')
                ->with('error', 'Accès réservé à l’administrateur.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $parametres = $this->parametreModel
            ->orderBy('cle', 'ASC')
            ->findAll();

        return view('template/healthy_food_international_landing_template(5)', [
            'parametres' => $parametres
        ]);
    }

    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('template/healthy_food_international_landing_template(5)');
    }

    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $data = [
            'cle'         => trim((string) $this->request->getPost('cle')),
            'valeur'      => trim((string) $this->request->getPost('valeur')),
            'description' => trim((string) $this->request->getPost('description')),
        ];

        if ($this->parametreModel->where('cle', $data['cle'])->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette clé existe déjà.');
        }

        if (!$this->parametreModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->parametreModel->errors());
        }

        return redirect()->to('/parametres')
            ->with('success', 'Paramètre ajouté avec succès.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $parametre = $this->parametreModel->find($id);

        if (!$parametre) {
            return redirect()->to('/parametres')
                ->with('error', 'Paramètre introuvable.');
        }

        return view('template/healthy_food_international_landing_template(5)', [
            'parametre' => $parametre
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $parametre = $this->parametreModel->find($id);

        if (!$parametre) {
            return redirect()->to('/parametres')
                ->with('error', 'Paramètre introuvable.');
        }

        $data = [
            'cle'         => trim((string) $this->request->getPost('cle')),
            'valeur'      => trim((string) $this->request->getPost('valeur')),
            'description' => trim((string) $this->request->getPost('description')),
        ];

        $existing = $this->parametreModel
            ->where('cle', $data['cle'])
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette clé est déjà utilisée.');
        }

        if (!$this->parametreModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->parametreModel->errors());
        }

        return redirect()->to('/parametres')
            ->with('success', 'Paramètre modifié avec succès.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $parametre = $this->parametreModel->find($id);

        if (!$parametre) {
            return redirect()->to('/parametres')
                ->with('error', 'Paramètre introuvable.');
        }

        $this->parametreModel->delete($id);

        return redirect()->to('/parametres')
            ->with('success', 'Paramètre supprimé avec succès.');
    }
}
