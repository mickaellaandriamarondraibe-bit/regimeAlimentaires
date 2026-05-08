<?php
namespace App\Controllers;
use App\Models\codeModel;
use App\Models\demandeCode;

class codeController extends BaseController
{
    private $codeModel;
    private $demandeCode;
    public function __construct()
    {
        $this->codeModel = new codeModel();
        $this->demandeCode = new demandeCode();
    }

    public function code(){
        return view('template/code');
    }

    public function validationCode()
{
    $code = trim((string) $this->request->getPost('code'));
    $codeBase = $this->codeModel->verifCode($code);

    if (empty($codeBase)) {
        return redirect()->to('/code')->with('error', 'Code incorrect.');
    }

    $codeId = is_array($codeBase) ? ($codeBase['id'] ?? null) : ($codeBase->id ?? null);

    if (!$codeId) {
        return redirect()->to('/code')->with('error', 'Code invalide (id introuvable).');
    }

    $demandeData = [
        'code_id'   => $codeId,
        'statut'    => 'en_attente',
        'client_id' => session()->get('user_id'),
       
    ];
        $this->demandeCode->createDemande($demandeData);
        if(!$this->demandeCode->createDemande($demandeData)){
            return redirect()->to('/code')->with('error', 'Erreur lors de la création de la demande.' + e.getMessage());
        }
    return redirect()->to('/code')->with('success', 'Code soumis pour validation.');
}

    
}
