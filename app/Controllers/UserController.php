<?php

namespace App\Controllers;

use App\Models\UserModele;
use App\Models\InfoClientsModel;

class UserController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/acceuil');
        }

        return view('template/login');
    }

    public function inscriptionPage1()
    {
        return view('template/inscriptionPage1');
    }

    public function inscriptionPage2()
    {
        $session = session();

        $session->set([
            'email' => $this->request->getPost('email') ?: $session->get('email'),
            'name'  => $this->request->getPost('name') ?: $session->get('name'),
            'pwd'   => $this->request->getPost('pwd') ?: $session->get('pwd'),
        ]);

        return view('template/inscriptionPage2');
    }

    public function savePage2()
    {
        session()->set([
            'phone'  => $this->request->getPost('phone'),
            'genre'  => $this->request->getPost('genre'),
            'taille' => $this->request->getPost('taille'),
            'poids'  => $this->request->getPost('poids'),
        ]);

        return redirect()->to('/inscription');
    }

    public function enregistrementUser()
    {
        $session = session();

        $email = trim((string) $session->get('email'));
        $username = trim((string) $session->get('name'));
        $password = (string) $session->get('pwd');

        $phone = trim((string) $this->request->getPost('phone'));
        $genre = (string) $this->request->getPost('genre');
        $taille = (float) $this->request->getPost('taille');
        $poids = (float) $this->request->getPost('poids');

        if ($email === '' || $username === '' || $password === '') {
            return redirect()->to('/inscription')
                ->with('error', 'Les informations de l’étape 1 sont manquantes.');
        }

        if ($phone === '' || $genre === '' || $taille <= 0 || $poids <= 0) {
            return redirect()->to('/step2')
                ->with('error', 'Veuillez remplir correctement toutes les informations.');
        }

        $userModel = new UserModele();
        $infoClientModel = new InfoClientsModel();

        if ($userModel->where('email', $email)->first()) {
            return redirect()->to('/inscription')
                ->with('error', 'Cet email existe déjà.');
        }

        if ($userModel->where('username', $username)->first()) {
            return redirect()->to('/inscription')
                ->with('error', 'Ce nom d’utilisateur existe déjà.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $userModel->insert([
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'client',
        ]);

        $userId = $userModel->getInsertID();

        $infoClientModel->insert([
            'user_id' => $userId,
            'phone'   => $phone,
            'genre'   => $genre,
            'taille'  => $taille,
            'poids'   => $poids,
            'is_gold' => 0,
            'wallet'  => 0,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/step2')
                ->with('error', 'Erreur lors de l’inscription. Veuillez réessayer.');
        }

        $session->remove([
            'email',
            'name',
            'pwd',
            'phone',
            'genre',
            'taille',
            'poids',
        ]);

        return redirect()->to('/login')
            ->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    public function validationLogin()
    {
        $userModel = new UserModele();

        $email = trim((string) $this->request->getPost('email'));
        $pwd = (string) $this->request->getPost('pwd');

        $userBase = $userModel->getUserByEmail($email);

        if (!$userBase) {
            return redirect()->to('/login')
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        $pwdBase = $userBase['password'] ?? '';

        if (!password_verify($pwd, $pwdBase)) {
            return redirect()->to('/login')
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'  => $userBase['id'],
            'username' => $userBase['username'],
            'email'    => $userBase['email'],
            'role'     => $userBase['role'] ?? null,
        ]);

        return redirect()->to('/acceuil')
            ->with('success', 'Connexion réussie.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}