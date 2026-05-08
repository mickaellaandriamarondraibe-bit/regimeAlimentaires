<?php
namespace App\Controllers;
use App\Models\codeModel;

class codeController extends BaseController
{
    private $codeModel;

    public function __construct()
    {
        $this->codeModel = new codeModel();
    }

    public function code(){
        return view('template/code');
    }

    public function validationCode()
    {
        $code = trim((string) $this->request->getPost('code'));

        $codeBase = $this->codeModel->verifCode($code);

        if (!$codeBase) {
            return redirect()->to('/code')->with('error', 'Code incorrect.');
        }
        return redirect()->to('/code')->with('success', 'Code valide , vous allez recevoir des notification plutard.');
    }
    
}