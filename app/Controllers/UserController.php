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

    
}
