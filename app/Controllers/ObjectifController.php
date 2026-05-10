<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\UserModel;

class ObjectifController extends BaseController
{
    private ObjectifModel $objectifModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->objectifModel = new ObjectifModel();
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
            return redirect()->to('/accueil')
                ->with('error', 'Accès réservé à l’administrateur.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $objectifs = $this->objectifModel
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('admin/objectifs/index', [
            'title' => 'Objectifs - NutriFit',
            'objectifs' => $objectifs,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin/objectifs/form', [
            'title' => 'Créer un objectif - NutriFit',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
        ];

        if (!$this->objectifModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->objectifModel->errors());
        }

        return redirect()->to('/objectifs')
            ->with('success', 'Objectif ajouté avec succès.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $objectif = $this->objectifModel->find($id);

        if (!$objectif) {
            return redirect()->to('/objectifs')
                ->with('error', 'Objectif introuvable.');
        }

        return view('admin/objectifs/form', [
            'title' => 'Modifier un objectif - NutriFit',
            'objectif' => $objectif,
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $objectif = $this->objectifModel->find($id);

        if (!$objectif) {
            return redirect()->to('/objectifs')
                ->with('error', 'Objectif introuvable.');
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
        ];

        if (!$this->objectifModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->objectifModel->errors());
        }

        return redirect()->to('/objectifs')
            ->with('success', 'Objectif modifié avec succès.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $objectif = $this->objectifModel->find($id);

        if (!$objectif) {
            return redirect()->to('/objectifs')
                ->with('error', 'Objectif introuvable.');
        }

        $this->objectifModel->delete($id);

        return redirect()->to('/objectifs')
            ->with('success', 'Objectif supprimé avec succès.');
    }
}
