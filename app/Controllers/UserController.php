<?php
namespace App\Controllers;
use App\Models\UserModele;

class UserController extends BaseController {
    
    public function login(){
        if(session()->get('user_id')){
           return redirect()->to('/acceuil');
        }
        return view('template/login');
    }

    public function validationLogin(){
        $user = new UserModele(); 
        $email = $this->request->getPost('email') ; 
        $pwd = $this->request->getPost('pwd'); 
        $userBase = $user.getUserByEmail($email)['password'];
        $pwdBase = $userBase['password'];
        if($pwdBase === $pwd){
            $estValid = true ; 
            $newhash = password_hash($pwd, PASSWORD_DEFAULT);
            $user->update($userBase['id'], ['password' => $newhash]);
            
        }
        elseif(password_verify($pwd, $pwdBase)){
            $estValid = true ; 
        }
        else{
            $estValid = false ; 
        }

        if($estValid){
                session()->set([
                    'user_id' => $userBase['id'],
                    'username' => $userBase['username'],
                    'email' => $userBase['email'],
                    'role' => $userBase['role']
                ]);
        }

        return redirect()->to('/acceuil');
    }

   
}
