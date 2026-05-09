<?php
namespace App\Models;
use CodeIgniter\Model;

class RegimeSportModel extends Model
{
    protected $table = 'regime_sports';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'regime_id',
        'sport_id'
    ];

    protected $validationRules = [
        'regime_id' => 'required|integer',
        'sport_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'regime_id' => [
            'required' => 'Le régime associé ne peut pas être vide',
            'integer' => 'L\'id du régime doit être un entier'
        ],
        'sport_id' => [
            'required' => 'Le sport associé ne peut pas être vide',
            'integer' => 'L\'id du sport doit être un entier'
        ],
    ];

    public function getSportsByRegimeId(int $regimeId): ?array
    {
        return $this->select('sport.*')
                    ->join('sport', 'sport.id = regime_sports.sport_id')
                    ->where('regime_sports.regime_id', $regimeId)
                    ->findAll();
    }

    public function getRegimesBySportId(int $sportId): ?array
    {
        return $this->select('regimes.*')
                    ->join('regimes', 'regimes.id = regime_sports.regime_id')
                    ->where('regime_sports.sport_id', $sportId)
                    ->regime();
    }

    public function verifyAssociation(int $regimeId, int $sportId)
    {
        return $this->where([
            'regime_id', $regimeId,
            'sport_id', $sportId
        ])->countAllResults() > 0;
    }
}