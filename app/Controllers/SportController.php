<?php

namespace App\Controllers;

use App\Models\SportModel;
use App\Models\RegimeModel;
use App\Models\RegimeSportModel;

class SportController extends BaseController
{
    private SportModel $sportModel;
    private RegimeModel $regimeModel;
    private RegimeSportModel $regimeSportModel;

    public function __construct()
    {
        $this->sportModel = new SportModel();
        $this->regimeModel = new RegimeModel();
        $this->regimeSportModel = new RegimeSportModel();
    }

    public function listSport()
    {
        $sports = $this->sportModel->findAll();

        return view('admin/sport/index', [
            'title' => 'Gestion des sports - NutriFit',
            'sports' => $sports,
        ]);
    }

    public function showForm()
    {
        return view('admin/sport/form', [
            'title' => 'Créer un sport - NutriFit',
        ]);
    }

    public function saveSport()
    {
        $sportData = [
            'name' => trim($this->request->getPost('sport_name')),
            'description' => trim($this->request->getPost('description')),
            'variation_poids_semaine' => $this->request->getPost('variation_poids_semaine')
        ];

        if (!$this->sportModel->insert($sportData)) {
            throw new \Exception("Impossible de créer le sport");
        }

        return redirect()
            ->to('/sport')
            ->with('success', 'Nouvelle activité sportive enregistrée');
    }

    public function edit($id)
    {
        $sport = $this->sportModel->find($id);

        if (!$sport) {
            throw new \Exception("Cette activité n'existe pas");
        }

        return view('admin/sport/form', [
            'title' => 'Modifier un sport - NutriFit',
            'sport' => $sport,
        ]);
    }

    public function update($id)
    {
        $sport = $this->sportModel->find($id);

        if (!$sport) {
            throw new \Exception("Cette activité n'existe pas");
        }

        $sportData = [
            'name' => trim($this->request->getPost('sport_name')),
            'description' => trim($this->request->getPost('description')),
            'variation_poids_semaine' => $this->request->getPost('variation_poids_semaine')
        ];

        if (!$this->sportModel->update($id, $sportData)) {
            throw new \Exception("Impossible de mettre à jour cette activité sportive");
        }

        return redirect()
            ->to('/sport')
            ->with('success', 'Activité sportive modifiée');
    }

    public function delete($id)
    {
        $sport = $this->sportModel->find($id);

        if (!$sport) {
            throw new \Exception("Cette activité n'existe pas");
        }

        $this->sportModel->delete($id);

        return redirect()
            ->to('/sport')
            ->with('success', 'Activité sportive supprimée');
    }

    public function detail($id)
    {
        $sport = $this->sportModel->find($id);

        if (!$sport) {
            throw new \Exception("Cette activité n'existe pas");
        }

        return view('admin/sport/detail', [
            'title' => 'Détail sport - NutriFit',
            'sport' => $sport,
        ]);
    }

    public function regimesAssocies(int $sportId)
    {
        $sport = $this->sportModel->find($sportId);

        if (!$sport) {
            return redirect()->to('/sport')->with('error', 'Sport introuvable.');
        }

        $regimes = $this->regimeModel->findAll();

        $regimesLies = $this->regimeSportModel->getRegimesBySportId($sportId);

        return view('admin/sport/regimes_associes', [
            'title' => 'Régimes associés - NutriFit',
            'sport' => $sport,
            'regimes' => $regimes,
            'regimes_lies' => $regimesLies,
        ]);
    }

    public function saveRegime($sportId)
    {
        $sport = $this->sportModel->find($sportId);

        if (!$sport) {
            return redirect()->to('/sport')->with('error', 'Sport introuvable.');
        }

        $regimeIds = $this->request->getPost('regime_ids') ?? [];

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            foreach ($regimeIds as $regimeId) {
                if (!$this->regimeSportModel->verifyAssociation($regimeId, $sportId)) {
                    $this->regimeSportModel->insert([
                        'sport_id' => $sportId,
                        'regime_id' => $regimeId
                    ]);
                }
            }

            $db->transCommit();

            return redirect()
                ->to('/sport')
                ->with('success', 'Sports liés avec succès aux régimes choisis');
        } catch (\Exception $e) {
            $db->transRollback();

            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }
}
