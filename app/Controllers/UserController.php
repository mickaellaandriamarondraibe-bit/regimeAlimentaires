<?php

namespace App\Controllers;

use App\Models\UserModele;
use App\Models\InfoClientsModel;

class UserController extends BaseController
{
    private $userModel;
    private $infoClientModel;

    public function __construct()
    {
        $this->userModel = new UserModele();
        $this->infoClientModel = new InfoClientsModel();
    }

    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/acceuil');
        }

        return view('template/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

     public function validationLogin()
    {
        $email = trim((string) $this->request->getPost('email'));
        $pwd = (string) $this->request->getPost('pwd');

        $userBase = $this->userModel->getUserByEmail($email);

        if (!$userBase) {
            return redirect()->to('/login')
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        $pwdBase = $userBase['password'] ?? '';

        if (!password_verify($pwd, $pwdBase)) {
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'  => $userBase['id'],
            'username' => $userBase['username'],
            'email'    => $userBase['email'],
            'role'     => $userBase['role'] ?? null,
        ]);

        return redirect()->to('/acceuil')->with('success', 'Connexion réussie.');
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
            return redirect()->to('/step2')
                ->with('error', 'Les informations de l’étape 1 sont manquantes.');
        }

        if ($genre === '' || $taille <= 0 || $poids <= 0) {
            return redirect()->to('/step2')
                ->with('error', 'Veuillez remplir correctement toutes les informations.');
        }

        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->to('/step2')
                ->with('error', 'Cet email existe déjà.');
        }

        if ($this->userModel->where('username', $username)->first()) {
            return redirect()->to('/step2')
                ->with('error', 'Ce nom d’utilisateur existe déjà.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->userModel->insert([
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'client',
        ]);

        $userId = $this->userModel->getInsertID();

        $this->infoClientModel->insert([
            'user_id' => $userId,
            'phone'   => $phone ?? null,
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

        return redirect()->to('/login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

   

    public function acceuil()
    {   if(!session()->get('user_id')) {
            return redirect()->to('/login');
        }
        return view('template/acceuil');
    }
    

    public function profil()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $user = $this->userModel->find($userId);

    $client = $this->infoClientModel
        ->where('user_id', $userId)
        ->first();

    return view('template/profil', [
        'user' => $user,
        'client' => $client,
    ]);
}
    
    
    public function modifierProfil()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $userData = [
        'email'    => trim((string) $this->request->getPost('email')),
        'username' => trim((string) $this->request->getPost('name')),
    ];

    $password = (string) $this->request->getPost('pwd');

    if ($password !== '') {
        $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $this->userModel->update($userId, $userData);

    $this->infoClientModel
        ->where('user_id', $userId)
        ->set([
            'phone'  => trim((string) $this->request->getPost('phone')),
            'genre'  => $this->request->getPost('genre'),
            'taille' => $this->request->getPost('taille'),
            'poids'  => $this->request->getPost('poids'),
        ])
        ->update();

    session()->set([
        'email'    => $userData['email'],
        'username' => $userData['username'],
    ]);

    return redirect()->to('/profil')
        ->with('success', 'Profil modifié avec succès.');
}
}



