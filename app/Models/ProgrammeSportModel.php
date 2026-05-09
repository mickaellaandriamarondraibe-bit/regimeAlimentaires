<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammeSportModel extends Model
{
    protected $table = 'programme_sport';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'programme_id',
        'sport_id',
    ];

    protected $validationRules = [
        'programme_id' => 'required|integer',
        'sport_id'     => 'required|integer',
    ];

    public function getSportsByProgrammeId(int $programmeId): array
    {
        return $this->select('
                sport.id,
                sport.name,
                sport.description,
                sport.variation_poids_semaine
            ')
            ->join('sport', 'sport.id = programme_sport.sport_id')
            ->where('programme_sport.programme_id', $programmeId)
            ->findAll();
    }

    public function addSportToProgramme(int $programmeId, int $sportId): bool
    {
        return $this->insert([
            'programme_id' => $programmeId,
            'sport_id'     => $sportId,
        ]) !== false;
    }

    public function addSportsToProgramme(int $programmeId, array $sportIds): void
    {
        foreach ($sportIds as $sportId) {
            $this->insert([
                'programme_id' => $programmeId,
                'sport_id'     => $sportId,
            ]);
        }
    }

    public function deleteByProgrammeId(int $programmeId): bool
    {
        return $this->where('programme_id', $programmeId)->delete();
    }
}