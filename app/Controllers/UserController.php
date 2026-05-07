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
            return redirect()->to('/login')->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id' => $userBase['id'],
            'username' => $userBase['username'],
            'email' => $userBase['email'],
            'role' => $userBase['role'] ?? null,
        ]);

        return redirect()->to('/acceuil');
    }

    public function logout()
    {
        session()->destroy();
        return view('template/login');
    }
}
