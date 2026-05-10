<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\InfoClientsModel;
use App\Models\RegimeModel;
use App\Models\ParametreModel;
use App\Models\TransactionModel;
use App\Models\ObjectifModel;

class UserController extends BaseController
{
    private $userModel;
    private $infoClientModel;
    private $parametreModel;
    private $transactionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->infoClientModel = new InfoClientsModel();
        $this->parametreModel = new ParametreModel();
        $this->transactionModel = new TransactionModel();
    }

    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/acceuil');
        }

        return view('template/healthy_food_international_landing_template(5)');
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
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        $pwdBase = $userBase['password'] ?? '';

        if (!password_verify($pwd, $pwdBase)) {
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'  => $userBase['id'],
            'username' => $this->infoClientModel->getByUserId((int) $userBase['id'])['name'] ?? '',
            'email'    => $userBase['email'],
            'role'     => $userBase['role'] ?? null,
        ]);

        if (($userBase['role'] ?? null) === 'admin') {
            return redirect()->to('/dashboard')->with('success', 'Connexion admin réussie.');
        }

        return redirect()->to('/acceuil')->with('success', 'Connexion réussie.');
    }

    public function inscriptionPage1()
    {
        return view('template/healthy_food_international_landing_template(5)');
    }

    public function inscriptionPage2()
    {
        $session = session();

        $session->set([
            'email' => $this->request->getPost('email') ?: $session->get('email'),
            'username'  => $this->request->getPost('username') ?: $session->get('username'),
            'pwd'   => $this->request->getPost('pwd') ?: $session->get('pwd'),
            'genre' => $this->request->getPost('genre') ?: $session->get('genre'),
        ]);

        return view('template/healthy_food_international_landing_template(5)');
    }


    public function savePage2()
    {
        session()->set([
            'phone'          => $this->request->getPost('phone'),
            'genre'          => $this->request->getPost('genre'),
            'date_naissance' => $this->request->getPost('date_naissance'),
            'age'            => $this->request->getPost('age'),
            'taille'         => $this->request->getPost('taille'),
            'poids'          => $this->request->getPost('poids'),
        ]);

        return redirect()->to('/inscription');
    }

    public function enregistrementUser()
    {
        $session = session();

        $email = trim((string) $session->get('email'));
        $username = trim((string) $session->get('username'));
        $password = (string) $session->get('pwd');

        $phone = trim((string) $this->request->getPost('phone'));
        $genre = (string) $this->request->getPost('genre');
        $dateNaissance = (string) $this->request->getPost('date_naissance');
        $age = (int) $this->request->getPost('age');
        $taille = (float) $this->request->getPost('taille');
        $poids = (float) $this->request->getPost('poids');

        if ($email === '' || $username === '' || $password === '') {
            return redirect()->to('/step2')->with('error', 'Les informations de l’étape 1 sont manquantes.');
        }

        if ($genre === '' || $dateNaissance === '' || $age <= 0 || $taille <= 0 || $poids <= 0) {
            return redirect()->to('/step2')->with('error', 'Veuillez remplir correctement toutes les informations.');
        }

        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->to('/step2')->with('error', 'Cet email existe déjà.');
        }

        if ($this->infoClientModel->where('name', $username)->first()) {
            return redirect()->to('/step2')->with('error', 'Ce nom d’utilisateur existe déjà.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->userModel->insert([
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'client',
        ]);

        $userId = $this->userModel->getInsertID();

        $this->infoClientModel->insert([
            'user_id'           => $userId,
            'name'              => $username,
            'phone'             => $phone ?? null,
            'genre'             => $genre,
            'date_naissance'    => $dateNaissance,
            'age'               => $age,
            'taille'            => $taille,
            'poids'             => $poids,
            'is_gold'           => 0,
            'wallet'            => 0,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/step2')->with('error', 'Erreur lors de l’inscription. Veuillez réessayer.');
        }

        $session->remove([
            'email',
            'username',
            'pwd',
            'phone',
            'genre',
            'date_naissance',
            'age',
            'taille',
            'poids',
        ]);

        return redirect()->to('/login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

   

    public function acceuil()
    {   if(!session()->get('user_id')) {
            return redirect()->to('/login');
        }
        $userId = (int) session()->get('user_id');
        $user = $this->userModel->find($userId);
        $client = $this->infoClientModel->getByUserId($userId);

        if (!$client && $user) {
            $db = \Config\Database::connect();
            $client = $db->table('infos_clients ic')
                ->select('ic.*')
                ->join('user u', 'u.id = ic.user_id')
                ->where('u.email', $user['email'])
                ->get()
                ->getRowArray();
        }

        return view('template/healthy_food_international_landing_template(5)', [
            'user' => $user,
            'client' => $client,
            'regimes' => (new RegimeModel())->findAll(),
            'objectifs' => (new ObjectifModel())->getAllObjectifs(),
            'gold_prix' => $this->parametreModel->getFloatValeur('gold_prix'),
            'gold_reduction' => $this->parametreModel->getFloatValeur('reduction_gold'),
        ]);
    }
    

    public function profil()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $user = $this->userModel->find($userId);

    $client = $this->infoClientModel->getByUserId((int) $userId);

    if (!$client && $user) {
        $db = \Config\Database::connect();
        $client = $db->table('infos_clients ic')
            ->select('ic.*')
            ->join('user u', 'u.id = ic.user_id')
            ->where('u.email', $user['email'])
            ->get()
            ->getRowArray();
    }

    return view('template/healthy_food_international_landing_template(5)', [
        'user' => $user,
        'client' => $client,
        'gold_prix' => $this->parametreModel->getFloatValeur('gold_prix'),
        'gold_reduction' => $this->parametreModel->getFloatValeur('reduction_gold'),
    ]);
}
    
   public function modifierProfil()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $this->infoClientModel->updateProfilByUserId($userId, [
        'name' => trim((string) $this->request->getPost('username')),
        'phone'  => trim((string) $this->request->getPost('phone')),
        'genre'  => $this->request->getPost('genre'),
        'taille' => $this->request->getPost('taille'),
        'poids'  => $this->request->getPost('poids'),
    ]);

    $this->userModel->updateProfilById($userId, [
        'email'    => trim((string) $this->request->getPost('email')),
    ]);

    session()->set([
        'email'    => trim((string) $this->request->getPost('email')),
        'username' => trim((string) $this->request->getPost('username')),
    ]);

        return redirect()->to('/profil')
        ->with('success', 'Profil modifié avec succès.');
}

    public function activerGold()
    {
        $userId = (int) session()->get('user_id');
        if ($userId <= 0) {
            return redirect()->to('/login');
        }

        $client = $this->infoClientModel->getByUserId($userId);
        if (!$client) {
            return redirect()->to('/profil')->with('error', 'Profil client introuvable.');
        }

        if (!empty($client['is_gold'])) {
            return redirect()->to('/profil')->with('success', 'Option Gold déjà active.');
        }

        $prixGold = (float) $this->parametreModel->getFloatValeur('gold_prix');
        if ($prixGold <= 0) {
            $prixGold = 50000;
        }

        $wallet = (float) ($client['wallet'] ?? 0);
        if ($wallet < $prixGold) {
            return redirect()->to('/profil')->with('error', 'Solde insuffisant pour activer Gold.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->transactionModel->createDebit((int) $client['id'], $prixGold);

            $this->infoClientModel->update((int) $client['id'], [
                'is_gold' => 1,
                'wallet' => $wallet - $prixGold,
            ]);

            $db->transCommit();
            return redirect()->to('/profil')->with('success', 'Option Gold activée avec succès.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/profil')->with('error', 'Erreur lors de l’activation Gold.');
        }
    }


}
