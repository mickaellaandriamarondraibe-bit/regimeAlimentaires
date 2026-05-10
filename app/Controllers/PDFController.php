<?php

namespace App\Controllers;

use App\ThirdParty\ExportPDF;
use App\Models\InfoClientsModel;
use App\Models\ObjectifModel;
use App\Models\ParametreModel;
use App\Models\RegimeModel;
use App\Models\PrixRegimeModel;
use App\Models\SportModel;
use App\Models\RegimeSportModel;
use App\Models\ProgrammeModel;
use App\Models\TransactionModel;
use App\Models\ProgrammeSportModel;
use App\Models\UserModel;

class PDFController extends BaseController
{
    private InfoClientsModel $infoClientsModel;
    private ObjectifModel $objectifModel;
    private ParametreModel $parametreModel;
    private RegimeModel $regimeModel;
    private PrixRegimeModel $prixRegimeModel;
    private SportModel $sportModel;
    private RegimeSportModel $regimeSportModel;
    private ProgrammeModel $programmeModel;
    private TransactionModel $transactionModel;
    private ProgrammeSportModel $programmeSportModel;
    private ExportPDF $pdf;

    public function __construct()
    {
        $this->infoClientsModel = new InfoClientsModel();
        $this->objectifModel = new ObjectifModel();
        $this->parametreModel = new ParametreModel();
        $this->regimeModel = new RegimeModel();
        $this->prixRegimeModel = new PrixRegimeModel();
        $this->sportModel = new SportModel();
        $this->regimeSportModel = new RegimeSportModel();
        $this->programmeModel = new ProgrammeModel();
        $this->transactionModel = new TransactionModel();
        $this->programmeSportModel = new ProgrammeSportModel();
        $this->pdf = new ExportPDF();
    }

    private function profileData(): array
    {
        $userId = (int) session()->get('user_id');
        $user = (new UserModel())->find($userId);
        $client = $this->infoClientsModel->getByUserId($userId);

        return ['user' => $user, 'client' => $client];
    }

    public function apercuAchat()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $profile = $this->profileData();

        $sportNames = $this->request->getPost('sports_names') ?? [];
        $sportVariations = $this->request->getPost('sports_variations') ?? [];

        $sports = [];

        foreach ($sportNames as $index => $name) {
            $sports[] = [
                'name' => $name,
                'variation_poids_semaine' => $sportVariations[$index] ?? 0,
            ];
        }

        $programmeData = [
            'regime_name' => $this->request->getPost('regime_name') ?? '-',
            'objectif_name' => $this->request->getPost('objectif_name') ?? '-',
            'duree_semaine' => $this->request->getPost('duree_facturee') ?? 0,
            'objectif_kg' => $this->request->getPost('objectif_kg') ?? 0,
            'variation_totale' => $this->request->getPost('variation_totale') ?? 0,
            'poids_initial' => $this->request->getPost('poids_initial') ?? 0,
            'poids_cible' => $this->request->getPost('poids_cible') ?? 0,
            'imc_initial' => $this->request->getPost('imc_initial') ?? 0,
        ];

        $tarification = [
            'prix_base' => $this->request->getPost('prix_base') ?? 0,
            'prix_final' => $this->request->getPost('prix_final') ?? 0,
            'solde_actuel' => $this->request->getPost('solde_actuel') ?? 0,
        ];

        $this->pdf->initDocument();
        $this->pdf->logoAndTitle('Résumé de votre programme');
        $this->pdf->infosClient($profile['user'], $profile['client']);
        $this->pdf->infosProgramme($programmeData);
        $this->pdf->infosSports($sports);
        $this->pdf->infosTarification($tarification);
        $this->pdf->noteFooter();

        return $this->downloadPdf($this->pdf, 'resume_programme_apercu.pdf');
    }

    public function detailProgramme($id)
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $profile = $this->profileData();
        $client = $profile['client'];

        if (!$client) {
            return redirect()->to('/profil')
                ->with('error', 'Profil client introuvable.');
        }

        $programme = $this->programmeModel->find($id);

        if (!$programme) {
            return redirect()->to('/programme/mes-programmes')
                ->with('error', 'Programme introuvable.');
        }

        if ((int) $programme['client_id'] !== (int) $client['id']) {
            return redirect()->to('/programme/mes-programmes')
                ->with('error', 'Accès refusé.');
        }

        $regime = $this->regimeModel->find((int) $programme['regime_id']);
        $objectif = $this->objectifModel->find((int) $programme['objectif_id']);
        $sports = $this->programmeSportModel->getSportsByProgrammeId((int) $programme['id']);
        $transaction = !empty($programme['transaction_id'])
            ? $this->transactionModel->find((int) $programme['transaction_id'])
            : null;

        $variationTotale = (float) ($regime['variation_poids_semaine'] ?? 0);

        foreach ($sports as $sport) {
            $variationTotale += (float) ($sport['variation_poids_semaine'] ?? 0);
        }

        $programmeData = [
            'regime_name' => $regime['name'] ?? '-',
            'objectif_name' => $objectif['name'] ?? '-',
            'duree_semaine' => $programme['duree_semaine'] ?? 0,
            'objectif_kg' => $programme['objectif_kg'] ?? 0,
            'variation_totale' => $variationTotale,
            'poids_initial' => $programme['poids_initial'] ?? 0,
            'poids_cible' => $programme['poids_cible'] ?? 0,
            'imc_initial' => $programme['imc_initial'] ?? 0,
        ];

        $tarification = [
            'prix_base' => $programme['prix_total'] ?? 0,
            'prix_final' => $programme['prix_total'] ?? 0,
            'solde_actuel' => $client['wallet'] ?? 0,
        ];

        if ($transaction) {
            $tarification['transaction_montant'] = $transaction['montant'] ?? 0;
        }

        $this->pdf->initDocument();
        $this->pdf->logoAndTitle('Résumé de votre programme');
        $this->pdf->infosClient($profile['user'], $profile['client']);
        $this->pdf->infosProgramme($programmeData);
        $this->pdf->infosSports($sports);
        $this->pdf->infosTarification($tarification);
        $this->pdf->noteFooter();

        return $this->downloadPdf($this->pdf, 'resume_programme_' . $id . '.pdf');
    }

    private function downloadPdf(ExportPDF $pdf, string $filename)
    {
        $content = $pdf->Output('S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}
