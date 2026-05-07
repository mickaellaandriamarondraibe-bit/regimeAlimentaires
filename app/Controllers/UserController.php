<?php
namespace App\Controllers;
use App\Models\UserModele;

class UserController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/acceuil');
        }
        return view('template/login');
    }

    public function inscriptionPage1(){
        $session = session();
        $session->set([
            'number' => request()->getGet('number') ,
            'genre' => request()->getGet('genre') ,
            'taille' => $this->request->getGet('taille'),
            'poids' => $this->request->getGet('poids'),
        ]);
        return view('template/inscriptionPage1');
    }

    public function inscriptionPage2(){
        $session = session();
        $newData = [
            'email' => $this->request->getGet('email') ?: $session->get('email'),
            'name' => $this->request->getGet('name') ?: $session->get('name'),
            'pwd' => $this->request->getGet('pwd') ?: $session->get('pwd'),
            'genre' => $this->request->getGet('genre') ?: $session->get('genre'),
            'taille' => $this->request->getGet('taille') ?: $session->get('taille'),
            'poids' => $this->request->getGet('poids') ?: $session->get('poids'),
        ];
        $session->set($newData);
        
        return view('template/inscriptionPage2');
    }

    public function savePage2(){
        $session = session();
        $session->set([
            'phone' => $this->request->getPost('phone'),
            'genre' => $this->request->getPost('genre'),
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids'),
        ]);
        
        return redirect()->to('/inscription');
    }

    public function verifierPasswordAndEmail(){
        $userModel = new UserModele();
        $email = trim((string) $this->request->getPost('email'));
        $pwd = (string) $this->request->getPost('pwd'); 
        $userBase = $userModel->getUserByEmail($email);
        $emailBase = $userBase['email'];
        $pwdBase = $userBase['password'];

        if($email === $emailBase &&  $pwd === $pwdBase){
            return false; 
        }
        return true ;
    }

    
    public function enregistrementUser(){
        $userModel = new UserModele();
        $infoClientModel = new InfoClientsModel();
        $email = trim((string) $this->request->getPost('email'));
        $username = (string) $this->request->getPost('name');
        $pwd = (string) $this->request->getPost('pwd'); 
        $phone = (integer) $this->request->getPost('number');
        $genre = $_SESSION['genre'];
        $taille = $_SESSION['taille'];
        $poids = $_SESSION['poids'];
        $is_gold = (boolean) $this->request->getPost('is_gold');
        $wallet = (double) $this->request->getPost('wallet');
     
        $userModel->save([
            'email' => $email,
            'username' => $username,
            'password' => $pwd,
            'role' => 'client',
        ]);

        $infoClientModel->save([
            'user_id' => $userModel->getInsertID(),
            'phone' => $phone,
            'genre' => $genre,
            'taille' => $taille,
            'poids' => $poids,
            'is_gold' => $is_gold,
            'wallet' => $wallet,
        ]);
        return redirect()->to('/login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    public function validationLogin()
    {
        $user = new UserModele();
        $email = trim((string) $this->request->getPost('email'));
        $pwd = (string) $this->request->getPost('pwd');
        $userBase = $user->getUserByEmail($email);

        if (!$userBase) {
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        $pwdBase = $userBase['password'] ?? '';
        $estValid = false;

        if ($pwdBase === $pwd) {
            $estValid = true;
            $newhash = password_hash($pwd, PASSWORD_DEFAULT);
            $user->update($userBase['id'], ['password' => $newhash]);
        }
        elseif (password_verify($pwd, $pwdBase)) {
            $estValid = true;
        }

        if (!$estValid) {
            return redirect()->to('/erreur')->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id' => $userBase['id'],
            'username' => $userBase['username'],
            'email' => $userBase['email'],
            'role' => $userBase['role'] ?? null,
        ]);

        return redirect()->to('/erreur')->with('success', 'Connexion réussie.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
